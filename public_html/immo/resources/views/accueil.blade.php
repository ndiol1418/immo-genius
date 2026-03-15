
@extends( ($_user->profil == 'superviseur') ? 'layouts.superviseur' : 'layouts.admin')
@section('title')
    {{ __('Tableau de Bord') }}
@endsection

@section('content')
    {{-- Contenu de la page --}}
    <div class="col-12 col-md-12">
        @include('components.title-separe',[
            'title'=>"Tableau de bord",
            'class'=>'text-muted d-none'
        ])

        <div class="row" id="_wait">
            <div class="col-12">
                <div class="jumbotron text-center p-5">
                    Chargement en cours ....
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scriptBottom')
    @include('components.fragmentJs',['url'=>route('partials.getCards'),"id"=>'wait'])
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
@endsection
