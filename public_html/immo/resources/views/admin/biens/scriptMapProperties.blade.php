<script>
    let longitude =  -17.4467;
    let latitude = 14.6928;
    // let longitude = -14.44;
    // let latitude = 14.499;
    async function initMap() {
        // Request needed libraries.

        const {
            Map
        } = await google.maps.importLibrary("maps");
        const {
            AdvancedMarkerElement
        } = await google.maps.importLibrary("marker");
        const center = {
            lat: latitude,
            lng: longitude
        };
        const map = new Map(document.getElementById("map"), {
            zoom: 14,
            center,
            mapId: "4504f8b37365c3d0",
        });
        var properties = @json($annonces);

        for (const property of properties) {
            let lon = property.immo.bien.lon;
            let lat = property.immo.bien.lat;
            let position = { lat: lat!== undefined ? parseFloat(lat):0, lng:  lon !== undefined?parseFloat(lon):0 }
            let montant = kConverter(property.prix);
            let name = property.immo.bien.name;
            const AdvancedMarkerElement = new google.maps.marker.AdvancedMarkerElement({
                map,
                content: buildContent(property,montant),
                position: position,
                title: name,
            });

            AdvancedMarkerElement.addListener("gmp-click", () => {
                toggleHighlight(AdvancedMarkerElement, property);
            });
        }

    }
    function kConverter(num) {
        return num <= 999 ? num : (0.1 * Math.floor(num / 100)).toFixed(1).replace('.0','') + 'k';
    }
    function toggleHighlight(markerView, property) {
        if (markerView.content.classList.contains("highlight")) {
            markerView.content.classList.remove("highlight");
            markerView.zIndex = null;
        } else {
            markerView.content.classList.add("highlight");
            markerView.zIndex = 1;
        }
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

    function buildContent(property,title) {
        // console.log(property.pieces[1].Chambres);
        const content = document.createElement("div");
        console.log(property.pieces);
        let chambres = property.pieces?property.pieces[1].Chambres:'';
        let toilettes = property.pieces?property.pieces[2].Toillettes:'';
        let salons = property.pieces?property.pieces[3].Salons:'';
        let cuisines = property.pieces?property.pieces[4].Cuisines:'';
        content.classList.add("property");
        content.innerHTML = `
        <div class="price-tag">${title}</div>

        <div class="details">
            <div class="price">${property.immo.bien.name}</div>
            <div class="address">${property.immo.bien.adresse??'---'}</div>
            <div class="features">
            <div>
                <i aria-hidden="true" class="fa fa-bed fa-lg bed" title="bedroom"></i>
                <span class="fa-sr-only">bedroom</span>
                <span>${chambres}</span>
            </div>
            <div>
                <i aria-hidden="true" class="fa fa-bath fa-lg bath" title="bathroom"></i>
                <span class="fa-sr-only">bathroom</span>
                <span>${toilettes}</span>
            </div>
            <div>
                <i aria-hidden="true" class="fa fa-ruler fa-lg size" title="size"></i>
                <span class="fa-sr-only">size</span>
                <span>${property.superficie?property.superficie:''} m<sup>2</sup></span>
            </div>
            </div>
        </div>
        `;
        return content;
    }

    const properties = [{
            address: "215 Emily St, MountainView, CA",
            description: "Single family house with modern design",
            price: "$ 3,889,000",
            type: "home",
            bed: 5,
            bath: 4.5,
            size: 300,
            position: {
                lat: 37.50024109655184,
                lng: -122.28528451834352,
            },
        },
        {
            address: "108 Squirrel Ln &#128063;, Menlo Park, CA",
            description: "Townhouse with friendly neighbors",
            price: "$ 3,050,000",
            type: "building",
            bed: 4,
            bath: 3,
            size: 200,
            position: {
                lat: 37.44440882321596,
                lng: -122.2160620727,
            },
        },
        {
            address: "100 Chris St, Portola Valley, CA",
            description: "Spacious warehouse great for small business",
            price: "$ 3,125,000",
            type: "warehouse",
            bed: 4,
            bath: 4,
            size: 800,
            position: {
                lat: 37.39561833718522,
                lng: -122.21855116258479,
            },
        },
        {
            address: "98 Aleh Ave, Palo Alto, CA",
            description: "A lovely store on busy road",
            price: "$ 4,225,000",
            type: "store-alt",
            bed: 2,
            bath: 1,
            size: 210,
            position: {
                lat: 37.423928529779644,
                lng: -122.1087629822001,
            },
        },
        {
            address: "2117 Su St, MountainView, CA",
            description: "Single family house near golf club",
            price: "$ 1,700,000",
            type: "home",
            bed: 4,
            bath: 3,
            size: 200,
            position: {
                lat: 37.40578635332598,
                lng: -122.15043378466069,
            },
        },
        {
            address: "197 Alicia Dr, Santa Clara, CA",
            description: "Multifloor large warehouse",
            price: "$ 5,000,000",
            type: "warehouse",
            bed: 5,
            bath: 4,
            size: 700,
            position: {
                lat: 37.36399747905774,
                lng: -122.10465384268522,
            },
        },
        {
            address: "700 Jose Ave, Sunnyvale, CA",
            description: "3 storey townhouse with 2 car garage",
            price: "$ 3,850,000",
            type: "building",
            bed: 4,
            bath: 4,
            size: 600,
            position: {
                lat: 37.38343706184458,
                lng: -122.02340436985183,
            },
        },
        {
            address: "868 Will Ct, Cupertino, CA",
            description: "Single family house in great school zone",
            price: "$ 2,500,000",
            type: "home",
            bed: 3,
            bath: 2,
            size: 100,
            position: {
                lat: 37.34576403052,
                lng: -122.04455090047453,
            },
        },
        {
            address: "655 Haylee St, Santa Clara, CA",
            description: "2 storey store with large storage room",
            price: "$ 2,500,000",
            type: "store-alt",
            bed: 3,
            bath: 2,
            size: 450,
            position: {
                lat: 37.362863347890716,
                lng: -121.97802139023555,
            },
        },
        {
            address: "2019 Natasha Dr, San Jose, CA",
            description: "Single family house",
            price: "$ 2,325,000",
            type: "home",
            bed: 4,
            bath: 3.5,
            size: 500,
            position: {
                lat: 37.41391636421949,
                lng: -121.94592071575907,
            },
        },
    ];

    initAutocomplete();
    initMap();

</script>
