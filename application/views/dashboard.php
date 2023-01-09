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
					<a href="<?= base_url('user/dashboard#div'); ?>"><li class="dasTabFun current" data-tab="tab-1">
			          	<i class="fa fa-list-ul"></i> Order Details
			        </li></a>
			        <!--<a href="<?= base_url('user/credit_slips#div'); ?>"><li class="dasTabFun" data-tab="tab-2">
			          	<i class="fa fa-credit-card-alt"></i> My Credit Slips
			        </li></a>-->
			        <a href="<?= base_url('user/address#div'); ?>"><li class="dasTabFun" data-tab="tab-3">
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
				<div class="dasnAnwSet pl-4">
					<div id="tab-1" class="tab-content current dasBRide clearfix">
						<h3>Order Details</h3>
						<p>Here are the orders you've placed since your account was created.</p>	<ul class="nav nav-tabs" id="dashboard-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" href="#tab1" role="tab" data-toggle="tab">Your Orders</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#tab2" role="tab" data-toggle="tab">Canceled Orders</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#tab3" role="tab" data-toggle="tab">Past Orders</a>
							</li>
						  </ul>	  
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane in active animated fadeInUp" id="tab1">
								<div class="currentOrder">
							<h6 class="curorder">Your Orders</h6>
							<div class="OrderListSectCu clearfix">
								<?php if(!empty($current_order)){ 
									foreach($current_order as $info){
									$product_list=$this->ProjectModel->OrderProductList($info['id']);
								?>
								<div class="clearfix">
									<?php if(!empty($product_list)){
										foreach ($product_list as $pro) { ?>
									<div class="orderImgSet">
										<img src="<?= base_url('uploads/images/'.$pro['image']); ?>" alt="" class="img-fluid" />
									</div>
									<div class="orderConSet">
										<h4><a href="<?= base_url('product/'.$pro['slug']);?>"><?= $pro['name'];?></a></h4>
										<p>Model No: <?= $pro['modal_no'];?></p>
										<p>Item: <?= $pro['qty'];?></p>
										<p class="price"><i class="fa fa-inr"></i> <?= number_format($pro['price']);?>/-</p>
									</div>
								    <?php } } ?>
									<div class="orderConSet">
										<p>Amount: &#8377; <?= number_format($info['amount']); ?>/-</p>
										<p>Order Date: <?= date('d-M-Y',strtotime($info['created']))?></p>
										<p>Order Status: <span><?= ($info['status']==1)?'New Order':'Shipped'; ?></span></p>
										<?php if($info['status']==2){ ?>
										<a href="<?= base_url('user/track_order/'.$info['id']); ?>" target="_blank">Track Order</a><br>
									    <?php } ?>
										<!--<a class="btn btn-danger btn-sm" href="javascript:void(0);">Cancell The Order</a> -->
									</div>
								</div>
								<?php } }else{ ?>
								<div class="text-center">
									<p class="noData">You have not placed any orders.</p>
								</div>
								<?php } ?>
							</div>
						</div>
							</div>
							<div role="tabpanel" class="tab-pane animated fadeInUp" id="tab2">
								<div class="currentOrder clearfix">
							<h6 class="curorder">Canceled Orders</h6>
							<div class="OrderListSectCu clearfix">
								<?php if(!empty($cancelled_order)){ 
									foreach($cancelled_order as $info){
									$product_list=$this->ProjectModel->OrderProductList($info['id']);
								?>
								<?php if(!empty($product_list)){
										foreach ($product_list as $pro) { ?>
									<div class="orderImgSet">
										<img src="<?= base_url('uploads/images/'.$pro['image']); ?>" alt="" class="img-fluid" />
									</div>
									<div class="orderConSet">
										<h4><a href="<?= base_url('product/'.$pro['slug']);?>"><?= $pro['name'];?></a></h4>
										<p>Model No: <?= $pro['modal_no'];?></p>
										<p>Item: <?= $pro['qty'];?></p>
										<p class="price"><i class="fa fa-inr"></i> <?= number_format($pro['price']);?>/-</p>
									</div>
								    <?php } } ?>
									<div class="orderConSet">
										<p>Amount: <?= number_format($info['amount']); ?>/-</p>
										<p>Order Date: <?= date('d-M-Y',strtotime($info['created']))?></p>
										<p>Order Status: <span>Cancelled</span></p>
									</div>
								</div>
								<?php } }else{ ?>
								<div>
									<p class="noData">You have not any cancelled order.</p>
								</div>
								<?php } ?>
							</div>
						</div>
							</div>
							<div role="tabpanel" class="tab-pane animated fadeInUp" id="tab3">
								<div class="currentOrder">
							<h6 class="curorder">Past Orders</h6>
							<div class="OrderListSectCu clearfix">
								<?php if(!empty($delivered_order)){ 
									foreach($delivered_order as $info){
									$product_list=$this->ProjectModel->OrderProductList($info['id']);
								?>
								<div class="clearfix">
									<?php if(!empty($product_list)){
										foreach ($product_list as $pro) { ?>
									<div class="orderImgSet">
										<img src="<?= base_url('uploads/images/'.$pro['image']); ?>" alt="" class="img-fluid" />
									</div>
									<div class="orderConSet">
										<h4><a href="<?= base_url('product/'.$pro['slug']);?>"><?= $pro['name'];?></a></h4>
										<p>Model No: <?= $pro['modal_no'];?></p>
										<p>Item: <?= $pro['qty'];?></p>
										<h6 class="price"><i class="fa fa-inr"></i> <?= number_format($pro['price']);?>/-</h6>
									</div>
								    <?php } } ?>
									<div class="orderConSet">
										<h6 class="text-red">Amount: <?= number_format($info['amount']); ?>/-</h6>
										<p>Order Date: <?= date('d-M-Y',strtotime($info['created']))?></p>
										<p>Delivery Date: <?= date('d-M-Y',strtotime($info['delivered_at']))?></p>
										<p class="mb-0"><strong>Order Status: <span class="text-success">successful delivery</span></strong></p>
									</div>
								</div>
								<?php } }else{ ?>
								<div>
									<p class="noData">You have not any delivered order.</p>
								</div>
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
	</div>
</div>
</div>
</section>
<?php require_once('container/footer.php'); ?>