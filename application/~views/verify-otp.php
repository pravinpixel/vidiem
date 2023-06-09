<?php include('container/header.php'); ?>

<div class="bgPro SignUpPage clearfix">
	<section class="signsec clearfix">
		<div class="siginInSetTop clearfix">
			<form class="signInput" method="post" action="">
				<h4 class="siHead">Verification Code</h4>
				<ul class="createAcc">
					<li>
						<h5>SMS Code</h5>
						<input type="text" placeholder="Enter SMS Code" value="<?= set_value('sms_code'); ?>" name="sms_code">
						<?= form_error('sms_code'); ?>
					</li>
				</ul>
				<button class="btn">Verify</button>
			</form>
		</div>
	</section>
<?php //require_once('container/top_seller.php'); ?>	
</div>
<?php require_once('container/footer.php')?>