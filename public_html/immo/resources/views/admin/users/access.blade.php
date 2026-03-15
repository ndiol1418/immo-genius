@include('components.title-separe',[
    'title'=>__('Configuration des accès'),
    'class'=>'text-muted mb-2'
])
<div class="col-12">
    <div class="form-group row access">
        <div class="col-md-{{ isset($user) && $user->exists === true ? "6" : "12" }} ">
            {{-- <h4 class="text-muted h5"><span>{{ __('general.param_acces') }}</span></h4> --}}
        </div>
        @if (isset($user) && $user->exists === true)
            <div class="col-md-6 text-right">
                <button type="button" onclick="{{ $user->exists === true ? "enableDisableInput()" : "" }}" class="btn btn-xs btn-primary">
                    <i class="fa fa-{{ $user->exists === true ? "edit" : "" }}"></i> {{ $user->exists === true ? "" : "" }} Editer le mot de passe
                </button>
            </div>
        @endif
        <div class="form-group col-12 col-lg-6">
            <label for="email">{{ __('general.ad_mail') }} (*)</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ isset($user)?$user->email:'' }}" required autocomplete="email">
    
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group col-md-6">
            {{-- @if ($_user->is_admin) --}}
                {{-- <label for="service_id">{{ __('general.choix_profil') }}(*)</label>
                <select name="profil" class="form-control" @if ($user->profil == 'fournisseur') {{ 'disabled' }} @endif>
                    @foreach ($_profils as $profil)
                        <option value="{{ $profil->id }}">{{ $profil->name }}</option>
                    @endforeach
                </select> --}}
            {{-- @endif --}}
        </div>
    
        <div class="col-lg-6 col-12 password">
            <label for="password" class="col-form-label text-md-right">{{ __('general.passwd') }} (*)</label>
            <div class="input-group border" style="border-radius: 8px">
                <input data-toggle="popover" title="Mot de passe" data-placement="top" data-trigger="focus" data-content="Au moins 8 caractères, au moins 1 majuscule, au moins 1 minuscule, et au moins 1 caractère spécial." id="password" type="password" {{ isset($user) && $user->exists === true ? "disabled" : "" }}  class="pwd form-control @error('password') is-invalid @enderror" name="password" value="" required autocomplete="new-password">
                <span class="input-group-btn">
                    <button class="btn" type="button" id="showPassword"><i class="fas fa-eye-slash"></i></button>
                </span>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-lg-6 col-12 password">
            <label for="password-confirm" class="col-form-label text-md-right">{{ __('general.conf_passwd') }} (*)</label>
            <input data-toggle="popover" title="Mot de passe" data-placement="top" data-trigger="focus" data-content="Doit correspondre au mot de passe saisi et être valide aussi." id="password-confirm" {{ isset($user) && $user->exists === true ? "disabled" : "" }}  type="password" class="pwd form-control" name="password_confirmation" required  autocomplete="new-password">
        </div>
    
        <div class="col-md-12">
            <label class="form-check-label text-warning" >{{ __('general.champ_oblig') }}(*)</label>
        </div>
    </div>
</div>
@push('subScript')
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
@endpush
