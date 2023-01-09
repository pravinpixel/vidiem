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


$('.top-search').on('click', function(){
    $('.top-search-open').toggleClass('show');
	$(this).toggleClass('text-red');
});


$('.search-close').on('click', function(){
    $('.top-search-open').removeClass('show');
	$('.top-search').removeClass('text-red');
});


$('.product-carousel').owlCarousel({
    loop:true,
    margin:10,
    dots:true,
    nav:true,
    mouseDrag:true,
    autoplay:true,
    animateOut: 'slideOutUp',
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
    animateOut: 'slideOutUp',
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



$(window).scroll(function() {    
    var scroll = $(window).scrollTop();
     //console.log(scroll);
    if (scroll >= 50) {
        //console.log('a');
        $(".navbar").addClass("fixed");
    } else {
        //console.log('a');
        $(".navbar").removeClass("fixed");
    }
});

$('.navbar-nav .nav-link').hover(function() {
    $(this).trigger('click');
}, function() { });


$(window).scroll(function() {    
    var scroll = $(window).scrollTop();
     //console.log(scroll);
    if (scroll >= 300) {
        //console.log('a');
        $(".back-to-top").addClass("scrollfixed");
    } else {
        //console.log('a');
        $(".back-to-top").removeClass("scrollfixed");
    }
});

$("#subForm").validate();

  $('.back-to-top').click(function() {
    $('html, body').animate({
      scrollTop1: 0
    }, 1500, 'easeInOutExpo');
    return false;
  });
  
  
  $(document).ready(function(){
        $('#product-details-view .simpleLens-thumbnails-container img').simpleGallery({
            loading_image: 'assets/images/loading.gif',
            show_event: 'click'
        });

        $('#product-details-view .simpleLens-big-image').simpleLens({
            loading_image: 'assets/images/loading.gif',
        });
    });
  

})(jQuery);