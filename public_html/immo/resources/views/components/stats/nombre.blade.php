@php
$titre = $titre??"";
$soustitre = $soustitre??"";
$url = $url??"#";
$icone = $icone??"";
$nombre = $nombre??-2;
$class = $class??"col-6 col-lg-4";
@endphp
<div class="{{$class}}">
    <a href="{{route($route)}}">
        <div class="card shadow-none {{ $bg??'bg-light' }}">
            <div class="card-body">
            <div class="row align-items-center gx-0">
                <div class="col">

                <!-- Title -->
                <h6 class="text-uppercase text-secondary  mb-2">
                    {{$titre}} <br>
                    <span class="text-danger subtitle">{{$soustitre??''}}</span>
                </h6>


                <!-- Heading -->
                <span class="mb-4 mt-2 h4 text-primary">
                    {{ $nombre ?? ''}}
                </span>
                <!-- Badge -->
                {{-- <span class="badge bg-success-soft mt-n1">
                    disponible(s)
                </span> --}}
                </div>
                <div class="col-auto">

                <!-- Icon -->
                <span class="h4 fe icone fe-dollar-sign text-muted mb-0">{!! $icone !!}</i></span>

                </div>
            </div> <!-- / .row -->
            </div>
        </div>
    </a>

</div>
