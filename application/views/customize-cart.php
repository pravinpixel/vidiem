<?php include('container/header.php'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="bgPro proDetaPage clearfix light-gray-bg">
	<form method="POST" id="custom_order_form" action="<?= base_url('customize-checkout'); ?>">
	<section class="checkOutDet clearfix ck_product_all pt-4">
	<div class="container">
			<div class="row">
				<div class="col">
					<h2>Your Cart</h2>
					<ul class="cart-tab my-4">
						<li>
							<a class="active" href="<?= base_url('customize-cart'); ?>">
								<span>01</span> Shopping <small>Cart</small>
							</a>
						</li>
						<li>
							<a href="<?= base_url('customize-checkout'); ?>">
								<span>02</span> Account &amp; <small>Shipping</small>
							</a>
						</li>
						<li>
							<a href="order-confirm.php" style="pointer-events: none;">
								<span>03</span> Order <small>Confirmation</small>
							</a>
						</li>
					</ul>
				</div>
			</div>
	<div class="row ck_product_all">
	<div class="col-sm-12 col-md-12 col-lg-12 col-xl-8">
<style>
.coupen input.custom_coupon_code {
    background: #ececec;
    border: none;
    padding: 5px 10px;
    line-height: 30px;
}

input.custom_coupon_code {
    height: 48px;
}

button.coupon_code_cancel {
    color: #FFF;
    background: #333;
    border: none;
    padding: 15px 15px;
    display: block;
    width: 100%;
    text-align: center;
    font-size: 16px;
    transition: 0.3s ease;
    box-shadow: 5px 5px 10px rgb(0 0 0 / 20%);
}

button.custom_order_coupon_code_cancel.ml-2 {
    color: #FFF;
    background: #333;
    border: none;
    padding: 15px 15px;
    display: block;
    width: 100%;
    text-align: center;
    font-size: 16px;
    transition: 0.3s ease;
    box-shadow: 5px 5px 10px rgb(0 0 0 / 20%);
}

</style>
	 <?php 
	  
	  if(!empty($cartitems['bodyinfo'][0]['base_id']) && !empty($cartitems['bodyinfo'][0]['bm_color_id']) && !empty($cartitems['bodyinfo'][0]['motor_id']) && count($cartitems['jarinfo'])>0 ){ ?>
	  <div class="addSetCarFu clearfix">	
		
		<ul class="ck_product_listing">
			<li class="p-3">
				<div class="row align-items-center">
					<div class="col-sm-3 col-md-3">
						<img src="" id="CusImg" alt="" class="img-fluid"/>
						<!-- img src="<?= base_url('uploads/customizeimg/basecolor/'.$cartitems['bodyinfo'][0]['bodycolorimg']); ?>" alt="" class="img-fluid"/ -->
					</div>
					<div class="col-sm-6 col-md-6">
						<div class="table-responsive customization-table">
							<table class="table">
								<thead>
									<tr>
										<th>Customization Code</th>
										<th><?= $cartitems['bodyinfo'][0]['cartcode'] ?></th>
										<th style="text-align: right;">Price</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Body Design</td>
										<td><?= $cartitems['bodyinfo'][0]['basetitle'] ?></td>
										<td style="text-align: right;">
											<?php 
												if( isset( $cartitems['bodyinfo'][0]['baseprice'] ) && $cartitems['bodyinfo'][0]['baseprice'] != '0.00') {
													echo '<i class="fa fa-inr"></i> '.$cartitems['bodyinfo'][0]['baseprice'];
												}
											?>
											 
										</td>
									</tr>
									<tr>
										<td>Color</td>
										<td><?= $cartitems['bodyinfo'][0]['title'] ?></td>
										<td style="text-align: right;"><i class="fa fa-inr"></i> <?= $cartitems['bodyinfo'][0]['colorprice'] ?></td>
									</tr>
									<tr>
										<td>Selected Jars</td>
										<?php 
										$total_jar = 0;
										$jar_count = 0;
										if( isset( $cartitems['jarinfo'] ) ) {
											foreach($cartitems['jarinfo'] as $jar) {
												$total_jar = $total_jar + ( $jar['qty']*$jar['price'] ); 
												$jar_count += $jar['qty'];
											}
										}
										?>
										<td><?= $jar_count ?> Items</td>
										<td style="text-align: right;">
											<?php 
												if( $total_jar > 0 ) {
													echo '<i class="fa fa-inr"></i> '. number_format($total_jar, 2);
												}
											?>
										</td>
									</tr>
									<tr>
										<td>Motor Power</td>
										<td><?= $cartitems['bodyinfo'][0]['motorname'] ?></td>
										<td style="text-align: right;"><i class="fa fa-inr"></i> <?= $cartitems['bodyinfo'][0]['motorprice'] ?></td>
									</tr>
								<?php if($cartitems['bodyinfo'][0]['canvas_text']!='') { ?>	
									<tr>
										<td>Personalised message</td>
										<td><?= $cartitems['bodyinfo'][0]['canvas_text'] ?></td>
										<td style="text-align: right;"><i class="fa fa-inr"></i> <?= $cartitems['bodyinfo'][0]['canvas_price'] ?></td>
									</tr>
								<?php } ?>	
									<?php 
									// show( $cartitems['bodyinfo'][0] );
									if($cartitems['bodyinfo'][0]['package_id']!='') { ?>	
									<tr>
										<td>Packaging</td>
										<td><?= $cartitems['bodyinfo'][0]['packagename'] ?></td>
										<td style="text-align: right;"><i class="fa fa-inr"></i> <?= $cartitems['bodyinfo'][0]['package_price'] ?></td>
									</tr>
									<?php } ?>	
									<?php 
									if( $cartitems['bodyinfo'][0]['occasion_text']!='' ) {
									?>
									<tr>
										<td>Gift Messages</td>
										<td><?= $cartitems['bodyinfo'][0]['occasion_text'] ?></td>
										<td style="text-align: right;"> 
											<?= $cartitems['bodyinfo'][0]['message_text'] ?>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>						
					</div>
				
					<div class="col-sm-3 col-md-3">
						<div class="customize-cart-price">
							Rs.<?= number_format($totprice); ?>						
						</div>
						<div class="text-center">
							<a class="customize-cart-link" href="<?= base_url('')?>vidiem-by-you-recustomize">Change Customization</a> 
						</div>
					</div>
				</div>
			</li>
		</ul>
	<?php if(count($cartitems['jarinfo'])>0) { ?>	
		<ul class="ck_product_listing">
			<li class="p-3">
				<div class="row align-items-center">
					<div class="col">
						<div class="table-responsive customization-jar-table">
							<table class="table">
								<thead>
									<tr>
										<th></th>
										<th></th>
										<th class="text-center">No. Jars</th>
										<th class="text-center">Unit Price</th>
										<th class="text-center">Total Price</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($cartitems['jarinfo'] as $jar) {  ?>
									<tr>
										<td>
											<a href="<?= base_url("uploads/customizeimg/jar/".$jar['basepath']) ?>" data-fancybox="" data-caption="Jar<?= $jar['jar_id'] ?>">
												<img src="<?= base_url("uploads/customizeimg/jar/".$jar['basepath']) ?>" alt="" class="img-fluid"/>
											</a>	
											</div>										
										</td>
										<td> <?= $jar['name'] ?><div class="m-2"><i><?= $jar['capacity_name'] ?> | <?= $jar['type_name'] ?> | <?= $jar['handle_name'] ?>| <?= $jar['lid_name'] ?></i> </td>
										<td class="text-center">
											<span class="text-red"><?= $jar['qty'] ?> Jars</span>
										</td>
										<td class="text-center">
											<span class="text-red">Rs. <?= $jar['price'] ?></span>
										</td>
										<td class="text-center">
											<span class="text-red">Rs. <?= $jar['qty']*$jar['price'] ?></span>
										</td>
									</tr>
								<?php } ?>	
									
								</tbody>
							</table>
						</div>			
						<p></p>
						
					</div>
				</div>
			</li>
		</ul>
		
		<ul class="ck_product_listing">
		    <li class="p-3">
		        
		        <div class="table-responsive customization-jar-table">
							<table class="table">
								<thead>
									<tr>
										<th><strong>Warranty Information</strong></th>
									 
									</tr>
								</thead>
								<tbody>
							 
									<tr>
										<td>- 2 Years Warranty on Product <br> - 5 Years Warranty on Motor <br> <span style="color:#ff0000;font-size:10px;"><i>(For Domestic Purpose Only)</i> </tdf>
										 
									</tr>
							 
									
								</tbody>
							</table>
						</div>			
		        
		    </li>
		</ul>
		
		
			<div class="bg-white shadow1 mb-4 p-4">
				<div class="row">
					<div class="col-sm-12 col-md-6 col-lg-8">	
						<h6 class="highlighted-text-red mb-0">Non Returnable / No Cancellation in all Vidiem by you orders</h6>
					</div>
				</div>
			</div>
	<?php } ?>	
		</div>
		</div>
		<div class="col-sm-12 col-md-12 col-lg-12 col-xl-4">
		<div class="ckPriceDe clearfix bg-white shadow1 p-4">
				<h4 class="ckproname text-dark mb-4">Price Detail</h4>
				<ul class="clearfix prival ck_product_pricing">
					<li class="clearfix">
						<p class="priceti">Price (1 Item)</p>
						<p class="priceAm"><i class="fa fa-inr"></i> <?= number_format($totprice); ?>/-</p>
					</li>
					<li class="clearfix">
						<p class="priceti">Package Charges</p>
						<p class="priceAm gre"><i class="fa fa-inr"></i>  <?= number_format($packageprice['price']); ?></p>
					</li>
					<li class="clearfix">
						<p class="priceti">Delivery Charges</p>
						<p class="priceAm gre">Free</p>
					</li>
					<?php 
						$hide_apply_btn = '';
						$hide_cancel_btn = 'hide';
						$readonly = '';
					
					if( isset( $_SESSION['customer_order_coupon_amount'] ) && !empty( $_SESSION['customer_order_coupon_amount'] ) ) {

						$hide_apply_btn = 'hide';
						$hide_cancel_btn = '';
						$readonly = 'readonly';
					?>
					<li class="clearfix">
						<p class="priceti">Discount</p>
						<p class="priceAm"><i class="fa fa-inr"></i> <?= number_format( $_SESSION['customer_order_coupon_amount'] ) ?></p>
					</li>
					<?php } ?>
					<?php 
					if( isset( $_SESSION['custom_coupon_code'] ) && strtolower($_SESSION['custom_coupon_code']) == 'vitago' ) {					
					?>
						<li class="clearfix">
							<p class="priceti">Get VITA-GO Personal Blender</p>
							<p class="priceAm">Free</p>
						</li>
					<?php } else if( isset( $_SESSION['custom_coupon_code'] ) && strtolower($_SESSION['custom_coupon_code']) == 'extend' ) {	 ?>
						<li class="clearfix">
							<p class="priceti"> 3 Months Extended Warranty </p>
							<p class="priceAm">Free</p>
						</li>
					<?php } ?>
					<li class="clearfix toamount">
						<p class="priceti">AMOUNT PAYABLE</p>
						<p class="priceAm text-red"><i class="fa fa-inr"></i> <?= number_format($totprice+$packageprice['price'] - ( $_SESSION['customer_order_coupon_amount'] ?? 0 ) ); ?>/-</p>
					</li>
				</ul>
		<div class="clearfix"></div>
		
		<div class="coupen clearfix">
			<h4 class="text-dark mb-3">Coupon </h4>
			<div class="d-flex mb-4">
			<input type="text" name="coupon" placeholder="Coupon Code" class="custom_coupon_code" value="<?= $_SESSION['custom_coupon_code'] ?? '' ?>" <?= $readonly ?>>
			<input type="hidden" name="from_cart" value="1">
			<button class="custom_order_coupon_code_trigger red-btn <?= $hide_apply_btn ?>" >Apply</button>
			<button class="custom_order_coupon_code_cancel ml-2 <?= $hide_cancel_btn ?>">Clear</button>
			</div>
		</div>
		<div class="proccedBtn clearfix">
			<div class="mb-3">
			
			<button type="submit" class="checkout-btn black-btn"><i class="lni lni-wallet"></i> &nbsp; Checkout</button>
			</div>
			<div class="safepay">
				<img src="<?= base_url(); ?>assets/front-end/images/safepay.png" alt="" />
				<p><i class="lni lni-shield"></i> Safe and Secure Payments.</p>
						</div>
		</div>
	<?php }else{ ?>
		<h3>Cart Empty</h3>
	<?php } ?>	
	</div>
	  </div>
	  </div>
</div>

</div>
	</section>
	</form>
	<?php //require_once('container/top_seller.php'); ?>
</div>
<style type="text/css">
	.btn_link{cursor: pointer;}
	.hide{display: none !important;}
</style>
<?php require_once('container/footer.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<script>

 /*document.querySelector('#custom_order_form').addEventListener('submit', function(e) {
      var form = this;
      
      e.preventDefault();
      swal({
          
                text: "Please note that due to the Year End Process our shipments will be delayed by a few days. Normal delivery will resume from April 8th Onwards.",
                type: "info",
                confirmButtonText: "Ok"
        }).then(function() {
           form.submit();
        });
      
      
    });*/
	// Checkout Coupen Code
	$(document).on('click','.custom_order_coupon_code_trigger',function(e){
		e.preventDefault();
		var code=$('.custom_coupon_code').val();
		var client_id = '<?= $this->session->userdata('client_id') ?>';
		$.ajax({
			url:'<?= base_url()?>home/custom_order_coupon_check',
			type:'POST',
			data:{code:code},
			dataType:'json',
			success:function(data){
				if(data.status==2){
					
					
					swal("Information",data.msg, "warning");
					if(client_id==''){
						setTimeout(function(){
							window.location.href = '<?= base_url()?>sign-in';
						}, 2000);
					
					}
					
				}else{
					swal("Information",'Coupen Code applied successfully..', "success");
					$('.ck_product_pricing').html(data.msg);
					$('.custom_coupon_code').prop('readonly', true);
					$('.custom_order_coupon_code_trigger').addClass('hide');
					$('.custom_order_coupon_code_cancel').removeClass('hide');
				}
			}
		});
	});

	$('.custom_order_coupon_code_cancel').click(function(e){
		e.preventDefault();
		$.ajax({ 
			url: '<?= base_url()?>home/custom_order_remove_coupon',
			type:'POST',
			data:'nounce=1',
			success:function(data){
				$('.ck_product_pricing').html(data);
			}
		});
		$('.custom_coupon_code').prop('readonly', false).val('');
		$('.custom_order_coupon_code_trigger').removeClass('hide');
		$('.custom_order_coupon_code_cancel').addClass('hide');
	});
</script>
<script>
//  $(document).on('ready', function(){
// 	var imgageCustom = localStorage.getItem('customImage');
// 	var imgCustom = imgageCustom.substring(0, imgageCustom.length-1);
// 	$("#CusImg").attr("src",imgCustom);
//     });					   
</script>

<script>
function checkBase64(base64Img){
    var base64Matcher = new RegExp("^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=|[A-Za-z0-9+/]{4})$");

    if (base64Matcher.test(base64Img)) {
        return true;
    } else {
         return false;
    }
}
 $(document).on('ready', function(){
	var imgageCustom = localStorage.getItem('customImage');
	var isValid = checkBase64(imgageCustom);
	
	if(isValid){
	    $("#CusImg").attr("src", imgageCustom);
	}
	else{
	    //var imgCustom = imgageCustom.substring(0, imgageCustom.length-1);
	     $("#CusImg").attr("src", imgageCustom);
	}
 });					   
</script>