<table class="table table-striped table-hover table-sm" id="datatable" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th>Requis</th>
        <th>Intitulé</th>
        <th>Type</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($fields as $field)
            <tr>
                <td> {{ $field->requis == 1 ? 'OUI' : "NON" }}</td>
                <td>
                    {{ $field->name }}
                </td>
                <td><span class="badge badge-info border small"> {{ $field->type_field->name }}</span></td>
                <td>
                    @if($field->type_field_id == 8)
                    <a title="configurer la grille" href="#" class="bg-white btn btn-xs">
                        <i class="fa fa-cogs" style="color: #00bcd4"></i>
                    </a>
                    @endif

                    <a href="{{ route('admin.fields.update', $field->id) }}" class="bg-white btn btn-sm editStatic"
                        data-attribut="{{ $field->attribut }}"
                        data-ref="{{ $field->ref }}"
                        data-type="{{ $field->type_field_id }}"
                        data-dynamic="{{ isset($field->dynamic) && !$field->dynamic ? '0' : '1' }}"
                        data-lignes="{{ $field->lignes }}"
                        data-col="{{ $field->col }}"
                        data-choices="{{ $field->choices }}"
                        data-nom="{{ $field->name }}"
                        data-niveau="{{ $field->niveau }}"
                        data-requis="{{ $field->requis }}"
                        data-label="{{ $field->label }}"
                        data-reference="{{ $field->reference }}"
                        data-toggle="modal"
                        data-target="#staticModal">
                        <i class="fa fa-edit text-success"></i>
                    </a>

                    @include('partials.components.deleteBtnElement',[
                    'url'=>route('admin.fields.destroy',$field->id),
                    'message_confirmation'=>'Voulez-vous supprimer le champ: ' .$field->name,
                    'btnInnerHTML'=>'<i class="fa fa-times text-danger"></i>',
                    'class'=>'btn bg-white btn-xs',
                    'entity'=>$field
                    ])
                    {{--  //$this->Form->postLink(__('<i class="fa fa-times text-danger"></i>'), ['controller' => 'Fields', 'action' => 'delete', $field->id], ['escape' => false,'class' => 'btn bg-white btn-xs', 'confirm' => __('Voulez vous supprimer :  {0}?', $field->name)])  --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
