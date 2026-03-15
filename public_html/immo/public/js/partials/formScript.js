$(function() {
    var errors = $("#errors").val();
    if(errors && errors != "") {
        $.each($('.form-control'), function(i,  item) {
            if($(item).attr('required') && (!$(item).val() || $(item).val() == "")) {
                $(item).parent().parent().css({
                    'border': '1px solid red'
                });
            }
        });
    }

    //Remove ; et replace par -
    $("input.input_grille_statique").on('input', function() {
        $(this).val($(this).val().replace(';', '-'));
    });

    //Tout coche event
    $('.toutCocher').on('change', function(e) {
        var field_id = $(this).data('id');
        var checked = $(this).prop('checked');

        //Event from children
        $.each($('.checkbox'+field_id), function(i, item) {
            $(item).prop('checked', checked);
        });
    });

    //Cochez un element MAJ TOUT
    $('.checkbox').on('change', function(e) {
        var field_id = $(this).data('id');
        var checked = $(this).prop('checked');
        var allIschecked = true;
        if(!checked) {
            allIschecked = false;
        } else {
            //Event from children
            $.each($('.checkbox'+field_id), function(i, item) {
                if(!$(item).prop('checked')) {
                    allIschecked = false;
                }
            });

        }
        $('#tout'+field_id).prop('checked', allIschecked);
    });

    //Select autres
    $('.select').change(function() {
        var val = $(this).val().toLowerCase();
        var field_id = $(this).data('id');
        var name = $(this).attr('name');
        var SelectParent = $(this).closest('div').parent();

        if(val == "autres" || val == "autre") {
            $(SelectParent).append(autreApresicer(name, field_id));
        } else {
            if($("#autre"+field_id).html() != undefined) {
                setTimeout(function() {
                    $("#autre"+field_id).closest('div').remove();
                },1500)
                $("#autre"+field_id).closest('div').removeClass('animate__zoomOut').addClass('animate__zoomOutLeft')
            }
        }
    });

    //Format Number On change
    $('.number').on('input', function() {
        var val = $(this).val();
        var id = $(this).data('id');
        var value_to_format = parseFloat(val.replace(/ /g, '').replace(',', '.'));
        var last_string = val.split('')[val.length - 1];
        var string_after_virgule = val.split(',')[1];
        var string_after_point = val.split('.')[1];

        if(val.length == 1 && val == '-') {
            $(this).val(val);
            $("#infos"+id).val("");
        }
        else {
            if(!isNaN(value_to_format)) {
                if(last_string != ",") {
                    if((string_after_point !== undefined && Number(string_after_point) == 0) || (string_after_virgule !== undefined && Number(string_after_virgule) == 0)) {
                        $(this).val(val);
                    } else {
                        $(this).val(numberWithSpace(value_to_format));
                    }
                    $("#infos"+id).val(value_to_format);
                }

            } else {
                $(this).val('');
                $("#infos"+id).val("");
            }
        }

    });

    if($(".textDate, .date").length) {
        //Formatage des dates
        $(".textDate, .date").datepicker({
            dateFormat: 'yy-mm-dd'
        });
    }

    $("#revome_step").click(function() {
        return confirm("Voulez-vous vraiment reprendre cette étape ? \nVous allez perdre les données de cette étape.")
    });

    $('#enregistrer').click(function(e) {
        var url  = $('#formulaire').attr('action');
        $('#formulaire').attr('action', url + '&return=true');
    });

    $('#next').click(function(e) {
        var url  = $('#formulaire').attr('action');
        if(url.includes('&return=true')) {
            url.replace('&return=true','');
            $('#formulaire').attr('action', url);
        }
    });

    $('#enregistrer').click(function(e) {
        var url  = $('#formulaire').attr('action');
        $('#formulaire').attr('action', url + '&return=true');
        $('#formulaire').submit();
    });

    $('.btn-grille').click(function(e) {
        var id = $(this).data('id');
        var nbInputs = $("tr#inputs" + id +" .input").length;
        var alreadyAdded = $("#info"+id).val();
        var nbValid = 0;
        var array = [];
        var arrayAfficher = [];
        var str = "";
        var strAfficher = "";

        $.each($("tr#inputs" + id +" .input"),function(i, item) {
            var current_val = $(item).val().replace(';', '-');
            var text_afficher = $(item).val();

            if(current_val.trim() != "" && text_afficher.trim() != "") {
                //Formater le texte en nombre des valeur de type number
                if($(item).hasClass('number')) {
                    current_val = parseFloat(current_val.replace(/ /g, ''));
                }

                array.push(current_val);
                arrayAfficher.push(text_afficher);
                nbValid++;
            }
        });

        if(nbInputs == nbValid) {
            str = array.join(';');
            strAfficher = arrayAfficher.join(';');
            if(alreadyAdded != null && alreadyAdded.trim() != "") {
                str = alreadyAdded + '|' + str;
            }
            $("#info"+id).val(str);
            $("#inputs" + id).before(insertLine(id,arrayAfficher,array.join(';')));
            $.each($("tr#inputs" + id +" .input"),function(i, item) {
                $(item).val('');
            });
        } else {
            if(!$('#alert' + id).html()) {
                $("#inputs" + id).before(insertTrBefore(id,nbInputs));
                setTimeout(function() {
                    $('#alert' + id).fadeOut().remove();
                }, 2000)
            }
        }

        //Btn remove
        $('.btn-remove').click(function() {
            var id = $(this).data('id');
            var last_str = $("#info"+id).val();
            var line_value = $(this).data('valeur');

            if(last_str.includes(line_value)) {
                    var new_array = last_str.split('|');
                    new_array.splice(new_array.indexOf(line_value), 1);
                    if(new_array.length > 0) {
                        $("#info"+id).val(new_array.join('|'));
                    } else $("#info"+id).val('');

                    $(this).parent().parent().remove();
                }
        });
    });

    //Btn remove
    $('.btn-remove').click(function() {
        var id = $(this).data('id');
        var last_str = $("#info"+id).val();
        var new_array = last_str.split('|');
        var line_value = $(this).data('valeur');

        if(last_str.includes(line_value)) {
                var new_array = last_str.split('|');
                new_array.splice(new_array.indexOf(line_value), 1);

                if(new_array.length > 0) {
                    $("#info"+id).val(new_array.join('|'));
                } else $("#info"+id).val('');

                $(this).parent().parent().remove();
            }
    });

    function insertTrBefore(id,colspan, message = "Veuillez renseigner tous les champs !") {
        return '<tr>'+
                '<td colspan="'+colspan+'" class="text-center text-danger" id="alert'+id+'">'+message+'</td>'+
            '</tr>';
    }

    function insertLine(id, tableau, valeur) {
        var line = '<tr>';
        $.each(tableau,function(i, item) {
            line += '<td>'+item+'</td>';
        });
        line += '<td><button class="btn btn-danger btn-sm btn-remove" data-id="'+id+'" data-valeur="'+valeur+'"><i class="fa fa-trash"></i></button></td>'+
                '</tr>';
        return line;
    }

    function autreApresicer(name, id) {
       var line = '<div class="py-1 px-1 my-1 animate__animated animate__zoomIn shadow-sm">'+
               '<label class="padding-5 text-dark" style="display: block">Autres à preciser</label>'+
                '<input type="text" name="'+name+'" id="autre'+id+'" class="form-control" required placeholder="autres à préciser">'+
            '</div>';

        return line;
    }

    function numberWithSpace(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }

    function isInt(n) {
    return n % 1 === 0;
    }

    function number_format(number, decimals, dec_point, thousands_sep = ' ') {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }
});
