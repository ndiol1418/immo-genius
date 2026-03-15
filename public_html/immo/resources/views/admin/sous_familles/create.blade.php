<div class="col-md-12">
    <div class="card  mb-4">
        <div class="content-form">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <form method="POST" action="{{ route('admin.sous-familles.store') }}">
                            @csrf
                            @include('admin.sous_familles.form')
                            <div class="form-group row  mb-0">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('general.valider') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->
    </div>
</div>


