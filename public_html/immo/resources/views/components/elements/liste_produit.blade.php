<h6>Renseignez les quantités des produits à commander</h6>
<div class="bg-light p-2 row rounded"  style="max-height: 430px;overflow:auto;">
    <form method="POST" action="{{ route('commandes.update', $commande->id) }}"  class="col-12">
        @csrf
        @foreach ($produits as $i => $produit)
            <div class="row">
                <div class="col-10 border-bottom mb-2 text-sm">{{ $produit->designation }}</div>
                <div class="col-2 mb-2">
                    <input type="number" name="qte[]" value="{{ $produit->quantite }}" class="form-control form-control-sm" placeholder="qte">
                    <input type="hidden" name="id[]" value="{{ $produit->id }}" class="form-control form-control-sm" >
                </div>
            </div>
        @endforeach
        <button type="submit" class="form-control form-control-sm mt-2" id="addProduits"> Ajouter</button>
    </form>
</div>

