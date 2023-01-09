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
			        <li class="dasTabFun" data-tab="tab-4">
			          	<i class="fa fa-user"></i> My Account Setting
			        </li></a>
					<a href="<?= base_url('user/customdashboard#div'); ?>"><li class="dasTabFun current" data-tab="tab-5">
			          	<i class="fa fa-list-ul"></i>Customize Order Details
			        </li></a>
					
				</ul>
				</div>				
			<div class="col-sm-12 col-md-8 col-lg-9">
				<div class="dasnAnwSet pl-4">
					<div id="tab-1" class="tab-content current dasBRide clearfix">
						<h3>Customize Order Details</h3>
						<p>Here are the customize orders you've placed since your account was created.</p>	<ul class="nav nav-tabs" id="dashboard-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" href="#tab1" role="tab" data-toggle="tab">Your Customize Orders</a>
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
							<h6 class="curorder">Your Customize Orders</h6>
							<div class="OrderListSectCu clearfix">
								<?php if(!empty($current_order)){
							foreach($current_order as $order) {		
						$basiciteminfo=	$this->CustomizeModel->getOrderBasicDetails($order['id']);
						$jarinfo=$this->CustomizeModel->getOrderJarsDetails($order['id']);
						
							
			 ?>
	 
		
		<ul class="ck_product_listing">
			<li class="p-3">
				<div class="row align-items-center">
					<div class="col-sm-3 col-md-3">
						<img src="<?= base_url('uploads/customizeimg/basecolor/'.$basiciteminfo['basecolorpath']); ?>" alt="" class="img-fluid"/>
					</div>
					<div class="col-sm-6 col-md-6">
						<div class="table-responsive customization-table">
							<table class="table">
								<thead>
									<tr>
										<th>Customization Code</th>
										<th><?= $basiciteminfo['cart_code'] ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Body Design</td>
										<td><?= $basiciteminfo['basetitle'] ?></td>
									</tr>
									<tr>
										<td>Color</td>
										<td><?= $basiciteminfo['bc_title'] ?></td>
									</tr>
									<tr>
										<td>Selected Jars</td>
										<td><?= count($jarinfo) ?></td>
									</tr>
									<tr>
										<td>Motor Power</td>
										<td><?= $basiciteminfo['motorname'] ?></td>
									</tr>
								<?php if($basiciteminfo['canvas_text']!='') { ?>	
									<tr>
										<td>Imprinted Text</td>
										<td><?= $basiciteminfo['canvas_text'] ?></td>
									</tr>
								<?php } ?>	
									<?php if($basiciteminfo['package_id']!='' && !empty($basiciteminfo['package_id'])) { ?>	
									<tr>
										<td>Package Preference</td>
										<td><?= $basiciteminfo['packagename'] ?></td>
									</tr>
									<?php } ?>	
								</tbody>
							</table>
						</div>						
					</div>
				
						<div class="col-sm-3 col-md-3">
						<div class="orderConSet">
										<p>Amount: &#8377; <?= number_format($order['amount']); ?>/-</p>
										<p>Order Date: <?= date('d-M-Y',strtotime($order['created']))?></p>
										<p>Order Status: <span><?= ($order['status']==1)?'New Order':'Shipped'; ?></span></p>
										<?php if($order['status']==2){ ?>
										<a href="<?= base_url('user/track_order/'.$order['id']); ?>" target="_blank">Track Order</a><br>
									    <?php } ?>
									
						</div>
						
						
						
					</div>	
				
				</div>
			</li>
		</ul>
	<?php if(count($jarinfo)>0) { ?>	
		<ul class="ck_product_listing">
			<li class="p-3">
				<div class="row align-items-center">
					<div class="col">
						<div class="table-responsive customization-jar-table">
							<table class="table">
								<thead>
									<tr>
										<th></th>
										<th></th>
										<th class="text-center">No. Jars</th>
										<th class="text-center">Unit Price</th>
										<th class="text-center">Total Price</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($jarinfo as $jar) {

									?>
									<tr>
										<td>
											<a href="<?= base_url("uploads/customizeimg/jar/".$jar['jarimgpath']) ?>" data-fancybox="" data-caption="Jar<?= $jar['jar_id'] ?>">
												<img src="<?= base_url("uploads/customizeimg/jar/".$jar['jarimgpath']) ?>" alt="" class="img-fluid"/>
											</a>											
										</td>
										<td><?= $jar['jarname'] ?></td>
										<td class="text-center">
											<span class="text-red"><?= $jar['qty'] ?> Jars</span>
										</td>
										<td class="text-center">
											<span class="text-red">Rs. <?= $jar['price'] ?></span>
										</td>
										<td class="text-center">
											<span class="text-red">Rs. <?= $jar['qty']*$jar['price'] ?></span>
										</td>
									</tr>
								<?php } ?>	
									
								</tbody>
							</table>
						</div>						
					</div>
				</div>
			</li>
		</ul>
		<hr/>
		
	<?php }
	?>	
		
		
	
									
									
									
							<?php		
								}
								
								}else{ ?>
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
								
					foreach($cancelled_order as $order) {		
						$basiciteminfo=	$this->CustomizeModel->getOrderBasicDetails($order['id']);
						$jarinfo=$this->CustomizeModel->getOrderJarsDetails($order['id']);
						
							
			 ?>
	 
		
		<ul class="ck_product_listing">
			<li class="p-3">
				<div class="row align-items-center">
					<div class="col-sm-3 col-md-3">
						<img src="<?= base_url('uploads/customizeimg/basecolor/'.$basiciteminfo['basecolorpath']); ?>" alt="" class="img-fluid"/>
					</div>
					<div class="col-sm-6 col-md-6">
						<div class="table-responsive customization-table">
							<table class="table">
								<thead>
									<tr>
										<th>Customization Code</th>
										<th><?= $basiciteminfo['cart_code'] ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Body Design</td>
										<td><?= $basiciteminfo['basetitle'] ?></td>
									</tr>
									<tr>
										<td>Color</td>
										<td><?= $basiciteminfo['bc_title'] ?></td>
									</tr>
									<tr>
										<td>Selected Jars</td>
										<td><?= count($jarinfo) ?></td>
									</tr>
									<tr>
										<td>Motor Power</td>
										<td><?= $basiciteminfo['motorname'] ?></td>
									</tr>
								<?php if($basiciteminfo['canvas_text']!='') { ?>	
									<tr>
										<td>Imprinted Text</td>
										<td><?= $basiciteminfo['canvas_text'] ?></td>
									</tr>
								<?php } ?>	
									<?php if($basiciteminfo['package_id']!='' && !empty($basiciteminfo['package_id'])) { ?>	
									<tr>
										<td>Package Preference</td>
										<td><?= $basiciteminfo['packagename'] ?></td>
									</tr>
									<?php } ?>	
								</tbody>
							</table>
						</div>						
					</div>
				
						<div class="col-sm-3 col-md-3">
						<div class="orderConSet">
										<p>Amount: &#8377; <?= number_format($order['amount']); ?>/-</p>
										<p>Order Date: <?= date('d-M-Y',strtotime($order['created']))?></p>
										<p>Order Status:<span>Cancelled</span></p>
									
						</div>
						
						
						
					</div>	
				
				</div>
			</li>
		</ul>
	<?php if(count($jarinfo)>0) { ?>	
		<ul class="ck_product_listing">
			<li class="p-3">
				<div class="row align-items-center">
					<div class="col">
						<div class="table-responsive customization-jar-table">
							<table class="table">
								<thead>
									<tr>
										<th></th>
										<th></th>
										<th class="text-center">No. Jars</th>
										<th class="text-center">Unit Price</th>
										<th class="text-center">Total Price</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($jarinfo as $jar) {

									?>
									<tr>
										<td>
											<a href="<?= base_url("uploads/customizeimg/jar/".$jar['jarimgpath']) ?>" data-fancybox="" data-caption="Jar<?= $jar['jar_id'] ?>">
												<img src="<?= base_url("uploads/customizeimg/jar/".$jar['jarimgpath']) ?>" alt="" class="img-fluid"/>
											</a>											
										</td>
										<td><?= $jar['jarname'] ?></td>
										<td class="text-center">
											<span class="text-red"><?= $jar['qty'] ?> Jars</span>
										</td>
										<td class="text-center">
											<span class="text-red">Rs. <?= $jar['price'] ?></span>
										</td>
										<td class="text-center">
											<span class="text-red">Rs. <?= $jar['qty']*$jar['price'] ?></span>
										</td>
									</tr>
								<?php } ?>	
									
								</tbody>
							</table>
						</div>						
					</div>
				</div>
			</li>
		</ul>
	
		<hr/>
	<?php }
	?>	
		
		
	
									
									
									
							<?php		
								}
								
								}else{ ?>
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
								
					foreach($delivered_order as $order) {		
						$basiciteminfo=	$this->CustomizeModel->getOrderBasicDetails($order['id']);
						$jarinfo=$this->CustomizeModel->getOrderJarsDetails($order['id']);
						
							
			 ?>
	
		
		<ul class="ck_product_listing">
			<li class="p-3">
				<div class="row align-items-center">
					<div class="col-sm-3 col-md-3">
						<img src="<?= base_url('uploads/customizeimg/basecolor/'.$basiciteminfo['basecolorpath']); ?>" alt="" class="img-fluid"/>
					</div>
					<div class="col-sm-6 col-md-6">
						<div class="table-responsive customization-table">
							<table class="table">
								<thead>
									<tr>
										<th>Customization Code</th>
										<th><?= $basiciteminfo['cart_code'] ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Body Design</td>
										<td><?= $basiciteminfo['basetitle'] ?></td>
									</tr>
									<tr>
										<td>Color</td>
										<td><?= $basiciteminfo['bc_title'] ?></td>
									</tr>
									<tr>
										<td>Selected Jars</td>
										<td><?= count($jarinfo) ?></td>
									</tr>
									<tr>
										<td>Motor Power</td>
										<td><?= $basiciteminfo['motorname'] ?></td>
									</tr>
								<?php if($basiciteminfo['canvas_text']!='') { ?>	
									<tr>
										<td>Imprinted Text</td>
										<td><?= $basiciteminfo['canvas_text'] ?></td>
									</tr>
								<?php } ?>	
									<?php if($basiciteminfo['package_id']!='' && !empty($basiciteminfo['package_id'])) { ?>	
									<tr>
										<td>Package Preference</td>
										<td><?= $basiciteminfo['packagename'] ?></td>
									</tr>
									<?php } ?>	
								</tbody>
							</table>
						</div>						
					</div>
				
						<div class="col-sm-3 col-md-3">
						
						
						
						<div class="orderConSet">
										<p>Amount: &#8377; <?= number_format($order['amount']); ?>/-</p>
										<p>Order Date: <?= date('d-M-Y',strtotime($order['created']))?></p>
										<p>Delivery Date: <?= date('d-M-Y',strtotime($order['delivered_at']))?></p>
										<p class="mb-0"><strong>Order Status: <span class="text-success">successful delivery</span></strong></p>
										
									
						</div>
						
						
						
					</div>	
				
				</div>
			</li>
		</ul>
	<?php if(count($jarinfo)>0) { ?>	
		<ul class="ck_product_listing">
			<li class="p-3">
				<div class="row align-items-center">
					<div class="col">
						<div class="table-responsive customization-jar-table">
							<table class="table">
								<thead>
									<tr>
										<th></th>
										<th></th>
										<th class="text-center">No. Jars</th>
										<th class="text-center">Unit Price</th>
										<th class="text-center">Total Price</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($jarinfo as $jar) {

									?>
									<tr>
										<td>
											<a href="<?= base_url("uploads/customizeimg/jar/".$jar['jarimgpath']) ?>" data-fancybox="" data-caption="Jar<?= $jar['jar_id'] ?>">
												<img src="<?= base_url("uploads/customizeimg/jar/".$jar['jarimgpath']) ?>" alt="" class="img-fluid"/>
											</a>											
										</td>
										<td><?= $jar['jarname'] ?></td>
										<td class="text-center">
											<span class="text-red"><?= $jar['qty'] ?> Jars</span>
										</td>
										<td class="text-center">
											<span class="text-red">Rs. <?= $jar['price'] ?></span>
										</td>
										<td class="text-center">
											<span class="text-red">Rs. <?= number_format($jar['qty']*$jar['price']) ?></span>
										</td>
									</tr>
								<?php } ?>	
									
								</tbody>
							</table>
						</div>						
					</div>
				</div>
			</li>
		</ul>
		<hr/>
		
	<?php }
	?>	
		
		
	
									
									
									
							<?php		
								}
								
								
								}else{ ?>
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
 
 
</section>
<?php require_once('container/footer.php'); ?>