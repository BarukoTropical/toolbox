import OpenAI from 'openai'
import type { Config, Context } from '@netlify/functions'

type DiscordOption = {
  name: string
  type: number
  value?: string | boolean
}

type DiscordInteraction = {
  id: string
  application_id: string
  token: string
  type: number
  data?: {
    name?: string
    options?: DiscordOption[]
  }
}

const interactionType = {
  ping: 1,
  applicationCommand: 2,
}

const responseType = {
  pong: 1,
  deferredChannelMessage: 5,
}

const ephemeralFlag = 1 << 6

const modeInstructions: Record<string, string> = {
  community: 'Antworte locker, motivierend und community-nah. Nutze modernes, natürliches Deutsch, aber übertreibe Jugendsprache nicht.',
  moderation: 'Antworte sachlich, fair und deeskalierend. Formuliere klare Discord-Regeln, Moderationshinweise und Konfliktlösungen.',
  creative: 'Sei besonders ideenreich. Entwickle Namen, Events, Ankündigungen, Rollen, Channels und Content-Konzepte mit konkreten Beispielen.',
}

const baseInstruction = `Du bist BARUKO AI, der deutschsprachige AI-Assistent eines Discord-Bots.
Du hilfst bei Discord-Communities, Server-Aufbau, Moderation, Events, Ankündigungen und Content.
Antworte standardmäßig auf Deutsch, außer der Nutzer wünscht eine andere Sprache.
Sei kompakt, hilfreich und direkt. Formatiere für Discord mit kurzen Absätzen und übersichtlichen Listen.
Behaupte niemals, Aktionen auf einem Discord-Server tatsächlich ausgeführt zu haben.
Gib keine gefährlichen, illegalen oder missbräuchlichen Anleitungen.`

function hexToBytes(value: string) {
  if (!/^[0-9a-f]+$/i.test(value) || value.length % 2 !== 0) return null

  const bytes = new Uint8Array(value.length / 2)
  for (let index = 0; index < value.length; index += 2) {
    bytes[index / 2] = Number.parseInt(value.slice(index, index + 2), 16)
  }
  return bytes
}

async function verifyDiscordRequest(request: Request, rawBody: string) {
  const signature = request.headers.get('x-signature-ed25519')
  const timestamp = request.headers.get('x-signature-timestamp')
  const publicKey = process.env.DISCORD_PUBLIC_KEY

  if (!signature || !timestamp || !publicKey) return false

  const requestTime = Number(timestamp) * 1000
  if (!Number.isFinite(requestTime) || Math.abs(Date.now() - requestTime) > 5 * 60 * 1000) return false

  const signatureBytes = hexToBytes(signature)
  const publicKeyBytes = hexToBytes(publicKey)
  if (!signatureBytes || !publicKeyBytes) return false

  try {
    const key = await crypto.subtle.importKey('raw', publicKeyBytes, { name: 'Ed25519' }, false, ['verify'])
    const message = new TextEncoder().encode(`${timestamp}${rawBody}`)
    return crypto.subtle.verify({ name: 'Ed25519' }, key, signatureBytes, message)
  } catch (error) {
    console.error('Discord signature verification failed', error)
    return false
  }
}

function getOption<T extends string | boolean>(interaction: DiscordInteraction, name: string) {
  return interaction.data?.options?.find((option) => option.name === name)?.value as T | undefined
}

function sanitizeDiscordMessage(content: string) {
  const trimmed = content.trim()
  if (trimmed.length <= 1900) return trimmed
  return `${trimmed.slice(0, 1888).trimEnd()}\n\n… gekürzt`
}

async function editInteractionResponse(interaction: DiscordInteraction, content: string) {
  const endpoint = `https://discord.com/api/v10/webhooks/${interaction.application_id}/${interaction.token}/messages/@original`
  const response = await fetch(endpoint, {
    method: 'PATCH',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      content: sanitizeDiscordMessage(content),
      allowed_mentions: { parse: [] },
    }),
  })

  if (!response.ok) {
    throw new Error(`Discord response update failed with status ${response.status}`)
  }
}

async function answerCommand(interaction: DiscordInteraction) {
  const prompt = getOption<string>(interaction, 'prompt')?.trim()
  const mode = getOption<string>(interaction, 'modus') || 'community'

  if (!prompt) {
    await editInteractionResponse(interaction, 'Bitte gib BARUKO AI eine konkrete Frage oder Aufgabe.')
    return
  }

  try {
    const openai = new OpenAI({ timeout: 25_000 })
    const completion = await openai.chat.completions.create({
      model: 'gpt-5.4-mini',
      messages: [
        { role: 'system', content: `${baseInstruction}\n\nAktiver Modus: ${modeInstructions[mode] || modeInstructions.community}` },
        { role: 'user', content: prompt.slice(0, 1500) },
      ],
      max_completion_tokens: 850,
      store: false,
    })

    const answer = completion.choices[0]?.message.content
    await editInteractionResponse(interaction, answer || 'Ich konnte gerade keine Antwort erzeugen. Bitte versuche es erneut.')
  } catch (error) {
    console.error('Discord AI command failed', error)
    await editInteractionResponse(interaction, 'BARUKO AI ist gerade nicht erreichbar. Bitte versuche es in einem Moment erneut.')
  }
}

export default async (request: Request, context: Context) => {
  if (request.method !== 'POST') {
    return new Response('Method Not Allowed', { status: 405, headers: { Allow: 'POST' } })
  }

  const rawBody = await request.text()
  if (!await verifyDiscordRequest(request, rawBody)) {
    return new Response('Invalid request signature', { status: 401 })
  }

  let interaction: DiscordInteraction
  try {
    interaction = JSON.parse(rawBody) as DiscordInteraction
  } catch {
    return new Response('Invalid JSON', { status: 400 })
  }

  const applicationId = process.env.DISCORD_APPLICATION_ID
  if (applicationId && interaction.application_id !== applicationId) {
    return new Response('Invalid application', { status: 401 })
  }

  if (interaction.type === interactionType.ping) {
    return Response.json({ type: responseType.pong })
  }

  if (interaction.type !== interactionType.applicationCommand || interaction.data?.name !== 'baruko') {
    return Response.json({ error: 'Unsupported interaction' }, { status: 400 })
  }

  const isPrivate = getOption<boolean>(interaction, 'privat') ?? true
  context.waitUntil(answerCommand(interaction))

  return Response.json({
    type: responseType.deferredChannelMessage,
    data: isPrivate ? { flags: ephemeralFlag } : {},
  })
}

export const config: Config = {
  path: '/api/discord/interactions',
}
