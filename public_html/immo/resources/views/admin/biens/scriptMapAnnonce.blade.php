<style>
    .gm-style .gm-style-iw-c{
        width: 180px !important;
        box-shadow: none !important;
    }
    .img_map{
        width:100%;height:100px;object-fit:cover;margin-bottom:10px;border-radius: 10px;
    }
</style>
@php
    $annonces = $annonces;
    $lng = -14.445;
    $lat = 14.499;
@endphp

<script>

    // Initialize and add the map
    let map;
      
    async function initMap() {
        // initAutocomplete();

        // The location of Uluru
        const position = { lat: parseFloat(@json($lat)), lng: parseFloat(@json($lng)) };
        // console.log(position);
        // const { Map, InfoWindow } = await google.maps.importLibrary("maps");
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
        var annonces = @json($annonces);
        console.log(annonces);
        const locations = [];
        const infos = [];
        annonces.forEach(element => {
            var item = element.immo.bien;
            // if (item.lat != null && item.lon !=null && item.lat != 0 && item.lon !=0 ) {
                if (element.immo.bien) {   
                    var url = '' 
                    if(element.images.lenght > 0) {
                        console.log(element.images);
                        url = element.images[0].url          
                    } 
                    console.log((element))
                    locations.push({ lat: parseInt(item.lat), lng: parseInt(item.lon) })
                    infos.push({nom:element.name,adresse:item.adresse,montant:element.immo.montant,bien:item.name,image:url})
                }
            // }
        });
        $('.checkShop').click(function(){
            var title = $(this).data('nom')
            var adresse = $(this).data('adresse')
            var lon = $(this).data('lon');
            var lat = $(this).data('lat');
            var adresse = $(this).data('adresse');
            var montant = $(this).data('montant');
            var image = $(this).data('image');
            console.log(lon)
            placeMarkerAndPanTo({lat:lat,lng:lon},map);

            var infoWindow = new google.maps.InfoWindow();
            var windowLatLng = new google.maps.LatLng(lat,lon);
            var locate = '<svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M6.72 16.64a1 1 0 1 1 .56 1.92c-.5.146-.86.3-1.091.44c.238.143.614.303 1.136.452C8.48 19.782 10.133 20 12 20s3.52-.218 4.675-.548c.523-.149.898-.309 1.136-.452c-.23-.14-.59-.294-1.09-.44a1 1 0 0 1 .559-1.92c.668.195 1.28.445 1.75.766c.435.299.97.82.97 1.594c0 .783-.548 1.308-.99 1.607c-.478.322-1.103.573-1.786.768C15.846 21.77 14 22 12 22s-3.846-.23-5.224-.625c-.683-.195-1.308-.446-1.786-.768c-.442-.3-.99-.824-.99-1.607c0-.774.535-1.295.97-1.594c.47-.321 1.082-.571 1.75-.766M12 7.5c-1.54 0-2.502 1.667-1.732 3c.357.619 1.017 1 1.732 1c1.54 0 2.502-1.667 1.732-3A2 2 0 0 0 12 7.5" class="duoicon-primary-layer"/><path fill="currentColor" d="M12 2a7.5 7.5 0 0 1 7.5 7.5c0 2.568-1.4 4.656-2.85 6.14a16.4 16.4 0 0 1-1.853 1.615c-.594.446-1.952 1.282-1.952 1.282a1.71 1.71 0 0 1-1.69 0a21 21 0 0 1-1.952-1.282A16.4 16.4 0 0 1 7.35 15.64C5.9 14.156 4.5 12.068 4.5 9.5A7.5 7.5 0 0 1 12 2" class="duoicon-secondary-layer" opacity="0.3"/></svg>';
            var money ='<svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 48 48"><g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M28.772 24.667A4 4 0 0 0 25 22v-1h-2v1a4 4 0 1 0 0 8v4c-.87 0-1.611-.555-1.887-1.333a1 1 0 1 0-1.885.666A4 4 0 0 0 23 36v1h2v-1a4 4 0 0 0 0-8v-4a2 2 0 0 1 1.886 1.333a1 1 0 1 0 1.886-.666M23 24a2 2 0 1 0 0 4zm2 10a2 2 0 1 0 0-4z"/><path d="M13.153 8.621C15.607 7.42 19.633 6 24.039 6c4.314 0 8.234 1.361 10.675 2.546l.138.067c.736.364 1.33.708 1.748.987L32.906 15C41.422 23.706 48 41.997 24.039 41.997S6.479 24.038 15.069 15l-3.67-5.4c.283-.185.642-.4 1.07-.628q.318-.171.684-.35m17.379 6.307l2.957-4.323c-2.75.198-6.022.844-9.172 1.756c-2.25.65-4.75.551-7.065.124a25 25 0 0 1-1.737-.386l1.92 2.827c4.115 1.465 8.981 1.465 13.097.002M16.28 16.63c4.815 1.86 10.602 1.86 15.417-.002a29.3 29.3 0 0 1 4.988 7.143c1.352 2.758 2.088 5.515 1.968 7.891c-.116 2.293-1.018 4.252-3.078 5.708c-2.147 1.517-5.758 2.627-11.537 2.627c-5.785 0-9.413-1.091-11.58-2.591c-2.075-1.437-2.986-3.37-3.115-5.632c-.135-2.35.585-5.093 1.932-7.87c1.285-2.648 3.078-5.197 5.005-7.274m-1.15-6.714c.8.238 1.636.445 2.484.602c2.15.396 4.306.454 6.146-.079a54 54 0 0 1 6.53-1.471C28.45 8.414 26.298 8 24.038 8c-3.445 0-6.658.961-8.908 1.916"/></g></svg>'

            infoWindow.setOptions({
                content: "<img src="+image+" class='img_map'><div>"+title+"</div><strong>"+locate+" </strong>"+adresse+"<br><strong>"+money+" </strong>"+montant,
                position: windowLatLng,
            });
            infoWindow.open(map);
        });
        console.log('====================================');
        console.log('====================================');
        const markers = locations.map((position, i) => {
            // const label = infos[i % labels.length];
            const label = infos[i];
            const pinGlyph = new google.maps.marker.PinElement({
                // glyph: label,
                glyphColor: "white",
            });
            // const image =   "../img/icon-total.png";
            const image =   "";
            const marker = new google.maps.Marker({
                position,
                content: pinGlyph.element,
                label: `${kConverter(label.montant)}`,
                icon: image
            });

            // markers can only be keyboard focusable when they have click listeners
            // open info window when marker is clicked
            marker.addListener("click", () => {
                // infoWindow.setContent(position.lat + ", " + position.lng);
                var locate = '<svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M6.72 16.64a1 1 0 1 1 .56 1.92c-.5.146-.86.3-1.091.44c.238.143.614.303 1.136.452C8.48 19.782 10.133 20 12 20s3.52-.218 4.675-.548c.523-.149.898-.309 1.136-.452c-.23-.14-.59-.294-1.09-.44a1 1 0 0 1 .559-1.92c.668.195 1.28.445 1.75.766c.435.299.97.82.97 1.594c0 .783-.548 1.308-.99 1.607c-.478.322-1.103.573-1.786.768C15.846 21.77 14 22 12 22s-3.846-.23-5.224-.625c-.683-.195-1.308-.446-1.786-.768c-.442-.3-.99-.824-.99-1.607c0-.774.535-1.295.97-1.594c.47-.321 1.082-.571 1.75-.766M12 7.5c-1.54 0-2.502 1.667-1.732 3c.357.619 1.017 1 1.732 1c1.54 0 2.502-1.667 1.732-3A2 2 0 0 0 12 7.5" class="duoicon-primary-layer"/><path fill="currentColor" d="M12 2a7.5 7.5 0 0 1 7.5 7.5c0 2.568-1.4 4.656-2.85 6.14a16.4 16.4 0 0 1-1.853 1.615c-.594.446-1.952 1.282-1.952 1.282a1.71 1.71 0 0 1-1.69 0a21 21 0 0 1-1.952-1.282A16.4 16.4 0 0 1 7.35 15.64C5.9 14.156 4.5 12.068 4.5 9.5A7.5 7.5 0 0 1 12 2" class="duoicon-secondary-layer" opacity="0.3"/></svg>';
                var money ='<svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 48 48"><g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M28.772 24.667A4 4 0 0 0 25 22v-1h-2v1a4 4 0 1 0 0 8v4c-.87 0-1.611-.555-1.887-1.333a1 1 0 1 0-1.885.666A4 4 0 0 0 23 36v1h2v-1a4 4 0 0 0 0-8v-4a2 2 0 0 1 1.886 1.333a1 1 0 1 0 1.886-.666M23 24a2 2 0 1 0 0 4zm2 10a2 2 0 1 0 0-4z"/><path d="M13.153 8.621C15.607 7.42 19.633 6 24.039 6c4.314 0 8.234 1.361 10.675 2.546l.138.067c.736.364 1.33.708 1.748.987L32.906 15C41.422 23.706 48 41.997 24.039 41.997S6.479 24.038 15.069 15l-3.67-5.4c.283-.185.642-.4 1.07-.628q.318-.171.684-.35m17.379 6.307l2.957-4.323c-2.75.198-6.022.844-9.172 1.756c-2.25.65-4.75.551-7.065.124a25 25 0 0 1-1.737-.386l1.92 2.827c4.115 1.465 8.981 1.465 13.097.002M16.28 16.63c4.815 1.86 10.602 1.86 15.417-.002a29.3 29.3 0 0 1 4.988 7.143c1.352 2.758 2.088 5.515 1.968 7.891c-.116 2.293-1.018 4.252-3.078 5.708c-2.147 1.517-5.758 2.627-11.537 2.627c-5.785 0-9.413-1.091-11.58-2.591c-2.075-1.437-2.986-3.37-3.115-5.632c-.135-2.35.585-5.093 1.932-7.87c1.285-2.648 3.078-5.197 5.005-7.274m-1.15-6.714c.8.238 1.636.445 2.484.602c2.15.396 4.306.454 6.146-.079a54 54 0 0 1 6.53-1.471C28.45 8.414 26.298 8 24.038 8c-3.445 0-6.658.961-8.908 1.916"/></g></svg>'
                infoWindow.setContent("<img src="+infos[i].image+" class='img_map'><div>"+infos[i].nom+"</div><strong>"+locate+" </strong>"+infos[i].adresse+"<br><strong>"+money+" </strong>"+infos[i].montant)

                infoWindow.open(map, marker);
            },toggleBounce);
            return marker;
        });

        // Add a marker clusterer to manage the markers.
        const markerCluster = new markerClusterer.MarkerClusterer({ markers, map });

    }

    function placeMarkerAndPanTo(latLng, map) {
        // const image =   "../img/icon-total.png";
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
    async function initAutocomplete() {
        const { PlaceAutocompleteElement } = await google.maps.importLibrary("places");

        const originalInput = document.querySelector("#ship-address");
        if (!originalInput) return;

        const wrapper = document.createElement("div");
        wrapper.style.cssText = "width:100%;";
        originalInput.parentNode.insertBefore(wrapper, originalInput);
        originalInput.type = "hidden";

        const placeAutocomplete = new PlaceAutocompleteElement({
            includedRegionCodes: ["sn"],
            types: ["address"],
        });
        placeAutocomplete.style.cssText = "width:100%;";
        wrapper.appendChild(placeAutocomplete);

        placeAutocomplete.addEventListener("gmp-placeselect", async ({ place }) => {
            await place.fetchFields({
                fields: ["formattedAddress", "addressComponents"],
            });

            let address1 = "";
            let postcode = "";
            for (const component of place.addressComponents) {
                const type = component.types[0];
                switch (type) {
                    case "street_number":      address1 = `${component.longText} ${address1}`; break;
                    case "route":              address1 += component.shortText; break;
                    case "postal_code":        postcode = `${component.longText}`; break;
                    case "postal_code_suffix": postcode = `${postcode}-${component.longText}`; break;
                }
            }
            originalInput.value = address1 || place.formattedAddress;
        });
    }
    window.initAutocomplete = initAutocomplete;

</script>
