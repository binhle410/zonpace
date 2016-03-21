/**
 * LOCATION DETAIL JS
 * 1. MAPs
 * 2. Grid layout
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
		}

		var map = new google.maps.Map(document.getElementById("detail-map"), mapOptions);

		var marker = new google.maps.Marker({
		    position: myLatlng,
		    title:"Hello World!"
		});

		// To add the marker to the map, call setMap();
		marker.setMap(map);
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
	})
};
/* ----------------------------------------------- */
/* ----------------------------------------------- */
/* OnLoad Page */
$(document).ready(function($){
	// MAPs
	detail_fn.MAPs.init();

	// grid layout
	detail_fn.gridLayout ();
});
/* OnLoad Window */
var init = function () {   

};
window.onload = init;
})(jQuery);
