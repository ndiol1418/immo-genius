<div class="en-tete-logo w-50">
    <img src="{{ public_path('img/logo.png') }}" alt="ALT" width="100%" height="80px"><br>
</div>
<div class="en-tete-texte w-50">
    <small style="font-size:16px"> {{ env('APP_NAME') }}</small> <br><br>

    Bon de {{ $titre??'' }} <br>
    <span style="text-transform: capitalize"> N° : {{ $data->ref }}</span> <br>
    <span> Date : {{ $data->date_reception }}</span>
</div>
