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
