<?php include('container/header.php');  
//echo "<pre>"; print_r($orderdetails); exit;
//echo "<pre>"; print_r($orderproduct); exit; 

?>
	<section class="light-gray-bg">
		<div class="container">
			<div class="row">
				<div class="col">
					<h2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Your Cart</h2>
					<ul class="cart-tab" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
						<li>
							<a href="<?= base_url('cart'); ?>">
								01 Shopping Cart
							</a>
						</li>
						<li>
							<a href="javascript:void(0);">
								02 Account Shipping
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
						<h3 class="mb-4"><i class="lni lni-checkmark-circle text-success"></i> &nbsp; Your order is Confirmed!</h3>
						<p><strong class="text-dark">Dear</strong> <?= $orderdetails['delivery_name']; ?></p>
						<p>Your order placed with Vidiem is confirmed, we will update back with the shipment details by mail.</p>
						<p>Thank You Support<br/> Care Team<br/><strong class="text-red">Vidiem</strong></p>					
					</div>
					<a href="<?= base_url('invoice/'.$orderdetails['id']); ?>" class="black-btn small"  data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
									<i class="lni lni-download"></i> &nbsp; Download Invoice
						</a>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-4">
					<h4 class="text-dark mb-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Cart Summary</h4>
					<div class="bg-white mb-5 p-4" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
						<div class="mh-200">
						<?php foreach($orderproduct as $data) { ?>
						<div class="row mb-4">
							<div class="col-sm-12 col-md-6 col-lg-4 light-gray-bg">						
								<img src="<?= base_url('uploads/images/'.$data['image']); ?>" alt="" class="img-fluid" />
							</div>
							<div class="col-sm-12 col-md-6 col-lg-8">
								<h6>Vidiem <small><?= $data['name']; ?></small></h6>
								<!--<p>Mixer Grinder - 3 Jars</p>-->
								<p>Item: <?= $data['qty']; ?></p>
								<h6 class="text-dark">₹ <?= number_format($data['price']); ?></h6>
							</div>
						</div>
						<?php } ?>
						</div>
						
						
						<div class="divider"></div>
						<div class="row">
							<div class="col">
								<p>Subtotal</p>
							</div>
							<div class="col">
								<p class="text-right text-dark"><?=  number_format($orderdetails['sub_total']); ?></p>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<p>Shipping Charges</p>
							</div>
							<div class="col">
								<p class="text-right text-dark">Free</p>
							</div>
						</div>
						
						<?php if(!empty($orderdetails['discount'])){ ?>
						
						<div class="row">
						    <?php if($orderdetails['coupon_type']==1){ ?>
							<div class="col">
								<p>Discount (-) <?= number_format($orderdetails['coupon_value']); ?>% </p>
							</div>
							<div class="col">
								<p class="text-right text-dark">₹ <?= number_format($orderdetails['discount']); ?></p>
							</div>
							<?php } else { ?>
							
							<div class="col">
								<p>Discount (-)</p>
							</div>
							<div class="col">
								<p class="text-right text-dark">₹ <?= number_format($orderdetails['discount']); ?></p>
							</div>
							
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
								<h6>Total Paid</h6>
							</div>
							<div class="col">
								<h6 class="text-right text-success">₹ <?= number_format($orderdetails['amount']); ?></h6>
							</div>
						</div>
					</div>

						<div class="row">
							<div class="col">
								<p class="pt-3">Payment Paid Successfully, You have Paid ₹ <?= number_format($orderdetails['amount']); ?> through online payment option.</p>
							</div>
						</div>
				</div>
			</div>
		</div>
	</section>
	  
<?php include 'container/footer.php';?>