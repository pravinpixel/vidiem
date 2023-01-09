<?php

$dealer_session = $this->session->userdata('dealer_session');
if (isset($dealer_session['user'])) {
	if ($dealer_session['user']['user_type'] != 'sale_person') {
		// redirect();
	}

?>
	<script>
		var isSelectPayment = false;
	</script>
<?php } else { ?>
	<script>
		var isSelectPayment = true;
	</script>
<?php }
?>
<?php include('container/header.php'); ?>
<style>
	.pay-label {
		font-size: 17px;
		font-weight: 600;
		margin-right: 10px;
	}

	#loaderWrapper {
		position: fixed;
		height: 100%;
		width: 100%;
		background: #0808086b;
		display: flex;
		justify-content: center;
		align-items: center;
		z-index: 9999999;
	}

	.loader {
		border: 16px solid #f3f3f3;
		border-radius: 50%;
		border-top: 16px solid #3498db;
		width: 120px;
		height: 120px;
		-webkit-animation: spin 2s linear infinite;
		/* Safari */
		animation: spin 2s linear infinite;
	}

	/* Safari */
	@-webkit-keyframes spin {
		0% {
			-webkit-transform: rotate(0deg);
		}

		100% {
			-webkit-transform: rotate(360deg);
		}
	}

	@keyframes spin {
		0% {
			transform: rotate(0deg);
		}

		100% {
			transform: rotate(360deg);
		}
	}
</style>

<div id="loaderWrapper" style="display:none;">
	<div class="loader"></div>
</div>


