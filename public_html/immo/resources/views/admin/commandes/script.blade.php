<script>
    var data = [];
    var btn = document.getElementById('valider');
    btn.disabled = true;

    $('body').on('change','#fournisseur',function(){
        $('.card_produits').show()
        data = [];
        initListeTableau(0,'','listeProduits');

        var id = $(this).val();
        var produits = @json($produits);

        var array = produits.filter((item) =>  item.fournisseur_id == id );

        var view = '';
        //  view += '<input type="text" class="form-control form-control-sm mb-2" id="search" placeholder="rechercher...">';
        view +='<div class="bg-light p-2 row rounded"  style="height:calc(100vh - (342px));overflow:auto;"><form id="form" name="formulaire" class="col-12">';
        array.forEach(element => {
            var tva_vente = 0;
            if(element.tva_vente != null) {
                tva_vente=element.tva_vente;
            }
            //console.log(element.prix_ht);
            view+='<div class="row form"><div class="col-9 border-bottom mb-2 text-sm">'+element.designation+'</div>';
            view+='<div class="col-3 mb-2"><input type="number" name="qte" data-produit="'+element.designation+'" data-id="'+element.id+'" data-prix_ttc="'+element.prix_ttc+'" data-prix_ht="'+element.prix_ht+'" data-colisage="'+element.colisage+'" data-tva_vente="'+tva_vente+'" class="form-control form-control-sm" placeholder="qte"></div></div>';
        });
        view+='</form></div>';
        view+='<button type="button" class="form-control form-control-sm mt-2 btn btn-outline-danger" id="addProduits"> Ajouter</button>'
        $('#produits').html(view);
    })

    $('body').on('click','#addProduits',function(){
        data = [];
        var elements = document.forms["formulaire"].getElementsByTagName("input");
        var cpt = 0;

        for (i=0; i<elements.length; i++){
            if (elements[i].value > 0) {
                var produit = elements[i].getAttribute('data-produit');
                var id = elements[i].getAttribute('data-id');
                var colisage = elements[i].getAttribute('data-colisage');
                var prix_ttc = elements[i].getAttribute('data-prix_ttc');
                var tva_vente = elements[i].getAttribute('data-tva_vente');
                var prix_ht = elements[i].getAttribute('data-prix_ht');
                data.push({'qte':elements[i].value,'name':produit,'tva_vente':tva_vente,'id':id,'colisage':colisage,'prix_ttc':prix_ttc,'prix_ht':prix_ht});
                cpt++;
            }
        }
        formatageTableau(data,cpt);
        somme(data)
    });

    function formatageTableau(tableau,cpt=0) {
        var view = '<table class="table table-striped table-borderless table-sm mt-2">';
            view+= '<tr><td>Désignation</td><td>Colisage</td><td>Quantité</td><td>TVA</td><td>PU HT</td><td>Montant HT</td><td></td></tr>';
        tableau.forEach((item,index) => {

            view+='<tr id="ligne'+item.id+'"><td><input type="hidden" name="id[]" value='+item.id+'>'+item.name+'</td><td><input type="hidden" name="colisage[]" value='+item.colisage+'>'+item.colisage+'</td>'
                +'<td><input type="hidden" name="qte[]" value='+item.qte+'>'+item.qte+'</td><td><input type="hidden" name="tva_vente[]" value='+item.tva_vente+'>'+item.tva_vente+'</td><td><input type="hidden" name="prix_ht[]" value='+item.prix_ht+'>'+item.prix_ht+'</td>'
                +'<td><input type="hidden" name="montant_ht[]" value='+(item.qte*item.prix_ht)+'>'+(item.qte*item.prix_ht)+'</td><td><i class="text-danger fa fa-trash removeLine" style="cursor:pointer" data-rang="'+item.id+'" data-index="'+index+'" ></i></td></tr>';
        });
        view+='<tr class="font-weight-bold"><td class="bg-white"></td><td class="bg-white"></td><td class="bg-white"></td><td colspan="2" class="bg-light">Total HT</td><td class="bg-light c" colspan="2"><input name="total_ht" type="hidden" class="ht"><span class="ht"></span></td></tr>';
        view+='<tr class="font-weight-bold"><td class="bg-white"></td><td class="bg-white"></td><td class="bg-white"></td><td colspan="2" class="bg-light">TVA</td><td class="bg-light"  colspan="2" colspan="2"><input name="total_tva" type="hidden" class="tva"><span class="tva"></tr>';
        view+='<tr class="font-weight-bold"><td class="bg-white"></td><td class="bg-white"></td><td class="bg-white"></td><td colspan="2" class="bg-light">Total TTC</td><td class="bg-light" colspan="2" colspan="2"><input name="total_ttc" class="ttc" type="hidden"><span class="ttc"></td></tr>';
        view += '</table>';
        $('#listeProduits').html(view).fadeIn(3000);
        initListeTableau(cpt,view,'listeProduits');
    }

    function initListeTableau(cpt,view=null,id=null) {
        if (cpt == 0) {
            $('#'+id).html('');
            this.btn.disabled = true;
        }else{
            $('#'+id+'').html(view);
            this.btn.disabled = false;
        }
    }

    $('body').on('click','.removeLine',function() {
        let rang = $(this).data('rang');
        let index = $(this).data('index');
        removeProduit(rang,index);
    });

    function removeProduit(rang,index) {
        const tab = this.data;
        tab.splice(index,1);
        $('tr#ligne'+rang).remove();
        formatageTableau(tab,tab.length);
        if (tab.length == 0) {
            initListeTableau(0,'','listeProduits');
        }
        somme(tab)
    }

    function somme(array) {
        var total_tva = 0;
        var total_ht = 0;
        var total_ttc = 0;
        array.forEach(element => {
            var montant_ht =  element.prix_ht * element.qte;
            var montant_tva = (montant_ht * parseInt(element.tva_vente)/100);
            total_ht += parseInt(montant_ht);
            total_tva += parseInt(montant_tva);
        });

        total_ttc = total_ht + total_tva;

        $('.ht').html(total_ht);
        $('.ht').val(total_ht);
        $('.tva').html(total_tva);
        $('.tva').val(total_tva);
        $('.ttc').html(total_ttc);
        $('.ttc').val(total_ttc);

    }
</script>
