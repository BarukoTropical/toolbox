const messagesElement = document.querySelector('#messages');
const form = document.querySelector('#chatForm');
const input = document.querySelector('#chatInput');
const sendButton = document.querySelector('#sendButton');
const errorBanner = document.querySelector('#errorBanner');
const countElement = document.querySelector('#messageCount');
const clearButton = document.querySelector('#clearChat');
const modeButtons = [...document.querySelectorAll('.mode')];
const sheenCards = [...document.querySelectorAll('.sheen-card')];

let activeMode = 'community';
let busy = false;
let conversation = [];
let requestCount = Number.parseInt(localStorage.getItem('barukoRequestCount') || '0', 10);
countElement.textContent = requestCount.toString().padStart(2, '0');

const escapeHtml = (value) => value.replace(/[&<>'"]/g, (character) => ({
  '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;',
}[character]));

function timeLabel() {
  return new Intl.DateTimeFormat('de-DE', { hour: '2-digit', minute: '2-digit' }).format(new Date());
}

function scrollToBottom() {
  messagesElement.scrollTop = messagesElement.scrollHeight;
}

function createMessage(role, text = '') {
  const article = document.createElement('article');
  article.className = `message ${role === 'user' ? 'user-message' : 'ai-message'}`;
  article.innerHTML = `
    <div class="message-avatar">${role === 'user' ? 'DU' : 'B'}</div>
    <div class="message-wrap">
      <div class="message-meta"><b>${role === 'user' ? 'DU' : 'BARUKO AI'}</b><span>${timeLabel()}</span></div>
      <div class="bubble"><p>${escapeHtml(text)}</p></div>
    </div>`;
  messagesElement.appendChild(article);
  scrollToBottom();
  return article.querySelector('.bubble p');
}

function createTyping() {
  const article = document.createElement('article');
  article.className = 'message ai-message typing';
  article.innerHTML = `
    <div class="message-avatar">B</div>
    <div class="message-wrap">
      <div class="message-meta"><b>BARUKO AI</b><span>DENKT NACH</span></div>
      <div class="bubble"><i></i><i></i><i></i></div>
    </div>`;
  messagesElement.appendChild(article);
  scrollToBottom();
  return article;
}

function setError(message = '') {
  errorBanner.textContent = message;
  errorBanner.classList.toggle('visible', Boolean(message));
}

function setBusy(value) {
  busy = value;
  sendButton.disabled = value;
  input.disabled = value;
}

function resizeInput() {
  input.style.height = 'auto';
  input.style.height = `${Math.min(input.scrollHeight, 130)}px`;
}

function bindSuggestionButtons() {
  document.querySelectorAll('[data-prompt]').forEach((button) => {
    button.addEventListener('click', () => sendMessage(button.dataset.prompt || ''));
  });
}

async function sendMessage(rawMessage) {
  const message = rawMessage.trim();
  if (!message || busy) return;

  setError();
  document.querySelector('#suggestions')?.remove();
  createMessage('user', message);
  conversation.push({ role: 'user', content: message });
  conversation = conversation.slice(-12);
  input.value = '';
  resizeInput();
  setBusy(true);
  const typing = createTyping();

  try {
    const response = await fetch('/api/chat', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ messages: conversation, mode: activeMode }),
    });

    if (!response.ok || !response.body) {
      const details = await response.json().catch(() => ({}));
      throw new Error(details.error || 'Die AI ist gerade nicht erreichbar.');
    }

    typing.remove();
    const output = createMessage('assistant', '');
    const reader = response.body.getReader();
    const decoder = new TextDecoder();
    let answer = '';

    while (true) {
      const { done, value } = await reader.read();
      if (done) break;
      answer += decoder.decode(value, { stream: true });
      output.textContent = answer;
      scrollToBottom();
    }

    if (!answer.trim()) throw new Error('Die AI hat keine Antwort gesendet.');
    conversation.push({ role: 'assistant', content: answer });
    requestCount += 1;
    localStorage.setItem('barukoRequestCount', String(requestCount));
    countElement.textContent = requestCount.toString().padStart(2, '0');
  } catch (error) {
    typing.remove();
    setError(error instanceof Error ? error.message : 'Etwas ist schiefgelaufen. Bitte versuche es erneut.');
  } finally {
    setBusy(false);
    input.focus();
  }
}

form.addEventListener('submit', (event) => {
  event.preventDefault();
  sendMessage(input.value);
});

input.addEventListener('input', resizeInput);
input.addEventListener('keydown', (event) => {
  if (event.key === 'Enter' && !event.shiftKey) {
    event.preventDefault();
    form.requestSubmit();
  }
});

bindSuggestionButtons();

modeButtons.forEach((button) => {
  button.addEventListener('click', () => {
    activeMode = button.dataset.mode || 'community';
    modeButtons.forEach((item) => {
      const selected = item === button;
      item.classList.toggle('active', selected);
      item.setAttribute('aria-checked', String(selected));
    });
    input.placeholder = `${button.querySelector('b')?.textContent || 'BARUKO'}-Modus aktiv …`;
    input.focus();
  });
});

clearButton.addEventListener('click', () => {
  conversation = [];
  messagesElement.querySelectorAll('.message:not(.welcome-message)').forEach((message) => message.remove());
  if (!document.querySelector('#suggestions')) {
    messagesElement.insertAdjacentHTML('beforeend', `
      <div class="suggestions" id="suggestions">
        <button data-prompt="Schreibe eine coole Willkommensnachricht für neue Mitglieder auf meinem Gaming-Discord.">
          <span class="suggestion-icon"><svg viewBox="0 0 20 20" fill="none"><path d="M10 3v14M3 10h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg></span>
          <span><b>Welcome Flow</b><small>Neue Mitglieder richtig begrüßen</small></span><i>01</i>
        </button>
        <button data-prompt="Plane ein kreatives Community-Event für meinen Discord-Server.">
          <span class="suggestion-icon"><svg viewBox="0 0 20 20" fill="none"><path d="M5 3v3m10-3v3M3.5 8h13M5 5h10a2 2 0 0 1 2 2v9H3V7a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
          <span><b>Event Blueprint</b><small>Community-Aktion konzipieren</small></span><i>02</i>
        </button>
        <button data-prompt="Formuliere faire und klare Regeln für einen deutschen Gaming-Discord.">
          <span class="suggestion-icon"><svg viewBox="0 0 20 20" fill="none"><path d="m10 2.8 6 2.3v4.5c0 3.7-2.5 6.2-6 7.6-3.5-1.4-6-3.9-6-7.6V5.1l6-2.3Z" stroke="currentColor" stroke-width="1.5"/><path d="m7.3 10 1.7 1.7 3.8-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
          <span><b>Rule System</b><small>Faire Server-Regeln formulieren</small></span><i>03</i>
        </button>
      </div>`);
    bindSuggestionButtons();
  }
  setError();
  scrollToBottom();
});

sheenCards.forEach((card) => {
  card.addEventListener('pointermove', (event) => {
    const bounds = card.getBoundingClientRect();
    card.style.setProperty('--pointer-x', `${event.clientX - bounds.left}px`);
    card.style.setProperty('--pointer-y', `${event.clientY - bounds.top}px`);
  });
});

input.focus();
