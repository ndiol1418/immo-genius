<style>
#chatbot-btn {
    position: fixed;
    bottom: 80px;
    right: 20px;
    width: 54px;
    height: 54px;
    border-radius: 50%;
    background: #27E3C0;
    color: #fff;
    border: none;
    font-size: 24px;
    cursor: pointer;
    z-index: 9990;
    box-shadow: 0 4px 15px rgba(39,227,192,.5);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform .2s;
}
#chatbot-btn:hover { transform: scale(1.1); }
#chatbot-window {
    position: fixed;
    bottom: 145px;
    right: 20px;
    width: 340px;
    max-width: calc(100vw - 32px);
    height: 480px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0,0,0,.15);
    display: flex;
    flex-direction: column;
    z-index: 9991;
    overflow: hidden;
    transform: scale(0);
    transform-origin: bottom right;
    transition: transform .25s cubic-bezier(.34,1.56,.64,1);
}
#chatbot-window.open { transform: scale(1); }
#chatbot-header {
    background: linear-gradient(135deg,#0d1c2e,#27E3C0);
    color: #fff;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-weight: 700;
    font-size: 14px;
}
#chatbot-header .bot-avatar {
    width: 32px; height: 32px; border-radius: 50%;
    background: rgba(255,255,255,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; margin-right: 8px;
}
#chatbot-close {
    background: none; border: none; color: #fff;
    font-size: 20px; cursor: pointer; line-height: 1;
}
#chatbot-messages {
    flex: 1;
    overflow-y: auto;
    padding: 12px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    background: #f8fffe;
}
.chat-msg {
    max-width: 82%;
    padding: 8px 12px;
    border-radius: 12px;
    font-size: 12.5px;
    line-height: 1.5;
    white-space: pre-wrap;
    word-break: break-word;
}
.chat-msg.bot {
    background: #e8fdf8;
    border: 1px solid #b2f5e8;
    align-self: flex-start;
    border-bottom-left-radius: 3px;
}
.chat-msg.user {
    background: #27E3C0;
    color: #fff;
    align-self: flex-end;
    border-bottom-right-radius: 3px;
}
.chat-quick-replies {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 4px;
}
.chat-quick-replies button {
    background: #fff;
    border: 1px solid #27E3C0;
    color: #0d1c2e;
    border-radius: 20px;
    padding: 4px 10px;
    font-size: 11px;
    cursor: pointer;
    transition: background .15s;
}
.chat-quick-replies button:hover { background: #e8fdf8; }
#chatbot-footer {
    padding: 10px;
    border-top: 1px solid #e8fdf8;
    display: flex;
    gap: 6px;
    background: #fff;
}
#chatbot-input {
    flex: 1;
    border: 1px solid #ddd;
    border-radius: 20px;
    padding: 7px 14px;
    font-size: 12px;
    outline: none;
}
#chatbot-input:focus { border-color: #27E3C0; }
#chatbot-send {
    background: #27E3C0;
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 34px;
    height: 34px;
    cursor: pointer;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
</style>

{{-- Bouton flottant --}}
<button id="chatbot-btn" onclick="toggleChatbot()" title="Assistant Vytimo">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2"/></svg>
    <span id="chatbot-badge" style="position:absolute;top:-3px;right:-3px;background:#e74c3c;color:#fff;border-radius:50%;width:16px;height:16px;font-size:9px;display:flex;align-items:center;justify-content:center;display:none;">1</span>
</button>

{{-- Fenêtre de chat --}}
<div id="chatbot-window">
    <div id="chatbot-header">
        <div style="display:flex;align-items:center;">
            <div class="bot-avatar">🏠</div>
            <div>
                <div>Assistant Vytimo</div>
                <div style="font-size:10px;font-weight:400;opacity:.85;">● En ligne</div>
            </div>
        </div>
        <button id="chatbot-close" onclick="toggleChatbot()">×</button>
    </div>
    <div id="chatbot-messages"></div>
    <div id="chatbot-footer">
        <input id="chatbot-input" type="text" placeholder="Posez votre question…" onkeydown="if(event.key==='Enter')sendChat()">
        <button id="chatbot-send" onclick="sendChat()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
        </button>
    </div>
</div>

<script>
var chatbotOpen = false;
var chatbotGreeted = false;

