@php
    $stations = $stations;
    $lng = isset($_user)?($_user->compte->lon??-14.445):'';
    $lat = isset($_user)?($_user->compte->lat??14.499):'';
@endphp
<script>
    // Initialize and add the map
    let map;

    async function initMap() {
        // The location of Uluru
        const position = { lat: parseFloat(@json($lat)), lng: parseFloat(@json($lng)) };
        // console.log(position);
        const { Map, InfoWindow } = await google.maps.importLibrary("maps");
        const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary(
            "marker",
        );
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 7,
            center: position,
            mapId: "map",
        });
        const infoWindow = new google.maps.InfoWindow({
            content: "",
            disableAutoPan: true,
        });
        // Create an array of alphabetical characters used to label the markers.
        const labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        // The marker, positioned at Uluru
        var stations = @json($stations);
        const locations = [];
        const infos = [];
        stations.forEach(element => {
            if (element.lat != null && element.lon !=null && element.lat != 0 && element.lon !=0 ) {
                locations.push({ lat: parseFloat(element.lat), lng: parseFloat(element.lon) })
                infos.push({nom:element.nom,adresse:element.adresse,telephone:element.telephone,email:element.user.email})
            }
        });
        $('.checkShop').click(function(){
            var title = $(this).data('nom')
            var adresse = $(this).data('adresse')
            var lon = $(this).data('lon');
            var lat = $(this).data('lat');
            var email = $(this).data('email');
            var telephone = $(this).data('telephone');

            placeMarkerAndPanTo({lat:lat,lng:lon},map);

            var infoWindow = new google.maps.InfoWindow();
            var windowLatLng = new google.maps.LatLng(lat,lon);
            infoWindow.setOptions({
                content: "<div>"+title+"</div><br><strong>Adresse: </strong>"+adresse+"<br><strong>Téléphone: </strong>"+telephone+"<br><strong>Email: </strong>"+email,
                position: windowLatLng,
            });
            infoWindow.open(map);
        });
        console.log('====================================');
        console.log('====================================');
        const markers = locations.map((position, i) => {
            // const label = infos[i % labels.length];
            // const label = infos[i];
            const pinGlyph = new google.maps.marker.PinElement({
                // glyph: label,
                glyphColor: "white",
            });
            const image =   "../img/icon-total.png";
            const marker = new google.maps.Marker({
                position,
                content: pinGlyph.element,
                // icon: image
            });

            // markers can only be keyboard focusable when they have click listeners
            // open info window when marker is clicked
            marker.addListener("click", () => {
                // infoWindow.setContent(position.lat + ", " + position.lng);
                infoWindow.setContent("<div>"+infos[i].nom+"</div><br><strong>Adresse: </strong>"+infos[i].adresse+"<br><strong>Téléphone: </strong>"+infos[i].telephone+"<br><strong>Email: </strong>"+infos[i].email)

                infoWindow.open(map, marker);
            },toggleBounce);
            return marker;
        });

        // Add a marker clusterer to manage the markers.
        const markerCluster = new markerClusterer.MarkerClusterer({ markers, map });
    }
    function placeMarkerAndPanTo(latLng, map) {
        const image =   "../img/icon-total.png";
        new google.maps.Marker({
        // new google.maps.marker.AdvancedMarkerElement({
            position: latLng,
            map: map,
            // icon: image
        });
        map.panTo(latLng);
    }
    function toggleBounce() {
        if (marker.getAnimation() !== null) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }
        initMap();
</script>
