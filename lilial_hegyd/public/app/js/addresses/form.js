var AddressableForm = function () {

    var self = this;

    var DEFAULT_LAT = 46.71109;
    var DEFAULT_LNG = 1.7191036;
    var DEFAULT_ZOOM = 6;

    this.countrySelector = '#country_id';
    this.countryEndpoint = '/countries';

    this.mapSelector = '#gmap';
    this.map;
    this.markers = [];

    this.initCountry = function () {
        $(self.countrySelector).select2({
            language: 'fr',
            ajax: {
                url: self.countryEndpoint,
                data: function (params) {
                    return {
                        query: params.term
                    };
                },
                processResults: function (data, params) {
                    var results = [];
                    $.each(data, function (id, entity) {
                        results.push({
                            id: entity.id,
                            text: entity.title_en
                        });
                    });
                    return {results: results}
                },
                templateResult: function (data) {
                    return data.title_fr;
                }
            }
        });
    };

    this.initMap = function () {
        if (!$(self.mapSelector).length)
            return false;

        self.map = new google.maps.Map($(self.mapSelector)[0], {
            zoom: DEFAULT_ZOOM,
            center: {lat: DEFAULT_LAT, lng: DEFAULT_LNG},
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        google.maps.event.trigger(self.map, 'resize');

        var $latitude = $('#latitude');
        var $longitude = $('#longitude');

        /**
         * Set initial marker
         */
        if ($latitude.val() && $longitude.val()) {
            self.addMarker($latitude.val(), $longitude.val());
            // Center to init marker
            self.map.setCenter(new google.maps.LatLng($latitude.val(), $longitude.val()));
            self.map.setZoom(14);
        }
    };

    this.initMapEvents = function () {
        google.maps.event.addListener(self.map, 'click', function (event) {
            /**
             * Get Lat Lng from click event
             */
            var clickLat = event.latLng.lat();
            var clickLng = event.latLng.lng();

            /**
             * Add values to fields
             */
            self.setLatLngFields(clickLat.toFixed(10), clickLng.toFixed(10));

            /**
             * Remove old markers
             */
            self.removeMarkers();

            /**
             * Add new marker
             */
            self.addMarker(clickLat, clickLng);
        });

        $('.js-search-address').on('click', function (e) {
            e.preventDefault();
            self.searchAddress();
        });
    };

    this.addMarker = function (latitude, longitude) {
        self.markers.push(new google.maps.Marker({
            position: new google.maps.LatLng(latitude, longitude),
            map: self.map
        }));
    };

    this.removeMarkers = function () {
        for (var i = 0; i < self.markers.length; i++) {
            self.markers[i].setMap(null);
            self.markers.splice(i, 1);
        }
    };

    this.setLatLngFields = function (latitude, longitude) {
        var $latitude = $('#latitude');
        var $longitude = $('#longitude');

        $latitude.val(latitude);
        $longitude.val(longitude);
    };

    this.searchAddress = function () {
        var $addressable_form = $('.addressable_form');
        var address = '';
        address += $('.address', $addressable_form).val() + ', ';
        address += $('.additional_1', $addressable_form).val() + ', ';
        address += $('.additional_2', $addressable_form).val() + ', ';
        address += $('.city', $addressable_form).val() + ', ';
        address += $('.zip', $addressable_form).val() + ', ';
        address += $('.country', $addressable_form).text();

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var Lat = results[0].geometry.location.lat();
                var Lng = results[0].geometry.location.lng();

                self.removeMarkers();
                self.addMarker(Lat, Lng);
                self.map.setCenter(new google.maps.LatLng(Lat, Lng));
                self.map.setZoom(14);

                /**
                 * Add values to fields
                 */
                self.setLatLngFields(Lat, Lng);
                toastr.success('Adresse trouvée avec succès');
            } else {
                swal('', 'L\'addresse est introuvable, vous pouvez cliquer sur la carte pour renseigner les coordonées GPS', 'error');
            }
        });
    };

    return {
        init: function () {
            self.initCountry();
        },
        initMap: function () {
            self.initMap();
            self.initMapEvents();
        }
    };
}();

$(window).load(function () {
    AddressableForm.init();
});