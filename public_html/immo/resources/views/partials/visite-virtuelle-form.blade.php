<div class="col-12 mt-4">
    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24" style="color:#2E7D32"><g fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10.55 2.876L4.595 6.182a2.98 2.98 0 0 0-1.529 2.611v6.414a2.98 2.98 0 0 0 1.529 2.61l5.957 3.307a2.98 2.98 0 0 0 2.898 0l5.957-3.306a2.98 2.98 0 0 0 1.529-2.611V8.793a2.98 2.98 0 0 0-1.529-2.61L13.45 2.876a2.98 2.98 0 0 0-2.898 0Z"/><path d="M20.33 6.996L12 12L3.67 6.996M12 21.49V12"/></g></svg>
                Visite Virtuelle
            </h5>

            {{-- Toggle type --}}
            <div class="btn-group mb-3" role="group">
                <input type="radio" class="btn-check" name="visite_virtuelle_type" id="vv_none"
                       value="none" autocomplete="off" checked>
                <label class="btn btn-outline-secondary btn-sm" for="vv_none">Aucune</label>

                <input type="radio" class="btn-check" name="visite_virtuelle_type" id="vv_pannellum"
                       value="pannellum" autocomplete="off">
                <label class="btn btn-outline-secondary btn-sm" for="vv_pannellum">Photos 360°</label>

                <input type="radio" class="btn-check" name="visite_virtuelle_type" id="vv_matterport"
                       value="matterport" autocomplete="off">
                <label class="btn btn-outline-secondary btn-sm" for="vv_matterport">Matterport 3D</label>
            </div>

            {{-- Section Photos 360° --}}
            <div id="section_pannellum" class="d-none">
                <p class="text-sm text-muted mb-2">
                    Uploadez jusqu'à 10 photos équirectangulaires (360°). Chaque photo correspond à une pièce.
                </p>
                <input type="file" name="visite_360_images[]" id="visite360Input"
                       class="form-control form-control-sm"
                       accept=".jpg,.jpeg,.png"
                       multiple>
                <div id="preview360" class="d-flex flex-wrap gap-2 mt-2"></div>
                <small class="text-muted">Formats acceptés : JPG, JPEG, PNG — Max 10 photos</small>
            </div>

            {{-- Section Matterport --}}
            <div id="section_matterport" class="d-none">
                <label class="col-form-label">URL Matterport</label>
                <input type="text" name="matterport_url" id="matterport_url"
                       class="form-control form-control-sm"
                       placeholder="https://my.matterport.com/show/?m=XXXXX">
                <small class="text-muted">
                    Collez l'URL de votre scan Matterport (ex: https://my.matterport.com/show/?m=XXXXX)
                </small>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    const radios = document.querySelectorAll('input[name="visite_virtuelle_type"]');
    const sectionPannellum  = document.getElementById('section_pannellum');
    const sectionMatterport = document.getElementById('section_matterport');

    function toggleSections() {
        const val = document.querySelector('input[name="visite_virtuelle_type"]:checked')?.value;
        sectionPannellum.classList.toggle('d-none',  val !== 'pannellum');
        sectionMatterport.classList.toggle('d-none', val !== 'matterport');
    }

    radios.forEach(r => r.addEventListener('change', toggleSections));

    // Aperçu des photos 360°
    const input360   = document.getElementById('visite360Input');
    const preview360 = document.getElementById('preview360');

    if (input360) {
        input360.addEventListener('change', function () {
            preview360.innerHTML = '';
            const files = Array.from(this.files).slice(0, 10);
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.cssText = 'width:80px;height:60px;object-fit:cover;border-radius:6px;border:1px solid #ddd;';
                    preview360.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    }
})();
</script>
