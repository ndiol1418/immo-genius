  // Initialize and add the map
  let map;

  async function initMap() {
      // The location of Uluru
      const position = { lat: 14.499, lng: -14.445 };
      // // Request needed libraries.
      // //@ts-ignore
      // const { Map } = await google.maps.importLibrary("maps");
      // const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

      // // The map, centered at Uluru

      // map = new Map(document.getElementById("map"), {
      //     zoom: 7,
      //     center: position,
      //     mapId: "map",
      // });
      const { Map, InfoWindow } = await google.maps.importLibrary("maps");
      const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary(
          "marker",
      );
      const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 3,
          center: position,
          mapId: "map",
      });
      const infoWindow = new google.maps.InfoWindow({
          content: "",
          disableAutoPan: true,
      });
      // Create an array of alphabetical characters used to label the markers.
      const labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      // Add some markers to the map.
      // The marker, positioned at Uluru
      //   var stations = @json($stations);
      const locations = [];
      const infos = [];
      stations.forEach(element => {
          if (element.lat != null && element.lon) {
              locations.push({ lat: element.lat, lng: element.lon })
              infos.push(element.nom)
          }
      });
      const markers = locations.map((position, i) => {
          // console.log(position);
          // const label = infos[i % labels.length];
          // const label = infos[i];
          const pinGlyph = new google.maps.marker.PinElement({
              // glyph: label,
              glyphColor: "white",
          });
          const marker = new google.maps.marker.AdvancedMarkerElement({
              position,
              content: pinGlyph.element,
          });

          // markers can only be keyboard focusable when they have click listeners
          // open info window when marker is clicked
          marker.addListener("click", () => {
              infoWindow.setContent(infos[i]);
              // infoWindow.setContent(position.lat + ", " + position.lng);
              infoWindow.open(map, marker);
          });
          return marker;
      });

      // Add a marker clusterer to manage the markers.
      const markerCluster = new markerClusterer.MarkerClusterer({ markers, map });
  }

  initMap();