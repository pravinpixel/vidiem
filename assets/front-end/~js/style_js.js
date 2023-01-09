$(document).ready(function(){
	
	$('.res_menu').click(function(){
		$('.menu').slideToggle(500);
	});
	
	$('.filter').click(function(){
		$('.product_filters').slideToggle(300);
	});
	
	
	$('.iclk').click(function(){
		if ($('.itog').css('display') == 'block')
		{
		   var val=$('.itog').val();
		   if(val!=''){
		   	   $('.search_form').submit();
		   }
		}
		$('.itog').slideToggle(500);
	});

	$('.compClose').click(function(){
		$('body').css('overflow','auto');
		$('.addCompSet').slideUp(500);
	});

	$('.mix_det_rt_add2').click(function(){
		$('.addCompSet').slideDown(500);
	});

	$('.comProRov').click(function(){
		$(this).parents('.comproList li').fadeOut(200);
	});

	$('.smcartClo').click(function(){
		$(this).parents('.addCartSmIn li').fadeOut(300);
	});

	//$('.AddCarHo').click(function(){
	//	$('.addCartSmIn').slideToggle(500);
	//});

	$('.inChanBill').click(function(){
		$('.changeBillAdd').slideDown(600);
	});

	$('.saveproCe').click(function(){
        $(this).parent().hide().next().slideDown(1000);
    });

	$('.fancybox').fancybox();

	$(window).on("scroll", function(){
        var headerFixed = $(window).scrollTop();

        if (headerFixed >= 80) {
            $('.header').addClass('fixed');
        }

        else {
            $('.header').removeClass('fixed');
        }
    });
    
    
    $(window).on("scroll", function(){
        var headerFixed = $(window).scrollTop();

        if (headerFixed >= 80) {
            $('.fixedf').addClass('fixedfi');
        }

        else {
            $('.fixedf').removeClass('fixedfi');
        }
    });
    
    // STAR RATING Script
        
        var $star_rating = $('.star-rating .fa');

		var SetRatingStar = function() {
		  return $star_rating.each(function() {
		    if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
		      return $(this).removeClass('fa-star-o').addClass('fa-star');
		    } else {
		      return $(this).removeClass('fa-star').addClass('fa-star-o');
		    }
		  });
		};

		$star_rating.on('click', function() {
		  $star_rating.siblings('input.rating-value').val($(this).data('rating'));
		  return SetRatingStar();
		});

	$("#owl-demo1").owlCarousel({
          autoPlay:5000, //Set AutoPlay to 3 seconds
          //items:4,
		  singleItem :true,
		  navigation:true,
		  navigationText : false,
		  pagination : false,
    });

    $("#owl-demo2").owlCarousel({
          autoPlay:3000, //Set AutoPlay to 3 seconds
          items:4,
           margin: '0 auto',
		  //singleItem :true,
		  navigation:false,
		  navigationText : false,
		  pagination : false,
    });

    $("#owl-demo3").owlCarousel({
          autoPlay:4000, //Set AutoPlay to 3 seconds
          items:3,
		  //singleItem :true,
		  navigation:false,
		  navigationText : false,
		  pagination : true,
    });

    $("#owl-demo4").owlCarousel({
          autoPlay:5000, //Set AutoPlay to 3 seconds
          //items:4,
		  singleItem :true,
		  navigation:false,
		  navigationText : false,
		  pagination : true,
    });
    
    $("#owl-demo5").owlCarousel({
          autoPlay:5000, //Set AutoPlay to 3 seconds
          //items:4,
		  singleItem :true,
		  navigation:false,
		  navigationText : false,
		  pagination : true,
    });

    $("#owl-demo6").owlCarousel({
          autoPlay:5000, //Set AutoPlay to 3 seconds
          items:4,
		  //singleItem :true,
		  navigation:true,
		  navigationText : false,
		  pagination : false,
    });

	//range slider
    $("#ex12c").slider({ id: "slider12c", min: 0, max: 7000, range: true, step:50, value: [0, 7000] });

    $(document).on('click','.tabCheckOut li.tab',function(){
			var tab_id = $(this).attr('data-tab');
			$('.tabCheckOut li').removeClass('current');
			$('.tab-content').removeClass('current');
			$(this).addClass('current');
			$("#"+tab_id).addClass('current');
	});

	$('.mix_list li').click(function(){
			
			var tab_id = $(this).attr('data-tab');
	
			$('.mix_list li').removeClass('current');
			$('.tab-content').removeClass('current');
	
			$(this).addClass('current');
			$("#"+tab_id).addClass('current');
	});

	$('.faqTab li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('.faqTab li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	});

	// $('.leftDashMenu .dasTabFun').click(function(){
	// 	var tab_id = $(this).attr('data-tab');

	// 	$('.leftDashMenu .dasTabFun').removeClass('current');
	// 	$('.tab-content').removeClass('current');

	// 	$(this).addClass('current');
	// 	$("#"+tab_id).addClass('current');
	// });

	//popup in recipe page
	$('#recipeCloseB').click(function(){
		$('.poppupRecipe').slideUp(300);
	});

	$('.menuListINREci li').click(function(){
		$('.poppupRecipe').slideDown(600);
	});





	$('.keySpec li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('.keySpec li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	});


	$(document).on('click','.glBtn',function(e) {
	    if ($(this).hasClass('grid')) {
	        $('.msec_2 .mix_list2').removeClass('list').addClass('grid');
	        $('.grid i').addClass('active');
	        $('.list i').removeClass('active');
	    }
	    
	    else if($(this).hasClass('list')) {
	        $('.msec_2 .mix_list2').removeClass('grid').addClass('list');
	         $('.list i').addClass('active');
	        $('.grid i').removeClass('active');
	    }
	});

    $(document).on('click','.QVpopup',function(){		
		$('.qviewPopup').addClass('qviewPopupAdCl');
	});

	$(document).on('click','.qvclose',function(){
		$('body').css('overflow','auto');
		$('.qviewPopup').removeClass('qviewPopupAdCl');
	});

	$('.zoThepro').zoom({ on:'click' });

	// FAQ Slide Toggle
  $('.question_trigger').click(function(){
      $('*.ans_section').not($(this).next('.ans_section')).slideUp(500);
      $('.question_trigger').not($(this)).removeClass('active');
      $(this).next('.ans_section').slideToggle(500);
      $(this).toggleClass('active');
  });

  $('.motSpecHead').click(function(){
  		$('.motorSpec .detSpecMot').not($(this).next('.detSpecMot')).slideUp(500);
  		$('.motSpecHead').not($(this)).removeClass('active');
  		$(this).next('.detSpecMot').slideToggle(500);
  		$(this).toggleClass('active');
  });

  $('.curorder').click(function(){
  	$('*.OrderListSectCu').not($(this).next('.OrderListSectCu')).slideUp(500);
  	$('.curorder').not($(this)).removeClass('active');
  	$(this).next('.OrderListSectCu').slideToggle(500);
  	$(this).toggleClass('active');
  });




	// Select all links with hashes
