<form id="{{ $ID}}" action="{{ $url }}" method="POST" style="display: none;">
    @foreach ($donnes as $name => $value)
    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
    @endforeach

    @csrf
    @if ($method)
        @method($method)
    @endif
</form>
