@if (!$filtre)
    @section('tableHeader')
        <tr>
            <td>{{ __('commande.date_commande') }}</td>
            <td style="width: 230px">{{ __('commande.reference') }}</td>
            {{-- <td>{{ __('boutique.code') }}</td> --}}
            <td>{{ __('general.station') }}</td>
            <td>{{ __('general.fournisseur') }}</td>
            <td>{{ __('commande.montant_ttc') }}</td>
            {{-- <td>{{ __('commande.etat') }}</td> --}}
            <td class="action text-center">Action(s)</td>
        </tr>
    @endsection
    {{-- Table Body --}}
    @section('tableBody')
        @php $i = 1; @endphp
        @foreach ($commandes as $commande)
            <tr>
            {{-- <td>{{ isset($commande->crea_date) ? $commande->crea_date : "---" }}</td> --}}
                <td>{{ $commande->date_creation ?? "---" }}</td>
                <td><a href="{{ route('commandes.show',$commande->id) }}" class="text-dark" title="afficher">{{ $commande->ref ?? "---" }}</a></td>
                {{-- <td>{{ isset($commande->station) ? $commande->station->code : "---" }}</td> --}}
                <td><a href="{{ route('admin.stations.show',$commande->station->id) }}">{{ isset($commande->station) ? $commande->station->nom : "---" }}</a></td>
                <td>{{ isset($commande->fournisseur) ? $commande->fournisseur->nom : "---" }}</td>
                <td>{{ $commande->total_ttc ?? "---" }}</td>
                {{-- <td>{{ $commande->etat ?? "---" }}</td> --}}
                <td class="text-center">
                    <a href="{{ route('commandes.show', $commande->id) }}" class="btn btn-success btn-xs">
                        <i class="fa fa-eye"></i>
                    </a>
                    @if($commande->etat == 'traité')
                        @include('commandes.partials.pdfBtn',[
                            'size'=>16,
                            'class'=>'btn btn-xs btn-light'
                        ])
                    @endif
                    @if ($commande->editable())
                        <form method="POST" action="{{ route("commandes.destroy",$commande->id) }}" style="display: inline-block;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-xs btn-danger delete-commande"> <i class="fa fa-trash"></i></button>
                        </form>
                    @endif
                </td>
            </tr>
        @php $i++; @endphp
        @endforeach
    @endsection

    {{-- Datatable extension --}}
    @include('layouts.sub_layouts.datatable',['atr'=>'commandes'])
    @else
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover table-sm table-borderless" id="{{ isset($id) ? $id : 'table' }}" width="100%">
                    <thead class="bg-dark">
                        <tr>
                            <td>{{ __('commande.date_commande') }}</td>
                            <td style="width: 230px">{{ __('commande.reference') }}</td>
                            {{-- <td>{{ __('boutique.code') }}</td> --}}
                            <td>{{ __('general.station') }}</td>
                            <td>{{ __('general.fournisseur') }}</td>
                            <td>{{ __('commande.montant_ttc') }}</td>
                            <td>{{ __('commande.etat') }}</td>
                            <td class="action text-center">Action(s)</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endif
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
                ajax: '{{ route("commandes.jsonCommandes.liste",$etat) }}',
                deferRender: true,
                columns: [
                    // { data: 'id', name: 'id' },
                    { data: 'commande_date', name: 'commande_date' },
                    { data: 'ref', name: 'ref' },
                    // { data: 'code', name: 'code' },
                    { data: 'station', name: 'station' },
                    { data: 'fournisseur', name: 'fournisseur'},
                    { data: 'montant_ttc', name: 'montant_ttc'},
                    { data: 'etat', name: 'etat'},
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                select:true,
                "paging": "{{ $paging??true }}",
                "lengthChange": true,
                "pageLength": {{ isset($taille)?$taille:10 }},
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


