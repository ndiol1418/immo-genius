<footer id="footer" class="footer _light-background">

    <div class="container mt-4" style="margin-top: 60px !important">
      <div class="row gy-3">

        <div class="col-lg-4 col-md-6">
          <img src="{{ asset('img/logo-teranga.png') }}" alt="Teranga Immobilier" style="height:90px;max-width:260px;object-fit:contain;">
        </div>
        <div class="col-lg-2 col-md-6">
          <h4>Acheter</h4>
          <div class="d-grid">
            <a href="#" class="">Demander une offre</a>
            <a href="#" class="">Tarifs</a>
            <a href="{{ route('cgu') }}" class="">Avis</a>
            <a href="#" class="">Témoignages</a>
          </div>
        </div>

        <div class="col-lg-2 col-md-6">
          <h4>Louer</h4>
          <div class="d-grid">
            <a href="#" class="">Acheter et vendre</a>
            <a href="#" class="">Louer un bien</a>
            <a href="{{ route('cgu') }}" class="">Construire</a>
          </div>
        </div>        
        <div class="col-lg-2 col-md-6">
          <h4>Agents</h4>
          <div class="d-grid">
            <a href="#" class="">Notre entreprise</a>
            <a href="#" class="">Comment ça marche</a>
            <a href="{{ route('cgu') }}" class="">Contact</a>
            <a href="#" class="">Investisseurs</a>
          </div>
        </div>
        <div class="col-lg-2 col-md-6">
          <div class="d-grid">
            <a href="#" class="">Entreprise</a>
            <a href="#" class="">Contact</a>
            <a href="{{ route('cgu') }}" class="">Conditions d'utilisation</a>
            <a href="#" class="">Politique de confidentialité</a>
          </div>
        </div>

        <div class="col-lg-2 col-md-6">
          <h4>Guides & Ressources</h4>
          <div class="d-grid">
            <a href="{{ route('guide.acheteur') }}" class="">Guide Acheteur</a>
            <a href="{{ route('guide.vendeur') }}" class="">Guide Vendeur</a>
            <a href="{{ route('faq') }}" class="">FAQ</a>
            <a href="{{ route('marche.index') }}" class="">Marché Immobilier</a>
            <a href="{{ route('blog.index') }}" class="">Blog Actualités</a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <div class="d-flex justify-content-between">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">{{ env('APP_NAME') }}</strong> <span>All Rights Reserved</span>
        </p>
        <div class="social-links d-flex">
          <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div>    
    <div class="container copyright text-center mt-4">

      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://softek-group.com">Softek Group</a>
      </div>
    </div>

  </footer>