/**
 * ALLPAGE JS
 * START - ONLOAD - JS
 * 1. Main slider
 * 2. Sticky header
 * 3. JS Select2
 * 4. Datetime picker
 * 5. Filter Ranger
 * 6 Show Mobile Search
 * 7. Show Menu Mobile
 */
var allpage_fn = {};
/* ----------------------------------------------- */
/* ------------- FrontEnd Functions -------------- */
/* ----------------------------------------------- */
/**
 * 1. Main slider
 */
allpage_fn.mainSlider = function (itmSlider) {
    if(!$(itmSlider).length) { return; }

    $(itmSlider).flexslider({
        animation: "fade",
        // Primary Controls
        controlNav: true,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
        directionNav: false,             //Boolean: Create navigation for previous/next navigation? (true/false)
        prevText: "",           //String: Set the text for the "previous" directionNav item
        nextText: "",
        slideshowSpeed: 4000,
        pauseOnHover: false,
        slideshow: true
    });
};
/**
 * 2. Sticky header
 */
allpage_fn.stickyHeader = function () {
    var body            =   $('body'),
        $header_wrap    =   $('.header-wrap'),
        offsetHeader    =   body.offset();

    $(window).scroll(function(){
        var scrollTop  = $(window).scrollTop();
        if(scrollTop > (offsetHeader.top + 100)){
            $header_wrap.addClass('hd-fixed');
        } else {
            $header_wrap.removeClass('hd-fixed');
        }
    });
};
/**
 * 3. JS Select2
 */
allpage_fn.jsSelect2 = function (itmSelect) {
    if(!$(itmSelect).length) { return; }

    $(itmSelect).select2();
};
/**
 * 4. Datetime picker
 */
allpage_fn.datePicker = function () {
    if(!$('.ipt-date').length) { return; }

    $('.ipt-date').each(function() {
        $(this).datetimepicker({
            dayViewHeaderFormat: 'MMMM YYYY',
            pickTime: false,
            format: 'DD-MM-YYYY'
        });
    });
};
/**
 * 5. Filter Ranger
 */
allpage_fn.filterRanger = function (itmRanger) {
    if(!$(itmRanger).length) { return; }

     $( itmRanger ).each(function () {
         var data_min   = $(this).data('min'),
            data_max    = $(this).data('max'),
            data_valmin = $(this).data('valmin'),
            data_valmax = $(this).data('valmax'),
            data_step   = $(this).data('step'),
            data_type   = $(this).data('type');
         $(this).slider({
            range: true,
            min: data_min,
            max: data_max,
            values: [ data_valmin, data_valmax ],
            step: data_step,
            slide: function( event, ui ) {
                if(data_type == "price") {
                    // original
                    $(this).siblings('.f-num').text( "$" + data_valmin );
                    $(this).siblings('.l-num').text( "$" + data_valmax + "+");

                    // after slider
                    $(this).siblings('.f-num').text( "$" + ui.values[ 0 ] );
                    $(this).siblings('.l-num').text( "$" + ui.values[ 1 ]  + "+");
                } else {
                    // original
                    $(this).siblings('.f-num').text( data_valmin );
                    $(this).siblings('.l-num').text( data_valmax );

                    // after slider
                    $(this).siblings('.f-num').text( ui.values[ 0 ] );
                    $(this).siblings('.l-num').text( ui.values[ 1 ]  + "+");
                }
            }
        });
     });
};
/**
 * 6 . Show Mobile Search
 */
allpage_fn.showSearchMB = function () {
    if(!$('.a_search').length) { return; }

    var w_scroll_window = 0;
    if (navigator.appVersion.indexOf("Win")!=-1) {
        w_scroll_window = 20;
    }

    $('.a_search').on('click', function () {
        var $a_seach     =   $(this),
            $icon        =   $a_seach.find('.fa'),
            $blk_search  =   $a_seach.siblings('.header-search'),
            $header      =   $a_seach.closest('.header-wrap');

        if($a_seach.hasClass('active')) {
            $a_seach.removeClass('active');
            $blk_search.removeClass('shw');
            $header.removeClass('z-ind');
            $icon.addClass('fa-search');
            $icon.removeClass('fa-times');
        } else {
            $a_seach.addClass('active');
            $blk_search.addClass('shw');
            $header.addClass('z-ind');
            $icon.removeClass('fa-search');
            $icon.addClass('fa-times');
        }
    });

    // click out
    if(($(window).width() + w_scroll_window) < 767 ) {
        $(".header-wrap").bind( "clickoutside", function(event){
            $('.a_search').removeClass('active');
            $('.header-search').removeClass('shw');
            $('.a_search .fa').addClass('fa-search');
            $('.a_search .fa').removeClass('fa-times');
        });
    }
};
/**
 * 7. Show Menu Mobile
 */
allpage_fn.menuMobile = {
    /**
     * [show description]
     * @return {[type]} [description]
     */
    showMN : function () {
        if(!$('.a_menu').length) { return; }

        $('.a_menu').on('click', function(e) {
            e.preventDefault();
            var $a_menu     =   $(this),
                $menu       =   $a_menu.closest('.header-wrap').siblings('.menu-mobile'),
                $body       =   $a_menu.closest('body');

            if($a_menu.hasClass('active')) {
                $a_menu.removeClass('active');
                $menu.removeClass('shw');
                $body.removeClass('mn-opening');
            } else {
                $a_menu.addClass('active');
                $menu.addClass('shw');
                $body.addClass('mn-opening');
            }
        });

        // click out
        $(document).on('click', function (e) {
            if($(e.target).is('.a_menu')
                || $(e.target).is('.a_menu *')
                || $(e.target).is('.menu-mobile-inner')
                || $(e.target).is('.menu-mobile-inner *')) { return; }

            $('.a_menu').removeClass('active');
            $('.menu-mobile').removeClass('shw');
            $('body').removeClass('mn-opening');
        });
    },

    /**
     * [hideMN description]
     * @return {[type]} [description]
     */
    hideMN : function () {
        $('.a_close').on('click', function (e) {
            e.preventDefault();
            var $a_close    =   $(this),
                $menu       =   $a_close.closest('.menu-mobile'),
                $a_menu     =   $menu.siblings('.header-wrap').find('.a_menu'),
                $body       =   $a_close.closest('body');

            $a_menu.removeClass('active');
            $menu.removeClass('shw');
            $body.removeClass('mn-opening');
        });
    }   
}
/* ----------------------------------------------- */
/* ----------------------------------------------- */
/* OnLoad Page */
$(document).ready(function($){
    // Main slider
    allpage_fn.mainSlider('.main-slider');

    // select 2
    allpage_fn.jsSelect2('.slect-lang');
    allpage_fn.jsSelect2('.slect-money');

    // datetime picker
    allpage_fn.datePicker();

    // filter ranger
    allpage_fn.filterRanger('#feet-slider');
    allpage_fn.filterRanger('#price-slider');

    // show mobile search
    allpage_fn.showSearchMB ();

    // show menu mobile
    allpage_fn.menuMobile.showMN ();
    allpage_fn.menuMobile.hideMN ();
});
/* OnLoad Window */
var init = function () {   

};
window.onload = init;
