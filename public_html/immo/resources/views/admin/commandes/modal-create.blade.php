<div class="modal fade" id="exampleModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Nouvelle commande
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ isset($url) ? url($url) : (isset($route) ? route($route) :'#')}}" enctype="multipart/form-data">
                <div class="modal-body">
                </div>
            </form>
        </div>
    </div>
</div>
