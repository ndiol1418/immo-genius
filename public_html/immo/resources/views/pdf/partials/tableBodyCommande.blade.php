@php
    $tva = 0;
    $somme = 0;
@endphp
@foreach ($commande->commande_lignes as $commande_ligne)
@php
    $somme  += $commande_ligne->produit->colisage*$commande_ligne->quantite*$commande_ligne->produit->prix_unitaire_ht ;
@endphp
    <tr>
        <td class=" text-sm">{{ $commande_ligne->produit->designation }}</td>
        <td class="text-center text-sm">{{ $commande_ligne->produit->colisage }}</td>
        <td class="text-center text-sm">{{ $commande_ligne->quantite }}</td>
        {{-- <td class="text-center text-sm">{{ $commande->qte_recu }}</td> --}}
        <td class="text-center text-sm">{{ $commande_ligne->produit->tva_vente }}</td>
        <td class="text-center text-sm">{{ $commande_ligne->produit->prix_unitaire_ht }}</td>
        <td class="text-right text-sm">{{ number_format($commande_ligne->produit->colisage*$commande_ligne->quantite*$commande_ligne->produit->prix_unitaire_ht,0,'',' ') }}</td>
    </tr>
@endforeach
<tr>
    <td class="no-border" colspan="4"></td>
    <td class="infos-table no-border bold " >Total HT</td>
    <td class="infos-table no-border bold text-right">{{ number_format($somme,0,'', ' ' )}} {{ $_devise }}</td>
</tr>
<tr>
    <td class="no-border" colspan="4"></td>
    <td class="infos-table no-border bold ">TVA</td>
    <td class="infos-table no-border bold text-right">{{ number_format($commande->tva_vente,0,'', ' ' ) }} {{ $_devise }}</td>
</tr>
<tr>
    <td class="no-border"  colspan="4"></td>
    <td class="infos-table no-border bold "  >Total TTC</td>
    <td class="infos-table no-border bold text-right ">  {{ number_format($somme+$tva,0,'', ' ' ) }} {{ $_devise }}</td>
</tr>
