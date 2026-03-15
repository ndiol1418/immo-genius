@extends('layouts.admin')
@section('title', 'Produits')
{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"> --}}
@section('actions')
    @if($_user->profil == 'admin')
        @include('partials.components.modalElement', [
            'title' => 'Importation du fichier de produits',
            'route' => 'admin.produits.importProduits',
            'key' => 'produit',
        ])
        <div class="d-flex justify-content-end">
            @include('partials.components.headTitlePageElement', ['url' => 'admin/produits/create']) &nbsp;
            @include('partials.components.headTitlePageElement', ['isModalImport' => true])
        </div>
    @endif
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover table-sm table-borderless" id="{{ isset($id) ? $id : 'table' }}" width="100%">
                    <thead class="bg-dark">
                        <tr>
                            {{-- <td>ID</td> --}}
                            <td>Désignation</td>
                            <td>Code Barre</td>
                            <td>Colisage</td>
                            <td>Prix TTC</td>
                            <td>Fournisseur</td>
                            {{-- <td>Commandes</td> --}}
                            <td >Actions</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- @include('layouts.sub_layouts.datatable') --}}

@endsection
@push('subScript')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        // $(document).ready(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("jsonProduits.liste") }}',
                deferRender: true,
                columns: [
                    // { data: 'id', name: 'id' },
                    { data: 'designation', name: 'designation' },
                    { data: 'codebarre', name: 'codebarre' },
                    { data: 'colisage', name: 'colisage' },
                    { data: 'prix_ttc', name: 'prix_ttc' },
                    { data: 'fournisseur', name: 'fournisseur'},
                    // { data: 'commandes', name: 'commandes'},
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                select:true,
                "paging": "{{ $paging??true }}",
                "lengthChange": true,
                "pageLength": {{ isset($taille)?$taille:10 }},
                order: [[0, 'DESC']],
                "language": {
                    "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
                    "iDisplayLength": 25,
                    "lengthMenu": "Afficher _MENU_ par page",
                    "zeroRecords": "Aucune donnée - désolé",
                    "info": "_MAX_ enregistrement(s)",
                    "infoEmpty": <?php echo json_encode(__('general.empty')); ?>,
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search":  <?php echo json_encode(__('general.recherche')); ?>,
                    "paginate": {
                        "previous": <?php echo json_encode(__('general.precedent')); ?>,
                        "next": <?php echo json_encode(__('general.suivant')); ?>,
                        "first":<?php echo json_encode(__('general.premiere')); ?>,
                        "last": <?php echo json_encode(__('general.derniere')); ?>
                    }
                },
                dom: 'Bflrtip',
                buttons: [
                {
                        extend: 'collection',
                        text: '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>',
                        buttons: [
                            {
                                extend: 'pdf',
                                text: '<i class="fas fa-file-pdf fa-1x" aria-hidden="true"></i>',
                                exportOptions: {
                                    columns: ':not(:first-child):not(:last-child)'
                                }
                            },
                            {
                                extend: 'csv',
                                text: '<i class="fas fa-file-csv fa-1x"></i>',
                                exportOptions: {
                                    columns: ':not(:first-child):not(:last-child)'
                                }
                            },
                            {
                                extend: 'excel',
                                text: '<i class="fas fa-file-excel" aria-hidden="true"></i>',
                                exportOptions: {
                                    columns: ':not(:first-child):not(:last-child)'
                                }
                            },
                            // 'colvis'
                        ]
                }
                ],
            });
        // });
    </script>

{{-- @include('partials.utilities.datatableElement', ['id' => 'datatable','paging'=>false]) --}}

@endpush

