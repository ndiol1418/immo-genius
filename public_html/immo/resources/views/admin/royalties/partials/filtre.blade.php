<div class="col-lg-6 col-sm-6">
    <div class="card shadow-none">
        <div class="card-body">
            <form action="{{ route($route??'royalties.fournisseur') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-4 col-lg-4">
                        <input type="month" name="debut" id="debut" class="form-control form-control-sm" value="<?=$debut->format('Y-m')?>">
                    </div>
                    <div class="col-4 col-lg-4">
                        <input type="month" name="fin" id="fin" class="form-control form-control-sm" value="<?=$fin->format('Y-m')?>">
                    </div>
                    <div class="col-4 col-lg-4 d-flex p-0 justify-content-between">
                        <button class="btn btn-sm btn-dark">Valider</button>
                        <a href="{{ route($route??'royalties.fournisseur') }}" class="btn btn-sm btn-dark" value="refresh" title="Reinitialiser">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M3 2v6h6"/><path d="M21 12A9 9 0 0 0 6 5.3L3 8m18 14v-6h-6"/><path d="M3 12a9 9 0 0 0 15 6.7l3-2.7"/><circle cx="12" cy="12" r="1"/></g></svg>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-12 col-lg-3 col-sm-6">
    <div class="card shadow-none ">
        <div class="card-body bg-dark rounded" style="height: 72px">
            <h5 class="text-white text-center text-md text-capitalize">{{ __('general.from').' '.$debut->isoFormat('MMMM YYYY') }}  {{ __('general.to').' '.$fin->isoFormat('MMMM YYYY') }}</h5>
        </div>
    </div>
</div>
