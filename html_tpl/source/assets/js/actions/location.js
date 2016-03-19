/**
 * CATPAGE JS
 * 1. MAPs
 */
var location_fn = {};
(function( $ ) {
/* ----------------------------------------------- */
/* ------------- FrontEnd Functions -------------- */
/* ----------------------------------------------- */
/**
 * 1. MAPs
 */
location_fn.MAPs = {
	/**
	 * [init description]
	 * @return {[type]} [description]
	 */
	init: function () {
		var map = new google.maps.Map(document.getElementById('location-map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8,
          scrollwheel: false,
        });

        location_fn.MAPs.setMaker(map);
	},

	/**
	 * [setMaker description]
	 * @param {[type]} map [description]
	 */
	setMaker : function (map) {
		var markers = [
		    {
		        "title": 'Aksa Beach',
		        "lat": 19.1759668,
		        "lng": 72.79504659999998,
		        "description": 'Aksa Beach is a popular beach and a vacation spot in Aksa village at Malad, Mumbai.'
		    },
		    {
		        "title": 'Juhu Beach',
		        "lat": 19.0883595,
		        "lng": 72.82652380000002,
		        "description": 'Juhu Beach is one of favorite tourist attractions situated in Mumbai.'
		    },
		    {
		        "title": 'Girgaum Beach',
		        "lat": 18.9542149,
		        "lng": 72.81203529999993,
		        "description": 'Girgaum Beach commonly known as just Chaupati is one of the most famous public beaches in Mumbai.'
		    },
		    {
		        "title": 'Jijamata Udyan',
		        "lat": 18.979006,
		        "lng": 72.83388300000001,
		        "description": 'Jijamata Udyan is situated near Byculla station is famous as Mumbai (Bombay) Zoo.'
		    },
		    {
		        "title": 'Sanjay Gandhi National Park',
		        "lat": 19.2147067,
		        "lng": 72.91062020000004,
		        "description": 'Sanjay Gandhi National Park is a large protected area in the northern part of Mumbai city.'
		    }
		];
		var latlngbounds = new google.maps.LatLngBounds();
		for (var i = 0; i < markers.length; i++) {
			var data = markers[i]
            var myLatlng = new google.maps.LatLng(data.lat, data.lng);

			var marker = new google.maps.Marker({
			  position: {lat: data.lat, lng: data.lng},
			  map: map,
			  title: data.title
			});
			latlngbounds.extend(marker.position);
		}
		var bounds = new google.maps.LatLngBounds();
        map.setCenter(latlngbounds.getCenter());
        map.fitBounds(latlngbounds);
	}
};
/* ----------------------------------------------- */
/* ----------------------------------------------- */
/* OnLoad Page */
$(document).ready(function($){

	// maps
	location_fn.MAPs.init();
});
/* OnLoad Window */
var init = function () {   

};
window.onload = init;
})(jQuery);