var chatFAQ = [
    { keys: ['publier','annonce'], response: "Pour publier une annonce :\n1️⃣ Créez un compte agent\n2️⃣ Cliquez sur 'Publier'\n3️⃣ Remplissez les détails du bien\n4️⃣ Ajoutez vos photos\n5️⃣ Soumettez pour validation ✅" },
    { keys: ['contact','agent','appel'], response: "Pour contacter un agent :\n1️⃣ Ouvrez une annonce\n2️⃣ Cliquez sur '💬 Message'\n3️⃣ Rédigez votre message\n\nOu visitez la page Agents pour voir tous nos professionnels 👥" },
    { keys: ['tarif','commission','prix','cout'], response: "Nos tarifs sont transparents :\n• Commission : 2% sur les transactions\n• Annonces standards : gratuites\n• Pack premium : visibilité boostée\n\nAucun frais caché 💚" },
    { keys: ['visite','360','virtuel','panoram'], response: "La visite virtuelle 360° vous permet de visiter depuis chez vous :\n• Photos panoramiques interactives\n• Navigation fluide\n• Compatible mobile 📱\n\nCherchez l'icône 🔄 sur les annonces !" },
    { keys: ['compte','inscription','register','creer'], response: "Pour créer un compte :\n1️⃣ Cliquez sur 'Se connecter'\n2️⃣ Sélectionnez 'Créer un compte'\n3️⃣ Choisissez votre profil\n4️⃣ Renseignez vos informations 📝\n\nC'est gratuit et rapide !" },
];

var quickReplies = [
    { label: '📢 Publier une annonce', text: 'publier' },
    { label: '👤 Contacter un agent', text: 'contacter agent' },
    { label: '💰 Nos tarifs', text: 'tarifs commissions' },
    { label: '🔄 Visite virtuelle', text: 'visite virtuelle 360' },
    { label: '🔑 Créer un compte', text: 'creer compte inscription' },
];

function toggleChatbot() {
    chatbotOpen = !chatbotOpen;
    var win = document.getElementById('chatbot-window');
    win.classList.toggle('open', chatbotOpen);
    if (chatbotOpen && !chatbotGreeted) {
        chatbotGreeted = true;
        setTimeout(function() {
            addBotMsg("Bonjour ! 👋 Je suis l'assistant Vytimo.\nComment puis-je vous aider aujourd'hui ?", true);
        }, 300);
    }
    document.getElementById('chatbot-badge').style.display = 'none';
}

function addBotMsg(text, withQuick) {
    var msgs = document.getElementById('chatbot-messages');
    var div = document.createElement('div');
    div.className = 'chat-msg bot';
    div.textContent = text;
    msgs.appendChild(div);
    if (withQuick) {
        var qr = document.createElement('div');
        qr.className = 'chat-quick-replies';
        quickReplies.forEach(function(q) {
            var btn = document.createElement('button');
            btn.textContent = q.label;
            btn.onclick = function() { processInput(q.text); };
            qr.appendChild(btn);
        });
        // Bouton parler à un agent
        var agentBtn = document.createElement('button');
        agentBtn.innerHTML = '👥 Parler à un agent';
        agentBtn.style.background = '#27E3C0';
        agentBtn.style.color = '#fff';
        agentBtn.style.borderColor = '#27E3C0';
        agentBtn.onclick = function() { window.location.href = '/agents'; };
        qr.appendChild(agentBtn);
        msgs.appendChild(qr);
    }
    msgs.scrollTop = msgs.scrollHeight;
}

function addUserMsg(text) {
    var msgs = document.getElementById('chatbot-messages');
    var div = document.createElement('div');
    div.className = 'chat-msg user';
    div.textContent = text;
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
}

function processInput(text) {
    var lower = text.toLowerCase();
    var answered = false;
    for (var i = 0; i < chatFAQ.length; i++) {
        for (var j = 0; j < chatFAQ[i].keys.length; j++) {
            if (lower.indexOf(chatFAQ[i].keys[j]) !== -1) {
                setTimeout(function(resp) {
                    return function() { addBotMsg(resp, false); };
                }(chatFAQ[i].response), 400);
                answered = true;
                break;
            }
        }
        if (answered) break;
    }
    if (!answered) {
        setTimeout(function() {
            addBotMsg("Je n'ai pas bien compris 🤔\nVoici ce que je peux vous aider à faire :", true);
        }, 400);
    }
}

function sendChat() {
    var input = document.getElementById('chatbot-input');
    var text = input.value.trim();
    if (!text) return;
    addUserMsg(text);
    input.value = '';
    processInput(text);
}
</script>
