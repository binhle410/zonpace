/**
 * ALLPAGE JS
 * START - ONLOAD - JS
 * 1. Main slider
 * 2. Sticky header
 * 3. JS Select2
 * 4. Datetime picker
 * 5. Filter Ranger
 * 6. Show Menu Mobile
 * 7. Hover Help Menu - Top Header
 * 8. Header Search Autocomplete
 * 9. Show Mobile Search
 */
var allpage_fn = {};
(function( $ ) {
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
        controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
        directionNav: false,             //Boolean: Create navigation for previous/next navigation? (true/false)
        prevText: "",           //String: Set the text for the "previous" directionNav item
        nextText: "",
        slideshowSpeed: 4000,
        pauseOnHover: false
    });
};
/**
 * 2. Sticky header
 */
allpage_fn.stickyHeader = function (offsetTop) {
    var body            =   $('body'),
        $header_wrap    =   $('.header-wrap'),
        $suggest_login  =   $('.blk-suggest-login'),
        offsetHeader    =   body.offset();

    $(window).scroll(function(){
        var scrollTop  = $(window).scrollTop();
        if(scrollTop > (offsetHeader.top + offsetTop)){
            $header_wrap.addClass('hd-fixed');
            $suggest_login.addClass('shw');
        } else {
            $header_wrap.removeClass('hd-fixed');
            $suggest_login.removeClass('shw');
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
    //if(!$('.input-daterange').length) { return; }

    $('.ipt-date').each(function() {
        $(this).datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });
    });
};
/**
 * 5. Filter Ranger
 */
allpage_fn.filterRanger = function (itmRanger) {
    if(!$(itmRanger).length) { return; }

    $(itmRanger).rangeSlider({
        wheelMode: "scroll",
        wheelSpeed: 30,
        bounds: {min: 0, max: 50},
        defaultValues:{min: 0, max: 20},
        // formatter:function(val){
        //     var value = Math.round(val * 5) / 5,
        //     decimal = value - Math.round(val);
        //     return decimal == 0 ? "$" + value.toString() : value.toString();
        // }
    });
};
/**
 * 6. Show Menu Mobile
 */
allpage_fn.showMenuMB = function () {
    if(!$('.a_menu').length) { return; }

    var w_scroll_window = 0;
    if (navigator.appVersion.indexOf("Win")!=-1) {
        w_scroll_window = 20;
    }

    $('.a_menu').on('click', function () {
        var $a_menu     =   $(this),
            $menu       =   $a_menu.closest('.header-logo').siblings('.header-menu'),
            $header     =   $a_menu.closest('.header-wrap');

        if($a_menu.hasClass('active')) {
            $a_menu.removeClass('active');
            $menu.removeClass('shw');
            $header.removeClass('z-ind');
        } else {
            $a_menu.addClass('active');
            $menu.addClass('shw');
            $header.addClass('z-ind');
        }
    });

    // click out
    if(($(window).width() + w_scroll_window) < 767 ) {
        $(".header-wrap").bind( "clickoutside", function(event){
            $('.a_menu').removeClass('active');
            $('.header-menu').removeClass('shw');
        });
    }
};
/**
 * 7. Show Menu Mobile
 */
allpage_fn.hoverHelpBlk = function () {
    //console.log($( window ).width());
    if ($(window).width() <= 980) {return;}
    if (!$('.hover-help-blk').length) {return;}
   
    $_this_hover = $('.hover-help-blk');

    $_this_hover.hover(function(e) {

        if ($(window).width() <= 980) {return;}
        $_this_hover.find('.help-blk').show();
    }, function() {
        if ($(window).width() <= 980) {return;}
        $_this_hover.find('.help-blk').hide();
        return;
    }, 250);
};
/**
 * 8. Header Search Autocomplete
 */
allpage_fn.searchAutocomplete = function () {
    if(!$('.header-search input').length) { return; }

    var options = {
      url: $('.header-search').data('href'),
      getValue: "name",
      list: {
        match: {
          enabled: true
        }
      },
      theme: "square"
    };

    $('.header-search input').easyAutocomplete(options);
};
/**
 * 9. Show Mobile Search
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
/* ----------------------------------------------- */
/* ----------------------------------------------- */
/* OnLoad Page */
$(document).ready(function($){
    // Main slider
    allpage_fn.mainSlider ('.main-slider');

    // sticky header
    allpage_fn.stickyHeader (0);

    // select 2
    allpage_fn.jsSelect2('.slect-lang');
    allpage_fn.jsSelect2('.slect-money');

    // datetime picker
    allpage_fn.datePicker();

    // filter ranger
    allpage_fn.filterRanger('#slider-ranger');

    // menu mobile
    allpage_fn.showMenuMB();

    // Hover HELP MENU TOP BAR
    allpage_fn.hoverHelpBlk();

    // search autocomplete
    allpage_fn.searchAutocomplete ();

    // show mobile search
    allpage_fn.showSearchMB ();

    // bootstrap tooltip
    $('[data-toggle="tooltip"]').tooltip();
});
/* OnLoad Window */
var init = function () {   

};
window.onload = init;
})(jQuery);
