<style>
    thead>tr{
        border: 0 !important;
    }
</style>
<div class="{{ $_classTableWrapper ?? "col-md-12" }}">
    <!-- Collapsable Card Example -->
    <div class="card mb-4 shadow-none">
        <!-- Card Content - Collapse -->
        <div class="content-form">
            <div class="card-body">
                <div class="row">
                    @yield('cardHeader')
                    <div class="col-md-12">
                        <div class="table-responsive-sm">
                            <table class="table table-striped table-hover table-sm table-borderless" id="{{ isset($id) ? $id : 'datatable' }}" width="100%">
                                <thead class="bg-primary">
                                    @yield('tableHeader')
                                </thead>

                                <tbody>
                                    @yield('tableBody')

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @yield('cardFooter')
        </div>
    </div>
</div>
