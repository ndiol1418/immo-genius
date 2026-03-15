{{-- Floating comparison bar — included in main layout --}}
<div id="compareBar" style="
    display:none;
    position:fixed;
    bottom:0;left:0;right:0;
    background:#0d1c2e;
    color:#fff;
    z-index:99999;
    padding:10px 20px;
    box-shadow:0 -2px 10px rgba(0,0,0,0.3);
">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap" style="gap:10px;">
        <div class="d-flex align-items-center" style="gap:12px;">
            <span style="font-size:14px;font-weight:600;">
                ⚖️ Comparer <span id="compareCount">0</span> annonce(s)
            </span>
            <div id="compareSlots" class="d-flex" style="gap:8px;"></div>
        </div>
        <div class="d-flex" style="gap:8px;">
            <a id="comparerBtn" href="#" class="btn btn-sm" style="background:#27E3C0;color:#000;font-weight:600;border-radius:8px;">
                Comparer maintenant
            </a>
            <button onclick="clearCompare()" class="btn btn-sm btn-outline-light" style="border-radius:8px;">
                Tout effacer
            </button>
        </div>
    </div>
</div>

<script>
var compareIds = JSON.parse(localStorage.getItem('compareIds') || '[]');

function syncCompareBar() {
    compareIds = JSON.parse(localStorage.getItem('compareIds') || '[]');
    const bar = document.getElementById('compareBar');
    const count = document.getElementById('compareCount');
    const slots = document.getElementById('compareSlots');
    const btn = document.getElementById('comparerBtn');

    if (compareIds.length > 0) {
        bar.style.display = 'flex';
        count.textContent = compareIds.length;
        slots.innerHTML = compareIds.map(id =>
            `<span style="background:#1e3a5f;padding:3px 8px;border-radius:6px;font-size:12px;cursor:pointer;" onclick="removeCompare(${id})" title="Retirer">
                #${id} ✕
            </span>`
        ).join('');
        btn.href = '{{ route("comparer") }}?ids=' + compareIds.join(',');
    } else {
        bar.style.display = 'none';
    }
}

function toggleCompare(id, name, btn) {
    var idx = compareIds.indexOf(String(id));
    if (idx > -1) {
        compareIds.splice(idx, 1);
        if (btn) {
            btn.style.background = '#f8f9fa';
            btn.style.color = '#333';
            btn.title = 'Comparer';
        }
    } else {
        if (compareIds.length >= 3) {
            alert('Vous pouvez comparer au maximum 3 annonces.');
            return;
        }
        compareIds.push(String(id));
        if (btn) {
            btn.style.background = '#0d1c2e';
            btn.style.color = '#27E3C0';
            btn.title = 'Retirer de la comparaison';
        }
    }
    localStorage.setItem('compareIds', JSON.stringify(compareIds));
    syncCompareBar();
}

function removeCompare(id) {
    compareIds = compareIds.filter(x => x != String(id));
    localStorage.setItem('compareIds', JSON.stringify(compareIds));
    syncCompareBar();
    // Update any compare buttons on page
    document.querySelectorAll('[data-compare-id="' + id + '"]').forEach(btn => {
        btn.style.background = '#f8f9fa';
        btn.style.color = '#333';
    });
}

function clearCompare() {
    compareIds = [];
    localStorage.setItem('compareIds', JSON.stringify([]));
    syncCompareBar();
    document.querySelectorAll('[data-compare-btn]').forEach(btn => {
        btn.style.background = '#f8f9fa';
        btn.style.color = '#333';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    syncCompareBar();
    // Restore button states
    compareIds.forEach(id => {
        document.querySelectorAll('[data-compare-id="' + id + '"]').forEach(btn => {
            btn.style.background = '#0d1c2e';
            btn.style.color = '#27E3C0';
        });
    });
});
</script>
