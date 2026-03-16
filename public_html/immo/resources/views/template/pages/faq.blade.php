@extends('layouts.accueil')
<style>
    #map {
        height: 500px
    }

    td {
        font-size: 12px
    }

    .icon-card {
        border-radius: 50px;
        border: 1px solid #26e3c0;
        padding: 2px;
        background: #26e3c0;
    }
    .card-header{
      border-bottom: 0 !important;
      background: #fff !important;
    }
    .card{overflow: hidden !important;cursor: pointer;}
    .accordion {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
        }
        .accordion-item {
            border-bottom: 1px solid #ddd;
            overflow: hidden;
            border-radius: 30px !important
        }
        .accordion-header {
            background: #fff;
            padding: 15px;
            cursor: pointer;
            display: flex;
            justify-content: left;
            align-items: center;
            font-size: 14px;
            font-weight: bold;
            gap: 10px
        }
        .icon {
            font-size: 20px;
            transition: transform 0.3s ease;
        }
        .accordion-content {
            display: none;
            padding: 0 15px;
            background: #fff;
            font-size: 13px
        }
        .active .accordion-content {
            display: block;
        }
        .active .icon {
            transform: rotate(180deg);
        }
</style>
@section('content')

  <section id="faq" class="services section" style="margin-top:100px;padding:0 20px;">
    <div class="container" style="max-width:860px;">

      <div class="text-center mb-5">
        <h3 class="fw-bold">❓ Foire Aux Questions</h3>
        <p class="text-muted" style="font-size:14px;">Toutes les réponses à vos questions sur l'immobilier au Sénégal</p>
      </div>

      @php
      $faqs = [
        ['cat' => 'Général', 'color' => '#0d1c2e', 'questions' => [
          ['q' => 'Comment fonctionne Teranga Immobilier ?',
           'r' => 'Teranga Immobilier est une plateforme qui met en relation acheteurs, locataires et agents immobiliers au Sénégal. Vous pouvez rechercher des biens, contacter des agents certifiés, estimer votre bien et gérer vos transactions immobilières en ligne.'],
          ['q' => 'Est-ce gratuit de publier une annonce ?',
           'r' => 'La publication d\'une annonce standard est gratuite. Des options de mise en avant (Standard, Premium, Vedette) sont disponibles pour augmenter la visibilité de votre bien.'],
          ['q' => 'Comment contacter un agent immobilier ?',
           'r' => 'Vous pouvez contacter directement un agent depuis sa fiche profil, utiliser notre messagerie intégrée, ou utiliser l\'outil "Trouver mon agent idéal" qui vous recommande les meilleurs agents selon votre projet.'],
        ]],
        ['cat' => 'Achat & Vente', 'color' => '#2E7D32', 'questions' => [
          ['q' => 'Quels sont les frais d\'agence au Sénégal ?',
           'r' => 'Au Sénégal, les frais d\'agence sont généralement de 3 à 5% du prix de vente, partagés entre l\'acheteur et le vendeur. Pour les locations, c\'est souvent l\'équivalent d\'un mois de loyer. Ces frais sont librement négociables.'],
          ['q' => 'Quels documents sont nécessaires pour acheter au Sénégal ?',
           'r' => 'Pour acheter un bien immobilier au Sénégal, il vous faut : une pièce d\'identité valide (CNI ou passeport), un justificatif de domicile, des justificatifs de revenus, un relevé bancaire des 3 derniers mois, et si financement bancaire : un dossier de prêt complet. Pour le vendeur : le titre foncier original, les plans cadastraux, les reçus de taxes foncières et le permis de construire.'],
          ['q' => 'Comment fonctionne le titre foncier au Sénégal ?',
           'r' => 'Le titre foncier est le document légal qui atteste de la propriété d\'un bien immobilier au Sénégal. Il est délivré par la Direction des Domaines et du Cadastre. Un bien avec titre foncier offre la meilleure sécurité juridique. Vérifiez toujours qu\'il est libre de toute hypothèque ou servitude avant d\'acheter.'],
          ['q' => 'Quelle est la différence entre titre foncier et bail ?',
           'r' => 'Le titre foncier est la propriété définitive et irrévocable d\'un terrain ou d\'une construction. Le bail est un droit d\'utilisation temporaire du domaine national, accordé par l\'État pour une durée limitée (généralement 50 ans renouvelables). Le titre foncier est préférable pour un investissement sécurisé, tandis que le bail est plus courant dans certaines zones périurbaines.'],
          ['q' => 'Comment vérifier la légalité d\'un bien immobilier ?',
           'r' => 'Pour vérifier la légalité d\'un bien : (1) demandez à voir le titre foncier original, (2) vérifiez au cadastre que le titre est libre de toute charge, (3) consultez les archives du tribunal foncier, (4) faites appel à un notaire qui effectuera une vérification complète. Ne versez jamais d\'argent avant d\'avoir vérifié tous les documents.'],
        ]],
        ['cat' => 'Location', 'color' => '#C49A0C', 'questions' => [
          ['q' => 'Comment louer en toute sécurité au Sénégal ?',
           'r' => 'Pour louer en sécurité : (1) vérifiez l\'identité du propriétaire et sa qualité de propriétaire légal, (2) exigez un contrat de bail écrit mentionnant le montant, la durée et les conditions, (3) faites un état des lieux contradictoire à l\'entrée et à la sortie, (4) gardez toutes vos quittances de loyer, (5) évitez de payer plusieurs mois d\'avance sans contrat signé.'],
          ['q' => 'Peut-on louer sans contrat de bail ?',
           'r' => 'Louer sans contrat de bail est fortement déconseillé. Un contrat écrit vous protège en cas de litige et prouve le montant convenu, la durée et les conditions de la location. En cas de problème, c\'est votre principale protection légale.'],
          ['q' => 'Quels sont les droits du locataire au Sénégal ?',
           'r' => 'Le locataire au Sénégal a le droit à : un logement en bon état d\'habitabilité, le respect des termes du contrat, un préavis raisonnable en cas de résiliation (généralement 3 mois), la restitution du dépôt de garantie si le bien n\'est pas endommagé.'],
        ]],
        ['cat' => 'Financement', 'color' => '#6366f1', 'questions' => [
          ['q' => 'Quelles banques proposent des prêts immobiliers au Sénégal ?',
           'r' => 'Les principales banques proposant des crédits immobiliers au Sénégal sont : CBAO Groupe Attijariwafa Bank, Ecobank Sénégal, Société Générale Sénégal, BIS (Banque de l\'Habitat du Sénégal), Banque Atlantique, et d\'autres établissements de microfinance. Comparez les taux et conditions avant de vous engager.'],
          ['q' => 'Quel est le taux moyen d\'un prêt immobilier au Sénégal ?',
           'r' => 'Les taux d\'intérêt pour les prêts immobiliers au Sénégal varient généralement entre 7% et 12% selon la banque, la durée et le profil de l\'emprunteur. La durée maximale est généralement de 20 ans. Utilisez notre simulateur de prêt pour estimer vos mensualités.'],
        ]],
      ];
      @endphp

      @foreach($faqs as $section)
      <div class="mb-4">
        <div class="fw-bold mb-3 d-flex align-items-center gap-2">
          <span style="background:{{ $section['color'] }};color:#fff;font-size:11px;padding:3px 14px;border-radius:20px;font-weight:700;">{{ $section['cat'] }}</span>
        </div>
        <div class="accordion">
          @foreach($section['questions'] as $i => $faq)
          <div class="accordion-item shadow-sm {{ $i===0 && $loop->parent->first ? 'active' : '' }}" style="margin-bottom:8px;border-radius:12px !important;">
            <div class="accordion-header" style="border-radius:12px;">
              <span class="icon" style="color:{{ $section['color'] }};font-size:18px;font-weight:700;min-width:20px;">+</span>
              <span style="font-size:14px;font-weight:600;">{{ $faq['q'] }}</span>
            </div>
            <div class="accordion-content" style="{{ ($i===0 && $loop->parent->first) ? 'display:block;' : '' }}">
              <p style="font-size:13px;line-height:1.7;color:#555;padding:4px 0 8px;">{{ $faq['r'] }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endforeach

      {{-- CTA guides --}}
      <div class="mt-5 p-4 text-center" style="background:#f8f9fa;border-radius:16px;">
        <div class="fw-bold mb-2">Vous avez d'autres questions ?</div>
        <p class="text-muted" style="font-size:13px;">Consultez nos guides complets ou contactez un agent Teranga</p>
        <div class="d-flex justify-content-center gap-2 flex-wrap mt-3">
          <a href="{{ route('guide.acheteur') }}" class="btn btn-sm fw-bold" style="background:#2E7D32;color:#fff;border-radius:8px;">📖 Guide Acheteur</a>
          <a href="{{ route('guide.vendeur') }}" class="btn btn-sm fw-bold" style="background:#0d1c2e;color:#fff;border-radius:8px;">💰 Guide Vendeur</a>
          <a href="{{ route('agent.match') }}" class="btn btn-sm fw-bold" style="background:#6366f1;color:#fff;border-radius:8px;">🎯 Trouver un agent</a>
        </div>
      </div>

    </div>
  </section>
@endsection
@section('scriptBottom')
<script>
  document.querySelectorAll('.accordion-header').forEach(item => {
      item.addEventListener('click', () => {
          const parent = item.parentNode;
          parent.classList.toggle('active');
          const icon = item.querySelector('.icon');
          icon.textContent = parent.classList.contains('active') ? '-' : '+';
      });
  });
</script>
@endsection