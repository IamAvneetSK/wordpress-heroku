(function($) {
    "use strict";

    var realEstateMaps = {};
    qode.modules.realEstateMaps = realEstateMaps;
    realEstateMaps.qodefInitMultipleRealEstateMap = qodefInitMultipleRealEstateMap;
    realEstateMaps.qodefInitSingleRealEstateMap = qodefInitSingleRealEstateMap;
    realEstateMaps.qodefInitMobileMap = qodefInitMobileMap;
    realEstateMaps.qodefReinitMultipleGoogleMaps = qodefReinitMultipleGoogleMaps;
    realEstateMaps.qodefGoogleMaps = {};

    $(document).ready(qodefOnDocumentReady);
    $(window).on('load', qodefOnWindowLoad);
    $(window).resize(qodefOnWindowResize);
    $(window).scroll(qodefOnWindowScroll);

    function qodefOnDocumentReady() {}

    function qodefOnWindowLoad() {
        qodefInitSingleRealEstateMap();
        qodefInitMultipleRealEstateMap();
        qodefInitMobileMap();
        qodefBindListTitlesAndMap();
    }

    function qodefOnWindowResize() {}

    function qodefOnWindowScroll() {}

    function qodefInitSingleRealEstateMap() {
        var mapHolder = $('#qodef-re-single-map-holder');
        if ( mapHolder.length ) {
            qode.modules.realEstateMaps.qodefGoogleMaps.getDirectoryItemAddress({
                mapHolder: 'qodef-re-single-map-holder'
            });
        }
    }

    function qodefInitMultipleRealEstateMap() {
        var mapHolder = $('#qodef-re-multiple-map-holder');
        if ( mapHolder.length ) {
            qode.modules.realEstateMaps.qodefGoogleMaps.getDirectoryItemsAddresses({
                mapHolder: 'qodef-re-multiple-map-holder',
                hasFilter: true
            });
        }
    }

    realEstateMaps.qodefGoogleMaps = {

        //Object varibles
        mapHolder : {},
        map : {},
        markers : {},
        radius : {},

        /**
         * Returns map with single address
         *
         * @param options
         */
        getDirectoryItemAddress : function( options ) {
            /**
             * use qodefMapsVars to get variables for address, latitude, longitude by default
             */
            var defaults = {
                location : qodefSingleMapVars.single['currentRealEstate'].location,
                zoom : 16,
                mapHolder : '',
                draggable : qodefMapsVars.global.draggable,
                mapTypeControl : qodefMapsVars.global.mapTypeControl,
                scrollwheel : qodefMapsVars.global.scrollable,
                streetViewControl : qodefMapsVars.global.streetViewControl,
                zoomControl : qodefMapsVars.global.zoomControl,
                title : qodefSingleMapVars.single['currentRealEstate'].title,
                itemId : qodefSingleMapVars.single['currentRealEstate'].itemId,
                content : '',
                styles: qodefMapsVars.global.mapStyle,
                markerPin : qodefSingleMapVars.single['currentRealEstate'].markerPin,
                featuredImage : qodefSingleMapVars.single['currentRealEstate'].featuredImage,
                itemUrl : qodefSingleMapVars.single['currentRealEstate'].itemUrl
            };
            var settings = $.extend( {}, defaults, options );

            //Save variables for later usage
            this.mapHolder = settings.mapHolder;

            //Get map holder
            var mapHolder = document.getElementById( settings.mapHolder );

            //Initialize map
            var map = new google.maps.Map( mapHolder, {
                zoom : settings.zoom,
                draggable : settings.draggable,
                mapTypeControl : settings.mapTypeControl,
                scrollwheel : settings.scrollwheel,
                streetViewControl : settings.streetViewControl,
                zoomControl : settings.zoomControl
            });

            //Set map style
            map.setOptions({
                styles: settings.styles
            });

            //Try to locate by latitude and longitude
            if ( typeof settings.location !== 'undefined' && settings.location !== null) {
                var latLong = {
                    lat : parseFloat(settings.location.latitude),
                    lng : parseFloat(settings.location.longitude)
                };
                //Set map center to location
                map.setCenter(latLong);
                //Add marker to map

                var templateData = {
                    title : settings.title,
                    itemId : settings.itemId,
                    address : settings.location.address,
                    featuredImage : settings.featuredImage,
                    itemUrl : settings.itemUrl
                };

                var customMarker = new CustomMarker({
                    map : map,
                    position : latLong,
                    templateData : templateData,
                    markerPin : settings.markerPin
                });

                this.initMarkerInfo();

            }

        },

        /**
         * Returns map with multiple addresses
         *
         * @param options
         */
        getDirectoryItemsAddresses : function( options ) {
            var defaults = {
                geolocation : false,
                mapHolder : 'qodef-re-multiple-map-holder',
                addresses : qodefMultipleMapVars.multiple.addresses,
                draggable : qodefMapsVars.global.draggable,
                mapTypeControl : qodefMapsVars.global.mapTypeControl,
                scrollwheel : qodefMapsVars.global.scrollable,
                streetViewControl : qodefMapsVars.global.streetViewControl,
                zoomControl : qodefMapsVars.global.zoomControl,
                zoom : 16,
                styles: qodefMapsVars.global.mapStyle,
                radius : 50, //radius for marker visibility, in km
                hasFilter : false
            };
            var settings = $.extend({}, defaults, options );

            //Get map holder
            var mapHolder = document.getElementById( settings.mapHolder );

            //Initialize map
            var map = new google.maps.Map( mapHolder, {
                zoom : settings.zoom,
                draggable : settings.draggable,
                mapTypeControl : settings.mapTypeControl,
                scrollwheel : settings.scrollwheel,
                streetViewControl : settings.streetViewControl,
                zoomControl : settings.zoomControl
            });

            //Save variables for later usage
            this.mapHolder = settings.mapHolder;
            this.map = map;
            this.radius = settings.radius;

            //Set map style
            map.setOptions({
                styles: settings.styles
            });

            //If geolocation enabled set map center to user location
            if ( navigator.geolocation && settings.geolocation ) {
                this.centerOnCurrentLocation();
            }

            //Filter addresses, remove items without latitude and longitude
            var addresses = [],
                addressesLength = settings.addresses.length;
            if(settings.addresses.length !== null){
                for ( var i = 0; i < addressesLength; i++ ) {
                    var location = settings.addresses[i].location;
                    if ( typeof location !== 'undefined' && location !== null ) {

                        if ( location.latitude !== '' && location.longitude !== '' ) {
                            addresses.push(settings.addresses[i]);
                        }
                    }
                }
            }


            //Center map and set borders of map
            this.setMapBounds( addresses );

            //Add markers to the map
            this.addMultipleMarkers( addresses );

        },

        /**
         * Add multiple markers to map
         */
        addMultipleMarkers : function( markersData ) {

            var map = this.map;

            var markers = [];
            //Loop through markers
            var len = markersData.length;
            for ( var i = 0; i < len; i++ ) {

                var latLng = {
                    lat: parseFloat(markersData[i].location.latitude),
                    lng: parseFloat(markersData[i].location.longitude)
                };

                //Custom html markers
                //Insert marker data into info window template
                var templateData = {
                    title : markersData[i].title,
                    itemId : markersData[i].itemId,
                    address : markersData[i].location.address,
                    featuredImage : markersData[i].featuredImage,
                    itemUrl : markersData[i].itemUrl
                };

                var customMarker = new CustomMarker({
                    position : latLng,
                    map : map,
                    templateData : templateData,
                    markerPin : markersData[i].markerPin
                });

                markers.push(customMarker);

            }

            this.markers = markers;

            //Init map clusters ( Grouping map markers at small zoom values )
            this.initMapClusters();

            //Init marker info
            this.initMarkerInfo();

            //Init visible circle area around center of map
            var that = this;
            google.maps.event.addListener(map, 'idle', function(){
                var visibleRadius = new google.maps.Circle({
                    strokeColor: '#FF0000',
                    strokeOpacity: 0,
                    strokeWeight: 0,
                    fillColor: '#FF0000',
                    fillOpacity: 0,
                    map: map,
                    center: map.getCenter(),
                    radius: that.radius * 1000 //in meters
                });
                //Display only markers in circle
                //that.refreshCircleAreaMarkers( visibleRadius.getBounds() );
            });

        },

        /**
         * Set map bounds for Map with multiple markers
         *
         * @param addressesArray
         */
        setMapBounds : function( addressesArray ) {

            var bounds = new google.maps.LatLngBounds();
            for ( var i = 0; i < addressesArray.length; i++ ) {
                bounds.extend( new google.maps.LatLng( parseFloat(addressesArray[i].location.latitude), parseFloat(addressesArray[i].location.longitude) ) );
            }

            this.map.fitBounds( bounds );

        },

        /**
         * Init map clusters for grouping markers on small zoom values
         */
        initMapClusters : function() {

            //Activate clustering on multiple markers
            var markerClusteringOptions = {
                minimumClusterSize: 2,
                maxZoom: 12,
                styles : [{
                    width: 50,
                    height: 60,
                    url: '',
                    textSize: 12
                }]
            };
            var markerClusterer = new MarkerClusterer(this.map, this.markers, markerClusteringOptions);

        },

        initMarkerInfo : function() {

            $(document).off('click', '.qodef-map-marker');
            $(document).on('click', '.qodef-map-marker', function() {
                var self = $(this),
                    markerHolders = $('.qodef-map-marker-holder'),
                    infoWindows = $('.qodef-info-window'),
                    markerHolder = self.parent('.qodef-map-marker-holder'),
                    infoWindow = self.siblings('.qodef-info-window');

                if ( markerHolder.hasClass('active mapActive') ) {
                    markerHolder.removeClass( 'active mapActive' );
                    infoWindow.fadeOut(0);
                } else {
                    markerHolders.removeClass('active mapActive');
                    infoWindows.fadeOut(0);
                    markerHolder.addClass('active mapActive');
                    infoWindow.fadeIn(300);
                }

            });

        },
        /**
         * Info Window for displaying data on map markers
         *
         * @returns {google.maps.InfoWindow}
         */
        addInfoWindow : function() {

            var contentString = '';
            var infoWindow = new google.maps.InfoWindow({
                content: contentString
            });
            return infoWindow;

        },

        /**
         * If geolocation enabled center map on users current position
         */
        centerOnCurrentLocation : function() {
            var map = this.map;
            navigator.geolocation.getCurrentPosition(
                function(position){
                    var center = {
                        lat : position.coords.latitude,
                        lng : position.coords.longitude
                    };
                    map.setCenter(center);
                }
            );
        },

        /**
         * Refresh area for visible markers
         *
         * @param circleArea
         */
        refreshCircleAreaMarkers : function( circleArea ) {

            var length = this.markers.length;
            for ( var i = 0; i < length; i++ ) {
                if ( circleArea.contains( this.markers[i].getPosition() ) ) {
                    this.markers[i].setVisible(true);
                } else {
                    this.markers[i].setVisible(false);
                }
            }

        },

    };

    function qodefInitMobileMap() {

        var mapOpener = $('.qodef-re-view-larger-map a'),
            mapOpenerIcon = mapOpener.children('i'),
            mapHolder = $('.qodef-map-holder');
        if (mapOpener.length) {
            mapOpener.on('click', function (e) {
                e.preventDefault();
                if (mapHolder.hasClass('qodef-fullscreen-map')) {
                    mapHolder.removeClass('qodef-fullscreen-map');
                    mapOpenerIcon.removeClass('icon-basic-magnifier-minus');
                    mapOpenerIcon.addClass('icon-basic-magnifier-plus');
                } else {
                    mapHolder.addClass('qodef-fullscreen-map');
                    mapOpenerIcon.removeClass('icon-basic-magnifier-plus');
                    mapOpenerIcon.addClass('icon-basic-magnifier-minus');
                }
                qode.modules.realEstateMaps.qodefGoogleMaps.getDirectoryItemsAddresses();
            });
        }
    }

    function qodefReinitMultipleGoogleMaps(addresses, action){

        if(action === 'append'){

            var mapObjs = qodefMultipleMapVars.multiple.addresses;
            mapObjs = qodefMultipleMapVars.multiple.addresses.concat(addresses);
            qodefMultipleMapVars.multiple.addresses = mapObjs;

            qode.modules.realEstateMaps.qodefGoogleMaps.getDirectoryItemsAddresses({
                addresses: mapObjs
            });
        }
        else if(action === 'replace'){

            qodefMultipleMapVars.multiple.addresses = addresses;
            qode.modules.realEstateMaps.qodefGoogleMaps.getDirectoryItemsAddresses({
                addresses: addresses
            });

        }

        qodefBindListTitlesAndMap();
    }

    function qodefBindListTitlesAndMap() {
        var itemsList = $('.qodef-map-list-holder');
        if(itemsList.length){
            itemsList.each(function(){
                var thisItemsList = $(this),
                    itemsHolder = thisItemsList.find('.qodef-ml-inner'),
                    listItems = thisItemsList.find('article'),
                    map = thisItemsList.find('.qodef-map-list-map-part');

                if(map.length) {
                    listItems.each(function() {
                        //Init hover
                        var listItem = $(this);
                        if(!listItem.hasClass("qodef-init")) {
                            listItem.mouseenter(function () {
                                var itemId = listItem.attr('id');
                                var markersHolder = $('.qodef-map-marker-holder:not(.mapActive)');
                                if (markersHolder.length) {
                                    markersHolder.removeClass('active');
                                    $('#' + itemId + '.qodef-map-marker-holder').addClass('active');
                                }
                            });
                            listItem.addClass("qodef-init")
                        }
                    });
                    itemsHolder.mouseleave(function () {
                        $('.qodef-map-marker-holder').each(function() {
                            if(!$(this).hasClass('mapActive')) {
                                $(this).removeClass('active');
                            }
                        });
                    });
                }
            });
        }
    }

})(jQuery);