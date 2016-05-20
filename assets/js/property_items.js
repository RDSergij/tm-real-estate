(function ($) {
    var PropertyItems = (function () {
        function PropertyItems() {
            this.lat = 48.450865;
            this.lng = 22.747808;
            this.id = 'property_items';
            this.google = window.google;
            this.map = null;
            this.google_map = null;
            this.markers = [];
            this.info_windows = [];
            this.bounds = [];
            this.data = window.property_items;
            this._ = window._;
            this.template = null;
            this._.templateSettings = {
                interpolate: /\{\{(.+?)\}\}/g
            };
            this.template = this._.template(jQuery('#info_window_content_tmpl').html());
            this.map = document.getElementById(this.id);
            if (null !== this.map) {
                this.initMap();
            }
            $(document).on('click', '.info-window', function () {
                window.open($(this).data('url'));
            });
        }
        PropertyItems.prototype.initMap = function () {
            this.google_map = new this.google.maps.Map(this.map, {
                zoom: 7,
                center: new this.google.maps.LatLng(this.lat, this.lng)
            });
            if ('undefined' !== typeof (this.data)) {
                for (var i = 0; i < this.data.length; i++) {
                    this.addMarker(this.data[i].lat, this.data[i].lng);
                }
            }
            this.bounds = new this.google.maps.LatLngBounds();
            for (var i = 0; i < this.markers.length; i++) {
                this.bounds.extend(this.markers[i].getPosition());
            }
            this.google_map.fitBounds(this.bounds);
            this.initInfo();
        };
        PropertyItems.prototype.initInfo = function () {
            this._.templateSettings = {
                interpolate: /\{\{(.+?)\}\}/g
            };
            for (var i = 0; i < this.markers.length; i++) {
                this.info_windows.push(new this.google.maps.InfoWindow({
                    content: this.template({
                        id: this.data[i].id,
                        url: window.property_settings.base_url + this.data[i].id,
                        content: this.data[i].content
                    })
                }));
                (function (x, me) {
                    me.markers[x].addListener('click', function () {
						for( var index = 0; index < me.info_windows.length; index++ ) {
							me.info_windows[index].close();
						}
                        me.info_windows[x].open(me.google_map, me.markers[x]);
                    });
                }(i, this));
            }
        };
        PropertyItems.prototype.addMarker = function (lat, lng) {
            this.markers.push(new this.google.maps.Marker({
                position: new this.google.maps.LatLng(lat, lng),
                map: this.google_map,
                title: 'Click to zoom'
            }));
        };
        return PropertyItems;
    }());
    var property_items = new PropertyItems();
})(jQuery);
//# sourceMappingURL=property_items.js.map