$('a[href*="#"]')
  // Remove links that don't actually link to anything
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
    ) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });

});

(function(o){var t={url:!1,callback:!1,target:!1,duration:120,on:"mouseover",touch:!0,onZoomIn:!1,onZoomOut:!1,magnify:1};o.zoom=function(t,n,e,i){var u,c,a,r,m,l,s,f=o(t),h=f.css("position"),d=o(n);return t.style.position=/(absolute|fixed)/.test(h)?h:"relative",t.style.overflow="hidden",e.style.width=e.style.height="",o(e).addClass("zoomImg").css({position:"absolute",top:0,left:0,opacity:0,width:e.width*i,height:e.height*i,border:"none",maxWidth:"none",maxHeight:"none"}).appendTo(t),{init:function(){c=f.outerWidth(),u=f.outerHeight(),n===t?(r=c,a=u):(r=d.outerWidth(),a=d.outerHeight()),m=(e.width-c)/r,l=(e.height-u)/a,s=d.offset()},move:function(o){var t=o.pageX-s.left,n=o.pageY-s.top;n=Math.max(Math.min(n,a),0),t=Math.max(Math.min(t,r),0),e.style.left=t*-m+"px",e.style.top=n*-l+"px"}}},o.fn.zoom=function(n){return this.each(function(){var e=o.extend({},t,n||{}),i=e.target&&o(e.target)[0]||this,u=this,c=o(u),a=document.createElement("img"),r=o(a),m="mousemove.zoom",l=!1,s=!1;if(!e.url){var f=u.querySelector("img");if(f&&(e.url=f.getAttribute("data-src")||f.currentSrc||f.src),!e.url)return}c.one("zoom.destroy",function(o,t){c.off(".zoom"),i.style.position=o,i.style.overflow=t,a.onload=null,r.remove()}.bind(this,i.style.position,i.style.overflow)),a.onload=function(){function t(t){f.init(),f.move(t),r.stop().fadeTo(o.support.opacity?e.duration:0,1,o.isFunction(e.onZoomIn)?e.onZoomIn.call(a):!1)}function n(){r.stop().fadeTo(e.duration,0,o.isFunction(e.onZoomOut)?e.onZoomOut.call(a):!1)}var f=o.zoom(i,u,a,e.magnify);"grab"===e.on?c.on("mousedown.zoom",function(e){1===e.which&&(o(document).one("mouseup.zoom",function(){n(),o(document).off(m,f.move)}),t(e),o(document).on(m,f.move),e.preventDefault())}):"click"===e.on?c.on("click.zoom",function(e){return l?void 0:(l=!0,t(e),o(document).on(m,f.move),o(document).one("click.zoom",function(){n(),l=!1,o(document).off(m,f.move)}),!1)}):"toggle"===e.on?c.on("click.zoom",function(o){l?n():t(o),l=!l}):"mouseover"===e.on&&(f.init(),c.on("mouseenter.zoom",t).on("mouseleave.zoom",n).on(m,f.move)),e.touch&&c.on("touchstart.zoom",function(o){o.preventDefault(),s?(s=!1,n()):(s=!0,t(o.originalEvent.touches[0]||o.originalEvent.changedTouches[0]))}).on("touchmove.zoom",function(o){o.preventDefault(),f.move(o.originalEvent.touches[0]||o.originalEvent.changedTouches[0])}).on("touchend.zoom",function(o){o.preventDefault(),s&&(s=!1,n())}),o.isFunction(e.callback)&&e.callback.call(a)},a.setAttribute("role","presentation"),a.alt="",a.src=e.url})},o.fn.zoom.defaults=t})(window.jQuery);


jQuery(function($) {
  
  // Function which adds the 'animated' class to any '.animatable' in view
  var doAnimations = function() {
    
    // Calc current offset and get all animatables
    var offset = $(window).scrollTop() + $(window).height(),
        $animatables = $('.animatable');
    
    // Unbind scroll handler if we have no animatables
    if ($animatables.size() == 0) {
      $(window).off('scroll', doAnimations);
    }
    
    // Check all animatables and animate them if necessary
        $animatables.each(function(i) {
       var $animatable = $(this);
            if (($animatable.offset().top + $animatable.height() - 100) < offset) {
        $animatable.removeClass('animatable').addClass('animated');
            }
    });

    };
  
  // Hook doAnimations on scroll, and trigger a scroll
    $(window).on('scroll', doAnimations);
  $(window).trigger('scroll');

});