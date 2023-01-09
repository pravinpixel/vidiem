<?php include('container/header.php'); ?>


<div class="bgPro SignUpPage clearfix login-bg">
	<section class="signsec clearfix">
		<div class="container">
			<div class="row justify-content-end">
				<div class="col-sm-12 col-md-12 col-lg-5">
		<div class="siginInSetTop clearfix bg-white shadow1 p-5">
		<form class="sgInSet clearfix mb-5" id="signIn" method="POST">
			<h2 class="siHead">Already registered?</h2>
				<h4 class="text-dark">Sign In</h4>
				<div class="divider"></div>
			<div class="row createAcc">
				<div class="col-sm-12 col-md-12">
					<div class="md-form">
					<input type="text" name="user_name" class="form-control" value="<?= set_value('user_name'); ?>">
					<?= form_error('user_name'); ?>
					<label for="">Email Id</label>
					
					</div>
				</div>
				<div class="col-sm-12 col-md-12">
					<div class="md-form">
					<input type="password" class="form-control" name="password">
					<?= form_error('password'); ?>
					<label for="">Password</label>
					
					<a class="d-flex justify-content-end" href="<?= base_url('forgot_password'); ?>" class="links">Forgot Password?</a>
					</div>
					
				</div>
				<div class="col-sm-12 col-md-12">
					<div class="row">
						<div class="col-sm-12 col-md-6">
							<button class="red-btn" type="submit"><i class="lni lni-enter"></i> &nbsp; Sign In</button>
						</div>
						<div class="col-sm-12 col-md-6">
							<a class="black-btn" href="<?= base_url('register'); ?>" class="links"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> &nbsp; Register <a>
						</div>
					</div>
				</div>
			</div>
			
		</form>
			<div class="divider"></div>
			<div class="sociLogin">
			   <!--<a class="btn btn-primary btn-block" href="javascript:;" id="fb-login-button">
				<i class="lni lni-facebook-filled"></i> &nbsp; Log in with Facebook
				</a>
					<p class="p-2 mb-0 text-center">OR</p>-->
				<!-- <a class="btn btn-secondary btn-block mt-0" href="javascript:open('<?php echo $loginURL; ?>', 'Google Login', 'height=500px,width=500px, resizable=no,location=1')">
					<i class="lni lni-google"></i> &nbsp; Log in with Google
				</a> -->
				 <!-- <p class="p-2 mb-0 text-center">OR</p> -->
			    <a href="<?= base_url(); ?>guest-login" class="linkerBtn btn btn-info btn-block mt-0">
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