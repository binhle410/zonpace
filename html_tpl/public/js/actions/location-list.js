/**
 * LOCATION LIST JS
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
		var data_marker = $('#location-map').data('href');
		var map = new google.maps.Map(document.getElementById('location-map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8,
          scrollwheel: false,
        });

        location_fn.MAPs.setMaker(map, data_marker);
	},

	/**
	 * [setMaker description]
	 * @param {[type]} map [description]
	 */
	setMaker : function (map, data_marker) {
		$.ajax({
			url: data_marker
		}).done(function (data_marker){
			if(!data_marker || data_marker == undefined) { return;}

			var latlngbounds = new google.maps.LatLngBounds();
			for (var i = 0; i < data_marker.length; i++) {
				var data     = data_marker[i];

	            var myLatlng = new google.maps.LatLng(data.lat, data.lng);

				var marker = new RichMarker({
					position: myLatlng,
					map: map,
					draggable: false,
					content: '<div class="my-marker">' +
								'<div class="d-letter"> '+ data.letter + ' </div>' +
								'<div class="d-kilo"> '  + data.kilometer + ' miles </div>' +
								'</div>'
		        });
				marker.setFlat(!marker.getFlat());
				latlngbounds.extend(marker.position);
			}
			var bounds = new google.maps.LatLngBounds();
	        map.setCenter(latlngbounds.getCenter());
	        map.fitBounds(latlngbounds);
		});
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
