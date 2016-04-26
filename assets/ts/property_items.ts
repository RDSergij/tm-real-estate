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
		 * Goole map info windows
		 * @type {any}
		 */
		info_windows: any = [];

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
		 * Underscore
		 * @type {any}
		 */
		_: any = (<any>window)._;

		/**
		 * Undersore template
		 * @type {any}
		 */
		template: any = null;

		/**
		 * Property Items class constructor
		 */
		constructor() {
			this._.templateSettings = {
				interpolate: /\{\{(.+?)\}\}/g
			};
			this.template = this._.template(jQuery('#info_window_content_tmpl').html());

			this.map = document.getElementById(this.id);
			if (null !== this.map) {
				this.initMap();
			}

			$(document).on(
				'click',
				'.info-window',
				function() {
					window.open($(this).data('url'));
				}
			);
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

			this.initInfo();
		}

		/**
		 * Initialize info windows
		 */
		initInfo() {
			this._.templateSettings = {
				interpolate: /\{\{(.+?)\}\}/g
			};
			for (var i = 0; i < this.markers.length; i++) {
				this.info_windows.push(
					new this.google.maps.InfoWindow({
						content: this.template({
							id: this.data[i].id,
							url: (<any>window).property_settings.base_url + this.data[i].id,
							content: this.data[i].address
						})
					})
				);
				(function(x : any, me: any) {
					me.markers[x].addListener(
						'click',
						function() {
							me.info_windows[x].open(me.google_map, me.markers[x]);
						}
					);
				} (i, this));
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
