function loadmap() {
			// initialize map
			var map = new google.maps.Map(document.getElementById("map-canvas"), {
				center: new google.maps.LatLng(L1, L2),
				zoom: 13,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});
			// initialize marker
			var marker = new google.maps.Marker({
				position: map.getCenter(),
				draggable: true,
				map: map
			});
			// intercept map and marker movements
			google.maps.event.addListener(map, "idle", function() {
				marker.setPosition(map.getCenter());
				document.getElementById("map-output").innerHTML = "Latitude:  " + map.getCenter().lat().toFixed(6) + "<br>Longitude: " + map.getCenter().lng().toFixed(6) + "<a href='https://www.google.com/maps?q=" + encodeURIComponent(map.getCenter().toUrlValue()) + "' target='_blank'>Go to maps.google.com</a>";
			});
			// get values
			google.maps.event.addListener(marker, "dragend", function(mapEvent) {
				map.panTo(mapEvent.latLng);
				var lat= marker.getPosition().lat();
				var lng= marker.getPosition().lng();
				$('#lat').val(lat);
				$('#lng').val(lng);
			});
			// initialize geocoder
			var geocoder = new google.maps.Geocoder();
			google.maps.event.addDomListener(document.getElementById("search-btn"), "click", function() {
				geocoder.geocode({ address: document.getElementById("search-txt").value }, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						var result = results[0];
						document.getElementById("search-txt").value = result.formatted_address;
						if (result.geometry.viewport) {
							map.fitBounds(result.geometry.viewport);
						} else {
							map.setCenter(result.geometry.location);
						}
					} else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
						alert("Sorry, geocoder API failed to locate the address.");
					} else {
						alert("Sorry, geocoder API failed with an error.");
					}
				});
			});
			google.maps.event.addDomListener(document.getElementById("search-txt"), "keydown", function(domEvent) {
				if (domEvent.which === 13 || domEvent.keyCode === 13) {
					google.maps.event.trigger(document.getElementById("search-btn"), "click");
				}
			});
			// initialize geolocation
			if (navigator.geolocation) {
				google.maps.event.addDomListener(document.getElementById("detect-btn"), "click", function() {
					navigator.geolocation.getCurrentPosition(function(position) {
						map.setCenter(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
					}, function() {
						alert("Sorry, geolocation API failed to detect your location.");
					});
				});
				document.getElementById("detect-btn").disabled = false;
			}
}