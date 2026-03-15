<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.0/mapbox-gl.js"></script>
<link href="https://api.mapbox.com/mapbox-gl-js/v2.14.0/mapbox-gl.css" rel="stylesheet">

<script>
    mapboxgl.accessToken = '{{ config("services.mapbox.token") }}';

    const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [-17.4467, 14.6928], // Dakar
    zoom: 10,
    attributionControl:false
  });

  let marker = new mapboxgl.Marker();
  let timeout = null;

  async function handleInput() {
    clearTimeout(timeout);
    const input = document.getElementById('address').value;

    if (!input) {
      document.getElementById('suggestions').innerHTML = '';
      return;
    }

    timeout = setTimeout(async () => {
      const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(input)}.json?access_token=${mapboxgl.accessToken}&country=SN&types=place,locality,address`;

      try {
        const res = await fetch(url);
        
        const data = await res.json();
        console.log(data);
        const list = document.getElementById('suggestions');
        list.innerHTML = '';

        data.features.forEach(feature => {
          const li = document.createElement('li');
          li.textContent = feature.place_name;
          li.onclick = () => selectAddress(feature);
          list.appendChild(li);
        });
      } catch (err) {
        console.error("Erreur lors de la récupération des suggestions", err);
      }
    }, 500); // délai anti spam
  }

  function selectAddress(feature) {
    const [lng, lat] = feature.center;
    const context = feature.context;
    let commune = "Non trouvée";
    let region = "Non trouvée";

    context.forEach(item => {
      if (item.id.includes("place")) {
        commune = item.text;
      }
      if (item.id.includes("region")) {
        region = item.text;
      }
    });

    document.getElementById('address').value = feature.place_name;
    document.getElementById('suggestions').innerHTML = '';
    // document.getElementById('commune').textContent = commune;
    // document.getElementById('departement').textContent = region;
    document.getElementById('lon').value = lng;
    document.getElementById('lat').value = lat;

    map.flyTo({ center: [lng, lat], zoom: 13 });
    marker.setLngLat([lng, lat]).addTo(map);
  }
</script>