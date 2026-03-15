<style>
    /* Styling plan creation */
#yourBtn {
    padding: 10px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border: 1px solid #dcdfe3;
    text-align: center;
    background-color: #f2f4f6;
    cursor: pointer;
    color: #00884a;
}
.remove{
    position: absolute;
    right: 14px;
    margin-top: -38px;
    background: #fff;
    padding: 10px;
    border-radius: 3px;
}
.iconFile{
    cursor: pointer;
    position: absolute;
    left: 20px;
    top: 16px;
}
</style>
@if (!isset($submit))
    <label for="">Documents</label>
@endif
@isset($plan->documents)
    @foreach ($plan->documents as $k => $document)
        {{-- <div class="row justify-content-between mb-2">
            <div class="col">
                <a href="{{ asset($document->name) }}" data-fancybox="{{ $document->name }}" data-caption="{{ $document->name }}" class="download-file btn btn-warning">
                    <i class="fas fa-file-pdf text-white"></i>
                </a>
            </div>
            <div class="col text-right">
                @include('partials.components.deleteBtnElement',[
                    'url'=>route('collaborateur.documents.destroy',$document->id),
                    'message_confirmation'=>'Voulez-vous supprimer le fichier : ' .$document->name,
                    'btnInnerHTML'=> 'DOC-PDA-00'.$document->id.' <i class="fa fa-times-circle fas-2X text-danger"></i>',
                    'class'=>'btn btn-light btn-sm shadow-sm',
                    'entity'=>$document,
                    'link'=>true
                ])
            </div>
        </div> --}}
    @endforeach
@endisset
<div class="card-body" style="border: 3px dotted #00884a;border-radius: 10px !important;">
    <div class="row jusctify-content-center">
        <div class="{{ $col??'col-lg-12 col-12 ' }} text-center">
            <iconify-icon icon="material-symbols:upload-rounded" style="color: #00884a;background: #e1f1e9;border-radius: 4px;padding: 5px;" width="30" height="30"></iconify-icon>
            <p class="mt-2 {{ isset($submit)?'d-none':'' }}">Choisir les fichiers à déposer</p>
        </div>

        <div class="{{ $col2??' col-lg-12 col-12 ' }} text-center">

            <div class="cloned" style="position: relative">
                <div id="yourBtn" onclick="getFile()">Choisir un fichier</div>
                <div style='height: 0px;width: 0px; overflow:hidden;'>
                    <span>
                        <i class="fa fa-file text-primary iconFile" style="cursor:pointer"></i>
                    </span>
                    <input id="upfile" type="file" value="upload" name="{{ isset($name)?$name:'files[]' }}" onchange="sub(this)" />
                </div>
            </div>
            <div class="newFiles">
                <div class="fileName"></div>
            </div>
            @if (!isset($submit))
                <a class="btn btn-primary clone add-row mt-2">Ajouter un fichier</a>
            @endif
        </div>
        @if (isset($submit))
            <div class="{{ $col??' col-lg-12 col-12 ' }} text-center">
                <button class="btn-primary btn" style="height: 42px">Valider</button>
            </div>
        @endif
    </div>
</div>
@push('subScript')
    <script>
        function getFile() {
            document.getElementById("upfile").click();
        }
        $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name+'<br>';
            $('.fileName').append(fileName);
            cpt++;
        });
    </script>
@endpush