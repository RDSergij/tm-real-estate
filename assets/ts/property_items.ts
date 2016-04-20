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
		 * Google map bounds
		 * @type {any}
		 */
		bounds: any = [];

		/**
		 * Property items data
		 * @type {any}
		 */
		data: any = (<any>window).property_items;

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
					zoom: 5,
					center: new this.google.maps.LatLng(this.lat, this.lng)
				}
			);

			if( 'undefined' !== typeof(this.data) ) {
				for (var i = 0; i < this.data.length; i++ ) {
					this.addMarker(this.data[i].lat, this.data[i].lng);
				}
			}

			this.bounds = new this.google.maps.LatLngBounds();
			for (var i = 0; i < this.markers.length; i++) {
				this.bounds.extend(this.markers[i].getPosition());
			}

			this.google_map.fitBounds(this.bounds);
		}

		/**
		 * Get lat and lng from address
		 * @param {string} address  property.
		 */
		getLatLng(address:string) {
			jQuery.ajax({
				type: 'GET',
				dataType: 'json',
				url: 'http://maps.googleapis.com/maps/api/geocode/json?address=' + address,
				success: (response: any) => this.addMarkerCallBack(response)
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
