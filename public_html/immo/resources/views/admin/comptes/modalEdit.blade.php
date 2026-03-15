<form method="POST" action="{{ route('admin.comptes.update',$compte->id) }}"  enctype="multipart/form-data" class="col-lg-8 col-12">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
            @csrf
            @method('PATCH')
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modification de la filiale</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @include('admin.comptes.form')
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>

        </div>
    </div>
    </div>
</form>
