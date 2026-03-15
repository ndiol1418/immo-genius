<?php use Carbon\Carbon; ?>
<div class="{{ $class ?? 'col-md-3' }} promo">
    <a href="{{ route('admin.promotions.show', $promotion->id) }}">
        <img src="{{ asset($promotion->image) }}" class="card-img-top" alt="Image de la promotion" style="height:150px !important; object-fit: cover;">
        <div class="card shadow-md">
            <div class="card-body bg-white" style="margin-top: -20px;">
                <div class="row">
                    <div class="col-12">
                        <h5 class="card-title text-capitalize font-weight-bold ellipsis mb-0">
                            {{ $promotion->nom }}
                        </h5>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="profile-work w-100">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="text-left pl-2 bg-light rounded text-danger mb-2 text-center">
                                        <strong class="w-50 text-danger ">{{ __('promotion.debut') }}</strong>
                                    </div>
                                    <div class="text-left pl-2 bg-light rounded text-danger mb-2 text-center">
                                        {{ Carbon::create($promotion->debut)->locale('fr')->isoFormat('D MMMM Y') }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-left pl-2 bg-light rounded text-danger mb-2 text-center">
                                        <strong class="w-50 text-danger ">{{ __('promotion.fin') }}</strong>
                                    </div>
                                    <div class="text-left pl-2 bg-light rounded text-danger mb-2 text-center">
                                        {{ Carbon::create($promotion->fin)->locale('fr')->isoFormat('D MMMM Y') }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                {{-- <div class="card-actions">
                    <a href="{{ route('admin.promotions.show', $promotion->id) }}" class="btn btn-custom-blue">
                        <i class="fas fa-eye"></i> Details
                    </a>
                </div> --}}
            </div>
        </div>
    </a>
</div>
