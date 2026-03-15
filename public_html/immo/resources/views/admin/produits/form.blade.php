<style>
    .required-field::after {
        content: " *";
        color: red;
    }
</style>
<div class="card shadow-none mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="designation_courte">Designation Courte</label>
                    <input type="text" class="form-control" id="designation_courte" name="designation_courte"
                        value="{{ old('designation_courte', $produit->designation_courte ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="designation" class="required-field">Désignation</label>
                    <input type="text" class="form-control" id="designation" name="designation"
                        value="{{ old('designation', $produit->designation ?? '') }}" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="fournisseur_id" class="required-field">Fournisseur</label>
                    <select class="form-control" id="fournisseur_id" name="fournisseur_id" required>
                        @foreach ($fournisseurs as $fournisseur)
                            <option value="{{ $fournisseur->id }}"
                                {{ isset($produit) && $produit->fournisseur_id == $fournisseur->id ? 'selected' : '' }} >
                                {{ $fournisseur->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="code" class="required-field">Code Interne</label>
                    <input type="text" class="form-control" id="code" name="code"
                        value="{{ old('code', $produit->code ?? '') }}" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="codebarre">Code Barre</label>
                    <input type="text" class="form-control" id="codebarre" name="codebarre"
                        value="{{ old('codebarre', $produit->codebarre ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="code_barre_pcb">Code Barre PCB</label>
                    <input type="text" class="form-control" id="code_barre_pcb" name="code_barre_pcb"
                        value="{{ old('code_barre_pcb', $produit->code_barre_pcb ?? '') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="famille_id">Famille</label>
                    <select class="form-control" id="famille_id" name="famille_id">
                        @foreach ($familles as $famille)
                            <option value="{{ $famille->id }}"
                                {{ isset($produit) && $produit->famille_id == $famille->id ? 'selected' : '' }}>
                                {{ $famille->libelle }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="sous_famille_id">Sous-famille</label>
                    <select class="form-control" id="sous_famille_id" name="sous_famille_id">
                        @foreach ($sous_familles as $sous_famille)
                            <option value="{{ $sous_famille->id }}"
                                {{ isset($produit) && $produit->sous_famille_id == $sous_famille->id ? 'selected' : '' }}>
                                {{ $sous_famille->libelle }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label>Gammes</label>
                    <div>
                        @foreach ($gammes as $gamme)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gamme_id"
                                    id="gamme_id{{ $gamme->id }}" value="{{ $gamme->id }}"
                                    {{ isset($produit) && $produit->gamme_id == $gamme->id ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="gamme_id{{ $gamme->id }}">{{ $gamme->nom }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label for="colisage" class="required-field">Colisage</label>
                    <input type="number" class="form-control" id="colisage" name="colisage"
                        value="{{ old('colisage', $produit->colisage ?? '') }}" required>
                </div>
            </div>
        </div>
        <div class="card border-secondary">
            <div class="card-header bg-light text-secondary">
                <h5 class="card-title mb-0"> Informations d'achat</h5>
            </div>
            <div class="card-body border">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="pcb" class="required-field">PCB</label>
                            <input type="number" class="form-control" id="pcb" name="pcb"
                                value="{{ old('pcb', $produit->pcb ?? '') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="prix_unitaire_ht" class="required-field">Prix Unitaire HT</label>
                            <input type="number" class="form-control" id="prix_unitaire_ht" name="prix_unitaire_ht"
                                value="{{ old('prix_unitaire_ht', $produit->prix_unitaire_ht ?? '') }}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="prix_ht" class="required-field">Prix HT</label>
                            <input type="number" class="form-control" id="prix_ht" name="prix_ht"
                                value="{{ old('prix_ht', $produit->prix_ht ?? '') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="prix_ttc" class="required-field">Prix TTC</label>
                            <input type="number" class="form-control" id="prix_ttc" name="prix_ttc"
                                value="{{ old('prix_ttc', $produit->prix_ttc ?? '') }}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="tva_achat">TVA</label>
                            <select class="form-control" id="tva_achat" name="tva_achat">
                                @foreach ($taxes as $taxe)
                                    <option value="{{ $taxe->taux }}"
                                        {{ isset($produit) && $produit->tva_vente == $taxe->id ? 'selected' : '' }}>
                                        {{ $taxe->libelle }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-secondary">
            <div class="card-header bg-light text-secondary">
                <h5 class="card-title mb-0"> Informations de vente</h5>
            </div>
            <div class="card-body border">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="prix_vente_ht">Prix de vente HT</label>
                            <input type="number" class="form-control" id="prix_vente_ht" name="prix_vente_ht"
                                value="{{ old('prix_vente_ht', $produit->prix_vente_ht ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="prix_vente_ttc">Prix de vente TTC</label>
                            <input type="number" class="form-control" id="prix_vente_ttc" name="prix_vente_ttc"
                                value="{{ old('prix_vente_ttc', $produit->prix_vente_ttc ?? '') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="tva_vente">TVA</label>
                            <select class="form-control" id="tva_vente" name="tva_vente">
                                @foreach ($taxes as $taxe)
                                    <option value="{{ $taxe->taux }}"
                                        {{ isset($produit) && $produit->tva_vente == $taxe->id ? 'selected' : '' }}>
                                        {{ $taxe->libelle }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Écouteur d'événement pour le champ du prix HT
    $("#prix_ht").on('input', function() {
        var tva = parseFloat($("#tva_achat").val());
        var prix_ht = parseFloat($(this).val());
        var prix_ttc = prix_ht * (1 + (tva / 100));
        $("#prix_ttc").val(Math.round(prix_ttc * 100) / 100);
    });

    // Écouteur d'événement pour le champ du prix TTC
    $("#prix_ttc").on('input', function() {
        var tva = parseFloat($("#tva_achat").val());
        var prix_ttc = parseFloat($(this).val());
        var prix_ht = prix_ttc / (1 + (tva / 100));
        $("#prix_ht").val(Math.round(prix_ht * 100) / 100);
    });

    // Écouteur d'événement pour le champ du prix de vente HT
    $("#prix_vente_ht").on('input', function() {
        var tva = parseFloat($("#tva_vente").val());
        var prix_ht = parseFloat($(this).val());
        var prix_ttc = prix_ht * (1 + (tva / 100));
        $("#prix_vente_ttc").val(Math.round(prix_ttc * 100) / 100);
    });

    // Écouteur d'événement pour le champ du prix de vente TTC
    $("#prix_vente_ttc").on('input', function() {
        var tva = parseFloat($("#tva_vente").val());
        var prix_ttc = parseFloat($(this).val());
        var prix_ht = prix_ttc / (1 + (tva / 100));
        $("#prix_vente_ht").val(Math.round(prix_ht * 100) / 100);
    });

    // Écouteur d'événement pour le champ de la TVA de vente
    $("#tva_vente").on('change', function() {
        var tva = parseFloat($(this).val());
        var prix_ht = parseFloat($("#prix_vente_ht").val());
        if (!prix_ht || prix_ht === undefined) {
            prix_ht = 0;
        }
        var prix_ttc = prix_ht * (1 + (tva / 100));
        $("#prix_vente_ttc").val(Math.round(prix_ttc * 100) / 100);
    });
    $("#tva_achat").on('change', function() {
        var tva = parseFloat($(this).val());
        var prix_ht = parseFloat($("#prix_ht").val());
        if (!prix_ht || prix_ht === undefined) {
            prix_ht = 0;
        }
        var prix_ttc = prix_ht * (1 + (tva / 100));
        $("#prix_ttc").val(Math.round(prix_ttc * 100) / 100);
    });
</script>
