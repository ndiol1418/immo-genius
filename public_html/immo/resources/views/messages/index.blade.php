@extends('layouts.accueil')

@section('title', 'Messages — ' . config('app.name'))

@section('content')
<style>
  .conv-card { border-radius: 12px; border: 1px solid #eee; padding: 14px 18px; margin-bottom: 12px; cursor: pointer; transition: box-shadow .2s; text-decoration: none; color: inherit; display: block; background: #fff; }
  .conv-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.08); }
  .conv-card .badge-unread { background: #e74c3c; color: #fff; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold; }
  .conv-avatar { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; background: #27E3C0; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: bold; font-size: 18px; }
</style>
<section class="services section mt-4" style="min-height: 60vh;">
  <div class="container" style="margin-top: 100px; max-width: 700px;">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h4 class="mb-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24" style="color:#27E3C0"><path fill="currentColor" d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2"/></svg>
        Messages
      </h4>
    </div>

    @if($conversations->isEmpty())
      <div class="text-center py-5">
        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" style="color:#ddd"><path fill="currentColor" d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2"/></svg>
        <p class="text-muted mt-3">Aucune conversation</p>
      </div>
    @else
      @foreach($conversations as $conv)
        @php
          $autre = $conv->acheteur_id === $userId ? $conv->agent : $conv->acheteur;
          $nonLus = $conv->messagesNonLus($userId);
          $dernier = $conv->dernierMessage;
        @endphp
        <a href="{{ route('messages.show', $conv->id) }}" class="conv-card {{ $nonLus > 0 ? 'border-start border-3' : '' }}" style="{{ $nonLus > 0 ? 'border-left-color:#27E3C0 !important' : '' }}">
          <div class="d-flex align-items-center" style="gap: 12px;">
            <div class="conv-avatar">{{ strtoupper(substr($autre->nom_complet ?? $autre->name ?? 'U', 0, 1)) }}</div>
            <div class="flex-grow-1 overflow-hidden">
              <div class="d-flex justify-content-between align-items-center">
                <strong style="font-size:14px;">{{ $autre->nom_complet ?? $autre->name ?? 'Utilisateur' }}</strong>
                @if($nonLus > 0)
                  <span class="badge-unread">{{ $nonLus }}</span>
                @endif
              </div>
              @if($conv->annonce)
                <p style="font-size:11px;color:#27E3C0;margin:0;">{{ $conv->annonce->name }}</p>
              @endif
              @if($dernier)
                <p style="font-size:12px;color:#888;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                  {{ Str::limit($dernier->contenu, 60) }}
                </p>
              @endif
            </div>
            <small class="text-muted" style="font-size:10px;white-space:nowrap;">{{ $conv->updated_at->diffForHumans() }}</small>
          </div>
        </a>
      @endforeach
    @endif
  </div>
</section>
@endsection
