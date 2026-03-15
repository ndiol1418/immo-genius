{{-- formulaire des accès --}}

<div class="form-group row">

    <div class="col-md-3  jumbotron">
        <div class="row justify-content-md-center">
            <div class="col-12 profil">

                <div class="profil_image">
                    <img src="{{ old('collaborateur.photo') ?? isset($collaborateur->photo) ? asset($collaborateur->photo) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/57/OOjs_UI_icon_userAvatar-progressive.svg/1024px-OOjs_UI_icon_userAvatar-progressive.svg.png' }}"
                    alt=""  id="img-logo"  class="rounded mx-auto d-block photo"/>

                </div>
                <label for="image-upload"><i class="fa fa-edit fa-pull-right text-primary"></i></label>
                <input type="file" name="image" id="image-upload" />
            </div>
            {{-- <div class="file">
                <input id="image" type="file" name="image" class="form-control @error('image') is-invalid @enderror" value="{{ old('image') }}"  autocomplete="image">

            </div> --}}
        </div>
        @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

    </div>
    <div class="col-md-9 pl-4">
        <div class="form-group  row">
            <div class="col-md-6">
                <label for="prenom" class="col-form-label text-md-right">{{ __('Prénom (*)') }}</label>
                <input id="prenom" type="text" class="form-control @error('collaborateur.prenom') is-invalid @enderror" name="collaborateur[prenom]" value="{{ old('collaborateur.prenom') ?? $collaborateur->prenom }}" required autocomplete="prenom">

                @error('collaborateur.prenom')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="nom" class="col-form-label text-md-right">{{ __("Nom  (*)") }}</label>
                <input id="nom" type="text" class="form-control @error('collaborateur.nom') is-invalid @enderror" name="collaborateur[nom]" value="{{ old('collaborateur.nom') ?? $collaborateur->nom }}" required autocomplete="nom" autofocus>

                @error('collaborateur.nom')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="matricule" class="col-form-label text-md-right">{{ __('Matricule (*)') }}</label>
                <input id="matricule" type="text" class="form-control @error('collaborateur.matricule') is-invalid @enderror" name="collaborateur[matricule]" value="{{ old('collaborateur.matricule') ?? $collaborateur->matricule }}" required autocomplete="matricule">

                @error('collaborateur.matricule')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="email" class="col-form-label text-md-right">{{ __('Adresse Email  (*)') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $user->email }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="mobile" class="col-form-label text-md-right">{{ __("Téléphone Portable") }}</label>
                <input id="mobile" type="text" class="form-control @error('collaborateur.mobile') is-invalid @enderror" name="collaborateur[mobile]" value="{{ old('collaborateur.mobile') ?? $collaborateur->mobile }}"  autocomplete="mobile" autofocus>

                @error('collaborateur.mobile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="telephone" class="col-form-label text-md-right">{{ __("Téléphone Fixe") }}</label>
                <input id="telephone" type="text" class="form-control @error('collaborateur.telephone') is-invalid @enderror" name="collaborateur[telephone]" value="{{ old('collaborateur.telephone') ?? $collaborateur->telephone }}"  autocomplete="telephone" autofocus>

                @error('collaborateur.telephone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


        </div>

        <div class="form-group row">

            <div class="col-md-6">
                <label for="igg" class="col-form-label text-md-right">{{ __('IGG  (*)') }}</label>
                <input id="igg" type="text" class="form-control @error('collaborateur.igg') is-invalid @enderror" name="collaborateur[igg]" value="{{ old('collaborateur.igg') ?? $collaborateur->igg }}" required autocomplete="igg">

                @error('collaborateur.igg')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="naissance" class="col-form-label">{{ __('Naissance') }}</label>
                <input id="naissance" type="date" class="form-control @error('collaborateur.naissance') is-invalid @enderror" name="collaborateur[naissance]" value="{{ old('collaborateur.naissance') ?? $collaborateur->naissance }}"  autocomplete="naissance">

                @error('collaborateur.naissance')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>



        </div>
        <div class="form-group row">
            <div class="col-md-6 ">
                <label for="inputState" class="col-form-label">Genre (*)</label>
                <div class="form-group">

                    <label for="genreH">
                        <input type="radio" name="collaborateur[genre]" id="genreH" value="1" {{ !isset($collaborateur->genre) ||  $collaborateur->genre == 1? "checked" : "" }}> Homme
                    </label>
                    <label for="genreF">
                        <input type="radio" name="collaborateur[genre]" id="genreF" value="0" {{ isset($collaborateur->genre) && $collaborateur->genre == 0 ? "checked" : "" }}> Femme
                    </label>

                </div>

                @error('collaborateur.genre')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="service_id" class="col-form-label">{{ __('Choisissez un poste') }}</label>
                @include('partials.components.selectElement', [
                    'options' => $_postes,
                    'empty' => "Sélectionner un poste",
                    "name" => "poste_id",
                    'display' => 'name',
                    'class' => 'select2',
                    'default' => old('poste_id') ?? null
                ])
                {{-- @error('poste_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror --}}
            </div>

            <div class="col-md-4 my-2">
                <label for="service_id" class="col-form-label">{{ __('Direction (*)') }}</label>
                @include('partials.components.selectElement', [
                    'options' => $directions,
                    'empty' => "Choisissez une direction",
                    "name" => "collaborateur[direction_id]",
                    "required"=>true,
                    'display' => 'name',
                    'class' => 'select2',
                    'default' => old('collaborateur.direction_id') ?? $collaborateur->direction_id
                ])
            </div>
            <div class="col-md-4 my-2">
                <label for="service_id" class="col-form-label">{{ __('Service') }}</label>
                @include('partials.components.selectElement', [
                    'options' => $services,
                    'empty' => "Choisissez un service",
                    "name" => "collaborateur[service_id]",
                    'display' => 'name',
                    'class' => 'select2',
                    'default' => old('collaborateur.service_id') ?? $collaborateur->service_id
                ])
            </div>
            <div class="col-md-4 my-2">
                <label for="service_id" class="col-form-label">{{ __('Département') }}</label>
                @include('partials.components.selectElement', [
                    'options' => $departements,
                    'empty' => "Choisissez un departement",
                    "name" => "collaborateur[departement_id]",
                    'display' => 'name',
                    'class' => 'select2',
                    'default' => old('collaborateur.departement_id') ?? $collaborateur->departement_id
                ])
            </div>

        </div>

        <!-- div class="form-group row">
            <div class="col-md-12">
                <h4 class="text-muted h5"><span>Les managers n+1 - n+3</span></h4>
            </div>

            <div class="col-md-4 my-2">
                @include('partials.components.selectElement', [
                    'options' => $_collaborateurs,
                    'empty' => "Manager n+1",
                    "name" => "collaborateur[manager_1]",
                    'display' => 'nom_complet',
                    'class' => 'select2',
                    'default' => old('collaborateur.manager_1') ?? $collaborateur->manager_1
                ])
            </div>
            <div class="col-md-4 my-2">
                @include('partials.components.selectElement', [
                    'options' => $_collaborateurs,
                    'empty' => "Manager n+2",
                    "name" => "collaborateur[manager_2]",
                    'display' => 'nom_complet',
                    'class' => 'select2',
                    'default' => old('collaborateur.manager_2') ?? $collaborateur->manager_2
                ])
            </div>
            <div class="col-md-4 my-2">
                @include('partials.components.selectElement', [
                    'options' => $_collaborateurs,
                    'empty' => "Manager n+3",
                    "name" => "collaborateur[manager_3]",
                    'display' => 'nom_complet',
                    'class' => 'select2',
                    'default' => old('collaborateur.manager_3') ?? $collaborateur->manager_3
                ])
            </div>
        </div -->

        <div class="form-group row access">
            <div class="col-md-{{ $user->exists === true ? "6" : "6" }} ">
                <h4 class="text-muted h5"><span>Paramétrage des accès</span></h4>
            </div>
            @if ($user->exists === true)
                <div class="col-md-6">
                    <button type="button" onclick="{{ $user->exists === true ? "enableDisableInput()" : "" }}" class="btn btn-xs btn-primary btn-block float-right col-md-2">
                        <i class="fa fa-{{ $user->exists === true ? "edit" : "" }}"></i> {{ $user->exists === true ? "" : "" }}
                    </button>
                </div>
            @endif

            <div class="col-md-12">
                <label for="service_id" class="col-form-label">{{ __('Choisissez le profil (*)') }}</label>
                @include('partials.components.selectElement', [
                    'options' => $profils,
                    "name" => "profil_id",
                    'display' => 'name',
                    'class' => 'select2',
                    'default' => ''
                ])
                {{-- @error('poste_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror --}}
            </div>

            <div class="col-md-6 password">
                <label for="password" class="col-form-label text-md-right">{{ __('Mot de passe') }}</label>
                <div class="input-group border" style="border-radius: 8px">
                    <input data-toggle="popover" title="Mot de passe" data-placement="top" data-trigger="focus" data-content="Au moins 8 caractères, au moins 1 majuscule, au moins 1 minuscule, et au moins 1 caractère spécial." id="password" type="password" {{ $user->exists === true ? "disabled" : "" }}  class="pwd form-control @error('password') is-invalid @enderror" name="password" value="" required autocomplete="new-password">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" id="showPassword"><i class="fas fa-eye-slash"></i></button>
                    </span>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6 password">
                <label for="password-confirm" class="col-form-label text-md-right">{{ __('Confirmer mot de passe') }}</label>
                <input data-toggle="popover" title="Mot de passe" data-placement="top" data-trigger="focus" data-content="Doit correspondre au mot de passe saisi et être valide aussi." id="password-confirm" {{ $user->exists === true ? "disabled" : "" }}  type="password" class="pwd form-control" name="password_confirmation" required  autocomplete="new-password">

            </div>


            <div class="col-md-12">
                <label class="form-check-label text-warning" >Les champs obligatoire sont identifiés par (*)</label>
            </div>
        </div>
    </div>
</div>



@section('partialScript')
    <script>

        if(document.querySelector('#is_admin:checked') != null){
            var checkedValue_is_admin = document.querySelector('#is_admin:checked').value;
        }else{
            var checkedValue_is_admin = 0;
        }

        $(function() {
            function readURL(input) {
                if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#img-logo').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
                }
            }
            $("#image-upload").change(function() {
                readURL(this);
            });
        });


        if(checkedValue_is_admin){
            if(checkedValue_is_admin == 1) {
                $(".plateforme_id").prop('required',true);
                $(".plateforme" ).show(500);
            }else{
                $(".plateforme" ).hide(500);
                $(".plateforme_id").prop('required',false);
            }

        }else if(checkedValue_is_admin == 0){
            $("#is_admin").click(function(){
                if(document.querySelector('#is_admin:checked') != null){
                    if( document.querySelector('#is_admin:checked').value == 1){
                        $(".plateforme" ).show(500);
                        check();
                        $(".plateforme_id").prop('required',false);
                    }
                }else{
                    $(".plateforme" ).hide(500);
                    uncheck();
                    $(".plateforme_id").prop('required',false);
                }
            });
        }
    </script>
    <script src="{{ asset('js/partials/modalSelect.js') }}"></script>
    <script src="{{ asset('js/partials/validationPassword.js') }}"></script>
@endsection
