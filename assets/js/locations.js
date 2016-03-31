/**
 * Author: Guriev Eugen.
 */
function Locations() {
	var $me = this;

	$me.id      = 'locations';
	$me.map     = jQuery( '#' + $me.id );
	$me.markers = [];

	/**
	 * Initialize main address on map
	 * @param  string address --- address
	 */
	$me.initAddresAndMap = function( address ) {
		if ( $me.map.length ) {
			jQuery.ajax({
				type: 'GET',
				dataType: 'json',
				url: 'http://maps.googleapis.com/maps/api/geocode/json?address=' + address,
				success: function( response ) {
					if ( 'OK' == response.status ) {
						$me.initMap(
							response.results[0].geometry.location.lat,
							response.results[0].geometry.location.lng
						);
					} else {
						$me.initMap( 40.4778838, -74.290702 );
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
	$me.initMap = function( lat, lng ) {
		var mapOptions = {
			zoom: 15,
			center: new google.maps.LatLng( lat, lng ),
			scrollwheel: false,
			draggable: false
		};

		var map = new google.maps.Map( document.getElementById( $me.id ), mapOptions );

		var marker = new google.maps.Marker(
			{
				position: new google.maps.LatLng( lat, lng ),
				map: map,
				title: 'Click to zoom'
			}
		);

		google.maps.event.addListener(
			marker,
			'click',
			function() {
				map.setZoom( 8 );
				map.setCenter( marker.getPosition() );
			}
		);
	};
}

jQuery( document ).ready(
	function() {
		var locations = new Locations();
		if ( locations.map.length ) {
			locations.initAddresAndMap( locations.map.data( 'address' ) );
		}
	}
);
