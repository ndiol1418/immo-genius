
<style>
    h6{
        font-size: 14px !important;
    }
</style>
@if (isset($style))
    <div class="{{ $class??'col-lg-6 col-12 col-sm-6'}}">
        <a href="{{ isset($route) && $route?route($route,[isset($key)?$key:'']):'#'}}">
            <div class="card shadow-none">
                <div class="card-body">
                    <div class="row align-items-center gx-0">
                        <div class="col">

                        <!-- Title -->
                        <h6 class="text-capitalize text-muted  my-0">
                            {!! $title??'Info' !!}
                            <br>
                            @if(isset($subtitle))
                                <span class="text-danger subtitle text-right">{!! $subtitle??'SubTitle' !!}</span>
                            @endif
                        </h6>


                        <!-- Heading -->
                        @isset($nbre)
                            <span class="mb-4 mt-2 h4 text-muted">
                                {{ number_format($nbre,0,'','.')??'0' }} {!! $param !!}
                            </span>
                        @endisset
                        <!-- Badge -->

                        </div>
                        <div class="col-auto">

                        <!-- Icon -->
                        @isset($$icon)
                            <span class="h2 fe icone fe-dollar-sign text-muted mb-0">
                                {!! $icon??'<i class="fa fa-paperclip"></i>' !!}
                            </span>
                        @endisset

                        </div>
                    </div> <!-- / .row -->
                    @isset($datas['commandes'])
                        <div class="row">
                            @foreach ($datas['commandes'] as $data)
                                <div class="col-12">
                                    <div class="d-flex no-block align-items-center mt-2">
                                        <div class="d-flex">
                                            <div class="p-1 text-white mr-2" style="background: {{ $data['color'] }};border-radius:4px;"></div>
                                            <p class="fs-4 mb-1 text-muted d-flex align-items-center" style="font-size: 12px !important">
                                            {{ $data['title'] }}
                                            </p>
                                        </div>
                                        <div class="ml-auto">
                                            <h5 class="fw-light text-end text-muted mb-0">
                                                {{ number_format($data['nbre'],0,'',' ') }}
                                                <span class="text-muted text-sm">
                                                    {{ $data['param'] }}
                                                </span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endisset
                </div>
            </div>
        </a>
    </div>
@else
    <div class="{{ $class??'col-lg-6 col-12 col-sm-6'}}">
        <a href="{{ isset($route) && $route?route($route,isset($key)?$key:''):'#' }}">
            <div class="card shadow-none">

                <div class="card-body d-flex justify-content-between p-2" style="height: 80px">

                    <div class="row align-items-center gx-0 w-100">

                        <div class="col">

                        <!-- Title -->
                        <h6 class="text-capitalize text-muted  my-1">
                            {!! $title??'Info' !!} <br>
                            @if(isset($subtitle))
                                <span class="text-danger subtitle text-right">{!! $subtitle??'SubTitle' !!}</span>
                            @endif
                        </h6>


                        <!-- Heading -->
                        @isset($nbre)
                            @if (!isset($modelNbre) || !$modelNbre)

                                <span class="mb-4 mt-2 h5 text-primary">
                                    {{ number_format($nbre,0,'',' ')??'0' }} <span class="text-sm text-muted">{!! $param !!}</span>
                                </span>
                            @endif
                        @endisset
                        <!-- Badge -->

                        </div>
                        <div class="col-auto">

                        <!-- Icon -->
                        @isset($$icon)
                            <span class="h2 fe icone fe-dollar-sign text-muted mb-0">
                                {!! $icon??'<i class="fa fa-file"></i>' !!}
                            </span>
                        @endisset
                        @if(isset($modelNbre) && $modelNbre)
                            <span class="h2 fe icone fe-dollar-sign text-primary mb-0">
                                {{ $nbre }}
                            </span>
                        @endif

                        </div>
                    </div> <!-- / .row -->
                    @isset($infos)
                        <div class="row">
                            @foreach ($infos as $k=>$info)
                            <div class="col-lg-6 col-6 text-left">
                                <p class="text-muted mb-0"> <strong>{{ $k }}</strong> </p>
                            </div>
                            <div class="col-lg-6 col-6 text-right">
                                <p class="text-muted mb-0">{!! $info !!}</p>
                            </div>
                            @endforeach
                        </div>
                    @endisset
                </div>
            </div>
        </a>
    </div>
@endif
