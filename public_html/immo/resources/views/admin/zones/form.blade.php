<div class="form-group row">
    <div class="col-md-12">
        <label for="nom" class="col-form-label text-md-right">{{ __('zone.name') }}</label>
        <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') ?? $zone->nom }}" required autocomplete="nom" autofocus>
        @error('nom')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    @if ($_user->is_admin)
        <div class="col-md-12">
            <label for="compte_id" class="col-form-label text-md-right">{{ __('general.compte') }}</label>
            <select name="compte_id" class="form-control">
                @foreach ($comptes as  $compte)
                    <option value="{{ $compte->id }}"
                        @if ($compte->id == old('compte_id', $zone->compte_id))
                            selected="selected"
                        @endif
                    >
                        {{ $compte->libelle }}
                    </option>
                @endforeach
            </select>
            @error('compte_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    @else
        <input type="hidden" name="compte_id" value="{{ $_user->compte_id }}">
    @endif

</div>

@section('partialScript')

@endsection
