

@isset($is_btn)
<a href="{{ isset($route)?route($route):"#" }}" class="radius btn btn-{{ $bg??'dark'  }} p-1 w-{{ $size??100 }} text-{{ $color??'secondary' }}" style="margin-top: 18px;"> 
    {{ $title??'Titre' }}
    {!! $icon??'<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M4.5 11h11.586l-4.5-4.5L13 5.086L19.914 12L13 18.914L11.586 17.5l4.5-4.5H4.5z"/></svg>' !!}
</a>
@else
<a href="{{route('agent.show',$agent->id)}}" class="radius btn btn-{{ $bg??'dark'  }} p-1 w-{{ $size??100 }} text-{{ $color??'secondary' }}" style="margin-top: 18px;"> 
    {{ $title??'Titre' }}
    {!! $icon??'<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M4.5 11h11.586l-4.5-4.5L13 5.086L19.914 12L13 18.914L11.586 17.5l4.5-4.5H4.5z"/></svg>' !!}
</a>
@endisset