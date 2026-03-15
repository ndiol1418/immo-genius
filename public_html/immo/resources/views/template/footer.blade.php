<footer id="footer" class="footer _light-background">

    <div class="container mt-4" style="margin-top: 60px !important">
      <div class="row gy-3">

        <div class="col-lg-4 col-md-6">
          <img src="{{ asset('logo.png') }}" alt="" width="300px">
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
            <a href="#" class="">Buy and sell properties</a>
            <a href="#" class="">Rent Home</a>
            <a href="{{ route('cgu') }}" class="">Builder trade-up</a>
          </div>
        </div>        
        <div class="col-lg-2 col-md-6">
          <h4>Agents</h4>
          <div class="d-grid">
            <a href="#" class="">Company</a>
            <a href="#" class="">How it works</a>
            <a href="{{ route('cgu') }}" class="">Contact</a>
            <a href="#" class="">Investor</a>
          </div>
        </div>
        <div class="col-lg-2 col-md-6">
          <div class="d-grid">
            <a href="#" class="">Entreprise</a>
            <a href="#" class="">Contact</a>
            <a href="{{ route('cgu') }}" class="">Conditions d'utilisation</a>
            <a href="#" class="">Politique de confidentialité</a>
          </div>
          {{-- <div class="address">
            <h4>A propos</h4>
            <p>A108 Adam Street</p>
            <p>Dakar, Senegal</p>
            <p></p>
            <p>
              <strong>Phone:</strong> <span>+1 5589 55488 55</span><br>
              <strong>Email:</strong> <span>info@example.com</span><br>
            </p>
          </div> --}}

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