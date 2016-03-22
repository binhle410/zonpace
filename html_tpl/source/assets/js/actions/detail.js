/**
 * LOCATION DETAIL JS
 * 1. MAPs
 * 2. Grid layout
 * 3. Event click maps
 */
var detail_fn = {};
(function( $ ) {
/* ----------------------------------------------- */
/* ------------- FrontEnd Functions -------------- */
/* ----------------------------------------------- */
/**
 * 1. MAPs
 */
detail_fn.MAPs = {
	/**
	 * [init description]
	 * @return {[type]} [description]
	 */
	init: function () {
		var data_lat = $('#detail-map').data('lat'),
			data_lng = $('#detail-map').data('lng');

        var myLatlng = new google.maps.LatLng(data_lat, data_lng);
		var mapOptions = {
		  zoom: 15,
		  center: myLatlng,
		  scrollwheel: false,
		};

		var map = new google.maps.Map(document.getElementById("detail-map"), mapOptions);

		var marker = new google.maps.Marker({
		    position: myLatlng,
		    title:"Zonepace Maps"
		});

		// To add the marker to the map, call setMap();
		marker.setMap(map);
	},

	/**
	 * [streetView description]
	 * @return {[type]} [description]
	 */
	streetView : function (data_lat, data_lng) {
		console.log(1);
		var data_lat = $('#street-map').data('lat'),
			data_lng = $('#street-map').data('lng');

		var panorama = new google.maps.StreetViewPanorama(
			document.getElementById('street-map'), {
				position: {lat: 37.869260, lng: -122.254811},
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
 * 2. Grid layout
 */
detail_fn.gridLayout = function () {
	if(!$('.detail-comment .single-review').length) { return; }

	$('.detail-comment .cm-list').masonry({
		// set itemSelector so .grid-sizer is not used in layout
		itemSelector: '.single-review',
		percentPosition: true
	});
};
/**
 * 3. Event click maps
 */
detail_fn.evtClickMap = function (){
	if(!$('.path-right a').length) { return; }

	$('.path-right a').on('click', function (e) {
		if($(this).hasClass('view-street')) {
			if(!$(this).hasClass('active')) {
				$(this).addClass('active');
				$(this).siblings('a').removeClass('active');

				$(this).closest('.detai-location-path').siblings('.detail-map').find('#street-map').addClass('shw');
				$(this).closest('.detai-location-path').siblings('.detail-map').find('#street-map').removeClass('hiden');
				$(this).closest('.detai-location-path').siblings('.detail-map').find('#detail-map').addClass('hiden');
				$(this).closest('.detai-location-path').siblings('.detail-map').find('#detail-map').removeClass('shw');

				// invoke street view
				detail_fn.MAPs.streetView();
			}
		} else {
			if(!$(this).hasClass('active')) {
				$(this).addClass('active');
				$(this).siblings('a').removeClass('active');

				$(this).closest('.detai-location-path').siblings('.detail-map').find('#detail-map').addClass('shw');
				$(this).closest('.detai-location-path').siblings('.detail-map').find('#detail-map').removeClass('hiden');
				$(this).closest('.detai-location-path').siblings('.detail-map').find('#street-map').addClass('hiden');
				$(this).closest('.detai-location-path').siblings('.detail-map').find('#street-map').removeClass('shw');
			}
		}
	});
};
/* ----------------------------------------------- */
/* ----------------------------------------------- */
/* OnLoad Page */
$(document).ready(function($){
	// MAPs
	detail_fn.MAPs.init();

	// grid layout
	detail_fn.gridLayout ();

	// event click maps
	detail_fn.evtClickMap();
});
/* OnLoad Window */
var init = function () {   

};
window.onload = init;
})(jQuery);
