@extends('layouts.accueil')
@section('title', 'Guide Acheteur — Acheter au Sénégal | ' . config('app.name'))

@section('content')
<section class="section" style="padding-top:110px;min-height:80vh;">
<div class="container" style="max-width:900px;">

  {{-- Hero --}}
  <div class="text-center mb-5">
    <div style="font-size:52px;margin-bottom:12px;">🏠</div>
    <h2 class="fw-bold">Guide Complet de l'Acheteur</h2>
    <p class="text-muted" style="font-size:15px;">Tout ce qu'il faut savoir pour acheter un bien immobilier au Sénégal en toute sérénité</p>
  </div>

  @php
  $etapes = [
    [
      'num'   => 1,
      'titre' => 'Définir son budget',
      'emoji' => '💰',
      'desc'  => 'Avant de commencer votre recherche, établissez votre budget total : apport personnel, capacité d\'emprunt, frais de notaire (7-10% du prix) et frais d\'agence. Utilisez notre simulateur de prêt pour estimer vos mensualités.',
      'docs'  => ['Relevés bancaires des 3 derniers mois', 'Justificatifs de revenus', 'Avis d\'imposition'],
      'conseil' => 'Prévoyez 10-15% de frais supplémentaires (notaire, agence, travaux éventuels).',
    ],
    [
      'num'   => 2,
      'titre' => 'Rechercher le bien idéal',
      'emoji' => '🔍',
      'desc'  => 'Définissez vos critères : localisation, superficie, nombre de pièces, type de bien. Utilisez notre recherche IA qui analyse vos besoins en langage naturel pour vous proposer les meilleures annonces.',
      'docs'  => ['Liste de vos critères prioritaires', 'Budget défini'],
      'conseil' => 'Consultez notre carte interactive pour comparer les prix par quartier.',
    ],
    [
      'num'   => 3,
      'titre' => 'Contacter un agent Teranga',
      'emoji' => '🎯',
      'desc'  => 'Utilisez notre outil "Trouver mon agent idéal" pour être mis en relation avec l\'agent le mieux adapté à votre projet. Nos agents sont vérifiés et spécialisés par zone et type de bien.',
      'docs'  => ['Votre liste de critères'],
      'conseil' => 'Un bon agent vous fera économiser du temps et vous protégera des arnaques.',
    ],
    [
      'num'   => 4,
      'titre' => 'Visiter le bien',
      'emoji' => '🔑',
      'desc'  => 'Lors de la visite, inspectez attentivement : toiture, murs, plomberie, électricité, titre foncier. N\'hésitez pas à visiter plusieurs fois à des heures différentes.',
      'docs'  => ['Checklist de visite', 'Questions à poser'],
      'conseil' => 'Photographiez tout et notez les défauts pour négocier le prix.',
    ],
    [
      'num'   => 5,
      'titre' => 'Faire une offre',
      'emoji' => '📝',
      'desc'  => 'Une fois le bien trouvé, faites une offre d\'achat écrite avec un délai de réponse. Au Sénégal, une marge de négociation de 5-10% est courante selon le marché.',
      'docs'  => ['Lettre d\'offre d\'achat', 'Preuve de financement'],
      'conseil' => 'Basez-vous sur les prix du marché local (voir notre page Marché Immobilier).',
    ],
    [
      'num'   => 6,
      'titre' => 'Signer le compromis',
      'emoji' => '✍️',
      'desc'  => 'Le compromis de vente fixe les conditions de la transaction. Un dépôt de garantie (5-10%) est versé. Ce document vous engage légalement, vérifiez chaque clause avec votre notaire.',
      'docs'  => ['Pièce d\'identité', 'Compromis de vente', 'Chèque de garantie'],
      'conseil' => 'Incluez des clauses suspensives (obtention du prêt, vérification du titre foncier).',
    ],
    [
      'num'   => 7,
      'titre' => 'Obtenir le financement',
      'emoji' => '🏦',
      'desc'  => 'Si vous financez par crédit, déposez votre dossier auprès de plusieurs banques. Les principales banques sénégalaises proposent des prêts immobiliers sur 10-20 ans.',
      'docs'  => ['Compromis signé', 'Dossier de prêt complet', 'Justificatifs de revenus'],
      'conseil' => 'Comparez les taux (CBAO, Ecobank, BIS, Société Générale) et négociez les frais.',
    ],
    [
      'num'   => 8,
      'titre' => 'Signature définitive',
      'emoji' => '🎉',
      'desc'  => 'Chez le notaire, vous signez l\'acte authentique de vente, le bien vous est officiellement transféré. Les clés vous sont remises et le titre foncier est mis à votre nom.',
      'docs'  => ['Pièce d\'identité', 'Financement débloqué', 'Acte de vente final'],
      'conseil' => 'Vérifiez que le titre foncier porte bien votre nom avant de partir.',
    ],
  ];
  @endphp

  {{-- Timeline des étapes --}}
  @foreach($etapes as $i => $etape)
  <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;overflow:hidden;">
    <div class="d-flex">
      {{-- Numéro --}}
      <div style="background:#2E7D32;color:#fff;min-width:70px;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:20px 10px;font-size:13px;">
        <span style="font-size:24px;">{{ $etape['emoji'] }}</span>
        <span style="font-size:22px;font-weight:800;line-height:1;">{{ $etape['num'] }}</span>
      </div>
      {{-- Contenu --}}
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
      </div>
    </div>
  </div>
  @endforeach

  {{-- CTA --}}
  <div class="text-center my-5 py-4" style="background:linear-gradient(135deg,#0d1c2e,#1a3a5c);border-radius:20px;">
    <h4 class="text-white fw-bold mb-2">Prêt à trouver votre bien idéal ?</h4>
    <p class="text-white-50 mb-4" style="font-size:14px;">Nos agents Teranga vous accompagnent à chaque étape</p>
    <div class="d-flex justify-content-center gap-3 flex-wrap">
      <a href="{{ route('acheter') }}" class="btn fw-bold px-4" style="background:#2E7D32;color:#fff;border-radius:10px;">🏠 Voir les annonces</a>
      <a href="{{ route('agent.match') }}" class="btn fw-bold px-4" style="background:#fff;color:#0d1c2e;border-radius:10px;">🎯 Trouver mon agent</a>
      <a href="{{ route('calculateur') }}" class="btn fw-bold px-4" style="background:rgba(255,255,255,.1);color:#fff;border-radius:10px;">📊 Simuler mon prêt</a>
    </div>
  </div>

</div>
</section>
@endsection
