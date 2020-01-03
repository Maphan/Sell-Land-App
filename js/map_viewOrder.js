
function initMap(Lat,Lng) {
  // Create a map object and specify the DOM element for display.
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: L1, lng: L2},
    // Set mapTypeId to SATELLITE in order
    // to activate satellite imagery.
    mapTypeId: 'satellite',
    scrollwheel: false,
    zoom: 18
  });
  var marker = new google.maps.Marker({
        position: map.getCenter(),
        draggable: false,
        map: map
      });
}
