<div class="col-6">
    <table class="table bg-light" style="height: 130px;border-radius:5px">
        <tr>
            <th class="w-25">{{ __('fournisseur.fournisseur') }}</th>
            <td class="">
                {{ isset($commande->fournisseur)?$commande->fournisseur->nom:'' }}
            </td>
        </tr>
        <tr>

            <th class="w-25 first">{{ __('fournisseur.telephone') }}</th>
            <td class="bold first text-muted">
                {{ $commande->fournisseur->telephone }}
            </td>
        </tr>
        <tr>
            <th class="w-25">{{ __('fournisseur.adresse') }}</th>
            <td class="text-muted">{{ $commande->fournisseur->adresse }}</td>

        </tr>
        <tr>
            <th class="w-25">{{ __('fournisseur.email') }}</th>
            <td class="text-muted">{{ $commande->fournisseur->email }}</td>
        </tr>
    </table>
</div>
