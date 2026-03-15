<section id="services" class="services section">
    <div class="container">
      <div class="col-12">
        <div class="row d-flex align-items-center justify-content-between">
          <div class="col-12 col-lg-5">
            <div class="card btn-secondary border-0 radius-theme">
              <div class="card-body p-0">
                <h3 class="p-4"><strong>La nouvelle façon de trouver votre nouvelle maison</strong>
                  <p class="text-sm">Trouvez l'endroit de vos rêves où vivre avec plus de 10 000 propriétés répertoriées.</p>
                  @include('template.components.c_button',[
                    'title'=>'voir les annonces ',
                    'bg'=>'dark text-sm',
                    'size'=>25,
                    'route'=>'louer',
                    'is_btn'=>true,
                    'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M4.5 11h11.586l-4.5-4.5L13 5.086L19.914 12L13 18.914L11.586 17.5l4.5-4.5H4.5z"/></svg>'
                ])
                </h3>
                <div>
                  <img src="{{ asset('img/Illustration.png') }}" alt="" style="width: 100%;object-fit:contain">
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="row">
              @include('template.components.c_card',[
                'title'=>'Assurance de biens',
                'subtitle'=>"Nous offrons à nos clients une protection des biens grâce à une couverture responsabilité civile et une assurance pour une vie meilleure.",
                'img'=>'icon-home.svg'
              ])
              @include('template.components.c_card',[
                'title'=>'Les Meilleur prix',
                'img'=>'icon-money.svg',
                'subtitle'=>'Vous ne savez pas quel tarif vous devriez appliquer pour votre propriété ? Pas de souci, laissez-nous faire les calculs pour vous.'

              ])
              @include('template.components.c_card',[
                'title'=>'Faibles comissions',
                'img'=>'icon-comission.svg',
                'subtitle'=>"Vous n'avez plus besoin de négocier les commissions et de marchander avec d'autres agents, cela ne vous coûte que 2 % !"

              ])
              @include('template.components.c_card',[
                'title'=>'Contrôle Total',
                'img'=>'icon-info.svg',
                'subtitle'=>"Obtenez une visite virtuelle et planifiez des visites avant de louer ou d'acheter une propriété. Vous avez le contrôle total."

              ])
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>