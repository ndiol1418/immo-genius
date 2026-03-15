@component('mail::message')
<style>
    /* .panel{background: #fff !important;border: #ddd solid 1px !important;
    }
    .header{padding: 20px !important}
    h1{margin-top: 50px !important}
    table.panel{width: 100%;border-collapse: collapse !important;}
        table.panel tr:first-child td.first,th.first{
            border-top: 1px solid #ddd;
            font-size: 10px !important;
        } */
        table.panel td, th,tr{
            padding:5px !important;
            border:1px solid !important;
        }
        table.table * {padding: 10px;border-collapse: collapse;width: 100%;font-size: 10px !important;}
        .table  tr>td{font-size: 10px !important;color: #000 !important;
            background-color: #fff !important;padding: 4px !important;
            /* border:1px solid #f2f4f6!important; */
            width: auto !important;
        }
        thead>tr>td{background-color: #f2f4f6 !important;padding: 4px !important;font-size: 18x !important;font-weight: bold;}
</style>
# <span style="text-transform: capitalize">{{ $complement_subject??'---' }}</span>

<span style="text-transform: capitalize"> Bonjour {{ $gerant??'---' }}</span>, <br>
{!! $content??'---' !!}

@if(isset($is_commande) && $is_commande)

    @component('mail::button', ['url' => route('commandes.visualisation',$commande->token), 'color' => 'green'])
    Lien de confirmation
    @endcomponent
    <br>
    ## Informations


    <table class="table table-striped" style="width: 100%">
        <thead >
            <tr>
                <td style="background-color:#f2f4f6 !important">{{ __('produit.designation') }}</td>
                <td style="background-color:#f2f4f6 !important">{{ __('produit.qte') }}</td>
                <td style="background-color:#f2f4f6 !important">{{ __('produit.prix_ht') }}</td>
                <td style="background-color:#f2f4f6 !important">{{ __('produit.prix_ttc') }}</td>
            </tr>
            <tbody>
                @php
                    $somme = 0;
                @endphp
                @foreach ($commande->commande_lignes as $commande_ligne)
                @php
                    $somme  += $commande_ligne->produit->colisage*$commande_ligne->quantite*$commande_ligne->produit->prix_unitaire_ht ;
                @endphp
                <tr>
                    <td>{{ $commande_ligne->produit->designation }} </td>
                    <td>{{ $commande_ligne->quantite }} </td>
                    <td>{{ $commande_ligne->produit->prix_unitaire_ht }} </td>
                    <td>{{ number_format($commande_ligne->quantite*$commande_ligne->prix_ht,0,'',' ') }} </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="2"></td>
                    <td>{!! '<b>Montant Total </b>' !!}</td>
                    <td>{{number_format($somme,0,","," ") }} {{ $user?$user->compte->devise->libelle:'' }}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>{!! '<b>Subventions </b>' !!}</td>
                    <td>{{ number_format($commande->tva,0,","," ") }}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>{!! '<b>Total Net à Payer </b>' !!}</td>
                    <td>{{ number_format($somme + $commande->tva_vente,0,","," ") }} {{ $user?$user->compte->devise->libelle:'' }}</td>
                </tr>
            </tbody>
        </thead>
    </table>
@endif


<br><br>
Cordialement,<br>
{{ config('app.name') }} - {{ $commande->compte->libelle }}
@endcomponent
