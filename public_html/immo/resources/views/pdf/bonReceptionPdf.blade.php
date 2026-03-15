@extends('layouts.pdf')

@section('title', 'Visualisation du Bon de reception')


@section('customCss')
    <style>
        * {font-family:'Nunito' !important;font-size:12px;}
         @page { margin-top: 150px ;}
         .bg-light {
            background-color: #f8f9fa !important;
        }
         .text-center{text-align: center;}
         .text-right{text-align: right;}
         .row {
            display: flex;
            /* flex-wrap: wrap; */
            margin-right: -7.5px;
            margin-left: -7.5px;
        }
         .text-sm{font-size: 12px !important}
        .main-container{width: 100%; margin-top: 0px; margin-bottom: 30px }
        .en-tete{display:block;}
        .en-tete-logo{float:left;display:block;}
        .en-tete-texte{float:right;font-size:28px !important;text-transform: uppercase;margin-top:30px;font-weight: 400;font-family:'Nunito', sans-serif !important;line-height: 20px;text-align: right}
        .infos-table{background-color:#f2f4f6;width: 700px;}
        th,td{margin:0 !important;padding:0 2px !important;text-align:left;}

        .form-container{margin-top:20px;padding-top:5px;}
        .field-container{margin:2px 0;display:inline-block;}
        .field-value-container{min-height: 18px;background-color:#f2f4f6;padding:3px 3px;}
        .field-value-container{min-height: 18px;background-color:#f2f4f6;padding:3px 3px;line-height: 1.5}

        .pj-titre{font-weight:bold;margin-top:15px;}
        .pj{background-color:#f2f4f6;padding:3px;width: 693px;}
        .text-muted{color:#333}
        .ld-titre{font-weight:bold;margin-top:15px;}
        .ld{padding:3px 0;width: 693px;}
        .bg-gray{background: #ddd !important;}
        .bg-white{background: #fff !important;}
        .paraphes-titre{font-weight:bold;margin-top: 15px }
        .paraphes-titre-sans-signature{font-weight:bold;margin-top:15px}
        .paraphes-container{border:1px solid #eee;padding:2px;width: 693px;}
        .paraphe{font-size: 8px;line-height: 8px;display:inline-block;margin-top:10px }
        .paraphe-img{width:50px;height:30px;object-fit:contain;}

        .signatures-titre{font-weight:bold;margin-top:25px;margin-bottom: 28px;}
        .signatures-container{overflow:auto;}
        .signature{font-size: 11px;line-height: 11px;width:215.9px;padding:5px;border:1px solid #eee;text-align:center;display: inline-block;margin-top:10px;margin-left:2px;page-break-inside: avoid}
        .signature-img{width:215.9px;height:125px;object-fit:contain;}

        .chaine-traitement-titre{font-weight:bold;margin-top:15px;}
        .chaine-traitement-container{background-color:#f2f4f6;padding:3px;}

        .border {border: 1px solid #eee; }
        .no-border {border: 1px solid #fff !important; }
        .bold{font-weight: bold;}
        .objet{margin:40px 5px 5px 0;}
        .col-2{width: 115px;}
        .col-3{width: 172.4px;}
        .col-4{width: 230.9px;}
        .col-6{width: 348.2px;}
        .col-12{width: 700px;}
        th{font-weight: bold;}
        .w-25 {width: 25% !important;}
        .w-50 {width: 50% !important;}
        .w-75 {width: 75% !important;}
        .w-100 {width: 100%;}
        table.table{width: 100%;border-collapse: collapse !important;}
        table.table tr:first-child td.first,th.first{
            border-top: 1px solid #000;
        }
        table.table td, th{
            border: 1px solid #f8f9fa;
            padding:5px !important
        }
        table.table * {padding: 10px;border-collapse: collapse;width: 100%;font-size: 12px;}
        header {position: fixed;top: -140px;left: 0;right: 0;padding: 10px;padding: 0;margin:0 }
        footer {position: fixed;bottom: 0;left: 0;right: 0;background-color: #ddd;color: #fff; padding: 5px;text-align: center;color:#000}
        footer .pagenum:before {
            content: counter(page);
            float: right;
            margin-left: 8px;
            font-weight: 900;
            font-size: 14px
        }
    </style>
@endsection

@section('content')
    <header>
        <div class="en-tete">
            @include('pdf.partials.entetePdf',[
                'data'=>isset($is_commande)?$commande:$reception
            ])
        </div>
    </header>
    <div class="main-container">
        <br>
        <table class="w-100">
            <tr>
                <td class="w-50">
                    @include('pdf.partials.infos-fournisseur',[
                        'commande'=>isset($is_commande)?$commande:$reception->commande
                    ])
                </td>
                <td class="w-50">
                    @include('pdf.partials.infos-station',[
                        'commande'=>isset($is_commande)?$commande:$reception->commande
                    ])
                </td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        @if(!isset($is_commande))
            <div class="w-50">
                <span style="text-transform: capitalize;margin-left:4px"> {{ __('commande.num_bc') }} : {{ $reception->commande->ref }}</span> <br>
            </div>
        @endif

        <h3 class="text-center" style="text-transform: uppercase">Détails {{ $detail??'de la reception' }}</h3>
        <br>
        <table class="table">
            <thead class="infos-table">
                <th class="bold" style="width: 150px">
                    {{ __('produit.designation') }}
                </th>
                <th class="btext-center old" style="width: 50px">
                    {{ __('produit.colisage') }}
                </th>
                <th class="text-center bold" style="width: 50px">
                    {{ __('commande.qte') }}
                </th>
                @if(!isset($is_commande))
                    <th class="text-center bold" style="width: 50px">
                        {{ __('commande.qte_recu') }}
                    </th>
                @endif
                <th class="text-center bold"  style="width: 50px">
                    {{ __('fournisseur.tva') }}
                </th>
                <th class="text-center bold" style="width: 100px">
                    {{ __('produit.prix_unitaire_ht') }}
                <th class="text-right bold"  style="width: 100px">
                    {{ __('commande.montant_total') }}
                </th>
            </thead>
            <tbody>
                @isset($is_commande)
                    @include('pdf.partials.tableBodyCommande')
                    @else
                    @include('pdf.partials.tableBodyReception')
                @endisset
            </tbody>
        </table>
    </div>

        {{-- <div class='objet'> <span class="bold"> {{ _('Objet :') }} </span>  {{ $document->name }} </div> --}}


    <footer class="bg-light">
         Générée par {{ env('APP_NAME') }} &copy; <?php echo date("Y");?> <span class="pagenum" style="text-align: right"></span>
    </footer>

@endsection
