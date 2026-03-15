$('#observateurs').change(function(){
    route = this.dataset.action;
    validation_id = this.dataset.id;
    $.ajax({
        type: "PUT",
        url: route,
        data: {
            id:validation_id,
            observateurs:$(this).val()
        }
    }).done(function(rep){
       console.log(rep);
    })
});
