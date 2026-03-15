
<div class="form-group row">
    <div class="col-md-4  jumbotron">
        <div class="row justify-content-md-center">
            <div class="col-12 profil">

                <div class="profil_image">
                    <img src="{{ old('photo') ?? isset($user->photo) ? asset($user->photo) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/57/OOjs_UI_icon_userAvatar-progressive.svg/1024px-OOjs_UI_icon_userAvatar-progressive.svg.png' }}"
                    alt=""  id="img-logo"  class="rounded mx-auto d-block photo"/>

                </div>
                {{-- <label for="image-upload"><i class="fa fa-edit fa-pull-right text-primary"></i></label>
                <input type="file" name="image" id="image-upload" /> --}}
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
    <div class="col-md-8 pl-4">
        <div class="form-group  row">
            <div class="col-md-6">
                <label for="prenom" class="col-form-label text-md-right">{{ __('Prenom') }}(*)</label>
                <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="collaborateur[prenom]" value="{{ old('prenom') ?? $user->collaborateur?$user->collaborateur->prenom:'' }}" required autocomplete="Nom">

                @error('prenom')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="nom" class="col-form-label text-md-right">{{ __('Nom') }}(*)</label>
                <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="collaborateur[nom]" value="{{ old('prenom') ?? $user->collaborateur?$user->collaborateur->nom:'' }}" required autocomplete="Nom">

                @error('nom')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="telephone" class="col-form-label text-md-right">{{ __('general.telephone') }}(*)</label>
                <input id="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror" name="collaborateur[telephone]" value="{{ old('telephone') ?? $user->collaborateur?$user->collaborateur->telephone:'' }}" autocomplete="telephone" autofocus>

                @error('telephone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- <div class="col-md-6">
                <label for="matricule" class="col-form-label text-md-right">{{ __('Matricule (*)') }}</label>
                <input id="matricule" type="text" class="form-control @error('matricule') is-invalid @enderror" name="matricule" value="{{ old('matricule') ?? $user->matricule }}" required autocomplete="matricule">

                @error('matricule')
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
            </div> --}}

        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="photo" class="col-form-label text-md-right">Photo</label>
                <input type="file" name="images[0][file]" data-rang="0" id="piece_file0" accept="image/png, image/gif, image/jpeg" name="" class="" id="">
            </div>
        </div>

        @include('admin.users.access')
    </div>
</div>

