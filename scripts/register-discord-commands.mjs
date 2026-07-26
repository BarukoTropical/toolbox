const applicationId = process.env.DISCORD_APPLICATION_ID
const botToken = process.env.DISCORD_BOT_TOKEN
const guildId = process.env.DISCORD_GUILD_ID

if (!applicationId || !botToken) {
  console.error('DISCORD_APPLICATION_ID und DISCORD_BOT_TOKEN müssen gesetzt sein.')
  process.exit(1)
}

const command = {
  name: 'baruko',
  description: 'Frage BARUKO AI direkt auf deinem Discord-Server.',
  type: 1,
  integration_types: [0],
  contexts: [0, 1],
  options: [
    {
      name: 'prompt',
      description: 'Deine Frage oder Aufgabe für BARUKO AI',
      type: 3,
      required: true,
      max_length: 1500,
    },
    {
      name: 'modus',
      description: 'Wähle den passenden Antwortstil',
      type: 3,
      required: false,
      choices: [
        { name: 'Community', value: 'community' },
        { name: 'Moderation', value: 'moderation' },
        { name: 'Creative', value: 'creative' },
      ],
    },
    {
      name: 'privat',
      description: 'Antwort nur für dich anzeigen',
      type: 5,
      required: false,
    },
  ],
}

const commandPath = guildId
  ? `/applications/${applicationId}/guilds/${guildId}/commands`
  : `/applications/${applicationId}/commands`

const response = await fetch(`https://discord.com/api/v10${commandPath}`, {
  method: 'PUT',
  headers: {
    Authorization: `Bot ${botToken}`,
    'Content-Type': 'application/json',
  },
  body: JSON.stringify([command]),
})

if (!response.ok) {
  const error = await response.text()
  console.error(`Command-Registrierung fehlgeschlagen (${response.status}): ${error}`)
  process.exit(1)
}

const scope = guildId ? `Test-Server ${guildId}` : 'global'
console.log(`/baruko wurde erfolgreich ${scope} registriert.`)
