/**
 * AdminLTE Dashboard Common Script
 * Authour: J.Satham Ussain,
 * Email : satham.edu@gmail.com
 * ------------------
 */
 $(document).ready(function() {
 	var base_url=tmp_base_url+'Admin/';
 	// Dashboard Functionality
 	$('.sidebar-toggler').click(function() {
 		$.ajax({
 			url: base_url+'dashboard/sidebar_config',
			success:function(data){
				return true;
			}
 		});
 	});
    
    $('.table-export').click(function(){
	     $(".export_this").table2excel({
		    // exclude CSS class
		    exclude: ".noExl",
		    name: "Worksheet Name",
		    filename: "report" //do not include extension
	     });  
	}); 

 	 $('.select2').select2();

 	 // Input Mask
 	 $(":input").inputmask();

 	$('.theme-style-trigger>li>a').click(function(){
 		var data=$(this).attr('data-skin');
 		$.ajax({
 			url  : base_url+'dashboard/background_config',
 			type : 'POST',
 			data : 'style='+data,
			success:function(data){
				return true;
			}
 		});
 	});

 	// User Logout Confimation Code
 	$('.logout_trigger').click(function(){
			swal({
			  title: "Are you sure want to Logout?",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((Logout) => {
			  if (Logout) {
			    swal("Your Session will be Clear..", {
			      icon: "success",
			    }).then(() => {window.location.href = base_url+'logout';});
			  } else {
			    swal("Your session will continue..!","","info");
			  }
			});
	});	

    // Field Focus
    $('.focus_field').focus();

    // Image Upload Preview
	$(".imgUpload").on("change", function()
	{
		var x=$(this).parent().parent().find(".UploadImgPreview");
		var files = !!this.files ? this.files : [];
		if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
		if (/^image/.test( files[0].type)){ // only image file
			var reader = new FileReader(); // instance of the FileReader
			reader.readAsDataURL(files[0]); // read the local file
			reader.onloadend = function(){ // set image data as background of div
				x.attr("src",this.result);
			}
		}
	});

	// Image Viewer
	$(document).on('click','.img_view',function() {
		var data_url=$(this).attr('data-url');
		$('.modal-title-view').html('Image View');
		$('.modal-content-view').html("<img src='"+data_url+"' class='img-responsive' style='margin:0 auto;'>");
		$('#info-modal').modal('show');
	});

	// Common Delete All Function
	$(document).on('click','.delete_trigger',function(){
		 var data_url=$(this).attr('data-url');
		 swal({
			  title: "Are you sure want to delete?",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((Logout) => {
			  if (Logout) {
			    swal("Your File Will be Delete..", {
			      icon: "success",
			    }).then(() => {
			    	window.location.href = data_url;});
			  }
			});
	});


	$(document).on('click','.order_cacel_trigger',function(){
		 var data_url=$(this).attr('data-url');
		 swal({
			  title: "Are you sure want to cancel this order?",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((Logout) => {
			  if (Logout) {
			    swal("Your Order Will be Cancel..", {
			      icon: "success",
			    }).then(() => {
			    	window.location.href = data_url;});
			  }
			});
	});

	$(document).on('click','.trigger_cat_filter',function(){
		var id=$(this).attr('data-id');
		$.ajax({
			url:base_url+'category/categoryFilter',
			type:'POST',
			data:'id='+id,
			success:function(data){
				$('.product_filter_div').html(data);
				 $('.select2').select2({width: 'resolve'});
			}
		});
	});

	$(document).on('submit','.update_cat_filter',function(e){
		e.preventDefault();
		var data=$('.cat_filter_form').serialize();
		$.ajax({
			url:base_url+'category/UpdateFilters',
			type:'POST',
			data:data,
			success:function(data){
				$('.product_filter_div').html(data);
				 $('.select2').select2({width: 'resolve'});
			}
		})
	});

	$(document).on('change','.pro_cat_filter_trigger',function(){
		var cat=$(this).val();
		 $('input[type="search"]').val(cat).trigger('input');
	});

	// Master Functionality
	$(document).on('click','.trigger_filter_items',function(){
		var id=$(this).attr('data-id');
		$.ajax({
			url:base_url+'filters/AjaxFiltersItem',
			type:'POST',
			data:'id='+id,
			success:function(data){
				$('.product_feature_div').html(data);
			}
		});
	});

// Product Filters
$(document).on('click','.trigger_product_filter',function(){
	var id=$(this).attr('data-id');
	$.ajax({
		url:base_url+'products/AjaxFilters',
		type:'POST',
		data:'id='+id,
		success:function(data){
			$('.product_filter_div').html(data);
		}
	})
});

$(document).on('submit','.pro_filter_form',function(e){
	e.preventDefault();
	var data=$('.pro_filter_form').serialize();
	$.ajax({
		url:base_url+'products/AjaxProductFilter',
		type:'POST',
		data:data,
		success:function(data){
			$('.product_filter_div').html(data);
		}
	})
});
	// Feautre Submit

	$(document).on('click','.filter_submit',function(e){
		e.preventDefault();
		var data=$('.feautre_form').serialize();
		$.ajax({
			url:base_url+'filters/updateFilters',
			type:'POST',
			data:data,
			success:function(data){
				$('.product_feature_div').html(data);
			}
		});
	});

	$(document).on('click','.remove_filter',function(){
		var id=$(this).attr('data-id');
		var x=$(this).parent().parent();
		$.ajax({
			url:base_url+'filters/delete_filter',
			type:'POST',
			data:'id='+id,
			success:function(data){
				x.remove();
			}
		})
	});

	// Product Category
	$('.product_cat_trigger').change(function(){
		var cat_id=$(this).val();
		$.ajax({
				url: base_url+'products/AjaxSubCategory',
				type: 'POST',
				data: 'id='+cat_id,
				success:function(data){
					$('.sub_category').html(data);
				}
		   });
	});
	//product Register
	$(document).on('click','.product_register_view',function(){
		var data_id=$(this).attr('data-id');
		$.ajax({
			url: base_url+'productregister/AjaxSingleView',
			type: 'POST',
			dataType: 'json',
			data: {id: data_id},
			success:function(data){
				$('.modal-title-view').html(data.modal_title);
				$('.modal-content-view').html(data.modal_content);
			}
		});
		$('#info-modal').modal('show');
	});

	// Enquiry Replay
	$('.enquiry_replay').click(function(){
		var id=$(this).attr('data-id');
		var email=$(this).parent().parent().find('.mail_data').text();
		$('.enquiry_id').val(id);
		$('.enquiry_email').val(email);
	});

	$('.enquiry-mail').click(function(e){
		e.preventDefault();
		var id=$('.enquiry_id').val();
		var email=$('.enquiry_email').val();
		var reply_msg=$('.reply_msg').val();
		if(reply_msg==''){
			$('.reply_msg').addClass('error');
			return 0;
	    }else{
	    	$('.reply_msg').removeClass('error');
	    	$.ajax({
				url: base_url+'enquiry/ReplyEmail',
				type: 'POST',
				data: 'id='+id+'&email='+email+'&reply_msg='+reply_msg,
				success:function(data){
					$('#reply').modal('hide');
					swal("Your Reply Mail Sent to the Client", {
			      icon: "success",
			      title: "Mail Sent",
			    }).then(() => {window.location.href = "";});
				}
		   });
	    }
	});

	// Category Feauters Function 

	$('.trigger_cat_feautre').click(function(){
		var id=$(this).attr('data-id');
		$.ajax({
			url:base_url+'category/AjaxFeautres',
			type:'POST',
			data:'id='+id,
			success:function(data){
				$('.product_feature_div').html(data);
			}
		})
	});

	$(document).on('click','.add_feautre_trigger',function(){
		$('.feature_body').append('<tr><td><input type="hidden" name="hidden_id[]" value="0"></td><td><input type="text" name="name[]" class="form-control" value=""></td><td><input type="text" name="order_no[]" class="form-control" value=""></td><td><a href="javascript:void(0);" class="btn btn-danger remove_feautre_empty"><i class="fa fa-times"></i></a></td>');
	});

	$(document).on('click','.add_filter_trigger',function(){
		$('.feature_body').append('<tr><td><input type="hidden" name="hidden_id[]" value="0"></td><td><input type="text" name="name[]" class="form-control" value=""></td><td><a href="javascript:void(0);" class="btn btn-danger remove_feautre_empty"><i class="fa fa-times"></i></a></td>');
	});

	$(document).on('click','.remove_feautre_empty',function(){
		$(this).parent().parent().remove();
	});

	$(document).on('click','.remove_feautre',function(){
		var id=$(this).attr('data-id');
		var x=$(this).parent().parent();
		$.ajax({
			url:base_url+'category/delete_feautre',
			type:'POST',
			data:'id='+id,
			success:function(data){
				x.remove();
			}
		})
	});

	// Feautre Submit

	$(document).on('click','.feautre_submit',function(e){
		e.preventDefault();
		var data=$('.feautre_form').serialize();
		$.ajax({
			url:base_url+'category/updateCategoryFeautres',
			type:'POST',
			data:data,
			success:function(data){
				$('.product_feature_div').html(data);
			}
		});
	});

	$(document).on('click','.trigger_key_notes',function(){
		var id=$(this).attr('data-id');
		$.ajax({
			url:base_url+'products/AjaxKeyNotes',
			type:'POST',
			data:'id='+id,
			success:function(data){
				$('.product_feature_div').html(data);
			}
		})
	});

	$(document).on('click','.add_keynotes_trigger',function(){
		$('.feature_body').append('<tr><td><input type="hidden" name="hidden_id[]" value="0"></td><td><input type="text" name="name[]" class="form-control" value=""></td><td><textarea class="form-control" name="content[]"></textarea></td><td><input type="text" name="order_no[]" class="form-control" value=""></td><td><a href="javascript:void(0);" class="btn btn-danger remove_keynotes_empty"><i class="fa fa-times"></i></a></td>');
	});

	$(document).on('click','.remove_keynotes_empty',function(){
		$(this).parent().parent().remove();
	});

	$(document).on('click','.remove_keynotes',function(){
		var id=$(this).attr('data-id');
		var x=$(this).parent().parent();
		$.ajax({
			url:base_url+'products/delete_keynotes',
			type:'POST',
			data:'id='+id,
			success:function(data){
				x.remove();
			}
		})
	});

	// Feautre Submit

	$(document).on('click','.keynotes_submit',function(e){
		e.preventDefault();
		var data=$('.feautre_form').serialize();
		$.ajax({
			url:base_url+'products/updateKeyNotes',
			type:'POST',
			data:data,
			success:function(data){
				$('.product_feature_div').html(data);
			}
		});
	});

	// Product Feautres
	$(document).on('click','.trigger_product_feautre',function(){
		var id=$(this).attr('data-id');
		$.ajax({
			url:base_url+'products/AjaxFeautres',
			type:'POST',
			data:'id='+id,
			success:function(data){
				$('.product_feature_div').html(data);
			}
		});
	});

	$(document).on('click','.pro_feautre_submit',function(e){
		e.preventDefault();
		var data=$('.feautre_form').serialize();
		$.ajax({
			url:base_url+'products/UpdateProductFeautres',
			type:'POST',
			data:data,
			success:function(data){
				$('.product_feature_div').html(data);
			}
		});
    });
    
    // Order Status Management

    $(document).on('click','.trigger_order_status',function(){
		var data_id=$(this).attr('data-id');
		$.ajax({
			url: base_url+'orders/OrderStatusManagement',
			type: 'POST',
			dataType: 'json',
			data: {id: data_id},
			success:function(data){
				$('.order_id').val(data.id);
				$('.order_code').val(data.inv_code);
				$('.order_status').val(data.status);
				$('.order_courier').val(data.courier);
				$('.order_tracking_id').val(data.tracking_code);
				$('.order_notes').val(data.notes);
			}
		});
	});

	$('.update-order-status').click(function(e){
		e.preventDefault();
		var id=$('.order_id').val();
		var order_status=$('.order_status').val();
		var courier=$('.order_courier').val();
		var tracking_id=$('.order_tracking_id').val();
		var order_notes=$('.order_notes').val();
		if(order_status==2){
		    $('.courier_error,.tracking_error').html('');
		    var x=0;
		    if(courier==''){
		       $('.courier_error').html('Select Courier Partner');
		       x=1;
		    }
		    if(tracking_id==''){
		        $('.tracking_error').html('Enter Tracking Id');
		        x=1;
		    }
		    if(x==1){
		        return true;
		    }
		}
	    	$.ajax({
				url: base_url+'orders/OrderStatusUpdate',
				type: 'POST',
				data: {id:id,status:order_status,courier:courier,tracking_code:tracking_id,notes:order_notes},
				success:function(data){
					$('#feature').modal('hide');
						swal("Order Status updated successfully", {
						title: "Information",
						icon: "success",
					}).then(() => {window.location.href = '';});
				}
		   });

	});

	// Ajax Single View All List
	// Order View

	$(document).on('click','.order_view_trigger',function(){
		var data_id=$(this).attr('data-id');
		$.ajax({
			url: base_url+'orders/AjaxSingleView',
			type: 'POST',
			dataType: 'json',
			data: {id: data_id},
			success:function(data){
				$('.modal-title-view').html(data.modal_title);
				$('.modal-content-view').html(data.modal_content);
			}
		});
		$('#info-modal').modal('show');
	});

	$(document).on('click','.booking_view_trigger',function(){
		var data_id=$(this).attr('data-id');
		$.ajax({
			url: base_url+'orders/AjaxSingleViewBooking',
			type: 'POST',
			dataType: 'json',
			data: {id: data_id},
			success:function(data){
				$('.modal-title-view').html(data.modal_title);
				$('.modal-content-view').html(data.modal_content);
			}
		});
		$('#info-modal').modal('show');
	});

	// Category
	$(document).on('click','.category_view',function(){
		var data_id=$(this).attr('data-id');
		$.ajax({
			url: base_url+'category/AjaxSingleView',
			type: 'POST',
			dataType: 'json',
			data: {id: data_id},
			success:function(data){
				$('.modal-title-view').html(data.modal_title);
				$('.modal-content-view').html(data.modal_content);
			}
		});
		$('#info-modal').modal('show');
	});

	// Product
	$(document).on('click','.product_view',function(){
		var data_id=$(this).attr('data-id');
		$.ajax({
			url: base_url+'products/AjaxSingleView',
			type: 'POST',
			dataType: 'json',
			data: {id: data_id},
			success:function(data){
				$('.modal-title-view').html(data.modal_title);
				$('.modal-content-view').html(data.modal_content);
			}
		});
		$('#info-modal').modal('show');
	});

	$(document).on('click','.product_revision_view_trigger',function(){
		var data_id=$(this).attr('data-id');
		$.ajax({
			url: base_url+'products/AjaxProductRevisionList',
			type: 'POST',
			dataType: 'json',
			data: {id: data_id},
			success:function(data){
				$('.modal-title-view').html(data.modal_title);
				$('.modal-content-view').html(data.modal_content);
			}
		});
		$('#info-modal').modal('show');
	});

	$(document).on('click','.category_revision_view_trigger',function(){
		var data_id=$(this).attr('data-id');
		$.ajax({
			url: base_url+'category/AjaxCategoryRevisionList',
			type: 'POST',
			dataType: 'json',
			data: {id: data_id},
			success:function(data){
				$('.modal-title-view').html(data.modal_title);
				$('.modal-content-view').html(data.modal_content);
			}
		});
		$('#info-modal').modal('show');
	});

	$(document).on('click','.revision_category_view',function(){
		var data_id=$(this).attr('data-id');
		$.ajax({
			url: base_url+'category/AjaxSingleViewRevision',
			type: 'POST',
			dataType: 'json',
			data: {id: data_id},
			success:function(data){
				$('.modal-title-view').html(data.modal_title);
				$('.modal-content-view').html(data.modal_content);
			}
		});
		$('#info-modal').modal('show');
	});

	$(document).on('click','.revision_product_view',function(){
		var data_id=$(this).attr('data-id');
		$.ajax({
			url: base_url+'products/AjaxSingleViewRevision',
			type: 'POST',
			dataType: 'json',
			data: {id: data_id},
			success:function(data){
				$('.modal-title-view').html(data.modal_title);
				$('.modal-content-view').html(data.modal_content);
			}
		});
		$('#info-modal').modal('show');
	});

	$(document).on('click','.coupen_view',function(){
		var data_id=$(this).attr('data-id');
		$.ajax({
			url: base_url+'coupen/AjaxSingleView',
			type: 'POST',
			dataType: 'json',
			data: {id: data_id},
			success:function(data){
				$('.modal-title-view').html(data.modal_title);
				$('.modal-content-view').html(data.modal_content);
			}
		});
		$('#info-modal').modal('show');
	});
	
	var registerComplaintTable=$('#registerComplaintTable').DataTable({
	    "responsive": true,
	    "autoWidth": false,
	    "processing": true,
	    "pageLength": 10,
	    "serverSide": true,
	    'serverMethod': 'post',
	    "ajax": {
	        "url": base_url+"registration/complaint_registration_list",
	    },
	    "columns": [
	        { "data": "no","visible":false},
	        { "data": "id", },
	        { "data": "code", },
	        { "data": "category", },
	        { "data": "product", },
	        { "data": "serialnumer", },
	        { "data": "purchase_date", },
	        { "data": "dealername", },
	        { "data": "remarks", },	      
	        { "data": "name", },
	        { "data": "email", },
	        { "data": "mobile", },
	        { "data": "alternative_mobile", },	       
	        { "data": "address", },
	        { "data": "city", },
	        { "data": "state", },
	        { "data": "country", },
	        { "data": "pincode", },
	        { "data": "created", },
			{ "data": "action", "bSortable": false,"bSearchable": false, },
	    ]
	});

	var registerProductTable=$('#registerProductTable').DataTable({
	    "responsive": true,
	    "autoWidth": false,
	    "processing": true,
	    "pageLength": 10,
	    "serverSide": true,
	    'serverMethod': 'post',
	    "ajax": {
	        "url": base_url+"registration/product_registration_list",
	    },
	    "columns": [
	        { "data": "no","visible":false},
	        { "data": "id", },
	        { "data": "code", },
	        { "data": "category", },
	        { "data": "Product", },
	        { "data": "serialnumer", },
	        { "data": "jdate", },
			{ "data": "purchasefrom", },
	        { "data": "dealername", },
	        { "data": "gender", },
	        { "data": "name", },
	        { "data": "age", },
	        { "data": "email", },
	        { "data": "mobile", },
	        { "data": "occupation", },
	        { "data": "address", },
	        { "data": "city", },
	        { "data": "state", },
	        { "data": "country", },
	        { "data": "pincode", },
	        { "data": "created", },
			{ "data": "action", "bSortable": false,"bSearchable": false, },
	    ]
	});

	var registrationCategoryTable=$('#registrationCategoryTable').DataTable({
	    "responsive": true,
	    "autoWidth": false,
	    "processing": true,
	    "pageLength": 10,
	    "serverSide": true,
	    'serverMethod': 'post',
	    "ajax": {
	        "url": base_url+"CategoryRegistration/registration_category_list",
	    },
	    "columns": [
	        { "data": "no","visible":false},
	        { "data": "id", },
	        { "data": "category_name", },
	        { "data": "status",  "bSortable": false,"bSearchable": false, },
			{ "data": "action", "bSortable": false,"bSearchable": false, },
	    ]
	});

	var registrationProductTable=$('#registrationProductTable').DataTable({
	    "responsive": true,
	    "autoWidth": false,
	    "processing": true,
	    "pageLength": 10,
	    "serverSide": true,
	    'serverMethod': 'post',
	    "ajax": {
	        "url": base_url+"ProductRegistration/registration_product_list",
	    },
	    "columns": [
	        { "data": "no","visible":false},
	        { "data": "id", },
	        { "data": "product_name", },
	        { "data": "category_name", },
	        { "data": "status",  "bSortable": false,"bSearchable": false, },
			{ "data": "action", "bSortable": false,"bSearchable": false, },
	    ]
	});

	$(document).on('click', '.complaint-export-list', function () {
        $.ajax({
            url: base_url + 'registration/complaint_exports',
            data: {id:1},
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                var refwindow = window.open('?url=' + data.downloadurl, '_blank', 'location=no,hidden=yes,closebuttoncaption=Cerrar,toolbar=yes,enableViewportScale=yes');
                refwindow.close();
                var a = $("<a>");
                a.attr("href", data.file);
                $("body").append(a);
                a.attr("download", data.filename + ".xls");
                a[0].click();
                a.remove();
            }
        })
    });

    $(document).on('click', '.product-export-list', function () {
        $.ajax({
            url: base_url + 'registration/products_exports',
            data: {id:1},
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                var refwindow = window.open('?url=' + data.downloadurl, '_blank', 'location=no,hidden=yes,closebuttoncaption=Cerrar,toolbar=yes,enableViewportScale=yes');
                refwindow.close();
                var a = $("<a>");
                a.attr("href", data.file);
                $("body").append(a);
                a.attr("download", data.filename + ".xls");
                a[0].click();
                a.remove();
            }
        })
    });

}); 
function isNumber(evt) {
	var iKeyCode = (evt.which) ? evt.which : evt.keyCode
	if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
	  return false;
	return true;
  }

$('#-status-').on('show.bs.modal', function (e) {
	var removedLinkFull = $(e.relatedTarget).data('href');
	var message         = $(e.relatedTarget).data('message');
	var title           = $(e.relatedTarget).data('title');
	var method          = $(e.relatedTarget).data('method');
	$('#title').text(title);
	$('#message').text(message);
	$('#method').val(method);
	$('#remove-form').attr('action', removedLinkFull);
});