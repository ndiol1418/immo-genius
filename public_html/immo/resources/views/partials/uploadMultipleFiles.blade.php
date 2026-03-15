<div class="form-group col-md-12 mt-2">
    <label>Les pieces à joindre (<small class="small text-muted">Formats acceptés: </small> <small class="small text-primary text-uppercase">PNG/JPEG</small>)</label>
    <table class="table table-borderless table-striped border">
        <thead>
            <th>Fichier</th>
            <th>Nom du fichier</th>
            <th>
                <button class="btn btn-sm btn-danger" type="button" id="add_piece"><i class="fas fa-plus-circle"></i></button>
            </th>
        </thead>
        <tbody id="tableauPieces">
            @if (isset($document_pieces) && count($document_pieces))
                <form action="" class="d-none"></form>
                @foreach ($document_pieces as $piece)
                    <tr>
                        <td>
                            {!! $piece->link_fancy !!}
                        </td>
                        <td>
                            {{ $piece->name }}
                        </td>
                        <td>
                            @include("partials.components.deleteBtnElement", [
                                'url' => route('document_pieces.destroy', $piece->id),
                                'class' => ' ',
                                'entity' => $piece,
                                'btnInnerHTML' =>  '<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>'
                            ])
                        </td>
                    </tr>
                @endforeach
            @endif
            <tr id="ligne0">
                <td>
                    <input type="file" required name="images[0][file]" data-rang="0" id="piece_file0" accept="image/png, image/gif, image/jpeg" name="" class="" id="">
                </td>
                <td>
                    <input maxlength="255" type="text" required name="images[0][name]" data-rang="0" id="piece_name0" class="form-control form-control-sm" id="">
                </td>
                <td>
                    (obligatoire)
                    {{-- <button class="btn btn-sm btn-danger removePiece" data-rang="0"><i class="fas fa-trash"></i></button> --}}
                </td>
            </tr>
        </tbody>
    </table>
</div>
@push('subScript')
    <script>
        var i = 0;

        $('body').on('change','input[type=file]',function() {
            let val = $(this).val();
            let rang = $(this).data("rang");

            if(val) {
                let file = $(this)[0].files[0];
                if(file) {
                    $('#piece_name'+rang).val(file.name.split('.').slice(0, -1).join('.'));
                }
            }
        });
        $('body').on('click','#add_piece',function() {
            addLine();
        });

        $('body').on('click','.removePiece',function() {
            let rang = $(this).data('rang');
            removeLine(rang);
        });

        $('body').on('change','input[type=file]',function() {
            let val = $(this).val();
            let rang = $(this).data("rang");

            if(val) {
                let file = $(this)[0].files[0];
                if(file) {
                    $('#piece_name'+rang).val(file.name.split('.').slice(0, -1).join('.'));
                }
            }
        });
        function addLine() {
            i++;
            $("#tableauPieces").append(`<tr id="ligne${i}">
                <td>
                    <input type="file" required name="images[${i}][file]" data-rang="${i}" id="piece_file${i}" accept="image/png, image/gif, image/jpeg" name="" class="form-control form-control-sm" id="">
                </td>
                <td>
                    <input maxlength="255" type="text" required name="images[${i}][name]" data-rang="${i}" id="piece_name${i}" class="form-control form-control-sm" id="">
                </td>
                <td>
                    <button class="btn btn-sm btn-danger removePiece" data-rang="${i}"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`);
        }

        function removeLine(rang) {
            i--;
            $('tr#ligne'+rang).remove();
        }
    </script>
@endpush