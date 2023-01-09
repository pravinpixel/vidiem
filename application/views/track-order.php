 <?php include('container/header.php'); ?>
<section class="ban-next light-gray-bg pb-0">
	<div class="container">
		<div class="row">
			<div class="col mb-5">
				<h1 class="text-red" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Track Order</h1>
				<h2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Track Your Order</h2>
			</div>
		</div>
	</div>
</section>
<section class="light-gray-bg pt-0">
<div class="bgPro SignUpPage container bg-white p-5 shadow1">
	<div class="signsec row">
		<div class="siginInSetTop col">
			<form class="signInput" method="post" action="" style="margin: 0 auto;float: none;">
				<h3 class="siHead text-red">Track Order</h3>
				<?php if(!empty($tracked)){ ?>
				<div class="createAcc row">
					
					<div class="col-sm-12 col-md-6">
						<h5>Your Invoice Number</h5>
						<input type="text"  disabled="" value="<?= @$order['code']; ?>" name="code">
					</div>
					<div class="col-sm-12 col-md-6">
						<h5>Order Status</h5>
						<input type="text" disabled="" value="<?= @$order['order_status']==2?'Shipped':'Delivered'; ?>" name="email">
					</div>
					<div class="col-sm-12 col-md-6">
						<h5>Courier</h5>
						<input type="text" disabled="" value="<?= @$order['courier_name']; ?>" name="email">
					</div>
					<div class="col-sm-12 col-md-6">
						<h5>Tracking Id</h5>
						<input type="text" disabled="" value="<?= @$order['tracking_code']; ?>" name="email">
					</div>
					<div class="col-sm-12 col-md-6">
						<h5>Notes:</h5>
						<input type="text" disabled="" value="<?= @$order['notes']; ?>" name="email">
					</div>
					<div class="col-sm-12 col-md-6">
						<a class="btn" href="<?= $track_url;?>" style="width: 100%;" target="_blank">
					Track Live Status
						</a>
					</div>	
					
				</div>
			<?php }else{ ?>
				<div class="createAcc row">
					<div class="col-sm-12 col-md-4">
						<div class="md-form">
						<input type="text" class="form-control" value="<?= set_value('code'); ?>" name="code">
						<label for="">Your Invoice Number</label>
						<?= form_error('code'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-4">
						<div class="md-form">
						<input type="text" class="form-control" value="<?= set_value('email'); ?>" name="email">
						<label for="">Mail Address</label>
						<?= form_error('email'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-4">
						<button class="red-btn small">Submit</button>
					</div>
				</div>
				<!--<a href="<?= base_url('sign-in'); ?>" class="links">Sign Up</a>-->
			<?php } ?>
			</form>
			<div class="sociLogin">
				<!-- <a class="btn" href="javascript:open('<?= @$FbloginUrl; ?>', 'Facebook Login', 'height=500px,width=500px, resizable=no,location=1')">
					<img src="<?= base_url(); ?>assets/front-end/images/fbl.png" alt="fb" />
					Log in with Facebook
				</a>
				<p>OR</p>
				<a class="btn" href="javascript:open('<?php echo $loginURL; ?>', 'Google Login', 'height=500px,width=500px, resizable=no,location=1')
">
					<img src="<?= base_url(); ?>assets/front-end/images/gpl.png" alt="fb" />
					Log in with Google
				</a> -->
			</div>
		</div>
	</div>
</div>
</section>
<?php require_once('container/footer.php')?>