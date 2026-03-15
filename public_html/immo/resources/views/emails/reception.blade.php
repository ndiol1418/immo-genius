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


<br><br>
Cordialement,<br>
{{ config('app.name') }} - {{ $commande->compte->libelle }}
@endcomponent
