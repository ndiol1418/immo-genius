<script>
     $(document).ready(function() {
        $('.supp').on("click",function(){
            let route = this.dataset.action;
            let en_promo_id = this.dataset.id;
            if (confirm("Voulez-vous vraiment supprimer ce produit ?")) {
                $.ajax({
                    type: "POST",
                    url: route,
                    data: {
                        id:en_promo_id
                    }
                }).done(function(rep){
                    console.log(rep);
                })
            }
        });
    });
</script>
