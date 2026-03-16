@extends('layouts.admin')
@section('title')
   Visualisation
@endsection
@section('subtitle',"Visualisation")

@section('actions')
<a href="{{ route($_espace.'.immos.edit', $immo->id)  }}" class="btn btn-warning btn-xs">
    <i class="fa fa-edit"></i> Editer
</a>
<form method="POST" action="/admin/immos/{{$immo->id}}" style="display: inline-block;">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button type="submit" class="btn btn-xs btn-danger  delete-immo"> <i class="fa fa-trash"></i> Supprimer</button>
</form>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        @include('components.title-separe',[
                            'title'=>"Fiche",
                            'class'=>'text-muted text-uppercase'
                        ])
                        <div class="row">
                            @include('components.fiche',[
                                'title'=>'Nom',
                                'value'=>$immo->name,
                                'style'=>1,
                                'col'=>'col-12 col-lg-6'
                            ])
                            @include('components.fiche',[
                                'title'=>'Fournisseur',
                                'value'=>$immo->fournisseur?$immo->fournisseur->nom_complet:'Teranga Immobiliero',
                                'style'=>1,
                                'col'=>'col-12 col-lg-6'
                            ])
                            @include('components.fiche',[
                                'title'=>'Adresse',
                                'value'=>$immo->fournisseur?$immo->fournisseur->adresse:'Teranga Immobiliero',
                                'style'=>1,
                                'col'=>'col-12 col-lg-6'
                            ])
                            @include('components.fiche',[
                                'title'=>'Telephone',
                                'value'=>$immo->fournisseur?$immo->fournisseur->telephone:'Teranga Immobiliero',
                                'style'=>1,
                                'col'=>'col-12 col-lg-6'
                            ])
                            @include('components.fiche',[
                                'title'=>'Affecté à',
                                'value'=>$immo->agent?$immo->agent->nom_complet:'---',
                                'style'=>1,
                                'col'=>'col-12 col-lg-6'
                            ])
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        @if(count($agents))
                            @include('components.title-separe',[
                                'title'=>"Affectation",
                                'class'=>'text-muted text-uppercase'
                            ])
                            <div class="row">
                                <div class="col-12 mt-2">
                                    <div class="card-body bg-light rounded">
                                        <form action="{{ route($_espace.'.immos.update',$immo->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="fournisseur_id" id="" required class="form-control form-control-sm">
                                                @isset($agents)
                                                    @foreach ($mes_agents as $agent)
                                                        <option value="{{ $agent->id }}" {{ in_array($agent->id,[$immo->agent_id]) ? 'selected':'' }}>
                                                            {{ $agent->nom_complet }}
                                                        </option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            <button type="submit" name="affectation" class="btn btn-sm btn-primary mt-2">Mettre a jour</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="jumbotron">
                                <h3 class="text-center">
                                    Vous n'avez pas d'agents !!
                                </h3>
                                <p class="text-center text-danger">
                                    Veuillez développer votre réseau d'agents
                                </p>
                            </div>
                        @endif
                    </div>
                    <div class="col-12 col-lg-&é">
                        @include('components.title-separe',[
                            'title'=>"Développer mon réseau",
                            'class'=>'text-muted text-uppercase'
                        ])
                        <div class="row">
                            @foreach($agents as $key => $agent)
                                <div class="col-4 col-lg-2">
                                    <div class="card shadow-none">
                                        <div class="card-body">
                                            <div class="row d-flex justify-content-center align-items-center">
                                                <span class="col-12 text-center text-sm truncate text-uppercase">{{ $agent->nom_complet }}</span>
                                                @include('partials.components.postBtnElement',[
                                                    'url'=>route('agent.reseau',$immo->id),
                                                    'class'=> 'btn btn-xs btn-outline-primary text-center',
                                                    'message_confirmation'=>__("Voulez-vous vraiment se connecter à l agent ?"),
                                                    'id'=>$agent->id,
                                                    'btnInnerHTML'=>'<svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="m17.657 12l-1.414-1.414l2.121-2.122a2 2 0 1 0-2.828-2.828l-4.243 4.243a2 2 0 0 0 0 2.828l-1.414 1.414a4 4 0 0 1 0-5.657l4.242-4.242a4 4 0 0 1 5.657 5.657zM6.343 12l1.414 1.414l-2.121 2.122a2 2 0 1 0 2.828 2.828l4.243-4.243a2 2 0 0 0 0-2.828l1.414-1.414a4 4 0 0 1 0 5.657L9.88 19.778a4 4 0 1 1-5.657-5.657z"/></svg>
                                                    contacter',
                                                    'name'=>'agents[]',
                                                    'value'=>$agent->id
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scriptBottom')
<script>

    $('body').on('click', '.editModal', function() {
        $('#form').attr('action', $(this).attr('href'));
        $('#id').val($(this).data('id'));
        $('#name').val($(this).data('name'));
        $('#code_barre').val($(this).data('code_barre'));
        var val = $(this).data('formation_type_id');
        var dept = 1
        $('#type_promotion_id option[value='+val+']').attr('selected','selected');
        $('#departements_id option[value='+dept+']').attr('selected','selected');
    });
    @if (count($errors) > 0)
        $('#creationModal').modal('show');
    @endif
</script>
    <script src="{{ asset('js/scriptConfig.js') }}"></script>
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
@endsection
