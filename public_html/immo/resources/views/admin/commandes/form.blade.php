
<div class="row">
    <div class="col-12 col-lg-12">
        <label for="">Fournisseurs</label>
        <select name="fournisseur_id" @if(count($commande->commande_lignes) > 0) {{ 'disabled' }} @endif id="fournisseur" class="form-control select2">
            <option>Choisissez un fournisseur</option>
            @foreach ($fournisseurs as $k => $fournisseur)
                <option
                    @isset($commande)
                        @if ($commande->fournisseur_id == $fournisseur->id)
                            {{ 'selected' }}
                        @endif
                    @endisset
                    value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}
                </option>
            @endforeach
        </select>
    </div>
    @if (isset($station))
        @if($_user->profil == 'gerant')
            <input type="hidden" name="station_id" value="{{ $_user->station->id }}">
            @else
            <div class="col-12 col-lg-12">
                <label for="">Stations</label>
                <select name="station_id" id="station" class="form-control select2">
                    @foreach ($stations as $k => $station)
                        <option
                            @isset($commande)
                                @if ($commande->station_id == $station->id)
                                    {{ 'selected' }}
                                @endif
                            @endisset
                            value="{{ $station->id }}">{{ $station->nom }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    @endif
</div>

