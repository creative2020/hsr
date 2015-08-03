window.HJI = (function ()
{
    var location;

    var hji =
    {



        /**
         * by Zach Schryver zacharys@hjimail.com
         * https://bitbucket.org/homejunction/street-view
         */
        streetView: function(geoInfo, callback)
        {
            var streetView = function(geoInfo, callback)
            {

                this.errorFlag = false;

                //An address is required, so throw our custom error if we don't have one

                if (geoInfo.address.length < 1)
                {
                    this.streetViewError({
                        message: 'A valid address is required',
                        context: 'streetView.getStreetCoords',
                        toString: function() {return this.message + ' in ' + this.context;}
                    });
                }
                else
                {
                    this.address = geoInfo.address;
                }

                //These aren't absolutely necessary, so let them be empty strings if they weren't included

                this.city = geoInfo.city ? geoInfo.city : '';
                this.state = geoInfo.state ? geoInfo.state : '';

                if (!isNaN(geoInfo.lat) && !isNaN(geoInfo.lng))
                {
                    this.location = new google.maps.LatLng(geoInfo.lat, geoInfo.lng);
                }

                this.callback = callback ? callback : undefined;

                this.createStreetView();
            };

            streetView.prototype.fullAddress = function()
            {
                return this.address + ' ' + this.city + ', ' + this.state;
            };

            streetView.prototype.getStreetCoords = function()
            {

                //Maintain object scope for callback

                var that = this;

                //Geocoded coordinates point to the center of a property, which can cause issues in tightly packed or very rural neighborhoods
                //To get around this, we use the directions service to get the coordinates of the front of the property

                var directions = new google.maps.DirectionsService();
                directions.route({origin: this.fullAddress(), destination: this.fullAddress(), travelMode: 'DRIVING'}, function(results, status)
                {
                    if (status === google.maps.DirectionsStatus.OK)
                    {
                        that.streetCoords = results.routes[0].legs[0].end_location;
                        that.calculateHeading();
                    }
                    else
                    {
                        that.streetViewError({
                            message: 'Unable to locate the front of the property',
                            context: 'streetView.getStreetCoords',
                            status: status,
                            toString: function() {return this.message + ' in ' + this.context + '. Google status: ' + status;}
                        });
                    }
                });
            };

            streetView.prototype.calculateHeading = function()
            {
                var panoLocation,
                    that = this;

                //Find the nearest panorama to the street address and then calculate the correct heading that points the
                //street view camera at the desired property

                var streetViewService = new google.maps.StreetViewService();
                streetViewService.getPanoramaByLocation(this.streetCoords, 50, function(data, status)
                {
                    if (status === google.maps.StreetViewStatus.OK)
                    {
                        var diffX = that.location.lat() - data.location.latLng.lat();
                        diffY = that.location.lng() - data.location.latLng.lng();


                        var heading = (Math.atan2(diffY, diffX)) * (180 / Math.PI);

                        if (heading < 0)
                        {
                            heading += 2 * Math.PI;
                        }

                        that.heading = heading;

                        if (that.callback)
                        {
                            that.callback.call(that);
                        }
                    }

                    else
                    {
                        that.streetViewError({
                            message: 'Unable to locate Street View within 50m of location',
                            context: 'streetView.calculateHeading',
                            status: 'status',
                            toString: function() {return this.message + ' in ' + this.context + '. Google status: ' + status;}
                        });
                    }
                });

            };

            streetView.prototype.renderStreetView = function(elementId)
            {
                var targetElement = document.getElementById(elementId);

                if (this.errorFlag || !(this.heading))
                {
                    targetElement.innerHTML = "<h3 class='streetViewError'>Couldn't find a Street View for the given address</h3>";
                    this.errorFlag = false;
                    return;
                }

                //Take all of our generated options and render a new street view at the target element

                var panoramaOptions =
                {
                    position: this.streetCoords,

                    pov:
                    {
                        heading: Math.round(this.heading),
                        pitch: 0
                    },

                    zoom: 1
                };

                var myPano = new google.maps.StreetViewPanorama(targetElement, panoramaOptions);
                myPano.setVisible(true);
            };

            streetView.prototype.createStreetView = function()
            {
                var that = this;

                //Geocode a lat/lng from address if one is not provided

                if (!this.location)
                {
                    var geocoder = new google.maps.Geocoder();

                    geocoder.geocode({'address': this.fullAddress()}, function(results, status)
                    {
                        if (status === google.maps.GeocoderStatus.OK)
                        {
                            that.location = results[0].geometry.location;
                            that.getStreetCoords();
                        }
                        else
                        {
                            that.streetViewError({
                                errorType: 'StreetView',
                                message: 'Unable to find a Street View for the given location',
                                status: status,
                                context: 'streetView.createStreetView',
                                toString: function() {return this.message + ' in ' + this.context + '. Google status: ' + status;}
                            });
                        }
                    });
                }
                else
                {
                    this.getStreetCoords();
                }
            };

            streetView.prototype.getImageUrl = function(width, height)
            {
                var baseUrl = "http://maps.googleapis.com/maps/api/streetview?sensor=false&fov=75";

                //Establish some defaults

                width = (typeof width == 'undefined') ? '50' : width;
                height = (typeof height == 'undefined') ? '50' : height;

                var url =
                    [
                        baseUrl,
                        'size=' + width + 'x' + height,
                        'location=' + this.location.toUrlValue(),
                        'heading=' + this.heading
                    ];

                return url.join('&');
            };

            streetView.prototype.streetViewError = function(exception)
            {
                //A small custom error handling function to render a useful error message

                this.errorFlag = true;

                if (this.callback)
                {
                    this.callback();
                }

                //Probably shouldn't throw this in prod

//                throw new Error(exception.toString());
            };

            return new streetView(geoInfo, callback);
        }
    }

    return hji;
})();


/**
 * jQuery Plugins
 */

(function($)
{
    /**
     * Same as HJI.streetView() just more streamlined.
     * use data-parameter="value" in html markup for
     * address parameters as well as lat/lng
     * OR pass them via options{} object
     */


    $.fn.streetView = function(options)
    {
        var $obj = $(this),
            elementId = $obj.attr('id');

        if ($obj.length == 0)
        {
            return false;
        }

        var address = (typeof $obj.data('address') != 'undefined') ? $obj.data('address') : '',
            city = (typeof $obj.data('city') != 'undefined') ? $obj.data('city') : '',                  state = (typeof $obj.data('state') != 'undefined') ? $obj.data('state') : '',
            lat = (typeof $obj.data('lat') != 'undefined') ? $obj.data('lat') : false,
            lng = (typeof $obj.data('lng') != 'undefined') ? $obj.data('lng') : false;

        //noinspection JSValidateTypes
        var settings = $.extend({
            elementId: elementId,
            geoInfo: {
                address: address,
                city: city,
                state: state,
                lat: lat,
                lng: lng
            },
            wrapperSelector: false,
            hideWrapperOnError: true,
            callback: false,
            render: true
        }, options);

        return new HJI.streetView(
            settings.geoInfo,
            function()
            {
                if (settings.render === true)
                {
                    if (this.errorFlag && settings.wrapperSelector && settings.hideWrapperOnError)
                    {
                        $obj.css({'height' : 'auto'});

                        $obj.closest(settings.wrapperSelector).hide();
                    }
                    this.renderStreetView(settings.elementId);
                }

                if (settings.callback)
                {
                    if (typeof settings.callback === 'string')
                    {
                        window[settings.callback]();
                    }
                    else if (typeof settings.callback === 'function')
                    {
                        settings.callback();
                    }
                }
            }
        );

    }
})(jQuery);