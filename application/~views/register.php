<?php include('container/header.php'); ?>

<div class="bgPro SignUpPage clearfix">
	<section class="signsec clearfix light-gray-bg">
		<div class="container">
		<div class="row">
		<div class="col">
		<div class="siginInSetTop clearfix bg-white shadow1 p-5">
			<form class="signInput mb-5" method="post" action="">
				<h2 class="siHead">Sign Up / Register</h2>
				<h4 class="text-dark">Create an account</h4>
				<p>Please enter the below detail to create an account </p>
				<div class="divider"></div>
				<div class="row createAcc mt-5">
					<div class="col-sm-12 col-md-12 col-lg-12 mrMrs clearfix">
							<h6>Title:</h6>
							<label>
								<input name="gender" type="radio" value="Mr." <?= set_radio('gender','Mr.',TRUE);?> >
								Mr.
							</label> &nbsp;
							<label>
								<input name="gender" type="radio" value="Mrs." <?= set_radio('gender','Mrs.');?>>
								Mrs.
							</label>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="md-form">
						<input class="form-control" type="text" value="<?= set_value('name'); ?>" name="name">
						<label for="">Your Name</label>
						<?= form_error('name'); ?>
						</div>
					</div>

					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="md-form">
							<input type="text" name="dob" class="datepicker form-control" value="">
							<label for="">Date of Birth</label>
						<?= form_error('dob'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="md-form">
						<input type="text" class="form-control" value="<?= set_value('email'); ?>" name="email">
						<label for="">Mail Address</label>
						<?= form_error('email'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="md-form">
						<input type="text" class="form-control"  minlength="10"   maxlength="10" value="<?= set_value('mobile_no'); ?>" name="mobile_no">
						<label for="">Mobile Number</label>
						<?= form_error('mobile_no'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="md-form">
						<input class="form-control" type="password" value="<?= set_value('password'); ?>" name="password">
						<label for="">Password</label>
						<?= form_error('password'); ?>
						<small class="text-red">At least 6 Characters</small>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="md-form">
						<input type="password" class="form-control" value="<?= set_value('confirm_password'); ?>" name="confirm_password">
						<label for="">Confirm Password</label>
						<?= form_error('confirm_password'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12 newSignUp pt-1">					
						<div class="custom-checkbox">
							<label>
							  <input type="checkbox" name="newsletter" value="1"  <?= set_checkbox('newsletter',1);?>>
							  <span class="box"></span>
							  Sign up for our newsletter!
							</label>
						</div>
						<div class="custom-checkbox">
							<label>
							  <input type="checkbox" name="special_offer" value="1" <?= set_checkbox('special_offer',1);?>>
							  <span class="box"></span>
							  Receive special offers from our partners!
							</label>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4 pt-3">
					<button class="red-btn"><i class="lni lni-user"></i> &nbsp; Create your account</button>
					</div>
				</div>
				<!--<a href="<?= base_url('sign-in'); ?>" class="links">Sign Up</a>-->
				
			</form>
			<div class="divider"></div>
			<div class="sociLogin d-flex mt-5">
			  <!-- <a class="btn btn-primary mr-2" href="javascript:;" id="fb-login-button">
				<i class="lni lni-facebook-filled"></i> &nbsp; Log in with Facebook
				</a>
					<p class="pt-3 pl-2 pr-2 mb-0">OR</p>  -->
				<a class="btn btn-secondary mr-2" href="javascript:open('<?php echo $loginURL; ?>', 'Google Login', 'height=500px,width=500px, resizable=no,location=1')">
					<i class="lni lni-google"></i> &nbsp; Log in with Google
				</a>
				 <p class="pt-3 pl-2 pr-2 mb-0">OR</p>
			    <a href="<?= base_url(); ?>guest-login" class="linkerBtn btn btn-info">
					Login with OTP
				</a>
				
				
				
			</div>
		</div>
		</div>
		</div>
		</div>
	</section>
<?php //require_once('container/top_seller.php'); ?>	
</div>
<?php require_once('container/footer.php')?>