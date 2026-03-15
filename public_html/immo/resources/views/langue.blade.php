@php
$path_explode = explode('/', request()->path());
if(in_array($path_explode[0], Config::get('app.availables_lang'))) {
    array_splice($path_explode, 0, 1);
}
$base_path = "";
if(count($path_explode) > 0) $base_path = implode('/', $path_explode);
@endphp

<div id="langs">
    <a href="{{ $base_path != "" ? "/$base_path" : "" }}/?lang=fr" class="{{ app()->getLocale() == "fr" ? "active d-none" : "" }}" title="Francais"><img src="{{ asset('img/fr.png') }}" class="icon" width="15px" alt="FR"></a>
    <a href="{{ $base_path != "" ? "/$base_path" : "" }}/?lang=en" class="{{ app()->getLocale() == "en" ? "active d-none" : "" }}" title="English"><img src="{{ asset('img/en.png') }}" class="icon" width="15px" alt="EN"></a>
</div>

