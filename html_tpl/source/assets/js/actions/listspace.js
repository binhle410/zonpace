/**
 * LIST YOUR SPACE JS
 * 1. INIT MAP
 * 2. Upload Images
 * 3. Show Option Calendar Sidebar
 * 4. Calendar
 */
var listspace_fn = {};
(function( $ ) {
/* ----------------------------------------------- */
/* ------------- FrontEnd Functions -------------- */
/* ----------------------------------------------- */
/**
 * 1. INIT MAP
 */
listspace_fn.maps = {
	init: function () {
		if(!$('#location_map').length) { return; }
		var data_lat = $('#location_map').data('lat'),
			data_lng = $('#location_map').data('lng');
		var map = new google.maps.Map(document.getElementById('location_map'), {
          center: {lat: data_lat, lng: data_lng},
          zoom: 8,
          scrollwheel: false,
        });
	},
	streetView : function (data_lat, data_lng) {
		if(!$('#streetview-map').length) { return; }

		var data_lat = $('#streetview-map').data('lat'),
			data_lng = $('#streetview-map').data('lng');

		var panorama = new google.maps.StreetViewPanorama(
			document.getElementById('streetview-map'), {
				position: {lat: data_lat, lng: data_lng},
				addressControlOptions: {
				  position: google.maps.ControlPosition.TOP_LEFT
				},
				visible: true,
			    pov: {
					heading: 34,
					pitch: 10
			    }
		});
	}
};
/**
 * 2. Upload Images
 */
listspace_fn.uploadIMG = function () {
	$(".intro-upload").dropzone({
        url: "/file/post",
        maxFiles: 1,
        maxfilesexceeded: function(file) {
            this.removeAllFiles();
            this.addFile(file);
        }
    });
};
/**
 * 3. Show Option Calendar Sidebar
 */
listspace_fn.showOptCalendar = function () {
	if(!$('.opt-ttl').length) { return; }

	$('.opt-ttl').on('click', function (e) {
		var $a_title	=	$(this),
			$content	=	$a_title.siblings('.opt-content');

		if($a_title.hasClass('active')) {
			$a_title.removeClass('active');
			$content.removeClass('opt-shw');
		} else {
			$a_title.addClass('active');
			$content.addClass('opt-shw');
		}
	});
};
/**
 * 4. Calendar
 */
listspace_fn.calendar = {
	init : function () {
		$('#clndr').clndr({
			daysOfTheWeek: ['Sun', 'Mon', 'Tues', 'Wed', 'Thur', 'Fri', 'Sat'],
		});
	}
};
/* ----------------------------------------------- */
/* ----------------------------------------------- */
/* OnLoad Page */
$(document).ready(function($){
	// maps
	listspace_fn.maps.init();
	listspace_fn.maps.streetView();

	// upload img
	listspace_fn.uploadIMG();

	// show option calendar
	listspace_fn.showOptCalendar();

	// calendar
	listspace_fn.calendar.init();
});
/* OnLoad Window */
var init = function () {

};
window.onload = init;
})(jQuery);
