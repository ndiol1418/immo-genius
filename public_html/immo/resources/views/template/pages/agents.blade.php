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

</style>
@section('content')
    <section id="hero" class="hero section dark-background"
        style="margin:0 5%;border-radius: 15px;margin-top: 100px;box-shadow: none;">

        <div id="hero-carousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000" style="min-height: 60vh">

            <div class="carousel-item active">
                <img src="{{ asset('img/agents.png') }}" alt="">
                <div class="carousel-container">
                    <div>
                        <h2 class="text-white text-center">Un bon agent fait <br>
                          toute la différence. </h2>
                        <p class="text-center text-white">
                          Plateforme d’annonces immobilières pour tous
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </section><!-- /Hero Section -->

    <div class="container" style="padding: 0 200px;">
      @include('template.search-agent')
    </div>
    @include('template.components.c_section_agents')
  <section id="services" class="services section">
    <div class="container">
      <h3>Agents Premium</h3>
      <div class="col-12">
        <div class="row">
          @foreach ($agents->where('is_premium',1) as $i=>$agent)

            <div class="col-12 col-lg-6 col-sm-12 mb-2">
              <div class="d-flex">
                <img src="" alt="" width="150px" height="150px" style="object-fit: cover">
                @include('template.components.premium-agent',['tel'=>$agent->telephone,'nom_complet'=>$agent->nom_complet])
              </div>
            </div>
          @endforeach
          {{ $agents->links('pagination::bootstrap-4') }}
          @if(count($agents)==0)
            <div class="bg-light p-4">
              <p class="text-center">
                Aucun Agent trouvé
              </p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>
  <section id="services" class="services section">
    <div class="container">
      <h3>Agents</h3>
      <div class="col-12">
        <div class="row">
          @foreach ($agents->where('is_premium',0) as $i=>$agent)

            <div class="col-6 col-lg-2 col-sm-4 mb-2">
                @include('template.components.c_agent',[
                  'title'=>$agent->nom_complet,
                  'info'=>$agent->annonces->count()?'+'.$agent->annonces->count().' proprieté(s)':' aucune proprieté',
                  'img'=>$agent->picture!=null?$agent->picture:'img/user.png',
                  'tel'=>$agent->telephone,
                ])

            </div>
          @endforeach
          {{ $agents->links('pagination::bootstrap-4') }}
          @if(count($agents)==0)
            <div class="bg-light p-4">
              <p class="text-center">
                Aucun Agent trouvé
              </p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>
@endsection
