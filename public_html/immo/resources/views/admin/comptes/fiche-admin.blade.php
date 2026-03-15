@php
    // $admin = $compte->users()->where('profil','admin')->first();
@endphp
@if ($compte)
    @section('view_content')
        @include('components.tab_title',[
            'title'=>"Informations de l'administrateur",
            'class'=>'bg-primary'
        ])
        @include('components.affichage',[
            'title'=>'Email',
            'value'=>$compte->email
        ])
        @include('components.affichage',[
            'title'=>'Prénom & Nom',
            'value'=>$compte->Nom
        ])
        @include('components.affichage',[
            'title'=>'Téléphone',
            'value'=>$compte->telephone
        ])
    @endsection
    @include('layouts.sub_layouts.visualisation')
@endif
