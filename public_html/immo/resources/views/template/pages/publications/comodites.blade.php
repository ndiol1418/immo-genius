<div class="col-6 col-lg-3">
    <div class="form-check d-flex align-items-center" style="gap:10px">
        <input class="form-check-input"
               style="width: auto"
               id="comodite-{{ $comodite->id }}"
               type="checkbox"
               value="{{ $comodite->id }}"
               name="comodites[]"
               {{ in_array($comodite->id, isset($annoce)?$annonce->comodites->toArray():[]) ? 'checked' : '' }}>
        <label class="form-check-label" style="font-size: 12px" for="comodite-{{ $comodite->id }}">
            {{ $comodite->name }}
        </label>
    </div>
</div>
