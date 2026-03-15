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

  <section id="services" class="services section" style="margin-top: 100px;padding: 0 100px">
    <div class="container">
      <h3 class="text-center" style="margin-bottom: 50px">FAQ</h3>
      {{-- <div class="col-12 mt-4">
        <div class="row">
          <div class="col-12">
            <div id="accordion">
              <div class="card mb-4 shadow-none">
                <div class="card-header p-4" id="headingOne">
                  <h5 class="mb-0">
                    <a class="" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Collapsible Group Item #1
                    </a>
                  </h5>
                </div>
            
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                  <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                  </div>
                </div>
              </div>
              <div class="card mb-4 shadow-none">
                <div class="card-header p-4" id="headingTwo">
                  <h5 class="mb-0">
                    <a class=" collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      Collapsible Group Item #2
                    </a>
                  </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                  <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                  </div>
                </div>
              </div>
              <div class="card mb-4 shadow-none">
                <div class="card-header p-4" id="headingThree">
                  <h5 class="mb-0">
                    <a class=" collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      Collapsible Group Item #3
                    </a>
                  </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                  <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div> --}}
      <div class="accordion">
        <div class="accordion-item shadow-sm active">
            <div class="accordion-header">
                <span class="icon">+</span>
                <span>Quelle est votre politique de retour ?</span>
            </div>
            <div class="accordion-content">
                <p>Vous pouvez retourner un article sous 30 jours après l'achat.</p>
            </div>
        </div>
        
    </div>
      <div class="accordion">
        <div class="accordion-item shadow-sm ">
            <div class="accordion-header">
              <span class="icon">+</span>
                <span>Quelle est votre politique de retour ?</span>
            </div>
            <div class="accordion-content">
                <p>Vous pouvez retourner un article sous 30 jours après l'achat.</p>
            </div>
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