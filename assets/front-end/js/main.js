(function($) {
  "use strict";
  
  AOS.init();
  
  // Preloader
  $(window).on('load', function() {
    if ($('#preloader').length) {
      $('#preloader').delay(100).fadeOut('slow', function() {
        $(this).remove();
      });
    }
  });

$('.datepicker').datepicker({
    autoclose: true,
	format: 'yyyy-mm-dd',
	endDate: '+0d',
});

$("#thumbs-scroll").mCustomScrollbar({
	theme:"dark-thin",
	setHeight:400,
	scrollButtons:{enable:true},
});


$('.top-search').on('click', function(){
    $('.top-search-open').toggleClass('show');
	$(this).toggleClass('text-red');
});


$('.search-close').on('click', function(){
    $('.top-search-open').removeClass('show');
	$('.top-search').removeClass('text-red');
});

$('.collapse').on('shown.bs.collapse', function () {
        $(this).prev().addClass('active-acc');
    });

    $('.collapse').on('hidden.bs.collapse', function () {
        $(this).prev().removeClass('active-acc');
    });

// $('.collapse').on('shown.bs.collapse', function(e) {
//  var $card = $(this).closest('.card');
//  $('html,body').animate({
//    scrollTop: $card.offset().top -100
//  }, 500);
// });



$('.product-carousel').owlCarousel({
    loop:true,
    margin:10,
	slideBy: 3,
    dots:true,
    nav:true,
    mouseDrag:true,
    autoplay:false,
	smartSpeed: 1000, 
    autoplayTimeout:4000,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:2
        },
        1200:{
            items:3
        },
        1601:{
            items:4
        }
    }
});

$('.product-details-carousel').owlCarousel({
    loop:true,
    margin:30,
    dots:true,
    nav:true,
    mouseDrag:true,
    autoplay:true,
	smartSpeed: 3000, 
    autoplayTimeout:4000,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        },
        1200:{
            items:4
        }
    }
});


$('.testimonial_owlCarousel').owlCarousel({
    loop:true,
    margin:10,
    dots:false,
    nav:true,
    autoplay:false,   
    smartSpeed: 3000, 
    autoplayTimeout:4000,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})


$('.team-carousel').owlCarousel({
    loop:true,
    margin:20,
    dots:true,
    nav:true,
    mouseDrag:true,
    autoplay:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        },
        1200:{
            items:4
        }
    }
});

$('.awards-carousel').owlCarousel({
    loop:true,
    margin:20,
    dots:true,
    nav:true,
    mouseDrag:true,
    autoplay:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:2
        },
        1200:{
            items:2
        }
    }
});


$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

$(window).scroll(function() {    
    var scroll = $(window).scrollTop();
    if (scroll >= 50) {
        $("#header").addClass("fixed");
    } else {
        $("#header").removeClass("fixed");
    }
});



$(window).scroll(function() {    
    var scroll = $(window).scrollTop();
    if (scroll >= 150) {
        $(".cart-tab").addClass("fixed");
    } else {
        $(".cart-tab").removeClass("fixed");
    }
});





if ($(window).width() > 1200) {
		$('.navbar-nav .nav-link').hover(function() {
			$(this).trigger('click');
		}, function() { });
  }


$(window).scroll(function() {    
    var scroll = $(window).scrollTop();
    if (scroll >= 300) {
        $(".back-to-top").addClass("scrollfixed");
    } else {
        $(".back-to-top").removeClass("scrollfixed");
    }
});


$('.back-to-top').click(function() {
    $('html, body').animate({
      scrollTop: 0
    }, 500);
    return false;
  });

$("#subForm").validate();

$(window).scroll(function() {    
    var scroll = $(window).scrollTop();
    if (scroll >= 1200) {
        $(".navigation").addClass("fixed");
    } else {
        $(".navigation").removeClass("fixed");
    }
});

$(window).scroll(function() {    
    var scroll = $(window).scrollTop();
    if (scroll >= 800) {
        $(".product-details-colors").addClass("fixed-bottom");
    } else {
        $(".product-details-colors").removeClass("fixed-bottom");
    }
});

$('.collapse').on('shown.bs.collapse', function () {
        $(this).prev().addClass('active-acc');
    });

    $('.collapse').on('hidden.bs.collapse', function () {
        $(this).prev().removeClass('active-acc');
    });

$('.collapse').on('shown.bs.collapse', function(e) {
  var $card = $(this).closest('.card');
  $('html,body').animate({
    scrollTop: $card.offset().top -100
  }, 500);
});

$('.stop-video').on('click', function() { 
$('.product-video')[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*'); 
});

	
$("#country, #city, #state, #filters, #state_ship, #stateee, #menucategory, #menucategory, #category, #product").select2({
     allowClear: false
});


//document.querySelector(".card-flip").classList.toggle("flip");

})(jQuery);