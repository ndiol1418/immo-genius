<div class="col-md-12">
    <div class="card  mb-4">
        <div class="content-form">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <form method="POST" action="{{ route($route) }}" id="{{ $id??'form' }}">
                            @csrf
                            @method('POST')
                            <div class="form-group row  mb-0">
                                @include($formulaire??'')
                                <div class="col-md-4">
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
    </div>
</div>


