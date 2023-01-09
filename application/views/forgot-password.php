<?php include('container/header.php'); ?>

<div class="bgPro SignUpPage clearfix login-bg">
	<section class="signsec clearfix">
		<div class="container">
		<div class="row justify-content-end">
				<div class="col-sm-12 col-md-6 col-lg-5">
		<div class="siginInSetTop clearfix bg-white shadow1 p-5">
			<form class="signInput" method="post" action="">
				<h2 class="siHead">Forgot Password</h2>
				<p>Don't worry! Just fill in your email and we'll send you a link to reset your password.</p>
				<div class="divider"></div>
				<div class="row createAcc">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="md-form">
						<input type="text" class="form-control" value="<?= set_value('email'); ?>" name="email">
						<label for="">Email Id</label>
						<?= form_error('email'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12">						
						<button class="red-btn"><i class="lni lni-key"></i> &nbsp; Send New Password</button>
					</div>
				</div>
			</form>
		</div>
		</div>
		</div>
		</div>
	</section>
<?php //require_once('container/top_seller.php'); ?>	
</div>
<?php require_once('container/footer.php')?>