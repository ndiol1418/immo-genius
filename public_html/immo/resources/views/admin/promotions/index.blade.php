@extends('layouts.admin')
@section('title', $titre)

@section('actions')
    @if (auth()->user()->profil == 'admin')
        <div class="d-flex justify-content-end">
            <div class="mr-2">
                <div class="dropdown">
                    <button class="btn btn-secondary btn-xs dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filtre
                    </button>

                    <div class="dropdown-menu" aria-labelledby="filterDropdown">
                        <a class="dropdown-item" href="{{ route('admin.promotions.en_cours')}}">En cours</a>
                        <a class="dropdown-item" href="{{ route('admin.promotions.terminees')}}">Terminées</a>
                    </div>
                </div>
            </div>
            @include('partials.components.headTitlePageElement', ['url' => 'admin/promotions/create']) &nbsp;
        </div>
    @endif
@endsection

@section('content')
    {{-- <div class="row"> --}}
        @if ($promotions->isEmpty())
            <div class="col-12">
                <div class="row  d-flex justify-content-center align-items-center">
                    <div class="col-12">
                        <div class="jumbotron bg-white rounded text-center d-flex justify-content-center align-items-center">
                            <h3>Pas de promotions pour le moment.</h3>
                        </div>
                    </div>

                </div>
            </div>
        @else
            @if ($titre === 'Les promotions en cours')
                @foreach ($promotions as $promotion)
                    {{-- <div class="col-6"> --}}
                        @include('components.promo-cards', ['promotion' => $promotion])
                    {{-- </div> --}}
                @endforeach
            @elseif ($titre === 'Les promotions terminées')
                @include('components.promo-tables', ['promotions' => $promotions])
            @endif
        @endif
    {{-- </div> --}}
@endsection
