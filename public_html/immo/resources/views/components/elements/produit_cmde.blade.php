<table class="table table-striped table-borderless table-sm" style="width: 100%">
    <thead>
        <tr class="bg-gray">
            <th>{{ __('commande.designation') }}</th>
            <th class="text-center">{{ __('commande.colisage') }}</th>
            <th class="text-center">{{ __('commande.qte_cmd') }}</th>
            {{-- <th>{{ __('commande.qte_recu') }}</th> --}}
            <th class="text-center">{{ __('fournisseur.tva') }}</th>
            <th class="text-center">{{ __('produit.prix_unitaire_ht') }}</th>
            <th class="text-right">{{ __('produit.prix_ht') }}</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($commande->commande_lignes as $ligne)
            <tr>
                <td><input type="hidden" name="id[]" value='{{ $ligne->produit_id }}'>{{ $ligne->produit->designation }}</td>
                <td class="text-center"> {{ $ligne->produit->colisage }}</td>
                <td class="text-center"> {{ $ligne->quantite }}</td>
                {{-- <td class="text-center"> {{ $ligne->quantite_rec }}</td> --}}
                <td class="text-center">{{ number_format($ligne->tva_vente,0,'',' ') }}</td>
                <td class="text-center">{{ number_format($ligne->prix_ht,0,'',' ') }}</td>
                <td class="text-right">{{ number_format($ligne->quantite*$ligne->prix_ht,0,'',' ') }}</td>

            </tr>
        @endforeach
        <tr class="font-weight-bold">
            <td class="bg-white"></td>
            <td class="bg-white"></td>
            <td class="bg-white"></td>
            <td class="bg-white"></td>
            {{-- <td class="bg-white"></td> --}}
            <td class="bg-gray">{{ __('commande.total_ht') }}</td>
            <td class="bg-gray text-right" colspan="3">{{ number_format($commande->somme(),0,'',' ') }}</td>
        </tr>
        <tr class="font-weight-bold">
            <td class="bg-white"></td>
            <td class="bg-white"></td>
            <td class="bg-white"></td>
            <td class="bg-white"></td>
            {{-- <td class="bg-white"></td> --}}
            <td class="bg-gray">{{ __('fournisseur.tva') }}</td>
            <td class="bg-gray text-right" colspan="3" >{{ number_format($commande->tva_vente,0,'',' ') }}</td>
        </tr>
        <tr class="font-weight-bold">
            <td class="bg-white"></td>
            <td class="bg-white"></td>
            <td class="bg-white"></td>
            <td class="bg-white"></td>
            {{-- <td class="bg-white"></td> --}}
            <td class="bg-gray">{{ __('commande.total_ttc') }}</td>
            <td class="bg-gray text-right" colspan="3">{{ number_format($commande->somme()+$commande->tva_vente,0,'',' ') }}</td>
        </tr>
    </tbody>
</table>


