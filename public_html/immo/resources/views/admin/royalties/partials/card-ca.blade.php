{{-- <div class="row justify-content-end"> --}}
    <div class="col-12">
        <div class="card">
            <div class="card-body px-1 py-3">
                <div class="col-12 d-flex justify-content-between">
                    <span class="text-muted text-sm">TOTAL RAYALTIES</span>
                    <span class="font-weight-bold text-sm">{{ number_format($ca_royalties,2,',',' ') }} {{ $_devise??'' }}</span>
                </div>
                <div class="col-12  d-flex justify-content-between">
                    <span class="text-muted text-sm">TOTAL CA HT</span>
                    <span class="font-weight-bold text-sm">{{ number_format($ca,2,',',' ') }} {{ $_devise??'' }}</span>
                </div>
            </div>
        </div>
    </div>
{{-- </div> --}}
