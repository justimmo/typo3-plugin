jQuery(function ($) {
	var
		$map = $('#tx_justimmo_detail_map'),
		lat = $map.data('lat'),
		lng = $map.data('lng'),
		gMap = new google.maps.Map($map.get(0), {
			center: new google.maps.LatLng(lat, lng),
			zoom: 7,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			mapTypeControl: true,
			panControl: true
		}),
		gMarkerLatLng = new google.maps.LatLng(lat, lng);

	new google.maps.Marker({
		position: gMarkerLatLng,
		map: gMap
	});
});