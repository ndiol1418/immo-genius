<div class="col-12">
    <div class="card shadow-none">
        <div class="card-body d-flex flex-column">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset($promotion->image) }}" class="card-img-top" alt="Image de la promotion" style="height:200px !important;width:200px; object-fit: cover;">
                </div>
                <div class="col-md-6">
                    <div class="profile-work mt-2 w-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong class="w-50 text-danger ">{{ __('promotion.nom') }}</strong>
                        </div>
                        <div class="text-left pl-2 bg-light rounded text-danger mb-2">
                            {{ $promotion->nom }}
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <strong class="w-50 text-danger ">{{ __('promotion.debut') }} </strong>
                        </div>
                        <div class="text-left pl-2 bg-light rounded text-danger">
                            {{ $promotion->debut }}
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <strong class="w-50 text-danger ">{{ __('promotion.fin') }}</strong>
                        </div>
                        <div class="text-left pl-2 bg-light rounded text-danger mb-2">
                            {{ $promotion->fin }}
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <strong class="w-50 text-danger ">{{ __('promotion.description') }}</strong>
                        </div>
                        <div class="text-left pl-2 bg-light rounded text-danger mb-2">
                            {{ $promotion->description }}
                        </div>
                    </div>
                    @if (auth()->user()->profil == 'admin')
                        <div class="mt-5 mb-5">
                            <div class="buttons-container d-flex justify-content-center">
                                <a href="{{ route('admin.promotions.edit', $promotion->id) }}" class="btn btn-info btn-sm mr-2">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <form method="post" action="{{ route('admin.promotions.destroy', $promotion->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette promotion ?')">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div>
</div>

<div class="col-12 order-last">
    <div class="card shadow-none">
        <div class="card-body d-flex flex-column h-100">
            <div class="card-body d-flex flex-column h-100">
                @include('components.title-separe',[
                    'title'=>__('Informations sur les produits'),
                    'class'=>'text-muted mb-2'
                ])
                @section('tableHeader')
                    <tr>
                        <td>{{ __('enpromo.produit') }}</td>
                        <td>{{ __('enpromo.type de promotion') }}</td>
                        <td>{{ __('enpromo.reduction') }}</td>
                        <td>{{ __('enpromo.quantite a acheter') }}</td>
                        <td>{{ __('enpromo.quantite a offrir') }}</td>
                    </tr>
                @endsection
                @section('tableBody')
                @php $i = 1 @endphp
                @foreach ($promotion->en_promos as $en_promo)
                    <tr>
                        <td>{{ $en_promo->produit->designation }}</td>
                        <td>{{ $en_promo->type_promo }}</td>
                        <td>
                            @if ($en_promo->type_promo == 'Quantité' && is_null($en_promo->reduction))
                                ...
                            @else
                                {{ $en_promo->reduction ?: '...' }}
                            @endif
                        </td>
                        <td>
                            {{ $en_promo->qte_acht ?: 0 }}
                        </td>
                        <td>
                            @if (in_array($en_promo->type_promo, [1, 2]) && is_null($en_promo->qte_off))
                                ...
                            @else
                                {{ $en_promo->qte_off ?: '...' }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endsection
            </div>
            @include('layouts.sub_layouts.datatable')
        </div>
    </div>
</div>
</div>

@section('scriptBottom')
    @include('partials.utilities.datatableElement', ['id' => 'datatable'])
@endsection
