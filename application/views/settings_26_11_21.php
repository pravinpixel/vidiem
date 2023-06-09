<?php include('container/header.php'); ?>

<section class="ban-next light-gray-bg pt-5">
	<div class="container clearfix">
		<div class="row">
			<div class="col">
				<h2>User Dashboard</h2>
				<h3>My Account</h3>
				<p>Welcome to your account. Here you can manage all of your information</p>
			</div>
		</div>
	<div class="bgPro contactUs userDash clearfix bg-white shadow1 p-5 mt-4">
	<div class="clearfix userSetDash" id="div">
		<div class="useDaFull clearfix">
			<div class="dahSection clearfix">
				<div class="row">
					<div class="col-sm-12 col-md-4 col-lg-3 light-gray-bg">
						<div class="Daslogo text-center pt-3 pb-3 gray-bg mb-4 mt-3">
							<img src="<?= base_url(); ?>assets/front-end/images/logo.png" alt="" />
						</div>
						<ul class="leftDashMenu">							
							<a href="<?= base_url('user/dashboard#div'); ?>"><li class="dasTabFun" data-tab="tab-1">
								<i class="fa fa-list-ul"></i> Order Details
							</li></a>
							<!--<a href="<?= base_url('user/credit_slips#div'); ?>"><li class="dasTabFun" data-tab="tab-2">
								<i class="fa fa-credit-card-alt"></i> My Credit Slips
							</li></a>-->
							<a href="<?= base_url('user/address#div'); ?>"><li class="dasTabFun" data-tab="tab-3">
								<i class="fa fa-tags"></i> My Address
							</li></a>
							<a href="<?= base_url('user/settings#div'); ?>">
							<li class="dasTabFun current" data-tab="tab-4">
								<i class="fa fa-user"></i> My Account Setting
							</li></a>
						</ul>
					</div>
					<div class="col-sm-12 col-md-8 col-lg-9">
						<div class="dasnAnwSet pl-4">
					<div id="tab-4" class="tab-content dasBRide clearfix current">
						<h3>Your personal information</h3>
						<p>Please be sure to update your personal information if it has changed.</p>
						<div class="divider"></div>
						<div class="userDetails clearfix">
							<!--<form class="signInput" method="POST" action="">
								<ul class="createAcc">
									<li class="mrMrs clearfix">
											<h5>Title:</h5>
											<label>
												<input name="gender" type="radio" value="Mr." <?= set_radio('gender','Mr.',(@$Edit_Result['gender']=='Mr.'?TRUE:''));?>>
												<p>Mr.</p>
											</label>
											<label>
												<input name="gender" type="radio" value="Mrs." <?= set_radio('gender','Mrs.',(@$Edit_Result['gender']=='Mrs.'?TRUE:''));?>>
												<p>Mrs.</p>
											</label>
											<label>
												<input name="gender" type="radio" value="Ms." <?= set_radio('gender','Ms.',(@$Edit_Result['gender']=='Ms.'?TRUE:''));?>>
												<p>Ms.</p>
											</label>
										<?= form_error('gender'); ?>
										</li>
									<li>
										<h5>Your Name</h5>
										<input type="text" value="<?= set_value('name',@$Edit_Result['name']); ?>" name="name" placeholder="Enter your name">
										<?= form_error('name'); ?>
									</li>
									<li>
										<h5>Date of Birth</h5>
										<input type="text" value="<?= set_value('dob',(@$Edit_Result['dob']=='0000-00-00')?'1990-01-01':$Edit_Result['dob']); ?>" name="dob" placeholder="yyyy/mm/dd" id="J-demo-01">
								        <?= form_error('dob'); ?>
									</li>
									
									<li>
										<h5>New Password</h5>
										<input type="password" placeholder="At least 6 characters" name="password">
										<?= form_error('password'); ?>
									</li>
									<li>
										<h5>Confirm Password</h5>
										<input type="password" placeholder="" name="confirm_password">
										<?= form_error('confirm_password'); ?>
									</li>
									<li class="newSignUp">
										<label>
											<input type="checkbox" name="newsletter" value="1" <?= set_checkbox('newsletter',1,(@$Edit_Result['newsletter']==1?TRUE:'')); ?>>
											Sign up for our newsletter
										</label>
									</li>
									<li class="newSignUp">
										<label>
											<input type="checkbox" name="special_offer" value="1" <?= set_checkbox('special_offer',1,(@$Edit_Result['special_offer']==1?TRUE:'')); ?>>
											Receive special offers.
										</label>
									</li>
								</ul>
								<button class="btn">Save Changes</button>
							</form>-->
							
							<?php if($Edit_Result['role'] != 2){?>
							<form class="signInput" method="POST" action="">
							<input type="hidden" name="role" value="<?= @$Edit_Result['role']; ?>">
								<div class="row createAcc">
									<div class="col-sm-12 col-md-12 col-lg-12 mrMrs clearfix">
											<h5>Title:</h5>
											<div class="form-check form-check-inline">
											<label>
												<input name="gender" type="radio" value="Mr." <?= set_radio('gender','Mr.',(@$Edit_Result['gender']=='Mr.'?TRUE:''));?>>
												Mr.
											</label>
											</div>
											<div class="form-check form-check-inline">
											<label>
												<input name="gender" type="radio" value="Mrs." <?= set_radio('gender','Mrs.',(@$Edit_Result['gender']=='Mrs.'?TRUE:''));?>>
												Mrs.
											</label>
											</div>
											<div class="form-check form-check-inline">
											<label>
												<input name="gender" type="radio" value="Ms." <?= set_radio('gender','Ms.',(@$Edit_Result['gender']=='Ms.'?TRUE:''));?>>
												Ms.
											</label>
											</div>
										<?= form_error('gender'); ?>
									</div>
									<div class="col-sm-12 col-md-6 col-lg-4">
										<div class="md-form">
										<input type="text" value="<?= set_value('name',@$Edit_Result['name']); ?>" name="name" class="form-control">
										<label for="">Your Name</label>
										<?= form_error('name'); ?>
										</div>
									</div>
									<div class="col-sm-12 col-md-6 col-lg-4">
									<div class="md-form">
										<input type="text" value="<?= set_value('dob',(@$Edit_Result['dob']=='0000-00-00')?'1990-01-01':$Edit_Result['dob']); ?>" name="dob" class="form-control datepicker" id="">
										<label for="">Date of Birth</label>
								        <?= form_error('dob'); ?>
									</div>
									</div>
									
									<div class="col-sm-12 col-md-6 col-lg-4">
									<div class="md-form">
										<input type="password" class="form-control" name="password">
										<label for="">New Password</label>
										<?= form_error('password'); ?>
									</div>
									</div>
									<div class="col-sm-12 col-md-6 col-lg-4">
									<div class="md-form">
										<input type="password" class="form-control" name="confirm_password">
										<label for="">Confirm Password</label>
										<?= form_error('confirm_password'); ?>
									</div>
									</div>
									<div class="col-sm-12 col-md-6 col-lg-4 pt-4 newSignUp">
									<div class="custom-checkbox">
										<label>
											<input type="checkbox" name="newsletter" value="1" <?= set_checkbox('newsletter',1,(@$Edit_Result['newsletter']==1?TRUE:'')); ?>>
											<span class="box"></span>
											Sign up for our newsletter
										</label>
									</div>
									</div>
									<div class="col-sm-12 col-md-6 col-lg-4 pt-4 newSignUp">
									<div class="custom-checkbox">
									<label>
											<input type="checkbox" name="special_offer" value="1" <?= set_checkbox('special_offer',1,(@$Edit_Result['special_offer']==1?TRUE:'')); ?>>
											<span class="box"></span>
											Receive special offers.
										</label>
									</div>
									</div>
								</div>
								<div class="row justify-content-end">									
									<div class="col-sm-12 col-md-6 col-lg-4 pt-3 newSignUp">
										<button class="red-btn" type="submit">Save Changes</button>
									</div>
								</div>
							</form>
						<?php } ?>

						<?php if($Edit_Result['role'] == 2){?>
							<form class="signInput" method="POST" action="">
								<input type="hidden" name="role" value="<?= @$Edit_Result['role']; ?>">
								<ul class="createAcc">
									
									<li>
										<h5>Your Name</h5>
										<input type="text" value="<?= set_value('rname',@$Edit_Result['name']); ?>" name="rname" placeholder="Enter your name">
										<?= form_error('rname'); ?>
									</li>
									
									
									<li>
										<h5>New Password</h5>
										<input type="password" placeholder="At least 6 characters" name="rpassword">
										<?= form_error('rpassword'); ?>
									</li>
									<li>
										<h5>Confirm Password</h5>
										<input type="password" placeholder="" name="rconfirm_password">
										<?= form_error('rconfirm_password'); ?>
									</li>
									
								</ul>
								<button type="submit" class="btn">Save Changes</button>
							</form>
						<?php } ?>
						
						
						</div>
					</div>

				</div>
					</div>
				</div>
				

				
			</div>
		</div>
	</div>
</div>
	</div>
</section>
<style type="text/css">
	.J-dtp-btn-today{display: none !important;}
	.userDetails p {
    text-align: left !important;
}
</style>

<?php require_once('container/footer.php'); ?>