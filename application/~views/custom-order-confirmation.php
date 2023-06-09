<?php include('container/header.php');  
//echo "<pre>"; print_r($orderdetails); exit;
//echo "<pre>"; print_r($orderproduct); exit; 

?>
	<section class="light-gray-bg pt-4">
		<div class="container">
			<div class="row">
				<div class="col">
					<h2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Your Cart</h2>
					<ul class="cart-tab my-4" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
						<li>
							<a href="<?= base_url('cart'); ?>">
								01 Shopping Cart
							</a>
						</li>
						<li>
							<a href="javascript:void(0);">
								02 Account &amp; Shipping
							</a>
						</li>
						<li>
							<a class="active" href="javascript:void(0);">
								03 Order Confirmation
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-8">
					<h4 class="text-dark mb-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Order Confirmation</h4>
					<div class="bg-white mb-5 p-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
						<h3 class="mb-4"><i class="lni lni-checkmark-circle text-success"></i> &nbsp; <?= $order_title ?? '' ?></h3>
						<p><strong class="text-dark">Dear</strong> <?= $orderdetails['delivery_name']; ?></p>
								

						<p><?= $order_message ?? '' ?></p>


						<p>Thank You Support<br/> Care Team<br/><strong class="text-red">Vidiem</strong></p>					
					</div>
					<?php 
						if( !$is_dealer_payment ){ ?>

					<a href="<?= base_url('custominvoice/'.$orderdetails['id']); ?>" class="black-btn small"  data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
						<i class="lni lni-download"></i> &nbsp; Download Invoice
					</a>
					<?php } ?>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-4">
					<h4 class="text-dark mb-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Cart Summary</h4>
					<div class="bg-white mb-5 p-4" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
						<div class="mh-200">
						<div class="checkout-scroll">
						
						
				<div class="row">
					<div class="col-sm-4 col-md-4">
						<img src="<?= base_url('uploads/customizeimg/'.$basiciteminfo['basecolorpath']); ?>" alt="" class="img-fluid"/>
					</div>
					<div class="col-sm-8 col-md-8">
						<div class="table-responsive customization-table">
							<table class="table">
								<thead>
									<tr>
										<th>Customization Code</th>
										<th><?= $basiciteminfo['cart_code'] ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Body Design</td>
										<td><?= $basiciteminfo['basetitle'] ?></td>
									</tr>
									<tr>
										<td>Color</td>
										<td><?= $basiciteminfo['bc_title'] ?></td>
									</tr>
									<tr>
										<td>Selected Jars</td>
										<td><?= count($jarinfo) ?></td>
									</tr>
									<tr>
										<td>Motor Power</td>
										<td><?= $basiciteminfo['motorname'] ?></td>
									</tr>
								<?php if($basiciteminfo['canvas_text']!='') { ?>	
									<tr>
										<td>Personalised message</td>
										<td><?= $basiciteminfo['canvas_text'] ?></td>
									</tr>
								<?php } ?>	
								<?php if ($basiciteminfo['package_id'] != '') { ?>
									<tr>
										<td>Gift Wrapping Preference</td>
										<td><?= $basiciteminfo['packagename'] ?></td>
									</tr>
								<?php } ?>
								<?php 
								if( $basiciteminfo['occasion_text']!='' ) {
								?>
								<tr>
									<td>Gift Messages</td>
									<td><?= $basiciteminfo['occasion_text'] ?></td>
									<td style="text-align: right;"> 
										<?= $basiciteminfo['message_text'] ?>
									</td>
								</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>						
					</div>
				</div>
						
						
						</div>
						</div>
						
						
						<div class="divider"></div>
						<div class="row">
							<div class="col">
								<h6>Subtotal</h6>
							</div>
							<div class="col">
								<h6 class="text-right text-dark">Rs. <?=  number_format($orderdetails['sub_total']); ?></h6>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<p>Shipping Charges</p>
							</div>
							<div class="col">
								<p class="text-right text-dark"><strong>FREE</strong></p>
							</div>
						</div>
						<?php 

						// print_r( $orderdetails );
						if( isset( $orderdetails['packageprice'] ) && !empty( $orderdetails['packageprice'] ) ) {
						?>
						<div class="row">
							<div class="col">
								<p>Package Charges</p>
							</div>
							<div class="col">
								<p class="text-right text-dark"><strong>₹ <?= number_format($orderdetails['packageprice']); ?></strong></p>
							</div>
						</div>
						<?php } ?>
						<?php if(!empty($orderdetails['discount'])){ ?>
						
							<div class="row">
						    <?php if($orderdetails['coupon_type']==1){ ?>
							
							<?php if($orderdetails['discount']!=0){ ?>
							
							<div class="col">
								<p>Discount (-) <?= number_format($orderdetails['coupon_value']); ?>% </p>
							</div>
							<div class="col">
								<p class="text-right text-dark">₹ <?= number_format($orderdetails['discount']); ?></p>
							</div>
							<?php } else {
								if( strtolower($orderdetails['coupon']) == 'vitago' ) {
								?>
									<div class="col">
										<p>Get VITA-GO Personal Blender</p>
									</div>
									<div class="col">
										<p class="text-right text-dark"><strong>FREE</strong></p>
									</div>
								<?php }  else  { ?>
									<div class="col">
										<p>3 Months Extended Warranty</p>
									</div>
									<div class="col">
										<p class="text-right text-dark"><strong>FREE</strong></p>
									</div>
								<?php } ?>
							
							<?php } ?>
							
							<?php } else { ?>
							
								<?php if($orderdetails['discount']!=0){ ?>
							
							<div class="col">
								<p>Discount (-)</p>
							</div>
							<div class="col">
								<p class="text-right text-dark">₹ <?= number_format($orderdetails['discount']); ?></p>
							</div>
							<?php } else { 
								if( strtolower($orderdetails['coupon']) == 'vitago' ) {   ?>
									<div class="col">
										<p>Get VITA-GO Personal Blender</p>
									</div>
									<div class="col">
										<p class="text-right text-dark"><strong>FREE</strong></p>
									</div>
								<?php } else {
								?>
									<div class="col">
										<p>3 Months Extended Warranty</p>
									</div>
									<div class="col">
										<p class="text-right text-dark"><strong>FREE</strong></p>
									</div>
							
							<?php } } ?>
							
							<?php } ?>
						</div>
						<?php } ?>
						
						<!--<div class="row">
							<div class="col">
								<p class="mb-0">GST 18%</p>
							</div>
							<div class="col">
								<p class="text-right text-dark mb-0"><?=  number_format($orderdetails['tax']); ?></p>
							</div>
						</div>-->
						<div class="divider"></div>
						<div class="row">
							<div class="col">
								<h6><?= $is_counter_payment ? 'To Be' : 'Total' ?> Paid</h6>
							</div>
							<div class="col">
								<h6 class="text-right text-red">₹ <?= number_format($orderdetails['amount']); ?></h6>
							</div>
						</div>
					</div>
						<?php 
						if( !$is_counter_payment ){ ?>
						<div class="row">
							<div class="col">
								<p class="pt-3">Payment Paid Successfully, You have Paid ₹ <?= number_format($orderdetails['amount']); ?> through online payment option.</p>
							</div>
						</div>
						<?php } ?>
				</div>
			</div>
		</div>
	</section>
	  
<?php include 'container/footer.php';?>