<section class="light-gray-bg pt-4">

	<div class="container">
		<div class="row">
			<div class="col">
				<h2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Your Cart</h2>
				<ul class="cart-tab my-4" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
					<li>
						<a href="<?= base_url('customize-cart'); ?>">
							<span>01</span> Shopping Cart
						</a>
					</li>
					<li>
						<a class="active" href="<?= base_url('customize-checkout'); ?>">
							<span>02</span> Account &amp; Shipping
						</a>
					</li>
					<li>
						<a href="javascript:void(0);">
							<span>03</span> Order Confirmation
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-8" id="content">
				<?php if (($this->session->flashdata('msg'))) { ?>
					<div class="alert alert-success <?= $this->session->flashdata('class'); ?> alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="icon fa <?= $this->session->flashdata('icon'); ?>"></i> Alert!</h4>
						<?= $this->session->flashdata('msg'); ?>
					</div>
				<?php } ?>
				<?php if ($client_id == '') { ?>
					<h4 class="text-dark mb-3">Account Details</h4>
					<div class="bg-white shadow1 mb-5 p-4 radio-alignment">
						<div class="form-check form-check-inline">
							<input type="radio" class="form-check-input" id="guest" name="checklogin" value="1" checked onclick="checkloginfun(1);">
							<label class="form-check-label text-dark" for="guest">Guest Checkout<br /><small>Instant Checkout</small></label>
						</div>
						<div class="form-check form-check-inline">
							<input type="radio" class="form-check-input" id="login-checkout" name="checklogin" value="2" onclick="checkloginfun(2);">
							<label class="form-check-label text-dark" for="login-checkout">Login and Checkout<br /><small>Registered Customers</small></label>
						</div>
					</div>
				<?php  } ?>
				<!--Login User Start  -->
				<?php if ($client_id != '') { ?>
					<h4 class="text-dark mb-2">Shipping Address Details</h4>

					<div class="bg-white shadow1 mb-4 p-4">


						<div id="address_list_1">
							<?php if (!empty($shipping_address)) {
								$cnt = 1;
								foreach ($shipping_address as $displayaddress) { ?>
									<div class="row mb-3 pb-3 border-bottom">
										<div class="col-12 col-sm-5">

											<p><input class="dot" type="radio" id="slctadd_<?php echo $cnt; ?>" name="shippingaddressid" value="<?php echo $displayaddress['id']; ?>"> <?php echo $displayaddress['name']; ?></p>
											<p><?php echo $displayaddress['mobile_no']; ?>
											<p>

										</div>
										<div class="col-12 col-sm-5">
											<p><?php echo $displayaddress['address']; ?>
											<p>
										</div>
										<div class="col-12 col-sm-2"> <a id="edit-shipping-address" href="javascript:void(0);" class="cust_link edit btn btn-primary btn-sm" title="Edit" data-toggle="tooltip" onClick="javascript:triggershippingaddress_edit(<?php echo $displayaddress['id']; ?>);"><span data-target=".addnew-address" aria-expanded="false" aria-controls="addnew-address"><i class="lni lni-pencil-alt"></i><span> </a> </div>
									</div>
							<?php $cnt++;
								}
							} ?>


						</div>
						<a href="javascript:void(0);" class="red-btn small" onClick="javascript:triggershippingaddress();">Add to new address</a>
					</div>
				<?php } ?>



				<h4 class="text-dark mb-2 shippingaddressdiv">Add Shipping Address</h4>
				<div class="bg-white shadow1 mb-4 p-4 shippingaddressdiv">
					<?php $states = $this->ProjectModel->states(); ?>
					<form method="POST" action="" id="shippingaddressForm">
						<input type="hidden" value="1" name="type">
						<input type="hidden" value="1" name="id" id="clientaddid">

						<div class="row">
							<div class="col-sm-12 col-md-6">
								<div class="md-form">
									<input type="text" id="name_ship" name="name" class="form-control jsrequired" value="<?= set_value('name', $this->session->userdata('client_name')); ?>">
									<label for="name_ship">Name</label>

								</div>
							</div>
							<div class="col-sm-12 col-md-6">
								<div class="md-form">
									<input type="text" id="company_ship" name="company" class="form-control" value="<?= set_value('company'); ?>">
									<label for="company_ship">Company</label>

								</div>
							</div>
							<div class="col-sm-12 col-md-12">
								<div class="md-form">
									<input type="text" id="address_ship" class="form-control jsrequired" name="address" value="<?= set_value('address'); ?>">
									<label for="address_ship">Address Line 1</label>

								</div>
							</div>
							<div class="col-sm-12 col-md-12">
								<div class="md-form">
									<input type="text" id="address2_ship" class="form-control" name="address2" value="<?= set_value('address2'); ?>">
									<label for="address2_ship">Address Line 2</label>
								</div>
							</div>

							<div class="col-sm-12 col-md-6">
								<div class="md-form">
									<input type="text" id="zip_code_ship" class="form-control jsrequired" name="zip_code" value="<?= set_value('zip_code'); ?>">
									<label for="zip_code_ship">Zip/Postal Code</label>

								</div>
							</div>

							<div class="col-sm-12 col-md-6">
								<div class="md-form">
									<input type="text" id="city_ship" class="form-control jsrequired" name="city" value="<?= set_value('city'); ?>">
									<label for="city_ship">City</label>

								</div>
							</div>

							<div class="col-sm-12 col-md-6 pt-4 mb-2">
								<select id="country_ship" name="country" class="js-states form-control">
									<option>India</option>
								</select>
							</div>
							<div class="col-sm-12 col-md-6 pt-4 mb-2">
								<select id="state_ship" name="state" class="js-states form-control jsrequired">

									<option>Select State</option>
									<?php if (!empty($states)) {
										foreach ($states as $info) { ?>
											<option value="<?= $info; ?>" <?= set_select('state', $info); ?>><?= $info; ?></option>
									<?php
										}
									} ?>

								</select>
							</div>

							<div class="col-sm-12 col-md-12">
								<div class="md-form">
									<input type="text" id="add_information_ship" class="form-control " name="add_information" value="<?= set_value('add_information'); ?>">
									<label for="add_information_ship">Additional Information</label>
								</div>
							</div>

							<div class="col-sm-12 col-md-6">
								<div class="md-form">
									<input type="text" id="mobile_no_ship" minlength="10" maxlength="10" class="form-control jsrequired" name="mobile_no" value="<?= set_value('mobile_no'); ?>">
									<label for="mobile_no_ship">Mobile Number</label>

								</div>
							</div>

							<div class="col-sm-12 col-md-6">
								<div class="md-form">
									<input type="text" id="emailid_ship" class="form-control jsrequired" name="emailid" value="<?= set_value('emailid'); ?>">
									<label for="emailid_ship">Email Id</label>

								</div>
							</div>
							<?php

							$client_id = $this->session->userdata('client_id');
							if ($client_id != '') {
							?>
								<div class="col-sm-12 col-md-12 col-lg-12 text-right">
									<button type="button" class="red-btn small" onClick="javascript:saveaddress('shippingaddressForm','<?= base_url('home/AjaxAddShippingAddress'); ?>','Shipping Address Added');"><i class="lni lni-save"></i> &nbsp; Save</button>
								</div>
							<?php } ?>
						</div>
					</form>
				</div>

				<div id="shippingaddressupdatediv"></div>

				<div class="bg-white shadow1 mb-5 p-4">
					<div class="row">
						<div class="col">
							<div class="custom-checkbox tick">
								<label class="filllTT">
									<input type="checkbox" data-ng-model="example.check" name="same_billing" id="same_billing"  checked class="tigger-billingaddress" value="1,2" onclick="samebillingfunction();">
									<span class="box"></span>
									Use the delivery address as the billing address.
								</label>
							</div>
						</div>
					</div>

				</div>

				<?php if ($client_id != '') { ?>
					<h4 class="text-dark mb-3 displaybillingaddressdiv">Billing Address Details</h4>

					<div class="bg-white shadow1 mb-4 p-4 displaybillingaddressdiv">


						<div id="address_list_2">
							<?php if (!empty($billing_address)) {
								$cnt = 1;
								foreach ($billing_address as $displayaddress) { ?>
									<div class="row mb-3 pb-3 border-bottom">
										<div class="col-12 col-sm-5">

											<p><input class="dot" type="radio" id="slctadd_<?php echo $cnt; ?>" name="billingaddressid" value="<?php echo $displayaddress['id']; ?>"> <?php echo $displayaddress['name']; ?></p>
											<p><?php echo $displayaddress['mobile_no']; ?>
											<p>

										</div>
										<div class="col-12 col-sm-5">
											<p><?php echo $displayaddress['address']; ?>
											<p>
										</div>
										<div class="col-12 col-sm-2"> <a href="javascript:void(0);" class="cust_link edit btn btn-primary btn-sm" title="Edit" data-toggle="tooltip" onClick="javascript:triggerbillingaddress_edit(<?php echo $displayaddress['id']; ?>);"><span data-target=".addnew-address" aria-expanded="false" aria-controls="addnew-address"><i class="lni lni-pencil-alt"></i><span> </a> </div>
									</div>
							<?php $cnt++;
								}
							} ?>
						</div>

						<a href="javascript:void(0);" class="red-btn small" onClick="javascript:triggerbillingaddress();">Add to new address</a>
					</div>
				<?php } ?>


				<!--Login User End -->

				<h4 class="text-dark mb-3 billingaddressdiv">Add Billing Address</h4>
				<div class="bg-white shadow1 mb-5 p-4 billingaddressdiv">
					<?php $states = $this->ProjectModel->states(); ?>
					<form method="POST" action="" id="billingaddressForm">
						<input type="hidden" value="2" name="type">
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<div class="md-form">
									<input type="text" id="name" name="name" class="form-control jsrequired" value="<?= set_value('name', $this->session->userdata('client_name')); ?>">
									<label for="name">Name</label>

								</div>
							</div>
							<div class="col-sm-12 col-md-6">
								<div class="md-form">
									<input type="text" id="company" name="company" class="form-control" value="<?= set_value('company'); ?>">
									<label for="company">Company</label>

								</div>
							</div>
							<div class="col-sm-12 col-md-12">
								<div class="md-form">
									<input type="text" id="address" class="form-control jsrequired" name="address" value="<?= set_value('address'); ?>">
									<label for="address">Address Line 1</label>

								</div>
							</div>
							<div class="col-sm-12 col-md-12">
								<div class="md-form">
									<input type="text" id="address2" class="form-control" name="address2" value="<?= set_value('address2'); ?>">
									<label for="address2">Address Line 2</label>
								</div>
							</div>

							<div class="col-sm-12 col-md-6">
								<div class="md-form">
									<input type="text" id="zip_code" class="form-control jsrequired" name="zip_code" value="<?= set_value('zip_code'); ?>">
									<label for="zip_code">Zip/Postal Code</label>

								</div>
							</div>

							<div class="col-sm-12 col-md-6">
								<div class="md-form">
									<input type="text" id="city" class="form-control jsrequired" name="city" value="<?= set_value('city'); ?>">
									<label for="city">City</label>

								</div>
							</div>

							<div class="col-sm-12 col-md-6 pt-4 mb-2">
								<select id="country2" name="country" class="js-states form-control">
									<option>India</option>
								</select>
							</div>
							<div class="col-sm-12 col-md-6 pt-4 mb-2">
								<select id="state1" name="state" class="js-states form-control">

									<option>Select State</option>
									<?php if (!empty($states)) {
										foreach ($states as $info) { ?>
											<option value="<?= $info; ?>" <?= set_select('state', $info); ?>><?= $info; ?></option>
									<?php
										}
									} ?>

								</select>
							</div>

							<div class="col-sm-12 col-md-12">
								<div class="md-form">
									<input type="text" id="add_information" class="form-control" name="add_information" value="<?= set_value('add_information'); ?>">
									<label for="add_information">Additional Information</label>
								</div>
							</div>

							<div class="col-sm-12 col-md-6">
								<div class="md-form">
									<input type="text" id="mobile_no" minlength="10" maxlength="10" maxlength="10" class="form-control jsrequired" name="mobile_no" value="<?= set_value('mobile_no'); ?>">
									<label for="mobile_no">Mobile Number</label>

								</div>
							</div>

							<div class="col-sm-12 col-md-6">
								<div class="md-form">
									<input type="text" id="emailid_ship" class="form-control jsrequired" name="emailid" value="<?= set_value('emailid'); ?>">
									<label for="emailid_ship">Email Id</label>

								</div>
							</div>
							<?php

							$client_id = $this->session->userdata('client_id');
							if ($client_id != '') {
							?>
								<div class="col-sm-12 col-md-12 col-lg-12 text-right">
									<button type="button" class="red-btn small" onClick="javascript:saveaddress('billingaddressForm','<?= base_url('home/AjaxAddShippingAddress'); ?>','Billing Address Added');"><i class="lni lni-save"></i> &nbsp; Save</button>
								</div>
							<?php } ?>
						</div>
					</form>
				</div>

				<div id="billingaddressupdatediv"></div>

				<h4 class="text-dark mb-2">Shipping Method</h4>
				<div class="bg-white shadow1 mb-4 p-4">
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-8 radio-alignment">
							<div class="form-check form-check-inline">
								<input type="radio" class="form-check-input" id="shippingmethodid" name="shippingmethodid" value="1" checked>
								<label class="form-check-label text-dark" for="shipping-method">Surface Shipping<br /><small>4 - 10 Day Approximately (FedEx / India Post / Blue Dart / DTDC / ST.,)</small></label>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-4">
							<h6 class="text-right text-red">Free</h6>
							<!--<p class="text-right mb-0">Delivery Charge<br/>₹ 150.00</p>-->
						</div>
					</div>
				</div>
				<h4 class="text-dark mb-2">Confirm Cart</h4>
				<div class="bg-white shadow1 mb-4 p-4">
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-8 radio-alignment">
							<div class="form-check form-check-inline">
								<input type="radio" class="form-check-input" checked="checked" id="confirmcart" name="confirmcart" value="1">
								<label class="form-check-label text-dark" for="confirmcart">I Agree<br /><small>I agree to the terms & conditions of VIdiem.in as per the given content of the website</small></label>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-4">
							<p class="text-right pt-3 mb-0"><a href="#" data-toggle="modal" data-target="#ViewModal">View Page</a></p>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-4">
				<div id="sidebar">
					<h4 class="text-dark mb-2">Cart Summary</h4>
					<div class="bg-white shadow1 mb-3 pl-4 pr-4 pt-4 pb-2">

						<div class="checkout-scroll">
							<?php

							if (!empty($cartitems['bodyinfo'][0]['base_id']) && !empty($cartitems['bodyinfo'][0]['bm_color_id']) && !empty($cartitems['bodyinfo'][0]['motor_id']) && count($cartitems['jarinfo']) > 0) { ?>


								<div class="row">
									<div class="col-sm-4 col-md-4">
										<img src="<?= base_url('uploads/customizeimg/basecolor/' . $cartitems['bodyinfo'][0]['bodycolorimg']); ?>" alt="" class="img-fluid" />
									</div>
									<div class="col-sm-8 col-md-8">
										<div class="table-responsive customization-table">
											<table class="table">
												<thead>
													<tr>
														<th>Customization Code</th>
														<th><?= $cartitems['bodyinfo'][0]['cartcode'] ?></th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Body Design</td>
														<td><?= $cartitems['bodyinfo'][0]['basetitle'] ?></td>
													</tr>
													<tr>
														<td>Color</td>
														<td><?= $cartitems['bodyinfo'][0]['title'] ?></td>
													</tr>
													<tr>
														<td>Selected Jars</td>
														<td>
														<?php 
														$jar_count = 0;
														if( isset( $cartitems['jarinfo'] ) && !empty($cartitems['jarinfo']) ) {
															foreach ($cartitems['jarinfo'] as $key => $value) {
																$jar_count += $value['qty'];
															}
														}
														?>
														<?= $jar_count; ?></td>
													</tr>
													<tr>
														<td>Motor Power</td>
														<td><?= $cartitems['bodyinfo'][0]['motorname'] ?></td>
													</tr>
													<?php if ($cartitems['bodyinfo'][0]['canvas_text'] != '') { ?>
														<tr>
															<td>Personalised message</td>
															<td><?= $cartitems['bodyinfo'][0]['canvas_text'] ?></td>
														</tr>
													<?php } ?>
													<?php if ($cartitems['bodyinfo'][0]['package_id'] != '') { ?>
														<tr>
															<td>Gift Wrapping Preference</td>
															<td><?= $cartitems['bodyinfo'][0]['packagename'] ?></td>
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


								</div>


							<?php } ?>
						</div>
						<div class="divider"></div>

						<div class="row">
							<div class="col">
								<p>Subtotal</p>
							</div>
							<div class="col">
								<p class="text-right text-dark">₹ <?php echo $totprice; ?></p>
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


						<div class="row">
							<div class="col">
								<p>Package Charges</p>
							</div>
							<div class="col">
								<p class="text-right text-dark">₹ <?php echo number_format($packageprice['price']); ?></p>
							</div>
						</div>

						<?php if (!empty($discount['status'])) { ?>
							<input type="hidden" id="coupon" name="coupon" value="<?= $discount['code']; ?>">
							<div class="row">
								<?php if ($discount['type'] == 1) {
									if ($discount['amount'] != 0) {
								?>
										<div class="col">
											<p>Discount <?= number_format($discount['value']); ?>% </p>
										</div>
										<div class="col">
											<p class="text-right text-dark">₹ <?= number_format($discount['amount']); ?></p>
										</div>
									<?php } else { ?>

										<div class="col">
											<p>3 Months Extended Warranty</p>
										</div>
										<div class="col">
											<p class="text-right text-dark">Free</p>
										</div>

									<?php } ?>

									<?php } else {
										if( isset( $_SESSION['customer_order_coupon_amount'] ) && !empty( $_SESSION['customer_order_coupon_amount'] ) ) {
											$discount['amount'] = $_SESSION['customer_order_coupon_amount'];
										}

									if ($discount['amount'] != 0) {
									?>
										<div class="col">
											<p>Discount</p>
										</div>
										<div class="col">
											<p class="text-right text-dark">₹ <?= number_format($discount['amount']); ?></p>
										</div>
									<?php } else { 
										if( isset( $_SESSION['custom_coupon_code'] ) && strtolower($_SESSION['custom_coupon_code']) == 'vitago' ) {	
										?>
											<div class="col">
												<p>  Get VITA-GO Personal Blender </p>
											</div>
											<div class="col">
												<p class="text-right text-dark">Free</p>
											</div>
										<?php } else { ?>

										<div class="col">
											<p>3 Months Extended Warranty</p>
										</div>
										<div class="col">
											<p class="text-right text-dark">Free</p>
										</div>

									<?php } } ?>



								<?php } ?>
							</div>
						<?php } ?>
						<?php //echo $totprice; 
						?>
						<!--<div class="row">
							<div class="col">
								<p class="mb-0">GST 18%</p>
							</div>
							<div class="col">
								<p class="text-right text-dark mb-0">2,174.00</p>
							</div>
						</div>-->

						<div class="divider"></div>
						<?php 
						// print_r( $totprice );
						// print_r( $discount );
						?>
						<div class="row">
							<?php if ( isset( $discount['status'] ) && !empty($discount['status'])) { ?>
								<div class="col">
									<h6>Total Paid</h6>
								</div>
								<div class="col">
									<h6 class="text-right text-red">₹ <?php echo number_format( ( $totprice + $packageprice['price'] ) - $discount['amount']); ?></h6>
								</div>
							<?php } else { ?>

								<div class="col">
									<h6>Total Paid</h6>
								</div>
								<div class="col">
									
									<h6 class="text-right text-red">₹ <?php echo number_format($totprice + $packageprice['price']); ?></h6>
								</div>

							<?php } ?>
						</div>
					</div>

					<div class="row">
						
						<?php 
							if( $this->session->has_userdata('dealer_session') ) {
								
								$in_array = explode( ',', $this->session->userdata('dealer_session')['dealer']['payment_option'] );

								if( in_array( 'online', $in_array ) ) { 
						?>
								<div class="col-sm-12 mt-3">
									<button class="proceed-to-pay-btn red-btn" type="button" onclick="proceedtopay();">
										Proceed to Pay
									</button>
								</div>
						<?php		
								}
								if( in_array( 'counter_pay', $in_array ) ) {
						?>
						
								<div class="col-sm-12 mt-3">
									<button class="proceed-to-pay-btn black-btn" type="button" onclick="goPayMethod();">
										Proceed to Counter Pay
									</button>
								</div>
						<?php } } else { ?>
							<div class="col-sm-12 mt-3">
								<button class="proceed-to-pay-btn red-btn" type="button" onclick="proceedtopay();">
									Proceed to Pay
								</button>
							</div>
						<?php } ?>
						
						<div class="col-sm-12 mt-3">
							<a class="cancel-btn" href="<?= base_url(); ?>">
								Cancel
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<?php if (!empty($discount['status'])) { ?>
								<p class="pt-3">Proceed to pay securly with Razorpay.</p>
							<?php } else { ?>
								<p class="pt-3">Proceed to pay securly with Razorpay.</p>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<?php include 'container/footer.php'; ?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<form name='razorpayform' action="<?= base_url('home/customize_razorpay_success') ?>" method="POST">
	<input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
	<input type="hidden" name="razorpay_signature" id="razorpay_signature">
</form>

<script>
	<?php if ($client_id != '') { ?>
		$(".shippingaddressdiv").hide();
		$(".billingaddressdiv").hide();
	<?php } ?>

	// Add shipping Address and billing Address
	function saveaddress(formid, url, text) {
		if ($('#' + formid).valid()) {
			var datas = $('#' + formid).serialize();

			if ($('#same_billing').is(":checked")) {
				var same_billing = $("#same_billing").val();
			} else {
				var same_billing = '';
			}

			$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: datas + '&same_billing=' + same_billing,
				success: function(data) {
					$("#" + formid)[0].reset();

					swal("Success", text + " successfully", "success");

					$("#address_list_" + data.type).html(data.addresshtml);
					<?php if ($client_id != '') { ?>
						$(".shippingaddressdiv").hide();
						$(".billingaddressdiv").hide();
						$(".shippingaddressdivupdate").hide();
						$(".billingaddressdivupdate").hide();
					<?php } ?>
				}
			});

		}

	}

	function triggershippingaddress() {
		$(".shippingaddressdiv").toggle();
		$(".billingaddressdiv").hide();
		$(".shippingaddressdivupdate").hide();
		$(".billingaddressdivupdate").hide();
	}

	function triggershippingaddress_edit(id) {
		$(".shippingaddressdiv").hide();
		$(".billingaddressdiv").hide();
		$(".billingaddressdivupdate").hide();


		$.ajax({
			url: '<?php echo base_url('home/shippingaddress_edit'); ?>',
			dataType: 'json',
			type: 'POST',
			data: 'id=' + id,
			success: function(data) {
				$("#shippingaddressupdatediv").html(data.addressformhtml);

			}
		});

	}

	function triggerbillingaddress() {
		$(".billingaddressdiv").toggle();
		$(".shippingaddressdiv").hide();
		$(".shippingaddressdivupdate").hide();
		$(".billingaddressdivupdate").hide();

	}

	function triggerbillingaddress_edit(id) {

		$(".shippingaddressdiv").hide();
		$(".billingaddressdiv").hide();
		$(".shippingaddressdivupdate").hide();

		$.ajax({
			url: '<?php echo base_url('home/billingaddress_edit'); ?>',
			dataType: 'json',
			type: 'POST',
			data: 'id=' + id,
			success: function(data) {
				$("#billingaddressupdatediv").html(data.addressformhtml);

			}
		});

	}

	// Billing Address Details (hide or Show )
	function samebillingfunction() {
		if ($('#same_billing').is(":checked")) {
			$('.displaybillingaddressdiv').hide();
			$(".billingaddressdiv").hide();
		} else {
			$('.displaybillingaddressdiv').show();

			<?php if ($client_id == '') { ?>
				$(".billingaddressdiv").show();
			<?php } ?>
		}
	}

	function goPayMethod() {

		swal({
			title: "Are you sure?",
			text: "You are trying to do Counter payment!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, Proceed it!",
			closeOnConfirm: false,
			buttons: true,
			dangerMode: true,
		}).then((isConfirm) => {
			if (isConfirm) {
				isSelectPayment = true;
				proceedtopay( 'counter');
				return true;
			}
		});

	}

	//Procced to pay
	function proceedtopay( from = ''  ) {

		var radioValue = $('input[name=checklogin]:checked').val();

		if( radioValue == 1 ) {
			//guest purchase
			var name_ship = $('#name_ship').val();
			var address_ship = $('#address_ship').val();
			var state_ship = $('#state_ship').val();
			var mobile_no_ship = $('#mobile_no_ship').val();
			var emailid_ship = $('#emailid_ship').val();
			var city_ship = $('#city_ship').val();
			var same_billing = $('#same_billing').val();

			if( name_ship == '' || address_ship == '' || state_ship == '' || mobile_no_ship == '' || emailid_ship == '' || city_ship == '' ) {
				swal("Information", "Please fill your shipping address fields", "warning");
				return false;
			}
			if( $('#same_billing').is(':checked') ) {
				// console.log('checked');
			} else {
				var name = $('#name').val();
				var address = $('#address').val();
				var zip_code = $('#zip_code').val();
				var city = $('#city').val();
				var state1 = $('#state1').val();
				var mobile_no = $('#mobile_no').val();
				if( name == '' || address == '' || zip_code == '' || city == '' || state1 == '' || mobile_no == '' ) {
					swal("Information", "Please fill your billing address fields", "warning");
					return false;
				}
			}
			
		} else {
			var addr = $('input[name=shippingaddressid]:checked').val();
			if( addr == '' || addr == undefined){
				swal("Information", "Please select your shipping address", "warning");
				return false;
			}
			
		}
		

		isSelectPayment = true;

		var payment_select_method 	= '';
		
		if (from != '' && from != undefined || from == null) {
			payment_select_method 	= from;
		}
		var errorcode = 0;
		// check shippingaddressid
		var shippingaddressid = '';
		<?php if ($client_id != '') { ?>
			var shippingaddressid = $('input[name=shippingaddressid]:checked').val();
			if (typeof(shippingaddressid) == 'undefined') {
				errorcode = 1;
				swal("Information", "Please choose your shipping address", "warning");
				return false;

			}
		<?php } else { ?>

			if ($('#shippingaddressForm').valid()) {
				var datas = $('#shippingaddressForm').serialize();

				if ($('#same_billing').is(":checked")) {
					var same_billing = $("#same_billing").val();
				} else {
					var same_billing = '';
				}

				$.ajax({
					url: 'home/AjaxAddShippingAddress',
					dataType: 'json',
					type: 'POST',
					async: false,
					data: datas + '&same_billing=' + same_billing,
					success: function(data) {

					}
				});

			}


		<?php } ?>

		//check Billingaddressid
		var billingaddressid = '';

		if ($('#same_billing').is(":checked")) {
			billingaddressid = '';
			var same_billing = 1;
		} else {
			var same_billing = '';
			billingaddressid = $('input[name=billingaddressid]:checked').val();
			<?php if ($client_id != '') { ?>
				if (typeof(billingaddressid) == 'undefined') {
					errorcode = 1;
					swal("Information", "Please choose your billing address", "warning");
					return false;
				}
			<?php } else { ?>

				if ($('#billingaddressForm').valid()) {
					var datas = $('#billingaddressForm').serialize();

					if ($('#same_billing').is(":checked")) {
						var same_billing = $("#same_billing").val();
					} else {
						var same_billing = '';
					}

					$.ajax({
						url: 'home/AjaxAddShippingAddress',
						dataType: 'json',
						type: 'POST',
						async: false,
						data: datas + '&same_billing=' + same_billing,
						success: function(data) {

						}
					});

				}


			<?php } ?>
		}


		//check shippingmethodid

		var shippingmethodid = $('input[name=shippingmethodid]:checked').val();
		//alert(shippingmethodid);
		if (typeof(shippingmethodid) == 'undefined') {
			errorcode = 1;
			swal("Information", "Please choose your shipping Method", "warning");
			return false;

		}

		//check shippingmethodid

		var confirmcart = $('input[name=confirmcart]:checked').val();

		if (typeof(confirmcart) == 'undefined') {
			errorcode = 1;
			swal("Information", "Please choose Terms & Conditions ", "warning");
			return false;

		}
		var coupon = $("#coupon").val();
		if (typeof(coupon) != 'undefined') {
			couponcode = coupon;
		} else {
			couponcode = '';
		}

		if (errorcode == 0 && isSelectPayment) {
			$.ajax({
				url: '<?php echo base_url('home/custompayment'); ?>',
				dataType: 'json',
				type: 'POST',
				data: 'shippingaddressid=' + shippingaddressid + '&billingaddressid=' + billingaddressid + '&shippingmethodid=' + shippingmethodid + '&confirmcart=' + confirmcart + '&couponcode=' + couponcode + '&payment_select_method=' + payment_select_method,
				beforeSend:function() {
					$('#loaderWrapper').show();
				},
				success: function(res) {
					$('#loaderWrapper').hide();
					if (res.pay_type == 'counter') {
						window.location.href = '<?= base_url() ?>custom-order-success/' + res.order_id;
					} else {

						var options = res;
						options.handler = function(response) {
							document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
							document.getElementById('razorpay_signature').value = response.razorpay_signature;
							document.razorpayform.submit();
						};

						// Boolean whether to show image inside a white frame. (default: true)
						options.theme.image_padding = false;

						options.modal = {
							ondismiss: function() {
								console.log("This code runs when the popup is closed");
							},
							// Boolean indicating whether pressing escape key 
							// should close the checkout form. (default: true)
							escape: true,
							// Boolean indicating whether clicking translucent blank
							// space outside checkout form should close the form. (default: false)
							backdropclose: false
						};

						var rzp = new Razorpay(options);
						rzp.open();
						//e.preventDefault();
					}

				}
			});
			/*  $('<form action="<?php echo base_url('home/payment'); ?>" method="POST"><input type="hidden" name="shippingaddressid" value="'+shippingaddressid+'"><input type="hidden" name="billingaddressid" value="'+billingaddressid+'"><input type="hidden" name="shippingmethodid" value="'+shippingmethodid+'"><input type="hidden" name="confirmcart" value="'+confirmcart+'"><input type="hidden" name="couponcode" value="'+couponcode+'"><input type="hidden" name="same_billing" value="'+same_billing+'"></form>').appendTo('body').submit(); */
		} else {
			goPayMethod();
		}

	}

	// Login Redirect
	function checkloginfun(id) {
		if (id == '2') {
			window.location.href = '<?= base_url('sign-in'); ?>';
		}
	}
</script>

<script>
	$("#state1, #country_ship, #country2").select2({
		allowClear: false
	});
</script>

<div id="ViewModal" class="modal fade" tabindex="-1" role="dialog">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<i class="lni lni-close"></i>
	</button>
	<div class="modal-dialog opacity-animate3">
		<div class="modal-content">
			<div class="modal-body">

				<?php include_once("terms_content.php"); ?>

			</div>
		</div>
	</div>
</div>
<script>
	(function($) {
		$(window).on("load", function() {

			$("#ViewModal .modal-body").mCustomScrollbar({
				setHeight: 500,
				theme: "dark-3"
			});

			$(".checkout-scroll").mCustomScrollbar({
				setHeight: 150,
				theme: "dark-3"
			});

		});
	})(jQuery);
</script>

<script>
	$(document).ready(function() {

		$('#sidebar').stickySidebar({
			sidebarTopMargin: 170,
			footerThreshold: 300
		});

	});
</script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>