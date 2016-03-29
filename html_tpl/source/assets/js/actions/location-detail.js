/**
 * LOCATION DETAIL JS
 * 1. MAPs
 * 2. Grid layout
 * 3. Event click maps
 * 4. Tabs Terms
 * 5. gallery box
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
		var data_lat 		= $('#detail-map').data('lat'),
			data_lng 		= $('#detail-map').data('lng'),
			data_location	= $('#detail-map').data('href');

		var map = new google.maps.Map(document.getElementById('detail-map'), {
		    zoom: 17,
		    center: {lat: data_lat, lng: data_lng},
		    scrollwheel: false,
		    mapTypeId: google.maps.MapTypeId.TERRAIN
		});

		// get data location
		$.ajax({
			url      : data_location,
		}).done(function(data) {
			if (!data || data == undefined) { return; }
			// Construct the polygon.
			var bermudaTriangle = new google.maps.Polygon({
				paths: data,
				strokeColor: '#CF242A',
				strokeOpacity: 0.8,
				strokeWeight: 3,
				fillColor: '#D4666A',
				fillOpacity: 0.35
			});
			bermudaTriangle.setMap(map);
		});
	},
	/**
	 * [streetView description]
	 * @return {[type]} [description]
	 */
	streetView : function (data_lat, data_lng) {
		var data_lat = $('#street-map').data('lat'),
			data_lng = $('#street-map').data('lng');

		var panorama = new google.maps.StreetViewPanorama(
			document.getElementById('street-map'), {
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
		} else if($(this).hasClass('view-gallery')) {
			if(!$(this).hasClass('active')) {
				$(this).addClass('active');
				$(this).siblings('a').removeClass('active');

				$('.gl-item').click();
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
/**
 * 4. Tabs Terms
 */
detail_fn.tabsTerm = {
	/**
	 * [clickTabLongTerm description]
	 * @return {[type]} [description]
	 */
	clickTabLongTerm : function () {
		if(!$('.term-wrap .nav li').length) { return; }

		$('.term-wrap .nav li').on('click', function (e) {
			if($(this).hasClass('long-term')) {
				$(this).closest('.detail-map').addClass('h-580');
			} else {
				$(this).closest('.detail-map').removeClass('h-580');
			}
		});
	},
	/**
	 * [showSummary description]
	 * @return {[type]} [description]
	 */
	showSummary : function () {
		if(!$('.book-now').length) { return; }

		$('.book-now').on('click', function (e) {
			var $a_book		=	$(this),
				$blk_price	=	$a_book.closest('.get-price-form'),
				$blk_sum	=	$blk_price.siblings('.summary-form'),
				$blk_map	=	$a_book.closest('.detail-map'),
				$a_back		=	$blk_sum.find('.back-state');
			if(!$a_book.hasClass('active')) {
				$a_book.addClass('active');
				$blk_price.hide();
				$blk_sum.show();
				$blk_map.addClass('h-720');
				$a_back.removeClass('active');
			}
		});
	},
	/**
	 * [closeSummary description]
	 * @return {[type]} [description]
	 */
	closeSummary : function () {
		if(!$('.back-state').length) { return; }

		$('.back-state').on('click', function (e) {
			var $a_back		=	$(this),
				$blk_sum	=	$a_back.closest('.summary-form'),
				$blk_price	=	$blk_sum.siblings('.get-price-form'),
				$blk_map	=	$a_back.closest('.detail-map'),
				$a_book		=	$blk_price.find('.book-now');
			if(!$a_back.hasClass('active')) {
				$a_back.addClass('active');
				$blk_price.show();
				$blk_sum.hide();
				$blk_map.removeClass('h-720');
				$a_book.removeClass('active');
			}
		});
	},
	/**
	 * [showTermMB description]
	 * @return {[type]} [description]
	 */
	showTermMB : function () {
		if(!$('.mb_term').length) { return; }

    	$('.mb_term').on('click', function (e) {
    		var $a_term		=	$(this),
    			$body		=	$a_term.closest('body')
    			$term_wrap	=	$a_term.siblings('.blk-frm-term');

    		$term_wrap.addClass('shw-term-mb');
			$body.addClass('bd-fixed');
    	});
	},

	/**
	 * [closeTermMB description]
	 * @return {[type]} [description]
	 */
	closeTermMB : function () {
		if(!$('.mb-close-term').length) { return; }

    	$('.mb-close-term').on('click', function (e) {
    		var $a_term		=	$(this),
    			$body		=	$a_term.closest('body')
    			$term_wrap	=	$a_term.closest('.blk-frm-term');

    		$term_wrap.removeClass('shw-term-mb');
			$body.removeClass('bd-fixed');
    	});
	}
};
/**
 * 5. gallery box
 */
detail_fn.galleryBox = function () {
	if(!$('.gal-box').length) { return; }

	$('.gal-box').lightGallery({
		selector: '.gl-item',
		loop: true,
        fourceAutoply: false,
        autoplay: false,
        thumbnail: false,
        pager: $(window).width() >= 768 ? true : false,
        speed: 300,
        scale: 1,
        keypress: true,
        download: false
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

	// tabs
	detail_fn.tabsTerm.clickTabLongTerm ();
	detail_fn.tabsTerm.showSummary();
	detail_fn.tabsTerm.closeSummary();
	detail_fn.tabsTerm.showTermMB();
	detail_fn.tabsTerm.closeTermMB();

	// gallery
	detail_fn.galleryBox();
});
/* OnLoad Window */
var init = function () {

};
window.onload = init;
})(jQuery);
