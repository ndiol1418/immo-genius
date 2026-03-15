@section('tableHeader')
    <tr>
        <td>{{ __('produit.designation') }}</td>
        <td>{{ __('produit.code_barre') }}</td>
        <td>{{ __('produit.colisage') }}</td>
        <td>{{ __('produit.prix_unitaire_ht') }}</td>
        <td>{{ __('produit.prix_ht') }}</td>
        <td class="action text-center">Action(s)</td>
    </tr>
@endsection
{{-- Table Body --}}
@section('tableBody')
@php $i = 1; @endphp
@foreach ($produits as $produit)
    <tr>
        <td>{{ $produit->designation }}</td>
        <td>{{ $produit->codebarre }}</td>
        <td>{{ $produit->collisage }}</td>
        <td>{{ $produit->prix_unitaire_ht }}</td>
        <td>{{ $produit->prix_ht }}</td>

        <td class="text-center">
            <a href="{{ route('admin.produits.show', $produit->id)  }}" class="btn btn-danger btn-xs">
                <i class="fa fa-eye"></i>
            </a>
            <a href="{{ route('admin.produits.edit', $produit->id)  }}" class="btn btn-warning btn-xs">
                <i class="fa fa-edit"></i>
            </a>
            @if ($produit->etat)
                @include('partials.components.deleteBtnElement',[
                    'url'=>route('admin.produits.destroy',$produit->id),
                    'class'=> 'btn btn-sm btn-success',
                    'message_confirmation'=>"Voulez-vous vraiment désactiver le produit : " .$produit->nom,
                    'entity'=>$produit,
                    'btnInnerHTML'=>'<i class="fa fa-unlock"></i>'
                ])
            @else
                @include('partials.components.deleteBtnElement',[
                    'url'=>route('admin.produits.destroy',$produit->id),
                    'class'=> 'btn btn-sm btn-danger',
                    'message_confirmation'=>"Voulez-vous vraiment activer le produit : " .$produit->nom,
                    'entity'=>$produit,
                    'btnInnerHTML'=>'<i class="fa fa-lock"></i>'
                ])
            @endif
        </td>
    </tr>
@php $i++; @endphp
@endforeach
@endsection

{{-- Datatable extension --}}
@include('layouts.sub_layouts.datatable',['atr'=>'produits'])
