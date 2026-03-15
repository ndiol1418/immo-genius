<style>
    .hidden {
        display: none;
    }
</style>

<div class="col-md-6">
    <div class="card shadow-none mb-4">
        <div class="card-body">
            <div class="form-group mb-2">
                <label for="fournisseur_id">{{ __('enpromo.fournisseur') }}</label>
                <select class="form-control select2" id="fournisseur_id" name="">
                    <option value="">Choisissez un fournisseur</option>
                    @foreach ($fournisseurs as $fournisseur)
                        <option value="{{ $fournisseur->id }}"
                            {{ old('fournisseur_id', isset($promotion) ? $promotion->fournisseur_id : '') == $fournisseur->id ? 'selected' : '' }}>
                            {{ $fournisseur->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-2">
                <label for="produit_id">{{ __('enpromo.produit') }}</label>
                <select class="form-control select2 designation-produit" id="produit_id" name="">
                    <option value="">Choisissez un produit</option>
                    @foreach ($produits as $produit)
                        <option value="{{ $produit->id }}" data-fournisseur-id="{{ $produit->fournisseur_id }}">
                            {{ $produit->designation }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Type de promotion</label><br>
                <div class="form-check form-check-inline ml-2">
                    <label class="btn btn-secondary {{ old('type', isset($promotion) ? $promotion->type : '') == 1 ? 'active' : '' }}">
                        <input type="radio" name="type" id="pourcentage" autocomplete="off" value="1" min="0"
                            {{ old('type', isset($promotion) ? $promotion->type : '') == 1 ? 'checked' : '' }}>
                        Pourcentage
                    </label>
                </div>
                <div class="form-check form-check-inline ml-2">
                    <label class="btn btn-secondary {{ old('type', isset($promotion) ? $promotion->type : '') == 2 ? 'active' : '' }}"
                        required>
                        <input type="radio" name="type" id="montant" autocomplete="off" value="2" min="0"
                            {{ old('type', isset($promotion) ? $promotion->type : '') == 2 ? 'checked' : '' }}>
                        Montant
                    </label>
                </div>
                <div class="form-check form-check-inline ml-2">
                    <label class="btn btn-secondary {{ old('type', isset($promotion) ? $promotion->type : '') == 3 ? 'active' : '' }}"
                        required>
                        <input type="radio" name="type" id="quantite" autocomplete="off" value="3" min="0"
                            {{ old('type', isset($promotion) ? $promotion->type : '') == 3 ? 'checked' : '' }}>
                        Quantité
                    </label>
                </div>
            </div>
            <div class="form-group promotion-fields" id="pourcentage-fields" style="display: none;">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="qte_min_acht_pourcentage">Quantité minimale à acheter</label>
                        <input type="number" class="form-control qte-min-acht" id="qte_min_acht_pourcentage"
                            name="" min="0"
                            value="{{ old('qte_min_acht_pourcentage', isset($promotion) ? $promotion->qte_min_acht : '') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="pourcentage">Réduction en pourcentage</label>
                        <input type="number" class="form-control pourcentage" id="pourcentage_input" name="" min="0"
                            value="{{ old('reduction_pourcentage', isset($promotion) ? $promotion->reduction : '') }}">
                    </div>
                </div>
                <button type="button" class="btn btn-success add-promotion">
                    <i class="fa fa-plus"></i> Ajouter
                </button>
            </div>
            <div class="form-group promotion-fields" id="montant-fields" style="display: none;">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="qte_min_acht_montant">Quantité minimale à acheter</label>
                        <input type="number" class="form-control qte-min-acht" id="qte_min_acht_montant" name="" min="0"
                            value="{{ old('qte_min_acht_montant', isset($promotion) ? $promotion->qte_min_acht : '') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="montant">Réduction en montant</label>
                        <input type="number" class="form-control montant" id="montant_input" name="" min="0"
                            value="{{ old('reduction_montant', isset($promotion) ? $promotion->reduction : '') }}">
                    </div>
                </div>
                <button type="button" class="btn btn-success add-promotion">
                    <i class="fa fa-plus"></i> Ajouter
                </button>
            </div>
            <div class="form-group promotion-fields" id="quantite-fields" style="display: none;">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="qte_acht">Quantité à acheter</label>
                        <input type="number" class="form-control qte-acht" id="qte_acht" name="" min="0"
                            value="{{ old('qte_acht', isset($promotion) ? $promotion->qte_acht : '') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="qte_off">Quantité à offrir</label>
                        <input type="number" class="form-control qte-off" id="qte_off" name="" min="0"
                            value="{{ old('qte_off', isset($promotion) ? $promotion->qte_off : '') }}">
                    </div>
                </div>
                <button type="button" class="btn btn-success add-promotion">
                    <i class="fa fa-plus"></i> Ajouter
                </button>
            </div>     
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card shadow-none mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">{{ __('enpromo.produit') }}</th>
                        <th scope='col'>{{ __('enpromo.type de promotion') }}</th>
                        <th scope="col">{{ __('enpromo.reduction') }}</th>
                        <th scope="col">{{ __('enpromo.quantite a acheter') }}</th>
                        <th scope="col">{{ __('enpromo.quantite a offrir') }}</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                    <tbody>
                        @if (isset($en_promos) && count($en_promos) > 0)
                        @foreach ($en_promos as $en_promo)
                            <tr>
                                <td>{{ $en_promo->produit->designation }}</td>
                                <td>{{ $en_promo->type_promo }}</td>
                                <td>{{ $en_promo->reduction ?? 0 }}</td>
                                <td>{{ $en_promo->qte_acht ?? 0 }}</td>
                                <td>{{ $en_promo->qte_off ?? 0 }}</td>
                                <td><i class="fa fa-trash delete-row supp" data-id="{{$en_promo->id}}" data-action="{{ route('admin.promotions.suppression_produit_enpromo') }}"></i></td>
                            </tr>
                        @endforeach
                    </tbody>
                @else

                @endif

            </table>
        </div>
    </div>
</div>
