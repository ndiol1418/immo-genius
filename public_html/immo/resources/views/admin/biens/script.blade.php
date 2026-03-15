@php
    $biens = $biens;
    $lng = -14.445;
    $lat = 14.499;
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
        var biens = @json($biens);
        const locations = [];
        const infos = [];
        biens.forEach(element => {
            if (element.lat != null && element.lon !=null && element.lat != 0 && element.lon !=0 ) {
                locations.push({ lat: parseFloat(element.lat), lng: parseFloat(element.lon) })
                infos.push({nom:element.name,adresse:element.adresse,montant:element.montant,commune:element.commune.name})
            }
        });
        $('.checkShop').click(function(){
            var title = $(this).data('nom')
            var adresse = $(this).data('adresse')
            var lon = $(this).data('lon');
            var lat = $(this).data('lat');
            var adresse = $(this).data('adresse');
            var montant = $(this).data('montant');
            var commune = $(this).data('commune');
            console.log(lon)
            placeMarkerAndPanTo({lat:lat,lng:lon},map);

            var infoWindow = new google.maps.InfoWindow();
            var windowLatLng = new google.maps.LatLng(lat,lon);
            infoWindow.setOptions({
                content: "<div>"+title+"</div><br><strong>Adresse: </strong>"+adresse+"<br><strong>Prix: </strong>"+montant+"<br><strong>commune: </strong>"+commune,
                position: windowLatLng,
            });
            infoWindow.open(map);
        });
        console.log('====================================');
        console.log('====================================');
        const markers = locations.map((position, i) => {
            // const label = infos[i % labels.length];
            const label = infos[i];
            console.log(label.montant);
            const pinGlyph = new google.maps.marker.PinElement({
                // glyph: label,
                glyphColor: "white",
                
            });
            // const image =   "../img/icon-total.png";
            const image =   "";
            const marker = new google.maps.Marker({
                position,
                content: pinGlyph.element,
                label: `${kConverter(label.montant)}`
                // icon: image
                // label: labels[i++ % labels.length],
            });

            // markers can only be keyboard focusable when they have click listeners
            // open info window when marker is clicked
            marker.addListener("click", () => {
                // infoWindow.setContent(position.lat + ", " + position.lng);
                console.log(infos);
                infoWindow.setContent("<div>"+infos[i].nom+"</div><br><strong>Adresse: </strong>"+infos[i].adresse+"<br><strong>Prix: </strong>"+infos[i].montant+"<br><strong>Commune: </strong>"+infos[i].commune)

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
    function kConverter(num) {
        return num <= 999 ? num : (0.1 * Math.floor(num / 100)).toFixed(1).replace('.0','') + 'k'
    }
</script>
