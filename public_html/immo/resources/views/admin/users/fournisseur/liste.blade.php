    <!-- Dropdown - User Information -->
    @section('tableHeader')
        <tr>

            <td style="width:100px !important">Prénom</td>
            <td>Nom</td>
            <td>Adresse</td>
            <td>Telephone</td>
            <td>Action(s)</td>
        </tr>
    @endsection

    {{-- Table Body --}}
    @section('tableBody')
        @php $i = 1 @endphp
        @foreach ($users as $user)
        <tr>

            <td>{{  $user->fournisseur->prenom ?? '---' }}</td>
            <td>{{  $user->fournisseur->nom ?? '---' }}</td>
            <td>{{ $user->fournisseur->adresse }}</td>
            <td>{{  $user->fournisseur->telephone ?? '---' }}</td>
            <td>
                <a href="{{ route('admin.showUser', $user->fournisseur->id) }}" id="{{ $user->fournisseur->id }}" class="btn btn-success btn-xs user">
                    <i class="fa fa-eye"></i>
                </a>
                    <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-warning btn-xs">
                        <i class="fa fa-edit"></i>
                    </a>
                    @if ($user->statut)
                        @include('partials.components.deleteBtnElement',[
                            'url'=>route('admin.users.destroy',$user->id),
                            'class'=> 'btn btn-xs btn-success',
                            'message_confirmation'=>"Voulez-vous vraiment désactiver l'utilisateur : " .$user->id,
                            'entity'=>$user,
                            'btnInnerHTML'=>'<i class="fa fa-unlock"></i>'
                        ])
                        @else

                        @include('partials.components.deleteBtnElement',[
                            'url'=>route('admin.users.destroy',$user->id),
                            'class'=> 'btn btn-xs btn-danger',
                            'message_confirmation'=>"Voulez-vous vraiment activer l'utilisateur : " .$user->id,
                            'entity'=>$user,
                            'btnInnerHTML'=>'<i class="fa fa-lock"></i>'
                        ])
                    @endif
            </td>
        </tr>
        @php $i++ @endphp
        @endforeach
    @endsection
