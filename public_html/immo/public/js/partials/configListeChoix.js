var plateforme = data;
document.getElementById("ref").disabled = true;

$('#type_field_id').change(function(event){
    // document.getElementById("addBtn").disabled = false;
    event.preventDefault();
    const array = ["3", "4", "5"];
    var key = $("#"+this.id+"").val();
    var element = array.includes(key);
    if(element){
        document.getElementById("ref").disabled = false;
        document.getElementById("choices").disabled = false;
    }else{
        document.getElementById("ref").value = null;
        document.getElementById("ref").disabled = true;
        document.getElementById("choices").disabled = true;

    }
});
$('#typeModal').change(function(event){
    // document.getElementById("addBtn").disabled = false;
    event.preventDefault();
    const array = ["3", "4", "5"];
    var key = $("#"+this.id+"").val();
    var element = array.includes(key);
    if(element){
        document.getElementById("refModal").disabled = false;
        document.getElementById("choicesModal").disabled = false;
    }else{
        document.getElementById("refModal").value = null;
        document.getElementById("refModal").disabled = true;
        document.getElementById("choicesModal").disabled = true;

    }
});
$('#ref').on("blur focus" ,function(event){
    event.preventDefault();
    var type = event.type;
    if(type === "blur"){
        if($(this).val() == plateforme['api']){
            $(this).val('');
        }
    }
    if(type == 'focus'){
        if($(this).val() == ''){
            $(this).val(plateforme['api']);
        }
    }
});
$('#refModal').on("blur focus" ,function(event){
    event.preventDefault();
    var type = event.type;
    if(type === "blur"){
        if($(this).val() == plateforme['api']){
            $(this).val('');
        }
    }
    if(type == 'focus'){
        if($(this).val() == ''){
            $(this).val(plateforme['api']);
        }
    }
});
