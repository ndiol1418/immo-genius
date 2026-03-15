//Les champs avec select2
$('.select2').select2();

$(window).on('load', function() {
    setTimeout(removeLoader, 100); //wait for page load 1/2s
});

function removeLoader() {
    $(document).ready(function() {

        $("#loadingDiv").fadeOut(500, function() {
            // fadeOut complete. Remove the loading div
            $("#loadingDiv").remove(); //makes page more lightweight
            $("#dynamic-content").removeClass("d-none"); //makes page more lightweight
        });
    })
}