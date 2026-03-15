<div class="col-6" >
    <table class="table bg-light" style="height: 130px;;border-radius:5px">
        <tr>
            <th class="w-25 ">{{ __('boutique.station') }}</th>
            <td class="">
                {{ isset($commande->station)?$commande->station->nom:'' }}
            </td>
        </tr>
        <tr>

            <th class="w-25 ">{{ __('boutique.telephone') }}</th>
            <td class="bold  text-muted">
                {{ $commande->station->telephone }}
            </td>
        </tr>
        <tr>
            <th class="w-25">{{ __('boutique.adresse') }}</th>
            <td class="text-muted">{{ $commande->station->adresse }}</td>

        </tr>
        <tr>
            <th class="w-25">{{ __('boutique.email') }}</th>
            <td class="text-muted">{{ $commande->station->user->email }}</td>
        </tr>
    </table>
</div>
