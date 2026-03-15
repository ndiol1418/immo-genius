@php
$disabled = isset($disabled)?"disabled":"";
$required = isset($required)?"required":"";
$multiple = isset($multiple)?"multiple":"";
$data_id = isset($_data_id)?$_data_id:"";
$data_action = isset($_data_action) ? $_data_action:"";

$except = $except??[];
$class = $class??'form-control form-control-sm select';
$id = $id??"";
@endphp
{{-- {{ dd($default) }} --}}
<select data-id="{{ $data_id }}" data-action="{{ $data_action }}" {{$disabled}} @isset($name) name="{{$name}}" @endisset id="{{$id}}" class="{{$class}}   @isset($name) @error($name) is-invalid @enderror @endisset" {{$required}}  {{$multiple}}>
    @if (isset($empty) && $empty)
        <option value selected >{{ $empty }}</option>
    @endif
    @if (isset($first))
        <option value="tout">{{ $first }}</option>
    @endif
    @foreach ($options as $option)
        {{-- Options a retirer de la liste --}}
        @php if(in_array($option->id,$except)) continue; @endphp
        {{-- --------------------------------}}
        <option value="{{ $option->id }}"
        {{
            $multiple=="multiple" ? (isset($default) && in_array($option->id, $default)? "selected" : "")
            : (isset($default) && $default == $option->id ? "selected" : "")
        }}>
            {{ $option->{$display} }}
        </option>
    @endforeach
</select>
@isset($name)
    @error($name)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
@endisset
