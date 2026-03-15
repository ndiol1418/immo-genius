<a class="{{ isset($class) ? $class : 'btn btn-danger btn-xs'}}" type="button" href="#"
    onclick="event.preventDefault();
        if(confirm('{{ isset($message_confirmation) ? $message_confirmation : 'Voulez-vous supprimer cet element ?' }}')){
            document.getElementById('element{{ isset($entity)?$entity->id:$id }}').submit();
        }">
    {!! isset($btnInnerHTML) ? $btnInnerHTML : '<i class="fa fa-trash"></i>' !!}
</a>
<form id="element{{ isset($entity)?$entity->id:$id }}" action="{{ $url }}" method="POST" style="display: none;">
    @csrf
    @method('POST')
    <input type="hidden" name="{{ $name??'' }}" value="{{ $value??'' }}">
</form>
