<style>
    .text-sm{font-size: 12px}
    .img{
        height: 50px;
    width: 50px;
    border-radius: 50px;
    overflow: hidden;
    }
    
</style>
<div class="col-lg-6 col-sm-6 col-6 mb-2">
    <div class="border-0">
        <div class="card-body">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    {!! $icon??'' !!}
                    @isset($img)
                        <img src="{{ asset('img/'.$img) }}" alt="" width="30px">
                    @endisset
                </div>
                <div class="col-12 mt-2">
                    <h5>{{ $title??'' }}</h5>
                </div>
                <div class="col-12 text-sm">{{ $subtitle??'' }}</div>
    
            </div>
        </div>
    </div>
</div>