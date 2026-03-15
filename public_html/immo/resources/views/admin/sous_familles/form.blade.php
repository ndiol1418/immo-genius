<div class="form-group row">
    <div class="col-md-12">
        <label for="libelle" class="col-form-label text-md-right">{{ __('general.libelle') }}</label>
        <input id="libelle" type="text" class="form-control @error('libelle') is-invalid @enderror" name="libelle" value="{{ old('libelle') ?? $sous_famille->libelle }}" required autocomplete="name" autofocus>
        @error('libelle')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-12">
        <label for="famille_id" class="col-form-label text-md-right">{{ __('general.famille') }}</label>
        <select name="famille_id" class="form-control">
            @foreach ($familles as  $famille)
                <option value="{{ $famille->id }}"
                    @if ($famille->id == old('famille_id', $sous_famille->famille_id))
                        selected="selected"
                    @endif
                >
                    {{ $famille->libelle }}
                </option>
            @endforeach
        </select>
        @error('famille_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <input type="hidden" name="statut" id="" value="1">
    @if ($_user->is_admin)
        <div class="col-md-12">
            <label for="compte_id" class="col-form-label text-md-right">{{ __('general.compte') }}</label>
            <select name="compte_id" class="form-control">
                @foreach ($comptes as  $compte)
                    <option value="{{ $compte->id }}"
                        @if ($compte->id == old('compte_id', $sous_famille->compte_id))
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
        <input type="hidden" name="compte_id" id="" value="{{ $_user->compte_id }}">
    @endif
</div>

@section('partialScript')

@endsection
