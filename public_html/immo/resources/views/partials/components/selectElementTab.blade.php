@php
    $required = isset($required) ?? "";
@endphp
<select required name="{{ $name }}" id="{{ isset($id) ? $id : $name }}" class="{{ isset($class) ? $class : 'form-control select' }}  @error($name) is-invalid @enderror" {{ isset($required) ? 'required' : '' }}  {{ isset($multiple) ? 'multiple' : '' }}>
    @if (isset($empty) && $empty)
        <option value selected disabled>{{ $empty }}</option>
    @endif
    @if (isset($first))
        <option value="tout">{{ $first }}</option>
    @endif
    @foreach ($options as $option)
    <option
        value="{{ $option['id'] }}"
        {{
            isset($multiple) ? (isset($default) && in_array($option['id'], $default)? "selected" : "")
                                : (isset($default) && $default == $option['id'] ? "selected" : "") }}
        >{{ $option['prenom']." ".$option['nom'] }}
    </option>
    @endforeach
</select>

@error($name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
