<script src="https://maps.googleapis.com/maps/api/js?key=*****"></script>
<script>
	var companies = <?php echo json_encode($result ); ?>;
	console.log(companies);
	var geocoder;
	var map;
	var i=0;
	var time;

	function initialize() {
		geocoder = new google.maps.Geocoder();
		var latlng = new google.maps.LatLng(-34.397, 150.644);
		var mapOptions = {
			zoom: 8,
			center: latlng
		}
		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		geocoder.geocode( { 'address': 'Manila, Philippines'}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					map.setCenter(results[0].geometry.location);
				}
			});
		codeAddress();
	}

	function codeAddress() {
		if(i>companies.length/5) return;
		time = setTimeout(function(){
			console.log(i);
			var address = companies[i].address;
			geocoder.geocode( { 'address': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					var marker = new google.maps.Marker({
						map: map,
						position: results[0].geometry.location,
					});
					// var infowindow = new google.maps.InfoWindow({
					// 	map: map,
					// 	position: results[0].geometry.location,
					// 	content: i+" "+results[0].geometry.location
					// });
				} 
				else {
					console.log("Could not map location: "+address);
					console.log('Geocode was not successful for the following reason: ' + status);
				}
			})
			i++;
			codeAddress();
		}, 1000);		// max 10 queries per second. pero dahil sobrang bagal ng net, 1 query lang per second. tsk
	}

	function outputGeo(result){
        console.log("outside:" + result);
    }


	google.maps.event.addDomListener(window, 'load', initialize);
</script>
<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<h3>Map Results</h3>
		<div id="map-canvas" style="width:600px;height:600px;"></div>
	</div>
</div>