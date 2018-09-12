(function( $ ) {
/**
 * START - ONLOAD - JS
 * 1. Set Height Home Slider
 * 2. JQuery Slider
 * 3. Sticky Hotline
 * 4. Main Slider
 * 5. Menu Mobile
 * 6. Plugin Checkbox
 * 7. Product Gallery
 * 8. Show Search Header
 * 9. Menu Club Lilial
 */
/* ----------------------------------------------- */
/* ------------- FrontEnd Functions -------------- */
/* ----------------------------------------------- */
/**
 * 1. Set Height Home Slider
 */
function setHeightHomeSlider() {
    if(!$('.home-slider').length
        || $(window).width() <= 1200) { return;}

    var w_height = $(window).height();
    $('.home-slider').css('height', w_height);

    $( window ).resize(
        $.debounce(300, function(e){
            if($(window).width() <= 1200) { return; }
            
            var w_height = $(window).height();
            $('.home-slider').css('height', w_height);
        })
    );
}
/**
 * 2. JQuery Slider
 */
function runSlider (objSlide, speed,  numShow, isCenter) {
    if(!$( objSlide )
    || (objSlide === '.logo-slider' && $(window).width() <= 767)) { return; }
    
    $( objSlide).each(function() {
        $( this ).slick({
            infinite: true,
            autoplay: true,
            autoplaySpeed: speed,
            speed: 300,
            slidesToShow: numShow,
            slidesToScroll: 1,
            centerMode: isCenter ? true : false,
            variableWidth: true,
            arrows: false,
            dots: true,
        });
    });
};
/**
 * 3. Sticky Hotline
 */
function stickHotline () {
    if(!$('.hotline-side').length) { return; }

    $(window).scroll(function(){
        var mainTop = $('.blk-main-content').offset().top;
        
        var scrollTop  = $(window).scrollTop() ;
        if(scrollTop > mainTop){
            $('.hotline-side').addClass('fixed');
        } else {
            $('.hotline-side').removeClass('fixed');
        }
    });
}
/**
 * 4. Main Slider
 */
function mainSlider (objSlide) {
    if(!$( objSlide )) { return; }
  
    $( objSlide ).slick({
        autoplay: true,
        autoplaySpeed: 4000,
        speed: 300,
        centerMode: false,
        variableWidth: false,
        arrows: false,
        dots: false,
        fade: true,
    });
};
/**
 * 5. Menu Mobile
 */
function menuMobile() {
    if(!$('.hd_menu').length) { return; }

    $('.hd_menu').on('click', function(e) {
        e.preventDefault();

        var $a_menu = $(this),
            $body   = $a_menu.closest('body'),
            $menu   = $a_menu.siblings('.col-menu').find('.grp-menu'),
            $icon   = $a_menu.find('.ico');

        if($a_menu.hasClass('active')) {
            $a_menu.removeClass('active');
            $menu.removeClass('shw');
            $body.removeClass('mn-open');

            $icon.removeClass('ico-close');
            $icon.addClass('ico-bars');
        } else {
            $a_menu.addClass('active');
            $menu.addClass('shw');
            $body.addClass('mn-open');

            $icon.removeClass('ico-bars');
            $icon.addClass('ico-close');
        }
    });

    // click out
    $(".header-wrap").bind( "clickoutside", function(event){
        $('.hd_menu').removeClass('active');
        $('.grp-menu').removeClass('shw');
        $('body').removeClass('mn-open');

        $('.hd_menu .ico').removeClass('ico-close');
        $('.hd_menu .ico').addClass('ico-bars');
    });
}
// 5.1
function appendHtmlMenuMB() {
    if(!$('.col-menu').length) { return; }

    $('.col-menu .menu li').each(function(e) {
        if($(this).hasClass('has-child')) {
            $(this).append('<span class="shw_menu"><i class="fa fa-plus"></i><span>')
        }
    });

    // 5.3 show sub-menu
    showSubMenuMB();
}
// 5.3 show sub-menu
function showSubMenuMB() {
    if(!$('.shw_menu').length) { return; }

    $('.shw_menu').on('click', function(e) {
        e.preventDefault();

        var $a_click  =     $(this),
            $sub_menu =     $a_click.siblings('.sub-menu'),
            $li       =     $a_click.closest('.has-child').siblings('.has-child'),
            $icon     =     $a_click.find('.fa');

        if($a_click.hasClass('act')) {
            $a_click.removeClass('act');
            $sub_menu.hide();

            // change icon
            $icon.addClass('fa-plus');
            $icon.removeClass('fa-minus');
        } else {
            $a_click.addClass('act');
            $sub_menu.show();

            // close menu siblings
            $li.find('.shw_menu').removeClass('act');
            $li.find('.sub-menu').hide();
            $li.find('.fa').addClass('fa-plus');
            $li.find('.fa').removeClass('fa-minus');;

            // change icon
            $icon.removeClass('fa-plus');
            $icon.addClass('fa-minus');
        }
    });
}
/**
 * 6. Plugin Checkbox
 */
function pluginCheckbox(itemCheckbox) {
    if(!$(itemCheckbox).length) { return; }

    $(itemCheckbox).checkboxpicker();
}
/**
 * 7. Product Gallery
 */
function gallerySlider() {
    if(!$('.main-gallery').length) { return; }

    $('.main-gallery').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.thumb-gallery'
    });
    $('.thumb-gallery').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        asNavFor: '.main-gallery',
        dots: false,
        centerMode: false,
        focusOnSelect: true,
        variableWidth: true,
        infinite: false,
        arrows: true
    });
}

