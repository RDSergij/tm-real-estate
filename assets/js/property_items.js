(function ($) {
    var PropertyItems = (function () {
        function PropertyItems() {
            this.lat = 48.450865;
            this.lng = 22.747808;
            this.id = 'property_items';
            this.google = window.google;
            this.map = null;
            this.map = document.getElementById(this.id);
            if (null !== this.map) {
                this.initMap();
            }
        }
        PropertyItems.prototype.initMap = function () {
            var map, marker;
            map = new this.google.maps.Map(this.map, {
                zoom: 15,
                center: new this.google.maps.LatLng(this.lat, this.lng),
                scrollwheel: false,
                draggable: false
            });
            marker = new this.google.maps.Marker({
                position: new this.google.maps.LatLng(this.lat, this.lng),
                map: map,
                title: 'Click to zoom'
            });
            this.google.maps.event.addListener(marker, 'click', function () {
                map.setZoom(8);
                map.setCenter(marker.getPosition());
            });
        };
        return PropertyItems;
    }());
    var property_items = new PropertyItems();
})(jQuery);
//# sourceMappingURL=property_items.js.map