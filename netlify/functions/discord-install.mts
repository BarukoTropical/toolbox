import type { Config } from '@netlify/functions'

export default async () => {
  const applicationId = process.env.DISCORD_APPLICATION_ID
  if (!applicationId) {
    return new Response('Discord ist noch nicht konfiguriert.', {
      status: 503,
      headers: { 'Content-Type': 'text/plain; charset=utf-8' },
    })
  }

  const installUrl = new URL('https://discord.com/oauth2/authorize')
  installUrl.searchParams.set('client_id', applicationId)
  installUrl.searchParams.set('scope', 'bot applications.commands')
  installUrl.searchParams.set('permissions', '0')

  return Response.redirect(installUrl, 302)
}

export const config: Config = {
  path: '/api/discord/install',
}
