<div class="col-md-12">
    <!-- Collapsable Card Example -->
    <div class="card mb-4">
        <!-- Card Header - Accordion -->

        <!-- Card Content - Collapse -->
        <div class="content-form">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <form method="POST" action="{{ route('admin.zones.store') }}">
                            @csrf

                            @include('admin.zones.form')

                            <div class="form-group row  mb-0">
                                <div class="col-md-6">
                                    <button type="submit" id="submit-button" class="btn btn-primary">
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


