/// <reference path="jquery.d.ts" />

(function($: any) {

	class PropertyItems {

		/**
		 * Default latitude
		 * @type {number}
		 */
		lat: number = 48.450865;

		/**
		 * Default longitude
		 * @type {number}
		 */
		lng: number = 22.747808;

		/**
		 * Map id
		 * @type {string}
		 */
		id: string = 'property_items';

		/**
		 * Goole object
		 * @type {any}
		 */
		google: any = (<any>window).google;

		/**
		 * Our map emlement
		 * @type {any}
		 */
		map: any = null;

		/**
		 * Goole map object
		 * @type {any}
		 */
		google_map: any = null;

		/**
		 * Google map markers
		 * @type {any}
		 */
		markers: any = [];

		/**
		 * Property Items class constructor
		 */
		constructor() {
			this.map = document.getElementById(this.id);
			if (null !== this.map) {
				this.initMap();
			}
		}

		/**
		 * Init google map
		 */
		initMap() {
			this.google_map = new this.google.maps.Map(
				this.map,
				{
					zoom: 15,
					center: new this.google.maps.LatLng(this.lat, this.lng),
					scrollwheel: false,
					draggable: false
				}
			);

			this.addMarker(this.lat, this.lng);

			this.google.maps.event.addListener(
				this.markers[0],
				'click',
				function() {
					this.google_map.setZoom(8);
					this.google_map.setCenter(this.markers[0].getPosition());
				}
			);
		}

		/**
		 * Get lat and lng from address
		 * @param {string} address  property.
		 * @param {any}    callback geocode.
		 */
		getLatLng(address:string, callback:any) {
			jQuery.ajax({
				type: 'GET',
				dataType: 'json',
				url: 'http://maps.googleapis.com/maps/api/geocode/json?address=' + address,
				success: (response:any) => callback(response)
			});
		}

		/**
		 * Add marker callback
		 * @param {any} response google geocode response.
		 */
		addMarkerCallBack(response:any) {
			if ('OK' === response.status) {
				this.addMarker(
					response.results[0].geometry.location.lat,
					response.results[0].geometry.location.lng
				);
			}
		}

		/**
		 * Add marker to google map
		 * @param {number} lat latitude.
		 * @param {number} lng longitude.
		 */
		addMarker(lat:number, lng:number) {
			this.markers.push(
				new this.google.maps.Marker(
					{
						position: new this.google.maps.LatLng(lat, lng),
						map: this.google_map,
						title: 'Click to zoom'
					}
				)
			);
		}

	}

	var property_items = new PropertyItems();

})(jQuery);
