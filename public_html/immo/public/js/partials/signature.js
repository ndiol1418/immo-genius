
var canvas = document.getElementById('signature-pad');
// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
  // When zoomed out to less than 100%, for some very strange reason,
  // some browsers report devicePixelRatio as less than 1
  // and only part of the canvas is cleared then.
  var ratio = 1;// Math.max(window.devicePixelRatio || 1, 1);
  canvas.width = canvas.offsetWidth * ratio;
  canvas.height = canvas.offsetHeight * ratio;
}

// window.onresize = resizeCanvas;
// resizeCanvas();

var signaturePad = new SignaturePad(canvas, {
  backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
});

$("#sign_modal").on('shown.bs.modal',function(){
  window.onresize = resizeCanvas;
  resizeCanvas();
})

document.getElementById('save-png').addEventListener('click', function () {

    var signature = null;
    if(document.getElementById('signS').checked){
        signature = document.getElementById('signS').value;
    }else if( document.getElementById('signP').checked){
        signature = document.getElementById('signP').value;
    }

    if (signaturePad.isEmpty()) {
        return alert("Veuillez d’abord fournir une signature ou un paraphe.");
    }
    if(signature === null){
        return alert("Veuillez d'abord choisir une signature ou un paraphe");
    }
    var data = signaturePad.toDataURL('image/png');
    route = this.dataset.action;
    $.ajax({
        type: "PUT",
        url: route,
        data: {
        base64Img: data,
        sign: signature
        }
    }).done(function(rep){
       console.log(rep);
       window.location.reload()
    })
   // console.log(data);
 // window.open(data);
});

document.getElementById('clear').addEventListener('click', function () {
  signaturePad.clear();
});

document.getElementById('undo').addEventListener('click', function () {
	var data = signaturePad.toData();
  if (data) {
    data.pop(); // remove the last dot or line
    signaturePad.fromData(data);
  }
});
