//Array Profils
var profils = data;
var roles = roles;
$('#plateforme_id').change(function(event){
    document.getElementById("addBtn").disabled = false;
    event.preventDefault();
    var key = $("#"+this.id+"").val();

    var selected_profils = profils.filter(function(item) {
        return item.plateforme_id == key;
    });
    //Creation du select
    createSelect(selected_profils);
});

function createSelect(items) {
    var view='';
    if(items.length > 0) {
        for (var i in items) {
            const element = items[i];
            view+='<option value="'+element.id+'" >'+element.name+'</option>';

            }
        } else {
        view+='<option name="profil_id" selected>Aucun profil disponible</option>'
        document.getElementById("addBtn").disabled = true;
    }
    $("#profil").html(view);
}
