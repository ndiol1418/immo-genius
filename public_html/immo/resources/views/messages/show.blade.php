@extends('layouts.accueil')

@section('title', 'Conversation — ' . config('app.name'))

@section('content')
<style>
  .chat-container { display: flex; flex-direction: column; height: calc(100vh - 140px); }
  .chat-header { background: #fff; border-bottom: 1px solid #eee; padding: 14px 20px; display: flex; align-items: center; gap: 12px; }
  .chat-messages { flex: 1; overflow-y: auto; padding: 20px; display: flex; flex-direction: column; gap: 10px; background: #f4f6f8; }
  .msg-wrap { display: flex; }
  .msg-wrap.mine { justify-content: flex-end; }
  .bubble { max-width: 70%; padding: 10px 14px; border-radius: 18px; font-size: 13px; line-height: 1.5; }
  .bubble.mine { background: #27E3C0; color: #fff; border-bottom-right-radius: 4px; }
  .bubble.other { background: #fff; color: #333; border-bottom-left-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
  .bubble-time { font-size: 9px; opacity: .65; display: block; margin-top: 3px; }
  .chat-input { background: #fff; border-top: 1px solid #eee; padding: 14px 20px; }
  .chat-input form { display: flex; gap: 10px; }
  .chat-input textarea { flex: 1; border: 1px solid #ddd; border-radius: 22px; padding: 10px 16px; resize: none; font-size: 13px; outline: none; }
  .chat-input textarea:focus { border-color: #27E3C0; }
  .chat-input button { background: #27E3C0; color: #fff; border: none; border-radius: 50%; width: 42px; height: 42px; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
  .back-btn { color: #27E3C0; font-size: 13px; text-decoration: none; }
</style>
<div style="margin-top: 70px;">
  @php
    $autre = $conversation->acheteur_id === $userId ? $conversation->agent : $conversation->acheteur;
  @endphp
  <div class="chat-container">
    <div class="chat-header">
      <a href="{{ route('messages.index') }}" class="back-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M20 11H7.83l5.59-5.59L12 4l-8 8l8 8l1.41-1.41L7.83 13H20z"/></svg>
      </a>
      <div style="width:38px;height:38px;border-radius:50%;background:#27E3C0;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:bold;font-size:16px;flex-shrink:0;">
        {{ strtoupper(substr($autre->nom_complet ?? $autre->name ?? 'U', 0, 1)) }}
      </div>
      <div>
        <strong style="font-size:14px;">{{ $autre->nom_complet ?? $autre->name ?? 'Utilisateur' }}</strong>
        @if($conversation->annonce)
          <p style="font-size:11px;color:#27E3C0;margin:0;">{{ $conversation->annonce->name }}</p>
        @endif
      </div>
    </div>

    <div class="chat-messages" id="chatMessages">
      @foreach($messages as $msg)
        <div class="msg-wrap {{ $msg->sender_id === $userId ? 'mine' : '' }}">
          <div class="bubble {{ $msg->sender_id === $userId ? 'mine' : 'other' }}">
            {{ $msg->contenu }}
            <span class="bubble-time">{{ $msg->created_at->format('H:i') }}</span>
          </div>
        </div>
      @endforeach
    </div>

    <div class="chat-input">
      <form method="POST" action="{{ route('messages.store', $conversation->id) }}">
        @csrf
        <textarea name="contenu" rows="1" placeholder="Écrire un message..." required
          onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();this.form.submit();}"></textarea>
        <button type="submit">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M2.01 21L23 12L2.01 3L2 10l15 2l-15 2z"/></svg>
        </button>
      </form>
    </div>
  </div>
</div>
<script>
  const chat = document.getElementById('chatMessages');
  if (chat) chat.scrollTop = chat.scrollHeight;
</script>
@endsection
