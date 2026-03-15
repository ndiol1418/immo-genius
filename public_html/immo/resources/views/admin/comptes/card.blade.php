@foreach ($datas as $data)
    {{-- @include('components.dashboard.card-info',[
        'title'=>$data['title'],
        'subtitle'=>$data['subtitle']??'',
        'class'=>$data['col']??'col-lg-6 col-sm-6 col-6',
        'nbre'=>$data['nbre'],
        'icon'=>$data['icon']??'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
        'route'=>$data['route']??false,
        'param'=>$data['param']??'',
        'key'=>$data['key']??'',
        'modelNbre'=>$data['modelNbre']??false,
    ]) --}}
    @include('components.stats.nombre',[
        'titre'=>$data['title'],
        // 'soustitre'=>__('fournisseur.tous'),
        'class'=>$col??'col-lg-3 col-sm-6 col-6',
        'nombre'=>$data['nbre'],
        'icone'=>$data['icon']??'<iconify-icon icon="fontisto:product-hunt" width="24" height="24"></iconify-icon>',
        'route'=>$data['route']??false,

        'bg'=>$class??'bg-white'
    ])
@endforeach

