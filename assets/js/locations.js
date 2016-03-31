function Locations(){
	var $me = this;

	$me.id      = 'locations';
	$me.map     = jQuery('#' + $me.id);
	$me.markers = [];
	
	/**
	 * Initialize main address on map
	 * @param  string address --- address
	 */
	$me.initAddresAndMap = function(address){
		if($me.map.length)
		{
			jQuery.ajax({
				type: 'GET',
				dataType: 'json',
				url: 'http://maps.googleapis.com/maps/api/geocode/json?address=' + address,
				success: function(response){
					if(response.status == 'OK')
					{
						$me.initMap(
							response.results[0].geometry.location.lat, 
							response.results[0].geometry.location.lng
						);
					}
					else
					{
						$me.initMap(40.4778838, -74.290702);
					}
				}
			});
		}
	};

	/**
	 * Initialize map
	 * @param  float lat --- latitude
	 * @param  float lng --- longtitude
	 */
	$me.initMap = function(lat, lng){
		var mapOptions = {
			zoom: 15,
			center: new google.maps.LatLng(lat, lng),
			scrollwheel: false,
			draggable: false
		};

		var map = new google.maps.Map(document.getElementById($me.id), mapOptions);

		var marker = new google.maps.Marker(
			{
				position: new google.maps.LatLng(lat, lng),
				map: map,
				title: 'Click to zoom'
			}
		);

		$me.initMarkers(map);

		google.maps.event.addListener(
			marker, 
			'click', 
			function() {
				map.setZoom(8);
				map.setCenter(marker.getPosition());
			}
		);
	};

	/**
	 * Initialize markers
	 * @param  object map --- google map object
	 */
	$me.initMarkers = function(map){
		var loc = {};
		if(typeof(locations_json) != 'undefined' && locations_json.length > 0)
		{
			for(var i = 0; i < locations_json.length; i++)
			{
				loc = locations_json[i];
				$me.markers.push({
					id: loc.id,
					marker: new google.maps.Marker(
						{
							position: new google.maps.LatLng(loc.lat, loc.lng),
							map: map,
							title: loc.title
						}
					)
				});
			}
		}
	};
}

jQuery(document).ready(
	function(){
		var locations = new Locations();
		if(locations.map.length)
		{
			locations.initAddresAndMap( locations.map.data( 'address' ) );
		}
	}
);