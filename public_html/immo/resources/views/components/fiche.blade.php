@if(isset($style) && $style == 1)
    <div class="{{ $col??'col-12' }}">
        <div class="row">
            <div class="col-12 mb-1">
                <span class="w-100 font-weight-bold text-primary">{{ $title??'titre' }}</span>
            </div>
            <div class="col-12 mb-1">
                <div class="bg-light rounded {{ $class??'' }}">
                    {!!  $value ?? '---' !!}
                </div>
            </div>
        </div>
    </div>

@else
    <div class="row">
        <div class="{{'col-12 col-lg-6 mb-1' }}">
            <span class="w-100 font-weight-bold text-primary">{{ $title??'titre' }}</span>
        </div>
        <div class="{{'col-12 col-lg-6 mb-1' }}">
            <div class="text-left pl-2 w-100 bg-light rounded">{{ $value ?? '---'}}</div>
        </div>
    </div>
@endif

