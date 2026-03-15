$(document).ready(function() {
    var app = <?php echo json_encode($_departements); ?>;
    console.log(app)
    var data = <?= $_departements ?>;
    var services = <?= $_services?>;
    $('#direction_id').change(function(event){

        event.preventDefault();
        var val = $("#direction_id").val();
        var tab=[];
        var view='<label class="col-form-label text-md-right">Département</label> <select class="form-control" id="departement_id" name="departement_id"> ';
        view+='<option name="departement_id" >Choisissez le département</option>'
        for(i in data){
            if(data[i]["direction_id"] == val){
                console.log(data[i]["direction_id"] )
                tab['name']=data[i]["name"];
                tab['id']=data[i]["id"];
                view+='<option name="direction_id" value="'+tab['id']+'" >'+tab['name']+'</option>'
            }

            //view+='<label><img src="img/'+tab['image_model']+'"></label><br>'
        }
        view+='</select>';
        jQuery("#listedepartement").html(view);
    });


    $('#departement_id').change(function(event){
        alert('test')
        event.preventDefault();
        var val = $("#departement_id").val();
        var tab=[];
        var view='<label class="col-form-label text-md-right">Département</label> <select class="form-control" name="service_id"> ';
        view+='<option name="service_id" >Choisissez le service</option>'
        for(i in services){
            if(services[i]["departement_id"] == val){
                console.log(services[i]["departement_id"] )
                tab['name']=services[i]["name"];
                tab['id']=services[i]["id"];
                view+='<option name="departement_id" value="'+tab['id']+'" >'+tab['name']+'</option>'
            }

            //view+='<label><img src="img/'+tab['image_model']+'"></label><br>'
        }
        view+='</select>';
        jQuery("#listeservice").html(view);
    });
} );
