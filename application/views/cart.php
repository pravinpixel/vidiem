<?php include('container/header.php'); ?>
<div class="bgPro proDetaPage clearfix light-gray-bg">
	<form method="POST" action="<?= base_url('checkout'); ?>">
	<section class="checkOutDet clearfix ck_product_all">
	<div class="container">
			<div class="row">
				<div class="col">
					<h2>Your Cart</h2>
					<ul class="cart-tab">
						<li>
							<a class="active" href="<?= base_url('cart'); ?>">
								01 Shopping Cart
							</a>
						</li>
						<li>
							<a href="<?= base_url('checkout'); ?>">
								02 Account Shipping
							</a>
						</li>
						<li>
							<a href="order-confirm.php">
								03 Order Confirmation
							</a>
						</li>
					</ul>
				</div>
			</div>
	<div class="row ck_product_all">
	<div class="col-sm-12 col-md-12 col-lg-12 col-xl-8">
	 <?php $content=$this->cart->contents();
	 //print_r($content); exit;
	  if(!empty($content)){ ?>
	  <div class="addSetCarFu clearfix">	
		<ul class="ckProde clearfix ck_product_listing">
			<?php foreach($content as $key=>$info){ ?>
			<li class="clearfix">
				<div class="ckproimgleft">
					<div class="ckfinimg">
					<a href="<?= base_url('product/'.$info['slug']); ?>" >
						<img src="<?= base_url('uploads/images/'.$info['image']); ?>" alt="" class="img-fluid" />
					</a>	
					</div>	
					<div class="ckproimgright clearfix">
						<a href="<?= base_url('product/'.$info['slug']); ?>" >
						<h4 class="ckproname"><?= $info['name']; ?></h4>
						</a>
						<p>Model: <?= $info['modal_no']; ?></p>
						<p class="priceCartDe"><i class="fa fa-inr"></i> <?= number_format($info['price']*$info['qty']); ?>/-</p>
					</div>
					<div class="itemsbye clearfix">
						<div class="plus-minus">
							<div class="value-button decrease" value="Decrease Value">-</div>
								<input type="text" class="number product_count" id="number" readonly value="<?= $info['qty']; ?>" min="1" max="10" data-id="<?= $key;?>">
							<div class="value-button increase" value="Increase Value">+</div>
						</div>
						<div class="ckclosebtn">
							<a href="javascript:void(0);" class="remove_from_cart_page"  data-id="<?= $key; ?>">Remove</a>
						</div>
                    </div>
				</div>
			</li>
		<?php } ?>
		</ul>
		</div>
		</div>
		<div class="col-sm-12 col-md-12 col-lg-12 col-xl-4">
		<div class="ckPriceDe clearfix bg-white shadow1 p-4">
				<h4 class="ckproname text-dark mb-4">Price Detail</h4>
				<ul class="clearfix prival ck_product_pricing">
					<li class="clearfix">
						<p class="priceti">Price (<?= number_format($this->cart->total_items()); ?> Item)</p>
						<p class="priceAm"><i class="fa fa-inr"></i> <?= number_format($this->cart->total()); ?>/-</p>
					</li>
					<li class="clearfix">
						<p class="priceti">Delivery Charges</p>
						<p class="priceAm gre">Free</p>
					</li>
					<li class="clearfix">
						<p class="priceti">GST No</p>
						<p class="priceAm"><input type="text" class="form-control" name="gst_no" id="gst_no"></p>
					</li>
					<li class="clearfix toamount">
						<p class="priceti">AMOUNT PAYABLE</p>
						<p class="priceAm text-red"><i class="fa fa-inr"></i> <?= number_format($this->cart->total()); ?>/-</p>
					</li>
				</ul>
		<div class="clearfix"></div>
		
		<div class="coupen clearfix">
			<h4 class="text-dark mb-3">Coupon</h4>
			<div class="d-flex mb-4">
			<input type="text" name="coupon" placeholder="Coupon Code" class="coupon_code">
			<input type="hidden" name="from_cart" value="1">
			<button class="coupon_code_trigger">Apply</button>
			<button class="coupon_code_cancel hide ml-2">Clear</button>
			</div>
		</div>
		<div class="proccedBtn clearfix">
			<div class="mb-3">
			<button type="submit" class="checkout-btn red-btn "><i class="lni lni-wallet"></i> &nbsp; Proceed to Checkout</button> <br/>
			<a href="<?= base_url(); ?>" class="conshop-btn black-btn mb-3"><i class="lni lni-cart"></i> &nbsp; Add More Products</a>
			
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