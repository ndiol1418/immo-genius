@if(isset($chaine) && !$chaine->is_libre)
    @php
        $action = $action??route('admin.lignechaines.store');
        $ligne_chaines = $ligne_chaines??$chaine->ligne_chaines;
        $with_form = $with_form ?? true;
    @endphp
    <div class="col-12 mb-4">
        <label class="">Définir les collaborateurs de la chaine</label>
        <div class="border rounded">
            <table class="table table-striped table-sm mb-0">
                <thead>
                    <tr>
                        <th>Rang</th>
                        <th>Collaborateur</th>
                        <th title="Autorisation d'ajout sur la liste de diffusion.">Màj LD</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="chaine_body">
                    @php $n =0; @endphp
                    @if ($chaine->include_managers)
                        @if(!$with_form)
                            @php
                                $collaborateur = $document->collaborateur;
                                $array_managers = $collaborateur->array_managers;
                                $n = count($document->collaborateur->array_managers);
                            @endphp
                            @for ($i=1; $i < count($array_managers)+1; $i++)
                                <tr>
                                    <td class="rang">{{ $i }}</td>
                                    <td class="nom">{{ $collaborateur->manager_."{$array_managers[$i-1]->nom_complet}" }} (Manager-{{ $i }})</td>
                                    <td class="can_design">{{ in_array($document->type_document->chaine_validation->allow_observateurs,[2,3])?"Oui":"Non" }}</td>
                                    <td>
                                        <a href="#"
                                            type="button"
                                            data-toggle="modal"
                                            data-target="#editModal"
                                            data-collaborateur_id='{{ $collaborateur->manager_."{$array_managers[$i-1]->id}" }}'
                                            data-rang="{{ $i }}"
                                            data-can-design="{{ in_array($document->type_document->chaine_validation->allow_observateurs,[2,3])?1:0 }}"
                                            @if($with_form)
                                                data-url="{{ route('admin.lignechaines.update', $ligne) }}"
                                            @endif
                                            class="btn btn-xs btn-light text-warning editModal py-0"
                                            ><i class="fas fa-edit"></i></a>

                                        @if ($with_form)
                                            @include('partials.components.deleteBtnElement', [
                                                "btnInnerHTML" => '<i class="fas fa-trash"></i>',
                                                "class" => 'btn btn-sm btn-light text-primary py-0',
                                                'entity' => $ligne,
                                                'url' => route('admin.lignechaines.destroy', $ligne)
                                            ])
                                        @else
                                            <a class="delete_line btn btn-sm btn-light text-primary py-0"><i class="fas fa-trash"></i></a>
                                        @endif
                                        @if(!$with_form)
                                            <input class="input_collaborateur_id" type="hidden" name="chaine[{{ $i }}][collaborateur_id]" value="{{ $collaborateur->manager_."{$array_managers[$i-1]->id}" }}">
                                            <input class="input_can_design_obs" type="hidden" name="chaine[{{ $i }}][can_design_obs]" value="{{ in_array($document->type_document->chaine_validation->allow_observateurs,[2,3])?0:1 }}">
                                        @endif

                                    </td>
                                </tr>
                            @endfor
                        @else
                            @php $n = 3; @endphp
                            @for ($i = 1; $i < 4; $i++)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>Manager - {{ $i }}</td>
                                    <td>---</td>
                                    <td>---</td>
                                </tr>
                            @endfor
                        @endif
                    @endif
                    @php $rang = $n + count($ligne_chaines) + 1; @endphp
                    @foreach ($ligne_chaines as $ligne)
                        <tr>
                            <td class="rang">{{ $ligne->rang + $n }}</td>
                            <td class="nom">{{ $ligne->collaborateur->nom_complet }}</td>
                            <td class="can_design">{{ $ligne->can_design_obs?"Oui":"Non" }}</td>
                            <td>
                                <a href="#"
                                    type="button"
                                    data-toggle="modal"
                                    data-target="#editModal"
                                    data-collaborateur_id="{{ $ligne->collaborateur_id }}"
                                    data-rang="{{ $ligne->rang + $n }}"
                                    data-can-design="{{ $ligne->can_design_obs }}"
                                    @if($with_form)
                                        data-url="{{ route('admin.lignechaines.update', $ligne) }}"
                                    @endif
                                    class="btn btn-xs btn-light text-warning editModal py-0"
                                    ><i class="fas fa-edit"></i></a>

                                @if ($with_form)
                                    @include('partials.components.deleteBtnElement', [
                                        "btnInnerHTML" => '<i class="fas fa-trash"></i>',
                                        "class" => 'btn btn-sm btn-light text-primary py-0',
                                        'entity' => $ligne,
                                        'url' => route('admin.lignechaines.destroy', $ligne)
                                    ])
                                @else
                                    <a class="delete_line btn btn-sm btn-light text-primary py-0"><i class="fas fa-trash"></i></a>
                                @endif
                                @if(!$with_form)
                                    <input class="input_collaborateur_id" type="hidden" name="chaine[{{ $ligne->rang + $n }}][collaborateur_id]" value="{{ $ligne->collaborateur_id }}">
                                    <input class="input_can_design_obs" type="hidden" name="chaine[{{ $ligne->rang + $n }}][can_design_obs]" value="{{ $ligne->can_design_obs }}">
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($with_form)
                <form action="{{ $action }}" method="POST" class="mb-0">
                    @csrf
            @endif
                <table class="table table-sm table-borderless mb-0">
                    <tbody>
                        <tr class="shadow-sm border-top">
                            <td class="rang">
                                @if ($with_form)
                                    <input type="hidden" name="rang" value="{{ count($ligne_chaines) + 1 }}">
                                    <input type="hidden" name="chaine_validation_id" value="{{ $chaine->id }}">
                                @endif
                                {{ $rang }}
                            </td>
                            <td>
                                @if ($with_form)
                                    @include('partials.components.selectElement', [
                                        'options' => $_collaborateurs,
                                        "display" => "nom_complet",
                                        "name" => "collaborateur_id",
                                        "required" => true,
                                        "empty"=>"Choisissez un collaborateur",
                                        "id" => "line_name",
                                    ])
                                @else
                                    @include('partials.components.selectElement', [
                                        'options' => $_collaborateurs,
                                        "display" => "nom_complet",
                                        "empty"=>"Choisissez un collaborateur",
                                        "id" => "line_name",
                                    ])
                                @endif
                            </td>
                            <td>
                                <label for="can_design" class="p-1 font-weight-normal">
                                    <small>Autorisation d'ajout à la liste de diffusion </small> <input type="checkbox" name="can_design_obs" id="can_design" value="1">
                                </label>
                                <button id="add_chaine_element" @if($with_form) type="submit" @else type="button" @endif class="btn btn-primary btn-xs">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @if($with_form)
                </form>
            @endif

        </div>
    </div>

    @push('subContent')
        {{-- ligne a cloner pour l'ajour d'un élément à la chaine --}}
        <div class="d-none">
            <table>
                <tr id="chaine_element_0">
                    <td class='rang'>0</td>
                    <td id="element_0_name">Prénom Nom</td>
                    <td id="element_0_mj_ld"></td>
                    <td>
                        <a href="#"
                            type="button"
                            data-toggle="modal"
                            data-target="#editModal"
                            data-collaborateur_id="0"
                            data-rang="0"
                            data-can-design="0"
                            data-url="url"
                            class="btn btn-xs btn-light text-warning editModal py-0"
                            ><i class="fas fa-edit"></i></a>

                        <a class="btn btn-xs btn-light text-primary py-0 delete_line"><i class="fas fa-trash"></i></a>
                        @if(!$with_form)
                            <input class="input_collaborateur_id" type="hidden" name="chaine[0][collaborateur_id]" >
                            <input class="input_can_design_obs" type="hidden" name="chaine[0][can_design_obs]" >
                        @endif
                    </td>
                </tr>
            </table>
        </div>
        {{-- modal modification --}}
        <div class="modal fade" id="editModal"  role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="text-primary h6 font-weight-bold modal-title">
                            <i class="fas fa-edit"></i>
                            Modification de la chaine
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @if ($with_form)
                    <form method="POST" action="" id="editForm" enctype="multipart/form-data">
                    @endif
                        <div class="modal-body">
                            @csrf
                            @method("PATCH")
                            <div class="row">
                                <div class="form-group col-12 text-center">
                                    <b class="text-muted">Rang</b>
                                </div>
                                <div class="form-group col-12">
                                    <input type="hidden" name="chaine_validation_id" name="chaine_validation_id_modal" value="{{ $chaine->id }}">
                                    <h4 class="h1 text-center font-weight-lighter text-muted" id="rangText">---</h4>
                                </div>
                                <div class="form-group col-12">
                                    <label for="collaborateur_id">Sélectionner le collaborateur</label>
                                    @if ($with_form)
                                        @include('partials.components.selectElement', [
                                            'options' => $_collaborateurs,
                                            "display" => "nom_complet",
                                            "name" => "collaborateur_id",
                                            "id" => "collaborateur_id_modal",
                                            "required" => true,
                                        ])
                                    @else
                                        @include('partials.components.selectElement', [
                                            'options' => $_collaborateurs,
                                            "display" => "nom_complet",
                                            "id" => "collaborateur_id_modal",
                                        ])
                                    @endif
                                </div>
                                <div class="form-group col-12">
                                    <label for="edit_can_design" class="p-1 font-weight-normal border rounded p-1">
                                        Autorisation d'ajout sur la liste de diffusion <input type="checkbox" name="can_design_obs" id="edit_can_design" value="1">
                                    </label>
                                </div>
                                <hr class="col-10 mx-auto">
                                <div class="form-group col-12 text-center">
                                    <button id="chaine_edit_model_button" @if($with_form) type="button" @endif class="btn btn-lg shadow btn-primary shadow-sm rounded">Mettre à jour</button>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="modal-footer">
                            <button type="button" class="btn btn-xs btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-xs btn-primary">Enregistrer</button>
                        </div> --}}
                    @if ($with_form)
                    </form>
                    @endif
                </div>
            </div>
        </div>

    @endpush

    @push('subScript')
        <script>
            $('body').on('click', '.editModal', function() {
                let collaborateur_id = $(this).data('collaborateur_id');
                let url = $(this).data('url');
                let rang = $(this).data('rang');
                let can_design = $(this).data('can-design');
                $('#editForm').attr('action', url);
                $('#collaborateur_id_modal').val(collaborateur_id);
                $('#rangText').text(rang);
                $('#edit_can_design').prop('checked', can_design);
                $('#collaborateur_id_modal').select2();
            });
            @if (!$with_form)
                $('#add_chaine_element').click(function(){
                    addLine();
                })
                $('body').on('click','.delete_line',function(){
                    $(this).closest('tr').remove();
                    console.log("remove ok");
                    redefinirRangs();
                })
                $('#chaine_edit_model_button').click(function(){
                    editLine();
                })

                function addLine(){
                    collab_id = $('#line_name').val();
                    if(!collab_id){
                        alert('Sélectionnez un collaborateur');
                    }else{
                        $('#element_0_name').html($('#line_name option:selected').text());
                        if($('#can_design').prop('checked')){
                            $('#element_0_mj_ld').html('Oui');
                            $("#chaine_element_0").find(".input_can_design_obs").val(1);

                        }else{
                            $('#element_0_mj_ld').html('Non');
                            $("#chaine_element_0").find(".input_can_design_obs").val(0);
                        }
                        element = $("#chaine_element_0").clone();
                        element.removeAttr('id');
                        element.children('td').removeAttr('id');
                        //Configure Dataset ---------------------
                        element.find(".editModal").data('collaborateur_id',collab_id);
                        element.find(".input_collaborateur_id").val(collab_id);
                        if($('#can_design').prop('checked')){
                            element.find(".editModal").data('can-design',1);
                        }
                        //----------------------------------------
                        $('#chaine_body').append(element);
                        console.log('clone ok');
                        redefinirRangs();
                    }
                }

                function editLine(){
                    tr = getEditedChaineElement();
                    console.log(tr);
                    if(tr){
                        console.log('ligne identifiée');
                        collab_id = $('#collaborateur_id_modal').val();
                        //Nom du collaborateur
                        nom = $('#collaborateur_id_modal option:selected').text();
                        console.log(nom);
                        tr.find(".nom").html(nom);
                        if($('#edit_can_design').prop('checked')){
                            tr.find(".can_design").html('Oui');
                            tr.find(".editModal").data('can-design',1);
                            tr.find(".input_can_design_obs").val(1);
                        }else{
                            tr.find(".can_design").html('Non');
                            tr.find(".editModal").data('can-design',0);
                            tr.find(".input_can_design_obs").val(0);
                        }
                        tr.find(".editModal").data('collaborateur_id',collab_id);
                        tr.find(".input_collaborateur_id").val(collab_id);
                    }
                    console.log('closing...')
                    $('#editModal').modal('hide');
                }

                function redefinirRangs(){
                    $('.rang').each(function( index ) {
                        index++;
                        $(this).html(index);
                        tr = $(this).parent('tr');
                        tr.find(".editModal").data('rang',index);
                        tr.find(".input_collaborateur_id").attr('name', 'chaine['+index+'][collaborateur_id]');
                        tr.find(".input_can_design_obs").attr('name', 'chaine['+index+'][can_design_obs]');
                    });
                    console.log("Rangs redéfnis");
                }

                function getEditedChaineElement(){
                    rang = $('#rangText').html();
                    tr = false
                    $('.rang').each(function( index ) {
                        if($(this).html()==rang){
                            console.log('rang ok');
                            tr = $(this).parent('tr');
                        }
                    });
                    return tr;
                }

            @endif
        </script>
    @endpush

@endif

