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
            this.data = window.property_items;
            this.map = document.getElementById(this.id);
            if (null !== this.map) {
                this.initMap();
            }
        }
        PropertyItems.prototype.initMap = function () {
            this.google_map = new this.google.maps.Map(this.map, {
                zoom: 5,
                center: new this.google.maps.LatLng(this.lat, this.lng)
            });
            if ('undefined' !== typeof (this.data)) {
                for (var i = 0; i < this.data.length; i++) {
                    this.addMarker(this.data[i].lat, this.data[i].lng);
                }
            }
        };
        PropertyItems.prototype.getLatLng = function (address) {
            var _this = this;
            jQuery.ajax({
                type: 'GET',
                dataType: 'json',
                url: 'http://maps.googleapis.com/maps/api/geocode/json?address=' + address,
                success: function (response) { return _this.addMarkerCallBack(response); }
            });
        };
        PropertyItems.prototype.addMarkerCallBack = function (response) {
            if ('OK' === response.status) {
                this.addMarker(response.results[0].geometry.location.lat, response.results[0].geometry.location.lng);
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