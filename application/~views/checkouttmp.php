<?php require_once('container/header.php'); ?>
<script>
    fbq('track', 'InitiateCheckout');
</script>
<?php $client_id=$this->session->userdata('client_id'); ?>
<div class="bgPro proDetaPage clearfix AddressUpdater">
	
	<section class="checkLeft clearfix">
		<ul class="tabCheckOut clearfix">
			<li class="<?= (empty($client_id)?'current':''); ?>" data-tab="tab-1">Log In</li>
			<li class="address_li <?= (empty($client_id)?'':'current tab'); ?>" data-tab="tab-2">Address</li>
			<li class="shipping_li" data-tab="tab-3">Shipping</li>
			<li class="payment_li" data-tab="tab-4">Payment</li>
		</ul>

		<div id="tab-1" class="tab-content <?= (empty($client_id)?'current':''); ?> checkOutSingin clearfix">
			<div class="siginInSetTop clearfix">
				<form class="signInput checkout_register_form">
					<h4 class="siHead">Sign Up / Register</h4>
					<!--<p class="signOff">Sign up to get 5% off</p>-->
					<ul class="createAcc" method="POST">
						<li>
							<h4>Create an account</h4>
							<p>Please enter the below detail to create an account </p>
						</li>
						<li class="mrMrs clearfix">
							<h5>Title:</h5>
							<label>
								<input name="sex" type="radio" checked="checked" value="Mr.">
								<p>Mr.</p>
							</label>
							<label>
								<input name="sex" type="radio" value="Mrs.">
								<p>Mrs.</p>
							</label>
						</li>
						<li>
							<h5>Your Name</h5>
							<input type="text" placeholder="Enter your name" name="name" class="register_name">
							<div class="register_name_error"></div>
						</li>
						<li>
							<h5>Date of Birth</h5>
							<input type="text" placeholder="yyyy/mm/dd" id="J-demo-01" name="dob" class="register_dob">
							<script type="text/javascript">
					            $('#J-demo-01').dateTimePicker();
					        </script>
					        <div class="register_dob_error"></div>
						</li>
						<li>
							<h5>Mail Address</h5>
							<input type="text" placeholder="Enter your mail id" name="email" class="register_email">
					        <div class="register_mail_error"></div>
						</li>
						<li>
							<h5>Mobile Number</h5>
							<input type="text" placeholder="Mobile number" name="mobile_no" class="register_mobile_no">
					        <div class="register_mobile_error"></div>
						</li>
						<li>
							<h5>Password</h5>
							<input type="password" placeholder="At least 6 characters" name="password" class="register_password">
					        <div class="register_password_error"></div>
						</li>
						<li class="newSignUp">
							<label>
								<input type="checkbox" name="newsletter" value="1" class="register_newsletter">
								Sign up for our newsletter!
							</label>
						</li>
						<li class="newSignUp">
							<label>
								<input type="checkbox" name="special_offer" value="1" class="register_special_offer">
								Receive special offers from our partners!
							</label>
						</li>
					</ul>
					<button class="btn checkout_register">Create an account</button>
				</form>

				<form class="signInput checkout_otpcode_form hide">
					<h4 class="siHead">Verify OTP</h4>
					<ul class="createAcc" method="POST">
						<li>
							<p>Please enter otp code to verify your mobile no. </p>
						</li>
						<li>
							<h5>OTP Code</h5>
							<input type="text" placeholder="Enter OTP Code" name="sms_code">
							<div class="verify_otp_error"></div>
						</li>
					</ul>
					<button class="btn checkout_verify">Verify OTP</button>
				</form>


				<form class="sgInSet clearfix checkout_sign_in_form" id="signIn">
					<p>Already registered?</p>
					<h4 class="siHead">Sign In</h4>
					<ul class="createAcc">
						<li>
							<h5>Email or Phone number</h5>
							<input type="text" placeholder="Enter your name" name="user_name">
							<div class="signin_username_error"></div>
						</li>
						<li>
							<h5>Password</h5>
							<input type="password" placeholder="Enter password" name="password">
							<div class="signin_password_error"></div>
						</li>
					</ul>
					<button class="btn checkout_sign_in">Sign In</button>
				</form>
				
				<form class="sgInSet gestLogin clearfix guestcheckout_register_form" id="gestLogIn">
					<h4 class="siHead">Guest LogIn</h4>
					<ul class="createAcc">
						<li>
							<h5>Your Name</h5>
							<input type="text" placeholder="Enter your name" name="guestname" class="guestregister_name">
							<div class="guestregister_name_error"></div>
						</li>
						<li>
							<h5>Mail Address</h5>
							<input type="text" placeholder="Enter your mail id" name="guestemail" class="guestregister_email">
					        <div class="guestregister_mail_error"></div>
						</li>
						<li>
							<h5>Mobile Number</h5>
							<input type="text" placeholder="Mobile number" name="guestmobile_no" class="guestregister_mobile_no">
					        <div class="guestregister_mobile_error"></div>
						</li>
					</ul>
					<button class="btn guestcheckout_register gestBtn">Create</button>
				</form>
				
			</div>
		</div>
        <form method="POST" action="<?= base_url('payment'); ?>">
		<div id="tab-2" class="tab-content <?= (empty($client_id)?'':'current'); ?> checkOutSingin clearfix">
				<?php if(!empty($shipping_address)){ ?>
				<ul class="choseAdd clearfix">
					<li>
						<div class="chooseAdPo">
							<h5>Choose a address:</h5>
							<select name="delivery_address" class="delivery_address_trigger">
								<?php if(!empty($shipping_address)){
									foreach ($shipping_address as $info) { ?>		
									<option value="<?= $info['id']; ?>" <?= (@$ship_id==$info['id'])?'selected':''; ?>><?= $info['title']; ?></option>
								<?php }} ?>
							</select>
							<label class="inChanBill">
								<input type="checkbox" name="same_billing" <?= (@$same==1)?'checked="checked"':''; ?> value="1" class="billing_trigger">
								Use the delivery address as the billing address.
							</label>
						</div>
					</li>
					<li class="billing_div <?= (@$same==1)?'hide':''; ?>">
						<div class="chooseAdPo">
						<h5>Choose a Billing address:</h5>
							<select name="billing_address" class="billing_address_trigger">
								<?php if(!empty($billing_address)){
									foreach ($billing_address as $info) { ?>		
									<option value="<?= $info['id']; ?>" <?= (@$bill_id==$info['id'])?'selected':''; ?>><?= $info['title']; ?></option>
								<?php }} ?>
							</select>
						</div>	
						<a href="javascript:void(0);" class="btn add_address_trigger" data-type="2" style="width: 230px;">Add to new address</a>
					</li>

				</ul>
				
				<ul class="showFinAdd clearfix">
					<li>
						<div class="yourAdd">
							<h3>Your delivery address</h3>
							<div class="delivery_address_div">
							</div>
						</div>
					</li>

					<li>
						<div class="yourAdd">
							<h3>Your billing address</h3>
							<div class="billing_address_div">
							</div>
						</div>
					</li>
					<li>
						<a href="javascript:void(0);" class="btn add_address_trigger" data-type="1">Add to new address</a>
					</li>
				</ul>
			<?php } else{?>
				<ul class="choseAdd clearfix">
					<li style="float: none;">
						<div class="chooseAdPo">
							<h5>Choose a address:</h5>
						</div>	
					</li>
					<li>
						<a href="<?= base_url('add-address/checkout?type=1&same=1'); ?>" class="btn" style="width: 230px;">Add to new address</a>
					</li>
				</ul>
			<?php } ?>	
				<div class="proccedBtns clearfix">
					<a href="<?= base_url(); ?>" class="btn conshop">Continue shopping</a>
					<div class="nextPreBtn clearfix">
						<button class="nextBtn btn address_move">Procced to checkout <i class="fa fa-arrow-right"></i></button>
					</div>
				</div>
		</div>

		<div id="tab-3" class="tab-content checkShipping clearfix">
			<h4 class="siHead">Choose your delivery method</h4>
			<div class="shippingMeth">
				<h5>Choose a shipping option for this address: Home Address</h5>
				<ul class="optionShipping">
					<li class="clearfix">
						<label>
							<input type="radio" name="shippingOption" checked="checked">
							<p>Surface Shipping (FedEx / India Post / Blue Dart / DTDC / ST.,) 4 to 10 Days Approx	</p>
						</label>
						<p class="chargeShip">Free Shipping</p>
					</li>
				</ul>
			</div>
			<div class="readTerms">
				<h5>Terms of service</h5>
				<label>
					<input type="checkbox" name="terms" value="1" class="terms_trigger">
					I agree to the terms of service and will adhere to them unconditionally.<a href="javascript:void(0);">(Read the Terms of Service)</a>
				</label>
			</div>
			<div class="proccedBtns clearfix">
				<a href="index.php" class="btn conshop">Continue shopping</a>
				<div class="nextPreBtn clearfix">
					<button class="prevBtn btn"><i class="fa fa-arrow-left"></i> Back</button>
					<button class="nextBtn btn shipping_move">Procced to checkout <i class="fa fa-arrow-right"></i></button>
				</div>
			</div>
		</div>

		<div id="tab-4" class="tab-content checkShipping clearfix">
			<div class="addSetCarFu clearfix">	
				<ul class="ckProde finalCheck clearfix">
					<?php $contents=$this->cart->contents(); 
					if(!empty($contents)){
						foreach ($contents as $info) { ?>
					<li class="clearfix">
						<div class="ckproimgleft">
							<div class="ckfinimg">
								<img src="<?= base_url('uploads/images/'.$info['image']); ?>" alt="" />
							</div>
						</div>	

						<div class="ckproimgright clearfix">
							<h4 class="ckproname"><?= $info['name']; ?></h4>
							<p>Model: <?= $info['modal_no']; ?></p>
							<p>Item: <?= $info['qty']; ?></p>
							<p class="priceCartDe"><i class="fa fa-inr"></i> <?= number_format($info['price']); ?>/-</p>
						</div>
					</li>
					<?php } } ?>
				</ul>
				<div class="ckPriceDe finalCheckPrice clearfix">
						<h4 class="ckproname">Price Detail</h4>
						<ul class="clearfix prival">
							<li class="clearfix">
								<p class="priceti">Total products (tax incl.)</p>
								<p class="priceAm"><i class="fa fa-inr"></i> <?= number_format($this->cart->total()); ?>/-</p>
							</li>
							<li class="clearfix">
								<p class="priceti">Delivery Charges</p>
								<p class="priceAm gre">Free</p>
							</li>
						<?php if(!empty($discount['status'])){ ?>
						    <input type="hidden" name="coupon" value="<?= $discount['code'];?>">
							<li class="clearfix">
							<?php if($discount['type']==1){ ?>
							<p class="priceti">Discount <?= number_format($discount['value']); ?>% </p>
                        <p class="priceAm"><i class="fa fa-inr"></i> <?= number_format($discount['amount']); ?></p>
							<?php }else{ ?>	
	                        <p class="priceti">Discount</p>
	                        <p class="priceAm"><i class="fa fa-inr"></i> <?= number_format($discount['amount']); ?></p>
	                        <?php } ?>
	                        </li>
							<li class="clearfix toamount">
								<p class="priceti finPrTi">AMOUNT PAYABLE</p>
								<p class="priceAm finPrice"><i class="fa fa-inr"></i> <?= number_format($this->cart->total()-$discount['amount']); ?>/-</p>
							</li>
						<?php } else {?>
							<li class="clearfix toamount">
								<p class="priceti finPrTi">AMOUNT PAYABLE</p>
								<p class="priceAm finPrice"><i class="fa fa-inr"></i> <?= number_format($this->cart->total()); ?>/-</p>
							</li>
						<?php } ?>	
						</ul>
				</div>
			 </div>
			 <div class="proccedBtns clearfix">
				<a href="<?= base_url(); ?>" class="btn conshop">Continue shopping</a>
				<div class="nextPreBtn clearfix">
					<button class="prevBtn btn"><i class="fa fa-arrow-left"></i> Back</button>
					<input type="hidden" name="checkout" value="1">
					<button class="nextBtn pay_proc_btn btn" type="submit">Procced to Payment <i class="fa fa-arrow-right"></i></button>
				</div>
			</div>
		</div>
	</section>
</form>
<?php //require_once('container/top_seller.php'); ?>
</div>
<script type="text/javascript">
var paymentButton = document.querySelector('button.pay_proc_btn');
paymentButton.addEventListener("click", () => {
    fbq('track', 'AddPaymentInfo');
});
</script>
<?php require_once('container/footer.php'); ?>