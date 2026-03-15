<div class="row">
    <div class="card mt-4">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h2>Photos et Multimédias</h2>
                    <label class="upload-box w-100" for="imageInput">
                        <div class="plus">+</div>
                        <p>Vous pouvez ajouter jusqu’à 15 photos à votre annonce</p>
                    </label>
                    <input type="file" name="images[]" id="imageInput" accept="image/*" multiple>
                    <div class="preview-container d-none" id="previewContainer2"></div>
                   
                </div>
                <div class="col-12 col-lg-4">
                    <div class="input-container">
                        <input type="text" id="url_video" value="{{ $annonce?$annonce->url_video:'' }}" class="form-control form-control-sm @error('url_video') is-invalid @enderror" name="url_video" placeholder=" ">
                        <label for="url_video">Lien Url (Youtude,Vime0) (*)</label>
                    </div>
                    @error('url_video')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-12 col-lg-4">
                    <div class="input-container">
                        <input type="text" id="visite_virtuelle" value="{{ $annonce?$annonce->visite_virtuelle:'' }}" class="form-control form-control-sm @error('visite_virtuelle') is-invalid @enderror" name="visite_virtuelle" placeholder=" ">
                        <label for="visite_virtuelle">Lien Url </label>
                    </div>
                    @error('visite_virtuelle')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
@push('subScript')
    <script>

        $(document).ready(function () {
            $('.btn-delete-image').on('click', function () {
                const imageId = $(this).data('id');
                const token = $('meta[name="csrf-token"]').attr('content');
                const url = $(this).data('url')
                console.log(url);
                if (confirm('Voulez-vous vraiment supprimer cette image ?')) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                        _token: token
                        },
                        success: function (response) {
                            alert("Operation reussie.");
                        if (response.success) {

                            $('#image-' + imageId).remove();
                        }
                        },
                        error: function () {
                        alert("Une erreur s'est produite.");
                        }
                    });
                }
            });
        });
    </script>
@endpush