@php
    $nbre_fournisseurs = __('fournisseur.title_royalties');
@endphp
@extends('layouts.admin')
@section('title',$nbre_fournisseurs)

@section('actions')

@endsection

@section('content')
    <div class="col-12">
        <div class="row">
            @include('admin.royalties.partials.filtre',['route'=>'royalties.fournisseur'])
            <div class="col-12 col-lg-3">
                <div class="row justify-content-end">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="col-12 d-flex justify-content-between">
                                    <span class="text-muted">TOTAL RAYALTIES</span>
                                    <span class="font-weight-bold">{{ number_format($ca_royalties,2,',',' ') }} {{ $_devise??'' }}</span>
                                </div>
                                <div class="col-12  d-flex justify-content-between">
                                    <span class="text-muted">TOTAL CA HT</span>
                                    <span class="font-weight-bold">{{ number_format($ca,2,',',' ') }} {{ $_devise??'' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover table-sm table-borderless" id="{{ isset($id) ? $id : 'table' }}" width="100%">
                    <thead class="bg-dark">
                        <tr>
                            <td>{{ __('general.fournisseur') }}</td>
                            {{-- <td>{{ __('general.nbre_commande') }}</td> --}}
                            <td>{{ __('boutique.ca') }}</td>
                            <td>{{ __('general.ca_taux_royalties') }}</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

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
                ajax: {
                    url: '{{ route("admin.jsonFournisseurs.liste") }}',
                    data: function (d) {
                        d.debut = $('#debut').val();
                        d.fin = $('#fin').val();
                    }
                },
                deferRender: true,
                columns: [
                    { data: 'nom', name: 'nom' },
                    // { data: 'royalties', name: 'royalties' },
                    { data: 'ca', name: 'ca' },
                    { data: 'ca_royalties', name: 'ca_royalties' },
                ],
                select:true,
                "paging": 10,
                order: [[0, 'asc']],
                "lengthChange": 200,
                "pageLength": 200,
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

@endpush
