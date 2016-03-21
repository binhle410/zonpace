/**
 * LOCATION JS
 * 1. MAPs
 * 2. Blk Filter Advances
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
/**
 * 2. Blk Filter Advances
 */
location_fn.blkFilterAdvance = {
	/**
	 * [show description]
	 * @return {[type]} [description]
	 */
	show: function () {
		if(!$('.a_filter').length ) { return; }

		$('.a_filter').on('click', function (e) {
			var $a_show		=	$(this),
				$blk_adv 	=	$a_show.closest('.inner').siblings('.box-filter'),
				$a_close	=	$blk_adv.find('.a_filter_close');

			if(!$a_show.hasClass('active')) {
				$a_show.addClass('active');
				$blk_adv.addClass('shw');
				$a_close.removeClass('active');
			}
		});
	},

	/**
	 * [hide description]
	 * @return {[type]} [description]
	 */
	hide: function () {
		if(!$('.a_filter_close').length) { return; }

		$('.a_filter_close').on('click', function (e) {
			var $a_close 	=	$(this),
				$blk_adv	=	$a_close.closest('.box-filter'),
				$a_show		=	$blk_adv.siblings('.inner').find('.a_filter');

			if(!$a_close.hasClass('active')) {
				$a_close.addClass('active');
				$blk_adv.removeClass('shw');
				$a_show.removeClass('active');
			}
		});
	},

	blkLocationList : function () {
		if(!$('.view_space').length) { return; }

		$('.view_space').on('click', function (e) {
			var $a_view		=	$(this),
				$list		=	$a_view.closest('.location-map').siblings('.location-list');

			if($a_view.hasClass('active')) {
				$a_view.removeClass('active');
				$list.removeClass('shw');
			} else {
				$a_view.addClass('active');
				$list.addClass('shw');
			}
		});	
	}
};
/* ----------------------------------------------- */
/* ----------------------------------------------- */
/* OnLoad Page */
$(document).ready(function($){
	// maps
	location_fn.MAPs.init();

	// blk advances filter
	location_fn.blkFilterAdvance.show();
	location_fn.blkFilterAdvance.hide();
	location_fn.blkFilterAdvance.blkLocationList();
});
/* OnLoad Window */
var init = function () {   

};
window.onload = init;
})(jQuery);
