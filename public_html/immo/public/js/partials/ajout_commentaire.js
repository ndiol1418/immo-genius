$("#commentaire").on("focusout", function(){
    route = this.dataset.action;
    $.ajax({
        type: "PUT",
        url: route,
        data: {
            commentaire:$(this).val()
        }
    }).done(function(rep){
       console.log(rep);
      //window.location.reload()
    })
});
