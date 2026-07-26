# BARUKO AI Discord Bot

Der Bot stellt den Slash Command `/baruko` bereit und beantwortet Fragen über dieselbe BARUKO-AI-Konfiguration wie die Website. Er nutzt Discord HTTP Interactions und benötigt deshalb keinen dauerhaft laufenden Gateway-Server.

## Discord-Anwendung vorbereiten

1. Erstelle im Discord Developer Portal eine neue Application und aktiviere auf der Seite **Bot** einen Bot-User.
2. Kopiere aus **General Information** die Application ID und den Public Key.
3. Erzeuge auf der Seite **Bot** einen Token. Behandle ihn wie ein Passwort und speichere ihn niemals im Repository.

## Netlify-Variablen setzen

Lege diese Runtime-Variablen in Netlify an:

- `DISCORD_APPLICATION_ID`: Application ID aus Discord
- `DISCORD_PUBLIC_KEY`: Public Key aus Discord

Die bestehende Netlify AI Gateway-Konfiguration übernimmt weiterhin die AI-Anfragen. Es ist kein zusätzlicher AI-Schlüssel im Frontend erforderlich.

## Interaction Endpoint verbinden

Deploye die Seite und trage anschließend in Discord unter **General Information → Interactions Endpoint URL** diese URL ein:

```text
https://DEINE-DOMAIN/api/discord/interactions
```

Discord prüft den Endpoint automatisch über einen signierten Ping.

## Slash Command registrieren

Für einen schnellen Test kann zusätzlich `DISCORD_GUILD_ID` lokal oder in der Shell gesetzt werden. Dann wird der Command nur auf diesem Server registriert und erscheint dort schneller. Ohne diese Variable wird er global registriert.

Setze `DISCORD_BOT_TOKEN` nur in der Shell, in der du den Registrierungsbefehl ausführst. Die deployte Interaction Function benötigt den Bot-Token nicht.

```bash
npm run discord:register
```

Der Command unterstützt:

- `prompt`: Frage oder Aufgabe für BARUKO AI
- `modus`: Community, Moderation oder Creative
- `privat`: Antwort nur für die ausführende Person; standardmäßig aktiviert

## Bot installieren

Nach gesetzter `DISCORD_APPLICATION_ID` führt der Button **Bot installieren** auf der Website über `/api/discord/install` zum Discord-Installationsdialog. Der Bot verlangt keine administrativen Server-Rechte.
