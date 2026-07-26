const messagesElement = document.querySelector('#messages');
const form = document.querySelector('#chatForm');
const input = document.querySelector('#chatInput');
const sendButton = document.querySelector('#sendButton');
const errorBanner = document.querySelector('#errorBanner');
const countElement = document.querySelector('#messageCount');
const clearButton = document.querySelector('#clearChat');
const modeButtons = [...document.querySelectorAll('.mode')];

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

document.querySelectorAll('[data-prompt]').forEach((button) => {
  button.addEventListener('click', () => sendMessage(button.dataset.prompt || ''));
});

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
        <button data-prompt="Schreibe eine coole Willkommensnachricht für neue Mitglieder auf meinem Gaming-Discord."><span>✦</span> Willkommensnachricht</button>
        <button data-prompt="Plane ein kreatives Community-Event für meinen Discord-Server."><span>⌁</span> Event planen</button>
        <button data-prompt="Formuliere faire und klare Regeln für einen deutschen Gaming-Discord."><span>◈</span> Server-Regeln</button>
      </div>`);
    document.querySelectorAll('[data-prompt]').forEach((button) => {
      button.addEventListener('click', () => sendMessage(button.dataset.prompt || ''));
    });
  }
  setError();
  scrollToBottom();
});

input.focus();
