$(function() {
    $("body").on("click", ".fieldAddModal", function() {
        $("#type_field_id").change(function() {
            val = Number($(this).val());
            alert(val)
            if ([3, 4, 5, 8].includes(val)) {
                $("#choices").prop('disabled', false).parent().removeClass('d-none');
                if(val == 5){
                    $("#choices_int").prop('disabled', true).parent().addClass('d-none');
                }
                if(val == 8) {
                    $("#dynamic").prop('disabled', false).parent().removeClass('d-none');
                    $('#dynamic').change(function() {
                        var dymanic = $(this).val();
                        if(dymanic == "0") {
                            $("#lignes").prop('disabled', false).parent().removeClass('d-none');
                        } else $("#lignes").prop('disabled', true).parent().addClass('d-none');
                    });
                }
            } else if(val == 11){
                $("#choices_int").prop('disabled', false).parent().removeClass('d-none');
                $("#choices").prop('disabled', true).parent().addClass('d-none');

            } else {
                $("#choices").prop('disabled', true).parent().addClass('d-none');
                $("#choices_int").prop('disabled', true).parent().addClass('d-none');
                $("#dynamic").prop('disabled', true).parent().addClass('d-none');
                $("#lignes").prop('disabled', true).parent().addClass('d-none');
            }
        });
    });

    $("body").on('click','.editStatic', function() {

        $("#nameStaticModal").val($(this).data("nom"));
        $("#colModalEdit").val($(this).data("col"));
        $("#requisModal").val($(this).data("requis"));
        $("#displayModal").val($(this).data("affich"));
        $("#niveauModal").val($(this).data("niveau"));
        $("#labelModal").val($(this).data("label"));
        $("#referenceModal").text($(this).data("reference"));
        $("#dynamicModal").val($(this).data("dynamic"));
        $("#lignesModal").val($(this).data("lignes"));
        $("#refModal").val($(this).data("ref"));
        $("#attributStaticModal").val($(this).data("attribut"));
        if ($(this).data("choices")) {
            $("#choicesModal").val($(this).data("choices"));
            $("#choicesModal").prop('disabled', false).parent().removeClass('d-none');
        } else $("#choicesModal").prop('disabled', true).parent().addClass('d-none');


        $("#typeModal").val($(this).data("type"));
        $("#staticForm").attr('action', $(this).attr("href"));

        if($(this).data("type") == 8) {
            $("#dynamicModal").prop('disabled', false).parent().removeClass('d-none');

            if($(this).data("dynamic") == '0') $("#lignesModal").prop('disabled', false).parent().removeClass('d-none');
            else $("#lignesModal").prop('disabled', true).parent().addClass('d-none');
        }

        $('#dynamicModal').change(function() {
            var dymanic = $(this).val();
            if(dymanic == "0") {
                $("#lignesModal").prop('disabled', false).parent().removeClass('d-none');
            } else $("#lignesModal").prop('disabled', true).parent().addClass('d-none');
        });

        $("#typeModal").change(function() {
            val = Number($(this).val());
            if ([3, 4, 5, 8].includes(val)) {
                $("#choicesModal").prop('disabled', false).parent().removeClass('d-none');

                if(val == 8) {
                    $("#dynamicModal").prop('disabled', false).parent().removeClass('d-none');
                }
            } else if(val == 11){
            }else {
                $("#choicesModal").prop('disabled', true).parent().addClass('d-none');
                $("#dynamicModal").prop('disabled', true).parent().addClass('d-none');
                $("#lignesModal").prop('disabled', true).parent().addClass('d-none');
            }
        });
    });

});
//  // Simple list
//  Sortable.create(simpleList, {
// animation: 300,
// ghostClass: "list-group-item-success", // Class name for the drop placeholder
// // Element dragging ended
// onEnd: function( /**Event*/ evt) {
//     let old_index = evt.oldIndex; // element's old index within old parent
//     let new_index = evt.newIndex; // element's new index within new parent
//     let old_draggable_index = evt.oldDraggableIndex; // element's old index within old parent, only counting draggable elements
//     //console.log(evt.newDraggableIndex); // element's new index within new parent, only counting draggable elements

//     let taille = $('.list-group-item').length;

//     for(var i = 0; i < taille; i++) {
//         let item = $('.list-group-item')[i];
//         $(item).attr('id', 'elt' + i);
//         $('#champs' + $(item).data('id')).val(i);
//     }

//         //console.log(evt.clone); // the clone element
//         //console.log(evt.pullMode);  // when item is in another sortable: `"clone"` if cloning, `true` if moving
//     },
// });
