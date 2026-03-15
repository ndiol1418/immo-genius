<?php foreach ($fields as $field) : ?>
    <!-- Extended material form grid -->
    <div class="padding-5 <?= $field->col !== null ? 'col-md-' . $field->col : (in_array($field->type_field_id, [3, 4, 6, 8]) ? 'col-md-12' : 'col-md-6') ?>">
        <div class="{{ $field->type_field_id == 9 ? "text-white bg-gray px-3 py-1 my-2 separateur shadow-sm" : "py-1 my-1 field_component" }}">
            <?php if ($field->label) { ?>
                <label for="info<?= $field->id ?>" class="<?= $field->col == 12 ? "step-header" : "" ?> <?= isset($text) ? 'info-label' : '' ?>" style="display: block"><?= $field->label ?> <?= $field->requis == 1 ? ' <span class="text-danger">*</span>' : '' ?> </label>
            <?php } ?>
            <!-- TYPE TEXT OU DATE -->
            <?php if ($field->type_field_id == 1 || $field->type_field_id == 7) : ?>
                <?php if (isset($text)) : echo isset($field->info) ? '<span class="form-info-text" id="field' . $field->id . '">' . $field->info->value . '</span>' : '_';
                else : ?>
                    <input <?= isset($readyOnly) ? 'disabled' : '' ?> type="text" <?= $field->requis == 1 ? 'required' : '' ?> name="infos[<?= $field->id ?>]" value="<?= isset($field->info) ? $field->info->value : '' ?>" class="form-control form-control-sm input__large <?= $field->type_field_id == 7 ? 'textDate' : '' ?>" placeholder="<?= !$field->label ? $field->name : '' ?>">
                <?php endif; ?>
            <!-- TYPE NUMBER -->
            <?php elseif ($field->type_field_id == 2) : ?>
                <?php if (isset($text) || isset($readyOnly)) : echo isset($field->info) && $field->info->value ? '<span class="form-info-text" >' . (isset(explode('.', (string) $field->info->value)[1]) ? number_format((float) $field->info->value, 2, ',', ' ') : number_format((float) $field->info->value, 0, ',', ' ')) . '</span>' : '_';
                else : ?>
                    <input <?= isset($readyOnly) ? 'disabled' : '' ?> type="text" data-id="<?= $field->id ?>" id="field<?= $field->id ?>" step="any" <?= $field->requis == 1 ? 'required' : '' ?> value="<?= isset($field->info) ? $field->info->value : '' ?>" class="form-control form-control-sm input__large number" placeholder="<?= !$field->label ? $field->name : '' ?>">
                    <input <?= isset($readyOnly) ? 'disabled' : '' ?> type="hidden" id="infos<?= $field->id ?>" name="infos[<?= $field->id ?>]" value="<?= isset($field->info) ? $field->info->value : '' ?>">
                <?php endif; ?>

            <!-- TYPE SELECT BOX -->
            <?php elseif ($field->type_field_id == 5) :
                $choices = explode(';', $field->choices);
                ?>
                <?php if (isset($text)) : echo isset($field->info) ? '<span class="form-info-text" id="field' . $field->id . '">' . $field->info->value . '</span>' : '_';
                else : ?>
                    <?php if (isset($field->info->value) && !in_array($field->info->value, $choices)) {
                        $autre_a__preciser = $field->info->value;
                    } ?>
                    <select id="info<?= $field->id ?>" name="infos[<?= $field->id ?>]" data-id="<?= $field->id ?>" <?= $field->requis == 1 ? 'required' : '' ?> class="form-control select select__large select2-blue select2">
                        <option value default disabled>Selectionner : <?= $field->name ?></option>
                        <?php foreach ($choices as $key_value) :
                            $value = explode(':', $key_value)[0];
                            $libelle = isset(explode(':', $key_value)[1]) ? explode(':', $key_value)[1] : explode(':', $key_value)[0]; ?>
                            <option value="<?= $value ?>" <?= isset($autre_a__preciser) && $autre_a__preciser != "" && strtolower($value) == 'autres' ? 'selected' : '' ?> <?= isset($field->info->value) && strtolower($field->info->value) == strtolower($value) ? 'selected' : '' ?>><?= $libelle ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
                {{-- <?php //if (isset($autre_a__preciser) && $autre_a__preciser != "") : ?>
                    <div class="py-1 px-1 my-1 animate__animated animate__zoomIn shadow-sm">
                        <label class="padding-5 text-dark" style="display: block">Autre à preciser</label>
                        <input type="text" name="infos[<?= $field->id ?>]" id="autre<?= $field->id ?>" class="form-control form-control-sm input__large" value="<?= $autre_a__preciser ?>" placeholder="autre à préciser">
                    </div>
                <?php //endif; ?> --}}

            <!-- TYPE RADIO OU CHECKBOX -->
            <?php elseif ($field->type_field_id == 3 || $field->type_field_id == 4) : $choices = explode(';', $field->choices);
                if (isset($field->info->value)) {
                    $old_choices = explode(';', $field->info->value);
                } ?>
                <div class="panel-gray-xs border rounded bg-white">
                    <?php if (isset($text)) :
                        foreach ($old_choices as $i => $choice) {
                            echo $choice;
                            if ($i < sizeof($old_choices) - 1) echo ', ';
                        } else : if ($field->type_field_id == 3) { //Type checkbox only
                    ?>
                            <label for="tout<?= $field->id ?>" class="mx-1 label_check_component">
                                <input <?= isset($readyOnly) ? 'disabled' : '' ?> data-id="<?= $field->id ?>" id="tout<?= $field->id ?>" value="all" type="<?= $field->type_field->type ?>" class="tout<?= $field->id ?> toutCocher" id="tout<?= $field->id ?>">
                                <span class="text-info">Tout cocher</span>
                            </label>
                        <?php }
                        foreach ($choices as $choice) : ?>
                            <label for="<?= $choice . $field->id ?>" style="cursor: pointer;" class="mx-1 label_check_component">
                                <input <?= isset($readyOnly) ? 'disabled' : '' ?> data-id="<?= $field->id ?>" id="<?= $choice . $field->id ?>" name="infos[<?= $field->id ?>][]" <?= isset($old_choices) && in_array($choice, $old_choices) ? 'checked' : '' ?> value="<?= $choice ?>" type="<?= $field->type_field->type ?>" class="checkbox<?= $field->id ?> checkbox">
                                <span><?= $choice ?></span>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            <!-- TYPE TEXTAREA -->
            <?php elseif ($field->type_field_id == 6) : ?>
                <?php if (isset($readyOnly)) : ?>
                    <div class="p-2 text-dark textarea border" style="background-color: #eee;background-color: #eee;line-height: 1.5;font-weight: normal; ">
                        <?= $field->info->value && $field->info->value != "" ? $field->info->value : 'Aucune information !' ?>
                    </div>
                <?php else : ?>
                    <textarea class="form-control form-control-sm textarea" id="info<?= $field->id ?>" name="infos[<?= $field->id ?>]" rows="5" cols="30" placeholder="<?= $field->name ?>"><?= isset($field->info->value) ? $field->info->value : '' ?></textarea>
                <?php endif; ?>

            <!-- PIECE JOINTE OU DATE -->
            <?php elseif ($field->type_field_id == 10) : ?>
                <?php if (isset($field->info) && $field->info->value !== "") {
                    $ext = strtolower(pathinfo($field->info->value, PATHINFO_EXTENSION)); ?>
                    <div class="border p-1">
                        <?php if (in_array($ext, ['jpg', 'png', 'jpeg'])) { ?>
                            <a href="<?= asset($field->info->value) ?>" data-fancybox="<?= $field->name ?>" data-caption="<?= $field->name . $field->info->id ?>">
                                <img src="<?= asset('doc.png') ?>" alt="<?= $field->name ?>" class="mx-4" style="height: 35px; width: auto">
                            </a>
                        <?php  } else { ?>
                            <a href="<?= asset($field->info->value) ?>" data-type="iframe" data-fancybox="<?= $field->name ?>" data-caption="<?= $field->name . $field->info->id ?>">
                                <img src="<?= asset('doc.png') ?>" alt="<?= $field->name ?>" class="mx-4" style="height: 35px; width: auto">
                            </a>
                        <?php } ?>
                        <?php if (!isset($readyOnly)) : ?>
                            <a href=":" class="btn btn-xs btn-danger "><i class="fa fa-trash"></i></a>
                        <?php endif; ?>
                    </div>
                <?php  } else { ?>
                    <?php if (isset($readyOnly)) : ?>
                        <input type="text" value="Pas de fichier enregistré!" class="form-control form-control-sm disabled">
                    <?php else : ?>
                        <input type="file" <?= $field->requis == 1 ? 'required' : '' ?> name="infos[<?= $field->id ?>]" class="form-control form-control-sm <?= $field->type_field_id == 2 ? 'number' : '' ?>" placeholder="<?= !$field->label ? $field->name : '' ?>">
                    <?php endif; ?>
                <?php  } ?>
                <!-- TYPE GRILLE -->
                <?php elseif ($field->type_field_id == 8) :

                //Libelle des grilles
                $ths = explode(';', $field->choices);

                //If isset value
                if (isset($field->info->value)) {
                    $trs = explode('|', $field->info->value);
                }
                if ($field->dynamic == 1) { //TABLEAU DYNAMIQUE
                    if (count($ths) > 0) { ?>
                        <input <?= isset($readyOnly) ? 'disabled' : '' ?> type="hidden" name="infos[<?= $field->id ?>]" id="info<?= $field->id ?>" value="<?= isset($field->info->value) ? $field->info->value : '' ?>">

                        <table class="table table-striped table-bordered table-condensed">
                            <tr>
                                <?php foreach ($ths as $formated_String) :

                                    //1er niiveau d'explode vaut | et deuxieme pour les select vaut :
                                    $libelle_type_selectValues = explode('|', $formated_String);

                                    //Libelle
                                    if (isset($libelle_type_selectValues[0])) {
                                        $th = $libelle_type_selectValues[0];
                                    }
                                ?>
                                    <th class="td-grille"><?= $th ?></th>
                                <?php endforeach; ?>
                                <?= !isset($readyOnly) ? '<th class="td-grille">Action</th>' : '' ?>
                            </tr>
                            <?php if (isset($trs) && count($trs) > 0) : ?>
                                <?php foreach ($trs as $tr) : $tds = explode(';', $tr) ?>
                                    <tr>
                                        <?php $i = 0;
                                        foreach ($tds as $td) : $parseLigne = explode('|', $ths[$i]);
                                            if (isset($parseLigne[1]) && $parseLigne[1] == "number") $isNumber = true;
                                        ?>
                                            <td class="td-grille <?= isset($isNumber) && $isNumber == true ? "text-right" : "" ?>">
                                                <?= isset($isNumber) && $isNumber == true ? (isset(explode('.', (string) $td)[1]) ? number_format((float) $td, 2, ',', ' ') : number_format((float) $td, 0, ',', ' '))  : $td ?>
                                            </td>
                                        <?php $i++;
                                            $isNumber = null;
                                        endforeach;
                                        if ($tr && $tr != "" && !isset($readyOnly)) { ?>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm btn-remove" data-id="<?= $field->id ?>" data-valeur="<?= $tr ?>"><i class="fa fa-trash"></i></button>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if (!isset($readyOnly)) : ?>
                                <tr id="inputs<?= $field->id ?>">
                                    <?php foreach ($ths as $formated_String) :
                                        //1er niiveau d'explode vaut | et deuxieme pour les select vaut :
                                        $libelle_type_selectValues = explode('|', $formated_String);

                                        //Libelle
                                        if (isset($libelle_type_selectValues[0])) {
                                            $th = $libelle_type_selectValues[0];
                                        }

                                        //Type
                                        if (isset($libelle_type_selectValues[1])) {
                                            $type = $libelle_type_selectValues[1];
                                        }

                                        //If type = select
                                        if (isset($libelle_type_selectValues[2])) {
                                            $selectValues = explode(':', $libelle_type_selectValues[2]);
                                        }
                                    ?>
                                        <td class="td-grille">
                                            <?php if (isset($type) && $type == "select") : //Si le type est un select
                                            ?>
                                                <select class="input form-control">
                                                    <?php foreach ($selectValues as $select) : ?>
                                                        <option value="<?= $select ?>"><?= $select ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php else : ?>
                                                <input <?= isset($readyOnly) ? 'disabled' : '' ?> type="text" placeholder="<?= $th ?>" class="input form-control form-control-sm <?= isset($type) && $type != '' ? $type : '' ?>">
                                            <?php endif; ?>
                                        </td>
                                    <?php $type = null;
                                    endforeach; ?>
                                    <td class="td-grille">
                                        <button data-id="<?= $field->id ?>" id="btn<?= $field->id ?>" class="btn btn-success btn-sm btn-grille" type="button"><i class="fa fa-check"></i></button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    <?php }
                } else { //TABLEAU STATIQUE
                    if ($field->lignes != null && trim($field->lignes) != "") {
                        $lignes = explode(';', $field->lignes);
                        if (isset($field->info->value)) {
                            $informations = [];
                            $info_lignes = explode('|', $field->info->value);
                            for ($inf_i = 0; $inf_i < count($info_lignes); $inf_i++) {
                                $info_ligne = $info_lignes[$inf_i];
                                $info_cols = explode(';', $info_ligne);
                                for ($inf_c = 0; $inf_c < count($info_cols); $inf_c++) {
                                    $informations[$inf_i][$inf_c] = $info_cols[$inf_c];
                                }
                            }
                        } ?>
                        <table class="table table-striped table-bordered table-condensed">
                            <tr>
                                <td>Rubriques</td>
                                <?php foreach ($ths as $formated_String) :

                                    //1er niiveau d'explode vaut | et deuxieme pour les select vaut :
                                    $libelle_type_selectValues = explode('|', $formated_String);

                                    //Libelle
                                    if (isset($libelle_type_selectValues[0])) {
                                        $th = $libelle_type_selectValues[0];
                                    }
                                ?>
                                    <th class="td-grille text-right"><?= $th ?></th>
                                <?php endforeach; ?>
                            </tr>
                            <?php for ($row = 0; $row < count($lignes); $row++) : ?>
                                <tr id="infos_grille<?= $field->id ?>" data-indice="<?= $row ?>">
                                    <td class="text-left"><?= $lignes[$row] ?></td>
                                    <?php for ($col = 0; $col < count($ths); $col++) :
                                        $formated_String = $ths[$col];
                                        //1er niiveau d'explode vaut | et deuxieme pour les select vaut :
                                        $libelle_type_selectValues = explode('|', $formated_String);

                                        //Libelle
                                        if (isset($libelle_type_selectValues[0])) {
                                            $th = $libelle_type_selectValues[0];
                                        }

                                        //Type
                                        if (isset($libelle_type_selectValues[1])) {
                                            $type = $libelle_type_selectValues[1];
                                        }

                                        //If type = select
                                        if (isset($libelle_type_selectValues[2])) {
                                            $selectValues = explode(':', $libelle_type_selectValues[2]);
                                        }
                                    ?>
                                        <td class="td-grille text-right">
                                            <?php if (isset($type) && $type == "select") : //Si le type est un select
                                            ?>
                                                <select class="input form-control form-control-sm input_grille_statique" <?= isset($readyOnly) ? 'disabled' : '' ?> name="infos[<?= $field->id ?>][<?= $row ?>][<?= $col ?>]">
                                                    <?php foreach ($selectValues as $select) : ?>
                                                        <option value="<?= $select ?>" <?= isset($informations[$row][$col]) && $informations[$row][$col] == $select ? 'selected' : '' ?>><?= $select ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <?php else : if (!isset($readyOnly)) { ?>
                                                    <input <?= isset($readyOnly) ? 'disabled' : '' ?> type="text" name="infos[<?= $field->id ?>][<?= $row ?>][<?= $col ?>]" value="<?= isset($informations[$row][$col]) ? $informations[$row][$col] : '' ?>" placeholder="<?= $th ?>" class="input form-control form-control-sm input_grille_statique <?= isset($type) && $type != '' ? $type : '' ?>">
                                            <?php } else {
                                                    if (isset($type) && $type == 'number') { //Type Number
                                                        $info = str_replace(' ', '', $informations[$row][$col]);
                                                        echo isset($info) && $info != "" ? (isset(explode('.', (string) $info)[1]) ? number_format((float) $info, 2, ',', ' ') : number_format((float) $info, 0, ',', ' '))  : '_';
                                                    } else { //Autre Type
                                                        echo isset($info) && $info != "" ? $info  : '_';
                                                    }
                                                }
                                            endif; ?>
                                        </td>
                                    <?php $type = false;
                                    endfor; ?>
                                </tr>
                            <?php endfor; ?>
                        </table>
                    <?php } else { // Ligne Tableau est vide
                    ?>
                        <div class="alert alert-light text-danger border text-center">
                            Veuillez saisir les lignes de cette grille statique !
                        </div>
                <?php  }
                }
            ?>
            {{-- Liste interne --}}
            @elseif( $field->type_field_id == 11)
                @php
                    $valeurs = [];
                    $liste = App\Models\Liste::find($field->choices);
                    if($liste){
                        $valeurs = $liste->valeurs;
                    }
                @endphp
                <select id="info<?= $field->id ?>" name="infos[<?= $field->id ?>]" data-id="<?= $field->id ?>" <?= $field->requis == 1 ? 'required' : '' ?> class="form-control select select__large select2-blue select2">
                    <option value default disabled>Selectionner : <?= $field->name ?></option>
                    @foreach ($valeurs as $valeur) :
                        @isset($valeur[$liste->identifiant])
                            <option value="<?= $valeur[$liste->identifiant] ?>">{{$liste->displayElement($valeur[$liste->identifiant])}}</option>
                        @endisset
                    @endforeach
                </select>

            @endif
        </div>
    </div>
<?php $ths = null;
    $trs = null;
    $formated_String = null;
    $autre_a__preciser = null;
    $choices = null;
endforeach; ?>

@section('partialScript')
    <script src="{{ asset('js/partials/formScript.js') }}"></script>
@endsection

@section('customCss')
    <style>
        /* form {
            padding: 10px 8px;
            border: 1px solid #e3e6f0 !important;
            background-color: #e3e6f0;
            border-radius: 8px;
        }

        form hr {
            margin: 4px auto;
        }

        form label {
            color: #6C757D;
            margin-bottom: 0.1rem;
            font-size: 12px;
        } */
        .separateur {
            border-radius: 8px;
            text-transform: uppercase;
            border-right: 15px solid white;
            border-left: 5px solid white;
        }
        .separateur label { margin-bottom: 0 !important; color: white !important;font-size: 14px !important; }
    </style>
@endsection
