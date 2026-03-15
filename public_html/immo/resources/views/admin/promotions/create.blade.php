@extends('layouts.admin')
@section('title', 'Ajouter une promotion')
@section('actions')
    @include('partials.components.headTitlePageElement', ['urlback' => '', 'title' => __('Retour')])
@endsection

@section('content')
    <div class="col-12">
        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                @include('admin.promotions.forms.promo')
                @include('admin.promotions.forms.enpromo')
                <div class="col-12 mb-4">
                    <button type="submit" class="btn btn-primary text-sm-center">{{ __('general.save') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scriptBottom')
   @include('admin.promotions.script')
@endsection
