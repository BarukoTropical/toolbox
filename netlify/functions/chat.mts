import OpenAI from 'openai'
import type { Config } from '@netlify/functions'

type ChatMessage = {
  role: 'user' | 'assistant'
  content: string
}

const modeInstructions: Record<string, string> = {
  community: 'Antworte locker, motivierend und community-nah. Nutze modernes, natürliches Deutsch, aber übertreibe Jugendsprache nicht.',
  moderation: 'Antworte sachlich, fair und deeskalierend. Formuliere klare Discord-Regeln, Moderationshinweise und Konfliktlösungen.',
  creative: 'Sei besonders ideenreich. Entwickle Namen, Events, Ankündigungen, Rollen, Channels und Content-Konzepte mit konkreten Beispielen.',
}

const baseInstruction = `Du bist BARUKO AI, der deutschsprachige AI-Assistent eines Discord-Bots.
Du hilfst bei Discord-Communities, Server-Aufbau, Moderation, Events, Ankündigungen und Content.
Antworte standardmäßig auf Deutsch, außer der Nutzer wünscht eine andere Sprache.
Sei kompakt, hilfreich und direkt. Nutze übersichtliche Absätze oder Listen, wenn sie die Antwort verbessern.
Behaupte niemals, Aktionen auf einem Discord-Server tatsächlich ausgeführt zu haben. Erkläre stattdessen, wie der Nutzer sie umsetzt.
Gib keine gefährlichen, illegalen oder missbräuchlichen Anleitungen.`

export default async (request: Request) => {
  if (request.method !== 'POST') {
    return Response.json({ error: 'Methode nicht erlaubt.' }, { status: 405, headers: { Allow: 'POST' } })
  }

  try {
    const body = await request.json() as { messages?: ChatMessage[]; mode?: string }
    const messages = Array.isArray(body.messages) ? body.messages : []
    const validMessages = messages
      .filter((message): message is ChatMessage =>
        (message?.role === 'user' || message?.role === 'assistant') &&
        typeof message.content === 'string' &&
        message.content.trim().length > 0,
      )
      .slice(-12)
      .map((message) => ({ role: message.role, content: message.content.trim().slice(0, 1500) }))

    if (validMessages.length === 0 || validMessages.at(-1)?.role !== 'user') {
      return Response.json({ error: 'Bitte sende eine gültige Nachricht.' }, { status: 400 })
    }

    const mode = typeof body.mode === 'string' ? body.mode : 'community'
    const openai = new OpenAI({ timeout: 40_000 })
    const stream = await openai.chat.completions.create({
      model: 'gpt-5.4-mini',
      messages: [
        { role: 'system', content: `${baseInstruction}\n\nAktiver Modus: ${modeInstructions[mode] || modeInstructions.community}` },
        ...validMessages,
      ],
      max_completion_tokens: 900,
      store: false,
      stream: true,
    })

    return new Response(new ReadableStream({
      async start(controller) {
        const encoder = new TextEncoder()
        try {
          for await (const chunk of stream) {
            const text = chunk.choices[0]?.delta?.content
            if (text) controller.enqueue(encoder.encode(text))
          }
        } catch (error) {
          console.error('BARUKO AI stream failed', error)
        } finally {
          controller.close()
        }
      },
    }), {
      headers: {
        'Content-Type': 'text/plain; charset=utf-8',
        'Cache-Control': 'no-store',
        'X-Content-Type-Options': 'nosniff',
      },
    })
  } catch (error) {
    console.error('BARUKO AI request failed', error)
    return Response.json({ error: 'BARUKO AI ist gerade nicht erreichbar. Bitte versuche es gleich erneut.' }, { status: 500 })
  }
}

export const config: Config = {
  path: '/api/chat',
}
