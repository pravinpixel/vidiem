<?php include('container/header.php'); ?>

<section class="ban-next">
	<div class="container clearfix">
		<h2>User Dashboard</h2>
	</div>
</section>
<div class="bgPro contactUs userDash clearfix">
	<div class="container clearfix userSetDash" id="div">
		<div class="useDaFull clearfix">
			<div class="dashHeader">
				<h3>My Account</h3>
				<p>Welcome to your account. Here you can manage all of your information</p>
			</div>
			<div class="dahSection clearfix">
				<ul class="leftDashMenu">
					<li class="Daslogo">
						<img src="<?= base_url(); ?>assets/front-end/images/logo.png" alt="" />
					</li>
					<a href="<?= base_url('user/dashboard#div'); ?>"><li class="dasTabFun " data-tab="tab-1">
			          	<i class="fa fa-list-ul"></i> Order Details
			        </li></a>
			        <a href="<?= base_url('user/credit_slips#div'); ?>"><li class="dasTabFun current" data-tab="tab-2">
			          	<i class="fa fa-credit-card-alt"></i> My Credit Slips
			        </li></a>
			        <a href="<?= base_url('user/address#div'); ?>"><li class="dasTabFun" data-tab="tab-3">
			          	<i class="fa fa-tags"></i> My Address
			        </li></a>
			        <a href="<?= base_url('user/settings#div'); ?>">
			        <li class="dasTabFun" data-tab="tab-4">
			          	<i class="fa fa-user"></i> My Account Setting
			        </li></a>
				</ul>

				<div class="dasnAnwSet">
					<div id="tab-2" class="tab-content dasBRide clearfix current">
						<h2>Credit slips</h2>
						<p>Credit slips received after cancelled orders.</p>
						<div class="creditSlip">
							<p class="noData">You have not received any credit slips.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once('container/footer.php'); ?>