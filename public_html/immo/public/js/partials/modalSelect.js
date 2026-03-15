 $('.select').change(function(event){
    var id = (this.id);
    var val = $("#"+this.id+"").val();
    if(id == 'departement_id'){
        if(val !== 0){
            //$('.direction_id').hide('slow')
            document.getElementById("direction_id").disabled = true;
        }
        if(val == 0){
            //$('.direction_id').toggle('slow');
            document.getElementById("direction_id").disabled = false;
        }
    }
    if(id == 'direction_id'){
        if(val !== 0){
            //$('.departement_id').hide('slow')
            document.getElementById("departement_id").disabled = true;
        }
        if(val == 0){
            //$('.departement_id').toggle('slow');
            document.getElementById("departement_id").disabled = false;

        }
    }
});
//Modal Edition
$(".edit_btn_modal").click(function() {
    data = this.value.split('+');
    $name = "direction_name";
    console.log(data[4]);
    $("#id").val(data[0]);
    $("#direction_name").val(data[1]);
    var poste_id =data[4];
   // document.getElementById("poste_id").value = data[4];

   $('#poste_id').find('option[value="'+ poste_id +'"]').attr("selected",true);
   $('#poste_id').change();

    var url = $(this).data('url');
    var form = document.getElementById('form');
    form.action = url;
    var val = data[2]
    if(val == 0){
        $('#option option[value=0]').attr('selected','selected');
    }
    else{
        $('#option option[value=1]').attr('selected','selected');
    }



});



function enableDisableInput(){
    var x = document.getElementById("password");
    if (x.disabled === false) {
        x.disabled = true;
        // x.type = "text";
        console.log(x);
        document.getElementById("password-confirm").disabled = true;
    } else {
        x.disabled = false;
        // x.type = "password";
        document.getElementById("password-confirm").disabled = false;
    }
}
// Generer random matricule
$('#generate').click(function(event){
    if(this.checked){
        $('.password').hide();
        generateMatricule(8);
    }
    else{
        $('.password').show();

    }
});
function generateMatricule(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
       result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    result = 'TSN@'+result;
    var id = document.getElementById('password');
    var id_confirm = document.getElementById('password-confirm');
    id.value = result;
    id_confirm.value = result;
    if(id.type === 'password'){
        $('.password').hide()
    }
 }
