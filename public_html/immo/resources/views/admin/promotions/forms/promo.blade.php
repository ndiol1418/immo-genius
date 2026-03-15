<style>
    .required-field::after {
        content: " *";
        color: red;
    }

    .btn-small {
        width: 100px;
    }
</style>
<div class="col-md-6">
    <div class="card shadow-none mb-4">
        <div class="card-body">
                <div class="form-group">
                    <label for="nom" class="required-field">{{ __('promotion.nom') }}</label>
                    <input type="text" class="form-control" id="nom" name="promo[nom]"
                        value="{{ old('nom', $promotion->nom ?? '') }}" required>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="debut" class="required-field">{{ __('promotion.debut') }}</label>
                            <input type="date" class="form-control" id="debut" name="promo[debut]"
                                value="{{ old('debut', isset($promotion) ? \Carbon\Carbon::parse($promotion->debut)->format('Y-m-d') : '') }}"
                                required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="fin" class="required-field">{{ __('promotion.fin') }}</label>
                            <input type="date" class="form-control" id="fin" name="promo[fin]"
                                value="{{ old('fin', isset($promotion) ? \Carbon\Carbon::parse($promotion->fin)->format('Y-m-d') : '') }}"
                                required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="image" class="required-field">{{ __('promotion.image') }}</label>
                    <input type="file" class="form-control-file" id="image" name="promo[image]" accept="image/*" required>
                    @if(isset($promotion) && $promotion->image)
                        <div>
                            <label>{{ __('promotion.image') }}</label>
                            <img src="{{ asset($promotion->image) }}" alt="Previous Image" style="max-width: 200px;">
                        </div>
                    @endif
                </div>
                
                <div class="form-group">
                    <label for="description">{{ __('promotion.description') }}</label>
                    <textarea class="form-control" id="description" name="promo[description]"
                        rows="3">{{ old('description', $promotion->description ?? '') }}</textarea>
                </div>
        </div>
    </div>
</div>

