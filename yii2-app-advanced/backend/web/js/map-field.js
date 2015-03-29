/**
 * Created by vitaly on 3/29/15.
 */
(function () {

    'use strict';

    var MapField = (function () {
        var self = {},
            _$map_field = null,
            _$map_address_field = null,
            _$map_latitude_field = null,
            _$map_longitude_field = null,
            _$reset_button = null,
            _coordinates = null,
            _default = {
                latitude: 50.4501,
                longitude: 30.523400000000038,
                map_type: 'ROADMAP',
                zoom: 14
            },
            _geocoder = null,
            _map = null,
            _map_container = null,
            _map_type = null,
            _marker = null,
            _options = {
                streetViewControl: false
            },
            _timer = 0,
            _zoom = null;

        function MapField($map_field) {
            self = this;

            this.initialize_html_objects($map_field);

            _coordinates = {
                'lat': $('#project-lat').val(),
                'lng': $('#project-lng').val()
            };
            _map_type = _$map_address_field.data('map-type');
            _zoom = _$map_address_field.data('zoom');

            this.set_center();
            this.set_type();
            this.set_zoom();
            this.initialize_geocoder();
            this.initialize_map();
            this.initialize_marker();
            this.add_autocomplete();
            this.add_listeners();
        }

        MapField.prototype.initialize_html_objects = function ($map_field) {
            _$map_field = $map_field;
            _$map_field.addClass('rendered');
            _$map_address_field = jQuery('#input_address');
            _$map_latitude_field = jQuery('#project-lat');
            _$map_longitude_field = jQuery('#project-lng');
            _$reset_button = jQuery('#map_reset');

            _map_container = document.getElementById('map_container');
            jQuery(_map_container).resize(function () {
                setTimeout(function () {
                    google.maps.event.trigger(_map, 'resize');
                }, 3000);
            });
        };

        MapField.prototype.initialize_map = function () {
            _map = new google.maps.Map(_map_container, _options);

            if (_$map_field.val()) {
                this.update_coordinates(_options.center);
            }
        };

        MapField.prototype.initialize_marker = function () {
            _marker = new google.maps.Marker({
                position: _options.center,
                map: _map,
                draggable: true
            });
        };

        MapField.prototype.initialize_geocoder = function () {
            _geocoder = new google.maps.Geocoder();
        };

        MapField.prototype.set_zoom = function () {

            if (_zoom) {
                _options.zoom = _zoom;
            } else {
                _options.zoom = _default.zoom;
            }
        };

        MapField.prototype.set_center = function () {
            var latitude,
                longitude;

            if (_coordinates) {
                latitude = _coordinates.lat;
                longitude = _coordinates.lng;
            } else {
                latitude = _default.latitude;
                longitude = _default.longitude;
            }
            _options.center = new google.maps.LatLng(latitude, longitude);
        };

        MapField.prototype.set_type = function () {

            if (_map_type) {
                _options.mapTypeId = google.maps.MapTypeId[_map_type];
            } else {
                _options.mapTypeId = google.maps.MapTypeId[_default.map_type];
            }
        };

        MapField.prototype.add_listeners = function () {

            (function (map, marker, $map_field, $map_address_field, $map_latitude_field, $map_longitude_field) {
                var prev_value;

                google.maps.event.addListener(_marker, 'drag', function (event) {
                    self.update_coordinates(event.latLng, $map_field, $map_address_field, $map_latitude_field, $map_longitude_field);
                });

                $map_latitude_field.add($map_longitude_field).on('focus', function () {
                    prev_value = jQuery(this).val();
                }).on('change', function () {
                    var id = $map_field.attr('id'),
                        latitude = jQuery('#' + id + '_latitude').val(),
                        longitude = jQuery('#' + id + '_longitude').val(),
                        lat_lng = new google.maps.LatLng(latitude, longitude);

                    if (!isNaN(lat_lng.lat()) && !isNaN(lat_lng.lng())) {
                        map.setCenter(lat_lng);
                        marker.setPosition(lat_lng);
                        self.update_coordinates(lat_lng, $map_field, $map_address_field, $map_latitude_field, $map_longitude_field);
                    } else {
                        jQuery(this).val(prev_value);
                    }
                });

                _$reset_button.on('click', function (event) {
                    event.preventDefault();

                    self.reset($map_field, $map_address_field, $map_latitude_field, $map_longitude_field);
                });
            })(_map, _marker, _$map_field, _$map_address_field, _$map_latitude_field, _$map_longitude_field);
        };

        MapField.prototype.update_coordinates = function (lat_lng, $map_field, $map_address_field, $map_latitude_field, $map_longitude_field) {

            if (typeof $map_field === 'undefined' || $map_field === null) {
                $map_field = _$map_field;
            }

            if (typeof $map_address_field === 'undefined' || $map_address_field === null) {
                $map_address_field = _$map_address_field;
            }

            if (typeof $map_latitude_field === 'undefined' || $map_latitude_field === null) {
                $map_latitude_field = _$map_latitude_field;
            }

            if (typeof $map_longitude_field === 'undefined' || $map_longitude_field === null) {
                $map_longitude_field = _$map_longitude_field;
            }

            if (typeof lat_lng.lat === 'function' && typeof lat_lng.lng === 'function') {
                $map_field.val(lat_lng.lat() + ',' + lat_lng.lng());
                $map_latitude_field.val(lat_lng.lat());
                $map_longitude_field.val(lat_lng.lng());

                if (!_timer) {
                    this.call_geocoder(lat_lng, $map_address_field);
                } else {
                    $map_address_field.addClass('ui-autocomplete-loading').val('');
                }

                _timer && clearTimeout(_timer);
                _timer = setTimeout(function () {
                    self.call_geocoder(lat_lng, $map_address_field);
                }, 1000);
            }
        };

        MapField.prototype.add_autocomplete = function () {

            (function (map, marker, $map_field, $map_address_field, $map_latitude_field, $map_longitude_field) {
                _$map_address_field.autocomplete({
                    source: function (request, response) {
                        var requested_value = request.term;
                        _geocoder.geocode({'address': requested_value}, function (results, status) {
                            if (status === google.maps.GeocoderStatus.OK) {
                                response(jQuery.map(results, function (item) {
                                    return {
                                        value: item.formatted_address,
                                        latitude: item.geometry.location.lat(),
                                        longitude: item.geometry.location.lng()
                                    };
                                }));
                            } else {
                                response([{label: 'No matches found', value: requested_value}]);
                            }
                        });
                    },
                    select: function (event, ui) {
                        if (typeof ui.item.latitude == 'undefined') {
                            return;
                        }
                        var lat_lng = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);

                        map.setCenter(lat_lng);
                        marker.setPosition(lat_lng);
                        self.update_coordinates(lat_lng, $map_field, $map_address_field, $map_latitude_field, $map_longitude_field);
                    }
                });
            })(_map, _marker, _$map_field, _$map_address_field, _$map_latitude_field, _$map_longitude_field);
        };

        MapField.prototype.call_geocoder = function (lat_lng, $map_address_field) {

            if (typeof lat_lng.lat === 'function' && typeof lat_lng.lng === 'function') {
                _geocoder.geocode({'location': lat_lng}, function (results, status) {

                    if (status === google.maps.GeocoderStatus.OK) {
                        $map_address_field.val(results[0].formatted_address);
                    } else {
                        $map_address_field.val('');
                    }
                    $map_address_field.removeClass('ui-autocomplete-loading');
                });
            }
        };

        MapField.prototype.reset = function ($map_field, $map_address_field, $map_latitude_field, $map_longitude_field) {

            if (typeof $map_field === 'undefined' || $map_field === null) {
                $map_field = _$map_field;
            }

            if (typeof $map_address_field === 'undefined' || $map_address_field === null) {
                $map_address_field = _$map_address_field;
            }

            if (typeof $map_latitude_field === 'undefined' || $map_latitude_field === null) {
                $map_latitude_field = _$map_latitude_field;
            }

            if (typeof $map_longitude_field === 'undefined' || $map_longitude_field === null) {
                $map_longitude_field = _$map_longitude_field;
            }
            $map_field.val('');
            $map_address_field.val('');
            $map_latitude_field.val('');
            $map_longitude_field.val('');
        };

        return MapField;
    })();


    jQuery(function () {
        jQuery('#map_container').not('.rendered').each(function () {
            if (typeof document.mapFields == 'undefined') {
                document.mapFields = [];
            }
            document.mapFields.push(new MapField(jQuery(this)));
        });
    });

})();


