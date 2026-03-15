<div class="col-12 col-md-6">
    <div class="card-body pt-0">
        <div class="row">
        {{-- Dashbord --}}
            @include('components.title-separe',[
                'title'=>'Informations Globales',
                'class'=>'text-muted'
            ])
            @include('admin.comptes.card',[
                'datas'=>$datas
            ])
        </div>
    </div>
</div>
<div class="col-12 col-lg-6">
    <div class="card-body pt-0">
        <div class="row">
            @include('components.title-separe',[
                'title'=>'Commandes du mois en cours: '.$month.'',
                'class'=>'text-muted'
            ])
            @include('admin.comptes.card',[
                'datas'=>$commandes,
            ])
        </div>
    </div>
</div>
<div class="col-12 col-lg-6">
    <div class="card-body pt-0">
        <div class="row">
            @include('components.title-separe',[
                'title'=>'Situation du mois précédent',
                'class'=>'text-muted'
            ])
            @include('admin.comptes.card',[
                'datas'=>$mois_precedent
            ])
        </div>
    </div>
</div>
<div class="col-12 col-lg-6">
    <div class="card-body pt-0">
        <div class="row">
            @include('components.title-separe',[
                'title'=>"Chiffre d'affaire HT de l'année en cours",
                'class'=>'text-muted'
            ])
            <div class="col-12">
                <div class="card shadow-none">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-12 col-lg-6">
    <div class="card-body pt-0">
        <div class="row">
            @include('components.title-separe',[
                'title'=>"Chiffre d'affaire HT par fournisseur",
                'class'=>'text-muted'
            ])
            <div class="col-12">
                <div class="card shadow-none">
                    <div class="card-body chart-responsive d-flex justify-content-center align-items-center">
                        <div class="chart" id="myfirstchart" style="height: 330px;width:300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
