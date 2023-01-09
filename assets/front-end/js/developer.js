// Satham Ussain
// Mail: satham.edu@gmail.com
$(document).ready(function(){
	var base_url=tmp_base_url;
	$(document).on('click','li.filter_cat_trigger',function(){
		var cat=$(this).attr('data-tri');
		$('input[data-tri="'+cat+'"]').attr('checked','checked');
		 $('.serach_listing').html('');
		 $('html, body').animate({
        			'scrollTop' : $(".search_div").offset().top-350
    	});
		 $('*.cat_form_trigger').removeAttr('checked');
	});
	$(document).on('click','input.filter_cat_trigger',function(){
		var cat=$(this).attr('data-tri');
		$('.tab-link[data-tri="'+cat+'"]').trigger('click');
		$('.serach_listing').html('');
		 $('html, body').animate({
        			'scrollTop' : $(".search_div").offset().top-350
    	 });
    	 $('*.cat_form_trigger').removeAttr('checked');
	});
	
	$('.feRightCon ul>li> img').attr('src',''+base_url+'assets/front-end/images/checkbox_a.png');
    
    
    // Mastering Code

	$(document).on('click','.chkGuestLink',function(){
		$('p.error').html('');
		$('.chkGuestForm').removeClass('hide');
		$('.chkSignForm,.chkRegisterForm').addClass('hide');

		$('.chkGuestDiv').addClass('hide');
		$('.chkSignDiv,.chkRegisterDiv').removeClass('hide');

	});

	$(document).on('click','.chkSignLink',function(){
		$('p.error').html('');
		$('.chkSignForm').removeClass('hide');
		$('.chkGuestForm,.chkRegisterForm,.chkForgotForm').addClass('hide');

		$('.chkSignDiv').addClass('hide');
		$('.chkGuestDiv,.chkRegisterDiv').removeClass('hide');

	});

	$(document).on('click','.chkRegisterLink',function(){
		$('p.error').html('');
		$('.chkRegisterForm').removeClass('hide');
		$('.chkSignForm,.chkGuestForm').addClass('hide');

		$('.chkRegisterDiv').addClass('hide');
		$('.chkSignDiv,.chkGuestDiv').removeClass('hide');

	});

	$(document).on('click','.chkForgotLink',function(){
		$('.chkSignForm').addClass('hide');
		$('.chkGuestDiv,.chkRegisterDiv').addClass('hide');
		$('.chkForgotForm').removeClass('hide');
	});


	$('.complaint_category').change(function(){
		var cat_id=$(this).val();
		if(cat_id==''){
			$('.complaint_pro_list').html('<option value="">Select</option>');
		}else{
			$.ajax({
				url:base_url+'home/complaintProductFetch',
				data:{cat_id:cat_id},
				dataType:'json',
				type:'POST',
				success:function(data){
					$('.complaint_pro_list').html('<option value="">Select</option>');
					if(data.status==1){
						$.each(data.products,function(index,product){
							$('.complaint_pro_list').append(`<option value="${product.id}">${product.name}</option>`);
						});
					}
				}
			});
		}
	})

	$('.trigger_cancel_request').click(function(){
		$('.trigger_cancel_request_popup').slideDown();
		$('.order_cancel_id').val($(this).attr('data-id'));
		$('.cancel_reason').val('');
		$('.cancel_reason_text').addClass('hide');
	});

	$('.request_pop_close').click(function(){
		$('.trigger_cancel_request_popup').slideUp();
	})

	$('.trigger_cancel_request_submit').click(function(e){
		e.preventDefault();
		var id=$('.order_cancel_id').val();
		var reason=$('.cancel_reason').val();
		if(reason==''){
			$('.cancel_reason_text').removeClass('hide');
			return true;
		}
		$('.cancel_reason_text').addClass('hide');
		$.ajax({
			url  : base_url+'home/AjaxOrderCancel',
			type : 'POST',
			dataType:'json',
			data : {id:id,reason:reason},
			success:function(data){
			   swal("Order Cancel Updated", "We will contact you soon.", "success");
			   window.location.reload();
				return true;
			}
		});
	});

	$(document).on('click','.quick_view_trigger',function(){
		var id=$(this).attr('data-id');
		$.ajax({
			url:base_url+'home/AjaxProductInfo',
			type:'POST',
			data:'id='+id,
			success:function(data){
				$('.popup_product_info').html(data);
				$('.zoThepro').zoom({ on:'click' });
			}
		});
	});
	
	$('.recipe_view_trigger').click(function(){
		var id=$(this).attr('data-id');
		$.ajax({
			url:base_url+'home/AjaxRecipe',
			type:'POST',
			data:'id='+id,
			success:function(data){
				$('.popConSetRecipe').html(data);
			}
		});
	});
	
	$('.feedback_trigger').click(function(event) {
        var name=$('.input_fb_name').val();
        var comment=$('.input_fb_comment').val(); 
        if(name==''){
            $('.input_fb_name').addClass('error');
           // $('.input_fb_comment').addClass('error');
            return false;
        }
        
        $('.input_fb_name').removeClass('error');
        $('.input_fb_comment').removeClass('error'); 
        var id=$('.input_fb_id').val();
        var name=$('.input_fb_name').val();
        var rating=$('.input_fb_rating').val();
        var comment=$('.input_fb_comment').val(); 
         $.ajax({
                url  : base_url+'home/AjaxReview',
                type : 'POST',
                data : 'id='+id+'&name='+name+'&rating='+rating+'&comment='+comment,
                success:function(data){
                   swal("Thanks You", "Thanks for your Review. we will update soon.", "success");
                   $('.input_fb_name,.input_fb_comment').val('');
                    return true;
                }
        });

    });
	if($('.AddressUpdater').length > 0){
		AddressUpdater();
	}
	if($('.AddressUpdater').length > 0){
		AddressUpdater();
	}

	function AddressUpdater(){
		var id=$('.delivery_address_trigger').val();
		var same=$('.billing_trigger:checked').val();
		$.ajax({
			url:base_url+'home/AjaxFetchAddress',
			type:'POST',
			data:{id: id},
			dataType:'json',
			success:function(data){
				$('.delivery_address_div').html(data.address);
				if(same==1){
					$('.billing_address_div').html(data.address);
				}else{
					var id=$('.billing_address_trigger').val();
						$.ajax({
							url:base_url+'home/AjaxFetchAddress',
							type:'POST',
							data:{id: id},
							dataType:'json',
							success:function(data){
								$('.billing_address_div').html(data.address);
							}
						});
				}
			}
		});
	}

	// Master Code
	$('.add_address_trigger').click(function(){
		var type=$(this).attr('data-type');
		var shipping_id=$('.delivery_address_trigger').val();
		var billing_id=$('.billing_address_trigger').val();
		var same=$('.billing_trigger').is(':checked');
		if(same!=1){same=2;}else{same=1;}
		var url=base_url+'add-address/checkout?type='+type+'&shipping_id='+shipping_id+'&billing_id='+billing_id+'&same='+same;
		window.location.href = url;
	});

	$(document).on('click','.update_address_trigger',function(){
		var id=$(this).attr('data-id');
		var shipping_id=$('.delivery_address_trigger').val();
		var billing_id=$('.billing_address_trigger').val();
		var same=$('.billing_trigger').is(':checked');
		if(same!=1){same=2;}
		var url=base_url+'edit-address/'+id+'/checkout?&shipping_id='+shipping_id+'&billing_id='+billing_id+'&same='+same;
		window.location.href = url;
	});
	


	$('.compare_trigger').click(function(){
		$('.addCompSet').slideToggle();
	});

	// Product Availability Checked
	$('.product_availability').submit(function(e){
		e.preventDefault();
		var zipRegex = /^[1-9][0-9]{5}$/;
		var code=$('.pin_code').val();
		 if (!zipRegex.test(code))
            {
               	$('.availabile_status').html('Invalid zipcode');
            }else{
		$.ajax({
			url:base_url+'home/AjaxProductCheck',
			type:'POST',
			dataType:'json',
			data:{pincode: code},
			success:function(data){
				$('.availabile_status').html(data.msg);
			}
		});
	}
	});

	// Product Search
	$('.common_pro_range').on('slide',function(){
		console.log('Satham');
	});

	// Checkout Page Function
	$('.billing_trigger').change(function(){
		var same=$('.billing_trigger:checked').val();
		if(same==1){
			$('.billing_div').addClass('hide');
			var id=$('.delivery_address_trigger').val();
		}else{
			$('.billing_div').removeClass('hide');
			var id=$('.billing_address_trigger').val();
		}
		$.ajax({
			url:base_url+'home/AjaxFetchAddress',
			type:'POST',
			data:{id: id},
			dataType:'json',
			success:function(data){
				$('.billing_address_div').html(data.address);
			}
		});
	});

	$('.delivery_address_trigger').change(function(){
		var id=$(this).val();
		var same=$('.billing_trigger:checked').val();
		$.ajax({
			url:base_url+'home/AjaxFetchAddress',
			type:'POST',
			data:{id: id},
			dataType:'json',
			success:function(data){
				$('.delivery_address_div').html(data.address);
				if(same==1){
					$('.billing_address_div').html(data.address);
				}
			}
		});
	});

	$('.billing_address_trigger').change(function(){
		var id=$(this).val();
		$.ajax({
			url:base_url+'home/AjaxFetchAddress',
			type:'POST',
			data:{id: id},
			dataType:'json',
			success:function(data){
				$('.billing_address_div').html(data.address);
			}
		});
	});

	$('.address_move').click(function(e){
		e.preventDefault();
		var add=$('.delivery_address_trigger').val();
		if(add==null){
			swal("Information", "Add Address to Process Checkout", "warning");
		}
		else{
			if($('.billing_trigger').is(':checked')){
				$('.shipping_li').addClass('tab').trigger('click');
				 $('html, body').animate({
        			 'scrollTop' : $("body").offset().top+100
    			 });
			}else{
				var add=$('.billing_address_trigger').val();
				if(add==null){
					swal("Information", "Add Address to Process Checkout", "warning");
				}
				else{
					$('.shipping_li').addClass('tab').trigger('click');
					$('html, body').animate({
        			 'scrollTop' : $("body").offset().top+100
    			 	});
				}
			}
		}
	});

	$('.shipping_move').click(function(e){
		e.preventDefault();
		var same=$('.terms_trigger:checked').val();
		if(same!=1){
			swal("Information", "Agree Terms and condition to Process Checkout", "warning");
		}
		else{
			$('.payment_li').addClass('tab').trigger('click');
		}
	});

	// Category Filters 
	$('.cat_form_trigger').click(function(){
		cat_product_filter();
	});

	$(document).on('change','.cat_sort_trigger',function(){
		var sort=$(this).val();
		$('.input_sort').val(sort);
		cat_product_filter();
		
	});
 

if ($("#ex2").length > 0) {

	var originalVal;

	$('#ex2').slider().on('slideStart', function(ev){
	    originalVal = $('#ex2').data('slider').getValue();
	});

	 $('#ex2').slider().on('slideStop', function(ev){
	    var newVal = $('#ex2').data('slider').getValue();
	    if(originalVal != newVal) {
	        cat_product_filter();
			
	    }
	});
}


 function cat_product_filter(){
 	var data=$('.cat_filter_form').serialize();
		$.ajax({
			url:base_url+'home/AjaxProductFilter',
			type:'POST',
			data:data,
			dataType:'json',
			success:function(data){
				 $('.tab-content').removeClass('current');
				 $('.serach_listing').addClass('current').html(data.data);
				  $('html, body').animate({
        			 'scrollTop' : $(".search_div").offset().top-350
    			 });
			}
		})
 }

if ($("#ex3").length > 0) {
	var CatVal;

	$('#ex3').slider().on('slideStart', function(ev){
		CatVal = $('#ex3').data('slider').getValue();
	});

	$('#ex3').slider().on('slideStop', function(ev){
		var newVal = $('#ex3').data('slider').getValue();
		if(CatVal != newVal) {
		search_filter();
		}
	});
}

$(document).on('change','.serch_sort_trigger',function(){
		var sort=$(this).val();
		$('.input_sort').val(sort);
		search_filter();
	});
	
 function search_filter(){
 	var data=$('.cat_filter_form').serialize();
		$.ajax({
			url:base_url+'home/AjaxSearchFilter',
			type:'POST',
			data:data,
			dataType:'json',
			success:function(data){
				 $('.serach_listing').html(data.data);
			}
		})
 }


    
	// Product Compare
	$('.add_to_compare').click(function(){
		var id=$(this).attr('data-id');
		addtocompare(id);
	});
	
	function addtocompare(id){
		
		$.ajax({
			url:base_url+'home/Add_to_compare',
			data:'id='+id,
			type:'POST',
			success:function(data){
				var test=data.split('--@--');
				if(test[0]==1){
					 swal("Information", "Product Added", "success");
				}else if(test[0]==2){
					swal("Information", "Only Can Campare 3 Products..", "warning");
				}else if(test[0]==3){
					swal("Information", "Product Alredy Exists..", "warning");
				}else if(test[0]==4){
					swal("Information", "Alredy Product on Other Category", "information");
				}

				$('.comproList_section').html(test[1]);
			}
		});		
		
	}

	$(document).on('click','.remove_compare_products',function(){
		var id=$(this).attr('data-id');
		$.ajax({
			url:base_url+'home/Remove_From_compare',
			data:'id='+id,
			type:'POST',
			success:function(data){
				$('.comproList_section').html(data);
			}
		});
	});
	
	$(document).on('click','.remove_compare_all',function(){
		var id=1;
		$.ajax({
			url:base_url+'home/Remove_All_Compare',
			data:'id='+id,
			type:'POST',
			success:function(data){
				$('.comproList_section').html(data);
			}
		});
	});

	$('.compare_remove_reload').click(function(){
		var id=$(this).attr('data-id');
		$.ajax({
			url:base_url+'home/Remove_From_compare',
			data:'id='+id,
			type:'POST',
			success:function(data){
				location.reload();			
			}
		});
	});
	
	$('.compare_remove_all_reload').click(function(){
		var id=$(this).attr('data-id');
		$.ajax({
			url:base_url+'home/Remove_All_Compare',
			data:'id='+id,
			type:'POST',
			success:function(data){
				location.reload();			
			}
		});
	});

	// CheckOut Page Functionality
    $('.checkout_register').click(function(e){
    	e.preventDefault();
    	var data = $('.chkRegisterForm').serialize();
    	$.ajax({
    		url:base_url+'home/AjaxRegister',
    		type:'POST',
    		data:data,
    		dataType: 'json',
    		success:function(data){
    			if(data.status==1){
    				swal("Information", "Registered & Login Succesfully.", "success");
    				setTimeout(function(){ location.reload(); }, 1000);
    			}else if(data.status==2){
	    			$('.register_name_error').html(data.name);
	    			$('.register_dob_error').html(data.dob);
	    			$('.register_mail_error').html(data.email);
	    			$('.register_mobile_error').html(data.mobile_no);
	    			$('.register_password_error').html(data.password);
    			}
    		}
    	})
    });
    
    //guest register
    
        $('.guestcheckout_register').click(function(e){
    	e.preventDefault();
    	$(".login-loader").show();
    	var data = $('.chkGuestForm').serialize();
    	$.ajax({
    		url:base_url+'home/AjaxRegisterGuest',
    		type:'POST',
    		data:data,
    		dataType: 'json',
    		success:function(data){
    			if(data.status==1){
    				$('.guest-detail').hide();
    				$('.guest-otp').show();
    				$('.sms_code_success').html("OTP sent successfully to your mobile number!");
    			}else if(data.status==2){
	    			$('.guestregister_name_error').html(data.guestname);
	    			$('.guestregister_mail_error').html(data.guestemail);
	    			$('.guestregister_mobile_error').html(data.guestmobile_no);
    			}
    			$(".login-loader").hide();
    		}
    	})
    });
     $('.guest-otp-submit').click(function(e){
    	e.preventDefault();
    	$(".login-loader").show();
    	var data = $('.chkGuestForm').serialize();
    	$.ajax({
    		url:base_url+'home/AjaxOtpVerify',
    		type:'POST',
    		data:data,
    		dataType: 'json',
    		success:function(data){
    			if(data.status==1){
    				$('.sms_code_error').html('');
    				swal("Information", "Verified Succesfully and Logined as Guest.").then(function(){
                            window.location.href = data.redirect;
                       });
    			}else if(data.status==2){
	    			$('.sms_code_error').html(data.sms_code);
    			}
    			$(".login-loader").hide();
    		}
    	})
    });
      $('.guestcheckout_edit').click(function(e){
    	e.preventDefault();
    	$('.guest-detail').show();
    	$('.guest-otp').hide();
    });

     $('.checkout_verify').click(function(e){
    	e.preventDefault();
    	var data = $('.checkout_otpcode_form').serialize();
    	$.ajax({
    		url:base_url+'home/AjaxOtpVerify',
    		type:'POST',
    		data:data,
    		dataType: 'json',
    		success:function(data){
    			if(data.status==1){
    				$('.verify_otp_error').html('');
    				swal("Information", "Mobile No. verified Succesfully.", "success");
    				setTimeout(function(){ location.reload(); }, 1000);
    			}else if(data.status==2){
	    			$('.verify_otp_error').html(data.sms_code);
    			}
    		}
    	})
    });

     $('.checkout_sign_in').click(function(e){
    	e.preventDefault();
    	var data = $('.chkSignForm').serialize();
    	$.ajax({
    		url:base_url+'home/AjaxSignIn',
    		type:'POST',
    		data:data,
    		dataType: 'json',
    		success:function(data){
    			$('.signin_username_error,.signin_password_error').html('');
    			if(data.status==1){
    				swal("Information", "Login Succesfully.", "success");
    				setTimeout(function(){ location.reload(); }, 1000);
    			}else if(data.status==2){
	    			swal("Information", "Account suspended. Contact our team", "warning");
    			}else if(data.status==3){
	    			$('.checkout_sign_in_form').addClass('hide');
    				$('.checkout_otpcode_form').removeClass('hide');
    			}else if(data.status==4){
	    			$('.signin_username_error').html(data.user_name);
	    			$('.signin_password_error').html(data.password);
    			}
    		}
    	})
    });

     $('.checkout_forgot').click(function(e){
    	e.preventDefault();
    	var data = $('.chkForgotForm').serialize();
    	$.ajax({
    		url:base_url+'home/AjaxForgotPassword',
    		type:'POST',
    		data:data,
    		dataType: 'json',
    		success:function(data){
    			$('.forgot_email_error').html('');
    			if(data.status==1){
    				swal("Information", "New Password sent to your mail. ", "success");
    				$('.chkSignLink').trigger('click');
    			}else if(data.status==2){
	    			$('.forgot_email_error').html(data.email);
    			}
    		}
    	})
    });

	// Cart Functionality

	$(document).on('click','.add_to_cart',function(){
		var id=$(this).attr('data-id');
		$.ajax({
			url:base_url+'home/add_to_cart',
			type:'POST',
			data:'id='+id,
			success:function(data){
				var test=data.split('--@--');
				$('.cart_total_product').html(test[0]);
				$('.header_cart_section').html(test[1]);
				swal("Information",'Product added to cart!', "success");
			}
		});
	});

	$(document).on('click','.remove_from_cart',function(){
		var id=$(this).attr('data-id');
		$.ajax({
			url:base_url+'home/remove_from_cart',
			type:'POST',
			data:'id='+id,
			success:function(data){
				var test=data.split('--@--');
				$('.cart_total_product').html(test[0]);
				$('.header_cart_section').html(test[1]);
			}
		});
	});

	$(document).on('click','.remove_from_cart_page',function(){
		var id=$(this).attr('data-id');
		$.ajax({
			url:base_url+'home/remove_from_cart_page',
			type:'POST',
			data:'id='+id,
			success:function(data){
				var test=data.split('--@--');
				if(test[0]==1){
					$('.ck_product_listing').html(test[1]);
					$('.ck_product_pricing').html(test[2]);
				}
				else{
					$('.ck_product_all').html(test[1]);
				}
				// Recall for Header count Refresh
				$.ajax({
				url:base_url+'home/remove_from_cart',
				type:'POST',
				data:'id='+id,
				success:function(data){
					var test=data.split('--@--');
					$('.cart_total_product').html(test[0]);
					$('.header_cart_section').html(test[1]);
				}
				});
			}
		});
	});

	$(document).on('click','.increase',function(){
		var x=$(this).parent().find('.product_count');
		var count=x.val();
		var row_id=x.attr('data-id');
		$.ajax({
			url:base_url+'home/cart_product_update',
			type:'POST',
			data:'id='+row_id+'&count='+count+'&type=increase',
			success:function(data){
				var test=data.split('--@--');
				if(test[0]==1){
					$('.ck_product_listing').html(test[1]);
					$('.ck_product_pricing').html(test[2]);
				}
				else{
					$('.ck_product_all').html(test[1]);
				}
			}
		});
	});

	// Checkout Coupen Code
	$(document).on('click','.coupon_code_trigger',function(e){
		e.preventDefault();
		var code=$('.coupon_code').val();
		$.ajax({
			url:base_url+'home/coupon_check',
			type:'POST',
			data:{code:code},
			dataType:'json',
			success:function(data){
				if(data.status==2){
					
					swal("Information",data.msg, "warning");
					if(client_id==''){
						setTimeout(function(){
							window.location.href = base_url+'sign-in';
						}, 2000);
					
					}
					
				}else{
					swal("Information",'Coupon Code applied successfully..', "success");
					$('.ck_product_pricing').html(data.msg);
					$('.coupon_code').prop('readonly', true);
					$('.coupon_code_trigger').addClass('hide');
					$('.coupon_code_cancel').removeClass('hide');
				}
			}
		});
	});

	$('.coupon_code_cancel').click(function(e){
		e.preventDefault();
		$.ajax({ 
			url:base_url+'home/remove_coupon',
			type:'POST',
			data:'nounce=1',
			success:function(data){
				$('.ck_product_pricing').html(data);
			}
		});
		$('.coupon_code').prop('readonly', false).val('');
		$('.coupon_code_trigger').removeClass('hide');
		$('.coupon_code_cancel').addClass('hide');
	});
	
	
	// Checkout Coupen Code
	$(document).on('click','.custom_coupon_code_trigger',function(e){
		e.preventDefault();
		var code=$('.custom_coupon_code').val();
		$.ajax({
			url:base_url+'home/custom_coupon_check',
			type:'POST',
			data:{code:code},
			dataType:'json',
			success:function(data){
				if(data.status==2){
					
					swal("Information",data.msg, "warning");
					if(client_id==''){
						setTimeout(function(){
							window.location.href = base_url+'sign-in';
						}, 2000);
					
					}
					
				}else{
					swal("Information",'Coupon Code applied successfully..', "success");
					$('.ck_product_pricing').html(data.msg);
					$('.custom_coupon_code').prop('readonly', true);
					$('.custom_coupon_code_trigger').addClass('hide');
					$('.custom_coupon_code_cancel').removeClass('hide');
				}
			}
		});
	});

	$('.custom_coupon_code_cancel').click(function(e){
		e.preventDefault();
		$.ajax({ 
			url:base_url+'home/custom_remove_coupon',
			type:'POST',
			data:'nounce=1',
			success:function(data){
				$('.ck_product_pricing').html(data);
			}
		});
		$('.custom_coupon_code').prop('readonly', false).val('');
		$('.custom_coupon_code_trigger').removeClass('hide');
		$('.custom_coupon_code_cancel').addClass('hide');
	});
	


	$(document).on('click','.decrease',function(){
		var x=$(this).parent().find('.product_count');
		var count=x.val();
		var row_id=x.attr('data-id');
		$.ajax({
			url:base_url+'home/cart_product_update',
			type:'POST',
			data:'id='+row_id+'&count='+count+'&type=decrease',
			success:function(data){
				var test=data.split('--@--');
				if(test[0]==1){
					$('.ck_product_listing').html(test[1]);
					$('.ck_product_pricing').html(test[2]);
				}
				else{
					$('.ck_product_all').html(test[1]);
				}
			}
		});
	});
	


	// Mailchimp Functionality

	$('.newsletter_btn').click(function(){
		//subscribe(base_url);
	});

	$('.newsletter_form').submit(function(e){
		e.preventDefault();
		subscribe(base_url);
	});
	window.fbAsyncInit = function() {
                  FB.init({
                    appId      : '1441595949244042',
                    cookie     : true,   
                    status     : true,                  // Enable cookies to allow the server to access the session.
                    xfbml      : true,                     // Parse social plugins on this webpage.
                    version    : 'v9.0'           // Use this Graph API version for this call.
                  });
                };
                $(document).on('click','#fb-login-button',function(){
                     // $('#fb-login-loader').show();
                      FB.login(function(response) {
                         if (response.authResponse) {
                            console.log('Welcome!  Fetching your information.... ');
                            FB.api('/me?fields=id,name,email,picture,gender', function(response) {
                               myJSON = JSON.stringify(response);
                               console.log('Good to see you, ' + myJSON + '.');
                               var userEmail = response.email;
                               var userFBId = response.id;
                               var userName = response.name;
                               var userGender = response.gender;
                               var userPicture = response.picture;
                               if(userEmail!="" && userFBId!=""){
                               $.ajax({
                                  type:'POST',
                                  data: {
                                     userEmail: userEmail,
                                     userName: userName,
                                     userFBId: userFBId,
                                     userGender: userGender,
                                     userPicture:userPicture,
                                  },
                                  dataType:'json',
                                  url: base_url+"home/fb_login",
                                  success: function(resData) {
                                     if (resData.state == 1) {
                                       window.location.href = resData.redirect;
                                     } else {
                                        swal("Information",resData.message, "warning");
                                     }
                                  }
                               });
                                }else{
                                    swal("Information","Something went wrong. Please try after some time.", "warning");
                                }
                            });

                         } else {
                            console.log('User cancelled login or did not fully authorize.');

                         }
                      }, {
                         scope: 'public_profile,email'
                      });
                      //$('#fb-login-loader').hide();
                    });
					

// 08-02-2021

	// Same as shipping address for billing address
	
	$(document).on('click','.tigger-billingaddress',function(){	
		
		var same=$('#same_billing:checked').val();
		//alert(same);
		if(same==1){
			
			$('.billing_div').css('display','none');
		}else{
			
			$('.billing_div').css('display','block');
		}

	});	
	
		
					

});

function subscribe(base_url){
	var email=$('.newsletter_mail').val();
	if(!isValidEmailAddress(email)){
	swal("Information", "Enter Valid Email Id", "warning");
	 	return false;
	 }
	 $.ajax({
		   url:base_url+'home/Subscribe',
		   data:'email='+email,
		   type:'POST',
		   success:function(data){
		   	      $('.newsletter_mail').val('');
					 if(data==1){
					 	swal("Thank You", "Mail Id Subscribed", "success"); 	 
			         }
					 else if(data==2){
						swal("Information", "Mail Id Already Subscribed.", "warning");
						}
					 else{
					 	swal("Information", "Something Wrong...", "warning"); 	 
					}
			}
	});
}

function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
};