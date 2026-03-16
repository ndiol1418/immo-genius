@extends('layouts.accueil')
@section('title', 'Guide Vendeur — Vendre au Sénégal | ' . config('app.name'))

@section('content')
<section class="section" style="padding-top:110px;min-height:80vh;">
<div class="container" style="max-width:900px;">

  {{-- Hero --}}
  <div class="text-center mb-5">
    <div style="font-size:52px;margin-bottom:12px;">💰</div>
    <h2 class="fw-bold">Guide Complet du Vendeur</h2>
    <p class="text-muted" style="font-size:15px;">Vendez votre bien immobilier au meilleur prix grâce aux conseils des experts Teranga</p>
  </div>

  @php
  $etapes = [
    [
      'num'   => 1,
      'titre' => 'Estimer son bien',
      'emoji' => '📊',
      'desc'  => 'La première étape est d\'obtenir une estimation réaliste de votre bien. Utilisez notre outil Zestimate Teranga qui analyse les prix du marché local, la superficie, le quartier et l\'état du bien.',
      'docs'  => ['Titre foncier', 'Plans du bien', 'Superficie exacte'],
      'conseil' => 'Attention aux surestimations : un bien trop cher reste longtemps en vente et finit par se vendre moins cher.',
      'cta'   => ['Estimer mon bien', 'estimation'],
    ],
    [
      'num'   => 2,
      'titre' => 'Préparer son dossier',
      'emoji' => '📁',
      'desc'  => 'Rassemblez tous les documents légaux nécessaires à la vente. Un dossier complet rassure l\'acheteur et accélère la transaction.',
      'docs'  => ['Titre foncier original', 'Plans cadastraux', 'Reçus de taxe foncière', 'Permis de construire', 'Certificat de non-opposition'],
      'conseil' => 'Vérifiez que votre titre foncier est à jour et libre de toute hypothèque.',
    ],
    [
      'num'   => 3,
      'titre' => 'Choisir son agent',
      'emoji' => '🤝',
      'desc'  => 'Confiez la vente à un agent Teranga certifié. Nos agents disposent d\'un réseau d\'acheteurs qualifiés et maîtrisent la négociation immobilière au Sénégal.',
      'docs'  => ['Mandat de vente signé'],
      'conseil' => 'Le mandat exclusif avec Teranga vous garantit un suivi personnalisé et une mise en valeur optimale.',
      'cta'   => ['Trouver mon agent', 'agent.match'],
    ],
    [
      'num'   => 4,
      'titre' => 'Publier l\'annonce',
      'emoji' => '📸',
      'desc'  => 'Votre bien est mis en ligne sur Teranga Immobilier avec photos professionnelles, description détaillée et géolocalisation. Boostez votre annonce pour une visibilité maximale.',
      'docs'  => ['Photos de qualité', 'Description complète', 'Plans si disponibles'],
      'conseil' => 'Des photos lumineuses et professionnelles multiplient par 3 les demandes de visite.',
    ],
    [
      'num'   => 5,
      'titre' => 'Organiser les visites',
      'emoji' => '🏠',
      'desc'  => 'Préparez votre bien pour les visites : nettoyage, petites réparations, dépersonnalisation. Un bien bien présenté se vend plus vite et à un meilleur prix.',
      'docs'  => ['Planning de disponibilités'],
      'conseil' => 'La première impression est déterminante. Soignez l\'entrée et les espaces communs.',
    ],
    [
      'num'   => 6,
      'titre' => 'Négocier et accepter une offre',
      'emoji' => '🤜🤛',
      'desc'  => 'Lorsque vous recevez une offre, votre agent Teranga vous conseille sur la meilleure stratégie de négociation. Ne refusez pas une offre sérieuse sous prétexte qu\'elle est légèrement inférieure.',
      'docs'  => ['Offre d\'achat écrite', 'Preuve de financement de l\'acheteur'],
      'conseil' => 'Une contre-offre bien argumentée vaut mieux qu\'un refus sec. Restez ouvert à la discussion.',
    ],
    [
      'num'   => 7,
      'titre' => 'Signer le contrat',
      'emoji' => '✅',
      'desc'  => 'Chez le notaire, vous signez l\'acte authentique de vente. Le paiement vous est versé et le titre foncier est transféré à l\'acheteur. La transaction est officiellement terminée.',
      'docs'  => ['Pièce d\'identité', 'Titre foncier', 'Tous les documents de vente'],
      'conseil' => 'Gardez une copie certifiée de tous les documents. Déclarez la plus-value si applicable.',
    ],
  ];
  @endphp

  {{-- Timeline --}}
  @foreach($etapes as $etape)
  <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;overflow:hidden;">
    <div class="d-flex">
      <div style="background:#0d1c2e;color:#fff;min-width:70px;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:20px 10px;">
        <span style="font-size:24px;">{{ $etape['emoji'] }}</span>
        <span style="font-size:22px;font-weight:800;line-height:1;">{{ $etape['num'] }}</span>
      </div>
      <div class="p-4 flex-grow-1">
        <h6 class="fw-bold mb-2" style="font-size:16px;color:#0d1c2e;">Étape {{ $etape['num'] }} : {{ $etape['titre'] }}</h6>
        <p class="text-muted mb-3" style="font-size:14px;line-height:1.7;">{{ $etape['desc'] }}</p>
        <div class="row g-2">
          <div class="col-md-6">
            <div style="background:#f8f9fa;border-radius:10px;padding:12px 16px;">
              <div style="font-size:11px;font-weight:700;color:#888;margin-bottom:6px;">📋 DOCUMENTS NÉCESSAIRES</div>
              @foreach($etape['docs'] as $doc)
              <div style="font-size:12px;color:#555;">✓ {{ $doc }}</div>
              @endforeach
            </div>
          </div>
          <div class="col-md-6">
            <div style="background:#e8f5e9;border-radius:10px;padding:12px 16px;border-left:3px solid #2E7D32;">
              <div style="font-size:11px;font-weight:700;color:#2E7D32;margin-bottom:6px;">💡 CONSEIL TERANGA</div>
              <div style="font-size:12px;color:#555;">{{ $etape['conseil'] }}</div>
            </div>
          </div>
        </div>
        @if(isset($etape['cta']))
        <div class="mt-3">
          <a href="{{ route($etape['cta'][1]) }}" class="btn btn-sm fw-bold"
             style="background:#2E7D32;color:#fff;border-radius:8px;font-size:12px;">
            → {{ $etape['cta'][0] }}
          </a>
        </div>
        @endif
      </div>
    </div>
  </div>
  @endforeach

  {{-- CTA --}}
  <div class="text-center my-5 py-4" style="background:linear-gradient(135deg,#2E7D32,#1a5c1e);border-radius:20px;">
    <h4 class="text-white fw-bold mb-2">Vendez votre bien avec Teranga</h4>
    <p class="text-white-50 mb-4" style="font-size:14px;">Nos experts vous accompagnent du début à la fin</p>
    <div class="d-flex justify-content-center gap-3 flex-wrap">
      <a href="{{ route('estimation') }}" class="btn fw-bold px-4" style="background:#fff;color:#2E7D32;border-radius:10px;">📊 Estimer mon bien</a>
      <a href="{{ route('agent.match') }}" class="btn fw-bold px-4" style="background:rgba(255,255,255,.15);color:#fff;border-radius:10px;">🎯 Trouver mon agent</a>
    </div>
  </div>

</div>
</section>
@endsection
