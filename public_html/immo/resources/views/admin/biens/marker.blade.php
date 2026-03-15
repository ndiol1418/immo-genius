@php
    $lng = $station->lon;
    $lat = $station->lat;
@endphp
<script>
    // Initialize and add the map
    let map;

    async function initMap() {
    // The location of Uluru
    const position = { lat: parseFloat(@json($station->lat)), lng: parseFloat(@json($station->lon)) };
    var infos = @json($station);
    // Request needed libraries.
    //@ts-ignore
    const { Map, InfoWindow } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
    const infoWindow = new google.maps.InfoWindow({
            content: "",
            disableAutoPan: true,
        });
    // The map, centered at Uluru
    map = new Map(document.getElementById("map"), {
        zoom: 9,
        center: position,
        mapId: "map",
    });

    // The marker, positioned at Uluru
    const image =   "../img/icon-total.png";
    const marker = new AdvancedMarkerElement({
        map: map,
        position: position,
        title: "Uluru",
    });
        // open info window when marker is clicked
    marker.addListener("click", () => {
        // infoWindow.setContent(position.lat + ", " + position.lng);
        infoWindow.setContent("<div>"+infos.nom+"</div><br><strong>Adresse: </strong>"+infos.adresse+"<br><strong>Téléphone: </strong>"+infos.telephone+"<br><strong>Email: </strong>"+infos.email)

        infoWindow.open(map, marker);
    });
    return marker;
}

initMap();
</script>
