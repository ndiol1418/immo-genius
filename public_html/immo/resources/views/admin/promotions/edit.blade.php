@extends('layouts.admin')
@section('title', 'Promotions')
@section('subtitle', 'Modification de la promotion')

@section('content')
    <div class="col-12">
        <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row">
                @include('admin.promotions.forms.promo')
                @include('admin.promotions.forms.enpromo')
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
@endsection

@section('scriptBottom')
    @include('admin.promotions.script')
    @include('admin.promotions.forms.supp_ligne_promo')
@endsection
