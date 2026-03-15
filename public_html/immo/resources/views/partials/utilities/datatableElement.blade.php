<script src="{{ asset('js/biblio/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/biblio/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src='//cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js'></script>
<script src='//cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>
<script src='//cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js'></script>
<script src='//cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js'></script>
<script type="text/javascript">
    $(document).ready(function() {
    $('#datatable').DataTable( {
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
        // columnDefs: [ {
        //     targets: -1,
        //     visible: false
        // } ]
    });
} );
</script>
