<?php include('container/header.php'); ?>

<div class="bgPro SignUpPage clearfix">
	<section class="signsec clearfix">
		<div class="siginInSetTop clearfix">
			<form class="signInput" method="post" action="">
				<h4 class="siHead">OTP Verification</h4>
				<ul class="createAcc">
					<li>
						<h5>Otp Code</h5>
						<input type="text" placeholder="Enter Otp Code" value="<?= set_value('otp'); ?>" name="otp">
						<?= form_error('otp'); ?>
					</li>
					<li>
						<h5>Password</h5>
						<input type="password" placeholder="Enter Password" value="" name="password">
						<?= form_error('password'); ?>
					</li>
					<li>
						<h5>Confirm Password</h5>
						<input type="password" placeholder="Enter Confirm Password" value="" name="confirm_password">
						<?= form_error('confirm_password'); ?>
					</li>
				</ul>
				<button class="btn">Update Password</button>
			</form>
		</div>
	</section>
<?php //require_once('container/top_seller.php'); ?>	
</div>
<?php require_once('container/footer.php')?>