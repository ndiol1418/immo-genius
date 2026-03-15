@php
    $somme = 0;
@endphp
@foreach ($reception->reception_lignes as $item)
@php
    $tva = 0;
    $somme  += $item->commande_ligne->produit->colisage*$item->qte_recu*$item->commande_ligne->produit->prix_unitaire_ht ;
@endphp
    <tr>
        <td class=" text-sm">{{ $item->commande_ligne->produit->designation }}</td>
        <td class="text-center text-sm">{{ $item->commande_ligne->produit->colisage }}</td>
        <td class="text-center text-sm">{{ $item->commande_ligne->quantite }}</td>
        <td class="text-center text-sm">{{ $item->qte_recu }}</td>
        <td class="text-center text-sm">{{ $item->commande_ligne->produit->tva_vente }}</td>
        <td class="text-center text-sm">{{ $item->commande_ligne->produit->prix_unitaire_ht }}</td>
        <td class="text-right text-sm">{{ $item->commande_ligne->produit->colisage*$item->qte_recu*$item->commande_ligne->produit->prix_unitaire_ht }}</td>
    </tr>
@endforeach
<tr>
    <td class="no-border" colspan="5"></td>
    <td class="infos-table no-border bold " >Total HT</td>
    <td class="infos-table no-border bold text-right">{{ number_format($somme,0,'', ' ' )}} {{ $_devise }}</td>
</tr>
<tr>
    <td class="no-border" colspan="5"></td>
    <td class="infos-table no-border bold ">TVA</td>
    <td class="infos-table no-border bold text-right">{{ number_format($tva,0,'', ' ' ) }} {{ $_devise }}</td>
</tr>
<tr>
    <td class="no-border"  colspan="5"></td>
    <td class="infos-table no-border bold "  >Total TTC</td>
    <td class="infos-table no-border bold text-right ">  {{ number_format($somme+$tva,0,'', ' ' ) }} {{ $_devise }}</td>
</tr>
