<?php include('container/header.php'); ?>

<div class="bgPro SignUpPage clearfix light-gray-bg">
	<section class="signsec clearfix">
		<div class="container">
			<div class="row">
				<div class="col">
		<div class="siginInSetTop clearfix bg-white shadow1 p-5">
			<form class="signInput gestLogin chkGuestForm mb-5" method="post" action="" id="gestLogIn">
				<h2 class="siHead">Guest Login</h2>
				<h4 class="text-dark">Login with OTP</h4>
				<p>Please enter the below detail to Login with OTP</p>
				<div class="divider"></div>
				<div class="createAcc guest-detail row">					
                     <div class="col-sm-12 col-md-6 col-lg-4">
						<div class="md-form">
							<input type="text" class="form-control" name="guestname" class="guestregister_name">
							<label for="">Your Name</label>
							<div class="guestregister_name_error"></div>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="md-form">
							<input type="text" class="form-control" name="guestemail" class="guestregister_email">
							<label for="">Mail Address</label>
					        <div class="guestregister_mail_error"></div>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="md-form">
							<input type="text" class="form-control"  minlength="10"    maxlength="10"  name="guestmobile_no" class="guestregister_mobile_no">
							<label for="">Mobile Number</label>
					        <div class="guestregister_mobile_error"></div>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-3 pt-2">
						<button class="red-btn guestcheckout_register gestBtn guest-detail"><i class="lni lni-user"></i> &nbsp; Create Account</button>
					</div>
				</div>
				
				<div class="row createAcc guest-otp hide mt-5" style="display:none">
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="md-form">
						<input type="text" name="sms_code" class="guestregister_otp form-control">
						
						<label for="">Enter OTP</label>
						<div class="sms_code_error"></div>
						<div class="sms_code_success" style="color: green;"></div>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-2 pt-2">
						<button class="black-btn guest-otp guest-otp-submit hide"><i class="lni lni-checkmark-circle"></i> &nbsp; Verify</button>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-2 pt-2">
						<button class="red-btn guestcheckout_edit hide"><i class="lni lni-pencil-alt"></i> &nbsp; Edit</button>				
					</div>
					
				</div>
				
			</form>
			<div class="divider"></div>
			<div class="sociLogin d-flex mt-5">
			   <!--  <a class="btn btn-primary mr-2" href="javascript:;" id="fb-login-button">
						<i class="lni lni-facebook-filled"></i> &nbsp; Log in with Facebook
				</a>  
					<p class="pt-3 pl-2 pr-2 mb-0">OR</p>-->
				<!--<a class="btn btn-info" href="javascript:open('<?php echo $loginURL; ?>', 'Google Login', resizable=no,location=1')">-->
				<!--	<i class="lni lni-google"></i> &nbsp; Log in with Google-->
				<!--</a>-->
			</div>
		</div>
		</div>
		</div>
		</div>
	</section>
<?php //require_once('container/top_seller.php'); ?>	
</div>
<?php require_once('container/footer.php')?>