/**
 * 7.1 Gallery Zoom
 */
function galleryZoom() {
    if (!$('.main-gallery').length) {return;}
    $('.main-gallery').lightGallery({
        mode:"slide",
        speed : 400,
        selector: '.gal-item',
        download: false
    });
}
/**
 * 8. Show Search Header
 */
function showSearchHeader() {
    if(!$('.search-wrap').length) { return; }

    $('.hd_search').on('click', function(e) {
        e.preventDefault();

        var $a_search   =   $(this),
            $search     =   $a_search.siblings('.search-wrap');

        if($a_search.hasClass('active')) {
            $a_search.removeClass('active');
            $search.removeClass('shw');
        } else {
            $a_search.addClass('active');
            $search.addClass('shw');
        }
    });

    // click out
    $(".header-wrap").bind( "clickoutside", function(event){
        $('.hd_search').removeClass('active');
        $('.search-wrap').removeClass('shw');
    });
}
/**
 * 9. Menu Club Lilial
 */
function menuClub() {
    if(!$('.hd-club-wrap').length) { return; }

    if ($(window).width() > 992) {
        $('.hd-club-wrap').hoverIntent({
            interval: 200,
            timeout: 200,
            over: function() {
                $(this).find('.sub-menu').addClass('shw');
            },
            out: function() {
                $(this).find('.sub-menu').removeClass('shw');
            }
        });
    } else {
        $('.hd_club').on('click', function(e) {
            e.preventDefault();

            var $a_club = $(this),
                $menu   = $a_club.siblings('.sub-menu');      
                
            if($a_club.hasClass('act')) {
                $a_club.removeClass('act')
                $menu.removeClass('shw');
            } else {
                $a_club.addClass('act')
                $menu.addClass('shw');
            }
        });

        // click out
        $(".hd-club-wrap").bind( "clickoutside", function(event){
            $('.hd_club').removeClass('act')
            $('.sub-menu').removeClass('shw');
        });
    }
}
/* ----------------------------------------------- */
/* ----------------------------------------------- */
/* OnLoad Page */
$(document).ready(function($){
    // 1.
    setHeightHomeSlider();

    // 2. 
    runSlider('.logo-slider', 3000, 4);
    runSlider('.home-product .product-list', 5000, 1);
    runSlider('.nw-list-slider', 3000, 1, true);
    runSlider('.product-access .product-list', 4000, 1, true);

    // 3. 
    stickHotline();

    // 4.
    mainSlider('.home-slider .main-slider');

    // 5. 
    menuMobile();

    // 5.1
    appendHtmlMenuMB();

    // 6. 
    pluginCheckbox('.ipt-checkbox');

    // 7.
    gallerySlider();

    // 7.1
    galleryZoom();

    // 8.
    showSearchHeader();

    // 9. 
    menuClub();

    // stop video when close modal
    $('#myVideo').on('hidden.bs.modal', function () {
        $('.youtube_player_iframe').each(function(){
            var el_src = $(this).attr("src");
            $(this).attr("src",el_src);
        });
    })
});
/* OnLoad Window */
var init = function () {

};
window.onload = init;
})(jQuery);