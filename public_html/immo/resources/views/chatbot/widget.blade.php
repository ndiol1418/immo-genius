<style>
.chat-msg {
    max-width: 82%; padding: 8px 12px; border-radius: 12px;
    font-size: 12.5px; line-height: 1.5; white-space: pre-wrap; word-break: break-word;
}
.chat-msg.bot { background:#e8fdf8; border:1px solid #b2f5e8; align-self:flex-start; border-bottom-left-radius:3px; }
.chat-msg.user { background:#27E3C0; color:#fff; align-self:flex-end; border-bottom-right-radius:3px; }
.chat-quick-replies { display:flex; flex-wrap:wrap; gap:6px; margin-top:4px; }
.chat-quick-replies button { background:#fff; border:1px solid #27E3C0; color:#0d1c2e; border-radius:20px; padding:4px 10px; font-size:11px; cursor:pointer; }
.chat-quick-replies button:hover { background:#e8fdf8; }
</style>

{{-- Bouton flottant — styles 100% inline pour éviter toute surcharge CSS --}}
<button
    id="chatbot-btn"
    onclick="toggleChatbot()"
    title="Assistant Vytimo"
    style="position:fixed !important;bottom:30px !important;right:30px !important;z-index:99999 !important;
           width:60px !important;height:60px !important;border-radius:50% !important;
           background:#27E3C0 !important;border:none !important;cursor:pointer !important;
           font-size:26px !important;box-shadow:0 4px 15px rgba(0,0,0,0.25) !important;
           display:flex !important;align-items:center !important;justify-content:center !important;
           color:#fff !important;padding:0 !important;">
    💬
</button>

{{-- Fenêtre de chat — cachée par défaut, affichée via JS --}}
<div id="chatbot-window"
     style="display:none;position:fixed !important;bottom:100px !important;right:30px !important;
            z-index:99998 !important;width:340px;max-width:calc(100vw - 40px);height:480px;
            background:#fff;border-radius:16px;box-shadow:0 8px 30px rgba(0,0,0,.18);
            flex-direction:column;overflow:hidden;">

    {{-- Header --}}
    <div style="background:linear-gradient(135deg,#0d1c2e,#1a4a3a);color:#fff;padding:14px 16px;
                display:flex;align-items:center;justify-content:space-between;font-weight:700;font-size:14px;">
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,.2);
                        display:flex;align-items:center;justify-content:center;font-size:18px;">🏠</div>
            <div>
                <div>Assistant Vytimo</div>
                <div style="font-size:10px;font-weight:400;opacity:.8;">● En ligne</div>
            </div>
        </div>
        <button onclick="toggleChatbot()"
                style="background:none;border:none;color:#fff;font-size:22px;cursor:pointer;line-height:1;padding:0;">×</button>
    </div>

    {{-- Messages --}}
    <div id="chatbot-messages"
         style="flex:1;overflow-y:auto;padding:12px;display:flex;flex-direction:column;gap:8px;background:#f8fffe;"></div>

    {{-- Footer input --}}
    <div style="padding:10px;border-top:1px solid #e8fdf8;display:flex;gap:6px;background:#fff;">
        <input id="chatbot-input" type="text" placeholder="Posez votre question…"
               onkeydown="if(event.key==='Enter')sendChat()"
               style="flex:1;border:1px solid #ddd;border-radius:20px;padding:7px 14px;font-size:12px;outline:none;">
        <button onclick="sendChat()"
                style="background:#27E3C0;color:#fff;border:none;border-radius:50%;
                       width:36px;height:36px;cursor:pointer;font-size:14px;
                       display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
        </button>
    </div>
</div>

<script>
var chatbotOpen = false;
var chatbotGreeted = false;

var chatFAQ = [
    { keys: ['publier','annonce'], response: "Pour publier une annonce :\n1️⃣ Créez un compte agent\n2️⃣ Cliquez sur 'Publier'\n3️⃣ Remplissez les détails du bien\n4️⃣ Ajoutez vos photos\n5️⃣ Soumettez pour validation ✅" },
    { keys: ['contact','agent','appel'], response: "Pour contacter un agent :\n1️⃣ Ouvrez une annonce\n2️⃣ Cliquez sur '💬 Message'\n3️⃣ Rédigez votre message\n\nOu visitez la page Agents 👥" },
    { keys: ['tarif','commission','prix','cout'], response: "Nos tarifs :\n• Commission : 2% sur les transactions\n• Annonces standards : gratuites\n• Pack premium : visibilité boostée\n\nAucun frais caché 💚" },
    { keys: ['visite','360','virtuel','panoram'], response: "La visite virtuelle 360° :\n• Photos panoramiques interactives\n• Navigation fluide\n• Compatible mobile 📱\n\nCherchez l'icône 🔄 sur les annonces !" },
    { keys: ['compte','inscription','register','creer'], response: "Pour créer un compte :\n1️⃣ Cliquez sur 'Se connecter'\n2️⃣ Sélectionnez 'Créer un compte'\n3️⃣ Choisissez votre profil\n4️⃣ Renseignez vos infos 📝\n\nC'est gratuit !" },
];

var quickReplies = [
    { label: '📢 Publier une annonce', text: 'publier' },
    { label: '👤 Contacter un agent', text: 'contacter agent' },
    { label: '💰 Nos tarifs', text: 'tarifs commissions' },
    { label: '🔄 Visite virtuelle', text: 'visite virtuelle' },
    { label: '🔑 Créer un compte', text: 'creer compte' },
];

function toggleChatbot() {
    chatbotOpen = !chatbotOpen;
    var win = document.getElementById('chatbot-window');
    win.style.display = chatbotOpen ? 'flex' : 'none';
    if (chatbotOpen && !chatbotGreeted) {
        chatbotGreeted = true;
        setTimeout(function() {
            addBotMsg("Bonjour ! 👋 Je suis l'assistant Vytimo.\nComment puis-je vous aider aujourd'hui ?", true);
        }, 300);
    }
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
        var agentBtn = document.createElement('button');
        agentBtn.textContent = '👥 Parler à un agent';
        agentBtn.style.cssText = 'background:#27E3C0;color:#fff;border-color:#27E3C0;';
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
                (function(resp) {
                    setTimeout(function() { addBotMsg(resp, false); }, 400);
                })(chatFAQ[i].response);
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
