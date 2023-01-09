<?php include('container/header.php'); ?>
<section class="ban-next light-gray-bg pt-5">
<div class="container">
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
					<a href="<?= base_url('user/dashboard#div'); ?>"><li class="dasTabFun " data-tab="tab-1">
			          	<i class="fa fa-list-ul"></i> Order Details
			        </li></a>
			        <!--<a href="<?= base_url('user/credit_slips#div'); ?>"><li class="dasTabFun" data-tab="tab-2">
			          	<i class="fa fa-credit-card-alt"></i> My Credit Slips
			        </li></a>-->
			        <a href="<?= base_url('user/address#div'); ?>"><li class="dasTabFun current" data-tab="tab-3">
			          	<i class="fa fa-tags"></i> My Address
			        </li></a>
			        <a href="<?= base_url('user/settings#div'); ?>">
			        <li class="dasTabFun" data-tab="tab-4">
			          	<i class="fa fa-user"></i> My Account Setting
			        </li></a>
					<a href="<?= base_url('user/customdashboard#div'); ?>"><li class="dasTabFun " data-tab="tab-5">
			          	<i class="fa fa-list-ul"></i>Customize Order Details
			        </li></a>
				</ul>
				</div>
				<div class="col-sm-12 col-md-8 col-lg-9">
				<div class="dasnAnwSet">
					<!-- <?php echo '<pre>'; print_r($my_address); echo '</pre>'; ?> -->
					<div id="tab-3" class="tab-content dasBRide clearfix current">
						<h3>My addresses</h3>
						<p>Be sure to update your personal information if it has changed.</p>
						<ul class="nav nav-tabs" id="address-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" href="#tab1" role="tab" data-toggle="tab">Your Delivery Address</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#tab2" role="tab" data-toggle="tab">Your Billing Address</a>
							</li>
						  </ul>
						  
						  <div class="tab-content">
							<div role="tabpanel" class="tab-pane in active animated fadeInUp" id="tab1">
								<div class="currentOrder userAddressList">
							<h6 class="curorder">Your Delivery Address</h6>
							<div class="OrderListSectCu usCurAdd clearfix">
								<?php if(!empty($shipping_address)){
									foreach ($shipping_address as $info) { ?>
								<div class="clearfix">
									<div class="yourAdd userDelAdd">
										<p class="text-dark"><?= $info['name']; ?></p>
										<p><?= $info['address']; ?></p>
										<p><?= $info['city']; ?>-<?= $info['zip_code']; ?></p>
										<p><?= $info['country']; ?></p>
										<p><?= $info['mobile_no']; ?></p>
										<a href="<?= base_url('edit-address/'.$info['id']); ?>" class="red-btn small updateAdd mr-3 mb-4"><i class="lni lni-reload"></i> &nbsp; Update</a>
										<a href="<?= base_url('delete-address/'.$info['id']); ?>" class="black-btn small deleteUeAdd"><i class="lni lni-trash"></i> &nbsp; Delete</a>
									</div>
								</div>
								<?php } } ?>
								<div class="clearfix">
									<div class="yourAdd userDelAdd">
										<a href="<?= base_url('add-address?type=1'); ?>" class="red-btn small addNewUaAdd"><i class="lni lni-circle-plus"></i> &nbsp; Add New Address</a>
									</div>
								</div>
							</div>
						</div>
							</div>
							<div role="tabpanel" class="tab-pane animated fadeInUp" id="tab2">
								<div class="currentOrder userAddressList">
							<h3 class="curorder">Your Billing Address</h3>
							<div class="OrderListSectCu usCurAdd clearfix">
								<?php if(!empty($billing_address)){
									foreach ($billing_address as $info) { ?>
								<div class="clearfix">
									<div class="yourAdd userDelAdd">
										<p class="text-dark"><?= $info['name']; ?></p>
										<p><?= $info['address']; ?></p>
										<p><?= $info['city']; ?>-<?= $info['zip_code']; ?></p>
										<p><?= $info['country']; ?></p>
										<p><?= $info['mobile_no']; ?></p>
										<a href="<?= base_url('edit-address/'.$info['id']); ?>" class="red-btn small updateAdd mr-3">Update</a>
										<a href="<?= base_url('delete-address/'.$info['id']); ?>" class="black-btn small deleteUeAdd">Delete</a>
									</div>
								</div>
								<?php } } ?>
								<div class="clearfix">
									<div class="yourAdd userDelAdd p-3">
										<a href="<?= base_url('add-address?type=2'); ?>" class="red-btn small addNewUaAdd"><i class="lni lni-circle-plus"></i> &nbsp; Add New Address</a>
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
			</div>
		</div>
	</div>
</div>
</div>
</section>
<?php require_once('container/footer.php'); ?>