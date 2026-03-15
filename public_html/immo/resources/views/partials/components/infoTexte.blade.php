@php
    $readyOnly = true;
    $info = $field->info;
@endphp
@if ($info)
    @if(in_array($field->type_field_id, [1,2,5,6,7]))
        {{ $info->value }}
    @else
        <?php if ($field->type_field_id == 3 || $field->type_field_id == 4) : $choices = explode(';', $field->choices);
        if (isset($field->info->value)) {
            $old_choices = explode(';', $field->info->value);
        } ?>
        <div class="panel-gray-xs">
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

        <?php elseif ($field->type_field_id == 10) : ?>
            <?php if (isset($field->info) && $field->info->value !== "") {
                $ext = strtolower(pathinfo($field->info->value, PATHINFO_EXTENSION)); ?>
                <div class="border p-1">
                    <?php if (in_array($ext, ['jpg', 'png', 'jpeg'])) { ?>
                        <a href="<?= asset($field->info->value) ?>" data-fancybox="<?= h($field->name) ?>" data-caption="<?= h($field->name . $field->info->id) ?>">
                            <img src="<?= asset('doc.png') ?>" alt="<?= h($field->name) ?>" class="mx-4" style="height: 35px; width: auto">
                        </a>
                    <?php  } else { ?>
                        <a href="<?= asset($field->info->value) ?>" data-type="iframe" data-fancybox="<?= h($field->name) ?>" data-caption="<?= h($field->name . $field->info->id) ?>">
                            <img src="<?= asset('doc.png') ?>" alt="<?= h($field->name) ?>" class="mx-4" style="height: 35px; width: auto">
                        </a>
                    <?php } ?>
                    <?php if (!isset($readyOnly)) : ?>
                        <a href="<?= $this->Url->build(['controller' => 'KFichiers', 'action' => 'delete', '?' => ['info' => $field->info->id]]) ?>" class="btn btn-xs btn-danger "><i class="fa fa-trash"></i></a>
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
        @elseif($field->type_field_id == 11)
            @php
                $liste = App\Models\Liste::find($field->choices);
            @endphp
            {{ $liste->displayElement($field->info->value) }}
        @endif
    @endif
@else
    ---
@endif
