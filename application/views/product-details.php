<?php 
//echo "<pre>"; print_r($product_img[1]['classname']); exit;
include('container/header.php'); ?>
<style type="text/css">
	h1.product-details-heading1{
		color: #141414;
		font-size: 42px;
		line-height: 56px;
		text-transform: capitalize;
		font-weight: 300;
		letter-spacing: 0px;
		margin: 20px 0px 0px 10px;
	}
</style>
	  <!-- Products Listing Banner -->
	  <section class="bg-white pb-0 pt-0 product-details-banner">
		<div class="container-fluid p-0">
			<div class="row no-gutters justify-content-center">
				<div class="col-sm-12 col-md-12 col-lg-12 product-details-heading">
					<h1 class="product-details-heading1" data-aos="fade-up" data-aos-delay="1" data-aos-duration="500" data-aos-offset="10"><?= @$product['name']; ?></h1>
					<nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="1" data-aos-duration="500" data-aos-offset="10">
						<ol class="breadcrumb product-details-breadcrumb">
							<li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
							<li class="breadcrumb-item"><a href="<?= base_url('category/'.$cat_slug[0]['slug']); ?>"><?=$cat_slug[0]['name']; ?></a></li>
							<!--<li class="breadcrumb-item"><a href="<?= base_url('category/'.$subcat_slug[0]['slug']); ?>"><?=$subcat_slug[0]['name']; ?></a></li>-->
							<li class="breadcrumb-item"><?= @$product['name']; ?></li>
						</ol>
					</nav>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12">
					<div id="product-details-carousel" class="carousel slide vert" data-ride="carousel" data-interval="false">
						<div class="row no-gutters">


						  <div class="col-12 col-sm-12 col-md-12">
							<div id="thumbs-scroll" class="carousel-indicators mCustomScrollbar">
							  <!-- Images -->
							  <?php if(!empty($product_img)){
								 
									$cnt=0;
				            		foreach ($product_img as $info) { 
									    $activeclass='';
										if($cnt==0){
											$activeclass = 'active';
										}
									
									?>
								<?php 	if($info['type']=='image') { ?>	
							  <div data-target="#product-details-carousel" data-slide-to="<?php echo $cnt ?>" class="item <?= $activeclass; ?>">
								<img src="<?= base_url('uploads/images/'.$info['url']); ?>" class="img-fluid" />

							  </div>
								<?php } else { ?>
								
								<div data-target="#product-details-carousel" data-slide-to="<?php echo $cnt ?>" class="item clsvideoicon <?= $activeclass; ?>">
									<img src="<?= base_url('uploads/images/'.$info['backimage']); ?>" src="" class="img-fluid" />
							  </div>
								
								<?php } ?>
							  
							  <?php $cnt++; } 
							  
							  
							  
							  
							  } else { ?>
							  
							  <div data-target="#product-details-carousel" data-slide-to="0" class="item active">
								<img src="<?= base_url('assets/front-end/images/NoImageAvailable.png'); ?>" alt="" class="img-fluid" />
							  </div>
							  
							  <?php } ?>
							  
							   <!-- Videos -->
							  
							  <?php /* if(!empty($product_video)){
									
				            		foreach ($product_video as $info) { 
									    $activeclass='';
										
									
									?>
									
							  <div data-target="#product-details-carousel" data-slide-to="<?php echo $cnt ?>" class="item clsvideoicon <?= $activeclass; ?>">
							  <img src="<?= base_url('uploads/images/'.$info['url']); ?>" src="" class="img-fluid" />
							  
						
							  
							  </div>
							  <?php $cnt++; } } */ ?>
							  
							   
							</div>
							<div class="carousel-inner">
							  <!-- images -->
							 <?php if(!empty($product_img)){ 
								$cnt=1;
				            		foreach ($product_img as $info) {
								
										$activeclass='';
										if($cnt==1){
											$activeclass = 'active';
										}
									?>
							<?php 	if($info['type']=='image') {	 ?>		
							  <div class="carousel-item text-center <?= $activeclass.' '.$info['classname']; ?>">

								<img src="<?= base_url('uploads/images/'.$info['url']); ?>" src="" class="img-fluid" />
								
							  </div>
							  
								<?php }else{ ?>
								
								  <div class="carousel-item <?= $activeclass; ?>">
								<!--<img src="<?= base_url('uploads/images/'.$info['image']); ?>" src="" class="img-fluid" />-->
								<iframe src="https://www.youtube.com/embed/<?php echo $info['url']; ?>?autoplay=0&showinfo=0&controls=0&rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="product-video"></iframe>
							  </div>
							  
								<?php } ?>
							  <?php $cnt++; } 
							  
							  
							  
							  
							  
							  
							  }else{ ?>
							  <div class="carousel-item text-center active ">
								<img src="<?= base_url('assets/front-end/images/NoImageAvailable.png'); ?>" alt="" class="img-fluid" />
							  </div>
							  
							  <?php } ?>
							  
							  <!-- Videos -->
							  <?php if(!empty($product_video)){ 
								
				            		foreach ($product_video as $info) {
										
										$activeclass='';
										
									?>
							  <div class="carousel-item <?= $activeclass; ?>">
								<!--<img src="<?= base_url('uploads/images/'.$info['image']); ?>" src="" class="img-fluid" />-->
								<iframe src="https://www.youtube.com/embed/<?php echo $info['video_url']; ?>?autoplay=0&showinfo=0&controls=0&rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="product-video"></iframe>
							  </div>
							  <?php $cnt++; } } ?>
							  
							</div>
							<a class="carousel-control-prev" href="#product-details-carousel" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					  </a>
					  
					  <a class="carousel-control-next" href="#product-details-carousel" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					  </a>
						  </div>
						</div>
					  </div>
					  
				</div>
			</div>
		</div>
	  </section>
	  <section class="gray-bg1 pt-5 pb-5">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
				    <h2 class="text-white">
						About <?= @$product['name']; ?>
					</h2>
					<!--<p class="text-white" data-aos="fade-up" data-aos-delay="1" data-aos-duration="500" data-aos-offset="10">Ut enim ad minima veniam, nostum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur</p>-->
					<div class="text-white"><?= $product['short_description']; ?></div>
				</div>
				<!--<div class="col-sm-12 col-md-6 col-lg-7">
				<h3 class="text-white" data-aos="fade-up" data-aos-delay="1" data-aos-duration="500" data-aos-offset="10">
						Product Description
					</h3>
					<ul class="product-description-details" data-aos="fade-up" data-aos-delay="1" data-aos-duration="500" data-aos-offset="10">
							<li class="w-50 mr-0">
								Product Dimensions
								<span>54.5 x 29 x 25.5 CM / 4.33 Kilograms</span>
						</li>
						<li class="w-50 mr-0">
							Manufacturer
							<span>Vidiem</span>
												</li>
												<li class="w-50 mr-0">
													Voltage
													<span>220V - 240V AC 50Hz</span>
												</li>
												<li class="w-50 mr-0">
													Date First Available
													<span>26 January 2020</span>
												</li>
											</ul>
				</div>-->
			</div>
		</div>
	  </section>
	  <section class="product-details-colors">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-sm-12 col-md-6 col-lg-6">
					<h4 class="color-dark"><?= @$product['name']; ?><span class="price text-red">₹ <?= @number_format($product['price']);?> 
					<?php if(isset($product['old_price']) && $product['old_price']>0){ ?>
					<span class="strike">  ₹ <?= @number_format($product['old_price']);?></span>
					<?php } ?>
					</span></h4>
					
					<!--<p>Master Jar With Round Dome</p>-->
				</div>
				
				<div class="col-sm-12 col-md-6 col-lg-2">
					<!--<h6>Availability <span>In Stock (22 Nos)</span></h6>
					<h6>Select Color</h6>
					<ul class="colors" data-aos="fade-up" data-aos-delay="1" data-aos-duration="500" data-aos-offset="10">
						<li>
							<a href="#" class="dark-blue"></a>
						</li>
						<li>
							<a href="#" class="red"></a>
						</li>
						<li>
							<a href="#" class="yellow"></a>
						</li>
						<li>
							<a href="#" class="orange"></a>
						</li>
						<li class="active">
							<a href="#" class="light-pink"></a>
						</li>
					</ul>-->
				</div>
				
				
				<div class="col-sm-12 col-md-12 col-lg-4">
					<div class="row align-items-center">
						<div class="col-6">
						<?php if($product['outofstock']==0){ ?>
							<a id="<?= $data['slug']; ?>-buy-now" href="<?= base_url('buy-now/'.$product['id']); ?>" class="buy-now">Buy Now</a>
						<?php } else{ ?>
						<a  href="<?= base_url('contact-us'); ?>" class="buy-now">Out of Stock</a>
						<?php } ?>
						</div>
						<div class="col-6">
							<?php if($product['outofstock']==0){ ?>
							<a id="<?= $data['slug']; ?>-add-to-cart" href="javascript:void(0);" class="add-to-cart add_to_cart" data-id="<?= @$product['id'];?>">Add to Cart</a>
							<?php } ?>
						</div>
						<div class="col-12">
							<!--<p>You Can <a href="#" class="text-red">Customise</a> Your Own Vidiem Product</p>-->
						</div>
					</div>
				</div>
			</div>
		<div>
	  </section>
	  
	  <nav class="navigation" id="mainNav">
	     <?php if(count($product_about_detail)>0){ ?>
			<a class="navigation__link active" id="s1" href="#tab1">About the Product</a>
	     <?php } ?>	
	     <?php if(count($product_product_detail)>0){ ?>		
			<a class="navigation__link" id="s2" href="#tab2">Product Details</a>
		 <?php } ?>	
			<a class="navigation__link" id="s3" href="#tab3">Product Specification</a>
			<!-- <a class="navigation__link" id="s4" href="#tab4">Customer Review</a> -->
	  </nav> 
	  <section class="p-0">
		<div class="container-fluid pl-0 pr-0">
			<div class="row">
				<div class="col-sm-12 col-md-12">
				  <?php if(count($product_about_detail)>0){ ?>
				    <div class="page-section" id="tab1">
							<h1 class="pt-5 mt-5 text-red text-center">About</h1>
							<h2 class="pb-4 text-center">Vidiem <?= @$product['name']; ?></h2>
							
							
							<?php 
						
						
						
										
									
						
								/*$col4_header='<div class="light-gray-bg p-5">
								<div class="container">
									<div class="row align-items-center"> <div class="col-sm-12 col-md-12 pt-5">
											<div class="owl-carousel product-details-carousel">'; 
								$col4_footer=' </div>
										</div> 
										 </div>
										</div>
										</div>';	 */
										
								$col4_header='<section class="light-gray-bg">
								<div class="container">
									<div class="row justify-content-center">';	
								$col4_footer='	</div>
								</div>
							</section> ';		
								$col4_content='';
							$ind=1;	
							foreach($product_about_detail as $row) {
								$bg_cls=" gray-bg ";
								if(!($ind%2))
									$bg_cls=" light-gray-bg ";
							
								switch($row['position'])
								{
									case "2":
											if($row['content']=='' && $row['image']!='' )
											{ 
										    ?>
										<div class="<?php echo $bg_cls; ?> p-5 p-sm-0">
											<div class="container">
											<div class="text-center">
											<img src="<?= base_url('uploads/images/'.$row['image']); ?>" src="" class="img-fluid" />
											</div>
										  </div>
										 </div>		
											<?php
											}
											else if($row['content']!='' && $row['image']=='' )
											{ 
										  ?>
										  <div class="<?php echo $bg_cls; ?> p-5">
												<div class="container">
													<div class="row align-items-center">										
														<div class="col-sm-12 col-md-12">
															<h3 class="pb-4"><?= $row['name'] ?></h3>
															
															<div class="pb-3">
															<?= $row['content'] ?>
															</div>
														</div>
													</div>
												</div>
											</div>										
										<?php
											}
											else if($row['content']!='' && $row['image']!='' )
											{ 
										  ?>
										  <div class="<?php echo $bg_cls; ?> p-5">
												<div class="container">
													<div class="row align-items-center">

													<div class="col-sm-12 col-md-12">
															<h3 class="pb-4"><?= $row['name'] ?></h3>
															
															<div class="pb-3">
															<?= $row['content'] ?>
															</div>
														</div>
													
													<div class="col-sm-12 col-md-12 text-center">
														<img src="<?= base_url('uploads/images/'.$row['image']); ?>" src="" class="img-fluid" />
													</div>
													
													</div>
												</div>
											</div>										
										<?php
											}
											
											
									       break;
										   
									case "3":
									
										 if($row['content']=='' && $row['image']!='' )
											{ 
										    ?>
											<div class="text-center">
											<img src="<?= base_url('uploads/images/'.$row['image']); ?>" src="" class="img-fluid w-75" />
											</div>
											<?php
											}
											else if($row['content']!='' && $row['image']=='' )
											{ 
										  ?>
										  <div class="<?php echo $bg_cls; ?> p-5">
												<div class="container">
													<div class="row align-items-center">										
														<div class="col-sm-12 col-md-12">
															<h3 class="pb-4"><?= $row['name'] ?></h3>
															
															<div class="pb-3">
															<?= $row['content'] ?>
															</div>
														</div>
													</div>
												</div>
											</div>										
										<?php
											}
											else if($row['content']!='' && $row['image']!='' )
											{  
										    if($row['imageposition']=='0' || $row['imageposition']=='1') { 
										  ?>
										  <div class="<?php echo $bg_cls; ?> p-5">
												<div class="container">
													<div class="row align-items-center">	
													<div class="col-sm-12 col-md-6 text-center">
														<img src="<?= base_url('uploads/images/'.$row['image']); ?>" src="" class="img-fluid w-75" />
													</div>
													<div class="col-sm-12 col-md-6">
															<h3 class="pb-4"><?= $row['name'] ?></h3>
															
															<div class="pb-3">
															<?= $row['content'] ?>
															</div>
														</div>
													</div>
												</div>
											</div>	
											<?php } else { ?>											
											  <div class="<?php echo $bg_cls; ?> p-5">
												<div class="container">
													<div class="row align-items-center">	
													
													<div class="col-sm-12 col-md-6">
															<h3 class="pb-4"><?= $row['name'] ?></h3>
															
															<div class="pb-3">
															<?= $row['content'] ?>
															</div>
														</div>
														<div class="col-sm-12 col-md-6 text-center">
														<img src="<?= base_url('uploads/images/'.$row['image']); ?>" src="" class="img-fluid w-75" />
													    </div>
													</div>
												</div>
											</div>	
											
											
											
											

											<?php } ?>		
										<?php
											}
											
									
									       break;

									case "4":
									  
										$col4_content .= '<div class="col-sm-12 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="1" data-aos-duration="500" data-aos-offset="10">
										<div class="bg-white shadow1 p-3 more-products img-center">
											<img src="'.base_url('uploads/images/'.$row['image']).'" alt="" class="img-fluid light-gray-bg mt-3" />
											<h4 class="mb-2 mt-2 text-dark">'.$row['name'].'</h4>
											<div>'.$row['content'].'</div></div>
										</div> ';
									  
									/*$col4_content .= '<div class="item"> 
													  
														<img src="'.base_url('uploads/images/'.$row['image']).'" alt="" class="img-fluid" />
														<h4 class="mt-4">'.$row['name'].'</h4>
														
														<div>'.$row['content'].'</div>
												       </div> ';												
												*/
											 
									
									       break;			
										   
									


								}								
								
							$ind+=1;
								
							} ?>	
							
							<?php if($col4_content!=''){
								echo $col4_header.$col4_content.$col4_footer;
							 } ?>
							
							</div>
				  <?php } ?>
					<?php if(count($product_product_detail)>0) { ?>			
							<div class="page-section pd-liclass" id="tab2">
							<h1 class="pt-5 mt-5 text-red text-center">Product Details</h1>
						    <h2 class="pb-4 text-center">Vidiem <br/><?= @$product['name']; ?></h2>
							
							<?php 
						
								/*$col4_header='<div class="light-gray-bg p-5">
								<div class="container">
									<div class="row align-items-center"> <div class="col-sm-12 col-md-12 pt-5">
											<div class="owl-carousel product-details-carousel">'; 
								$col4_footer=' </div>
										</div> 
										 </div>
										</div>
										</div>';	 */
										
								$col4_header='<section class="light-gray-bg">
								<div class="container">
									<div class="row align-items-center">';	
								$col4_footer='	</div>
								</div>
							</section> ';		
								$col4_content='';
								
								
								
								$ind=1;
							foreach($product_product_detail as $row) {

							$bg_cls=" gray-bg ";
								if(!($ind%2))
									$bg_cls=" light-gray-bg ";
							
								switch($row['position'])
								{
									case "2":
											if($row['content']=='' && $row['image']!='' )
											{ 
										    ?>
										<div class="<?php echo $bg_cls; ?> p-5 mob-pad-0">
											<div class="container">
											<div class="text-center">
											<img src="<?= base_url('uploads/images/'.$row['image']); ?>" src="" class="img-fluid" />
											</div>
										  </div>
										 </div>		
											<?php
											}
											else if($row['content']!='' && $row['image']=='' )
											{ 
										  ?>
										  <div class="<?php echo $bg_cls; ?> p-5 mob-pad-0">
												<div class="container">
													<div class="row align-items-center">										
														<div class="col-sm-12 col-md-12">
															<h3 class="pb-4"><?= $row['name'] ?></h3>
															
															<div class="pb-3">
															<?= $row['content'] ?>
															</div>
														</div>
													</div>
												</div>
											</div>										
										<?php
											}
											else if($row['content']!='' && $row['image']!='' )
											{ 
										  ?>
										  <div class="<?php echo $bg_cls; ?> p-5 mob-pad-0">
												<div class="container">
													<div class="row align-items-center">	
													<div class="col-sm-12 col-md-12">
														<img src="<?= base_url('uploads/images/'.$row['image']); ?>" src="" class="img-fluid" />
													</div>
													<div class="col-sm-12 col-md-12">
															<h3 class="pb-4"><?= $row['name'] ?></h3>
															
															<div class="pb-3">
															<?= $row['content'] ?>
															</div>
														</div>
													</div>
												</div>
											</div>										
										<?php
											}
											
											
									       break;
										   
									case "3":
									
										 if($row['content']=='' && $row['image']!='' )
											{ 
										    ?>
											<div class="text-center">
											<img src="<?= base_url('uploads/images/'.$row['image']); ?>" src="" class="img-fluid" />
											</div>
											<?php
											}
											else if($row['content']!='' && $row['image']=='' )
											{ 
										  ?>
										  <div class="<?php echo $bg_cls; ?> p-5 mob-pad-0">
												<div class="container">
													<div class="row align-items-center">										
														<div class="col-sm-12 col-md-12">
															<h3 class="pb-4"><?= $row['name'] ?></h3>
															
															<div class="pb-3">
															<?= $row['content'] ?>
															</div>
														</div>
													</div>
												</div>
											</div>										
										<?php
											}
											else if($row['content']!='' && $row['image']!='' )
											{  
										    if($row['imageposition']=='0' || $row['imageposition']=='1') { 
										  ?>
										  <div class="<?php echo $bg_cls; ?> p-5 mob-pad-0">
												<div class="container">
													<div class="row align-items-center">	
													<div class="col-sm-12 col-md-6 text-center">
														<img src="<?= base_url('uploads/images/'.$row['image']); ?>" src="" class="img-fluid w-75" />
													</div>
													<div class="col-sm-12 col-md-6">
															<h3 class="pb-4"><?= $row['name'] ?></h3>
															
															<div class="pb-3">
															<?= $row['content'] ?>
															</div>
														</div>
													</div>
												</div>
											</div>	
											<?php } else { ?>											
											  <div class="<?php echo $bg_cls; ?> p-5 mob-pad-0">
												<div class="container">
													<div class="row align-items-center">	
													
													<div class="col-sm-12 col-md-6">
															<h3 class="pb-4"><?= $row['name'] ?></h3>
															
															<div class="pb-3">
															<?= $row['content'] ?>
															</div>
														</div>
														<div class="col-sm-12 col-md-6 text-center">
														<img src="<?= base_url('uploads/images/'.$row['image']); ?>" src="" class="img-fluid w-75" />
													    </div>
													</div>
												</div>
											</div>	
											
											
											

											<?php } ?>		
										<?php
											}
											
									
									       break;

									case "4":
									  
										$col4_content .= '<div class="col-sm-12 col-md-6 col-lg-3 bg-white shadow1">
											<img src="'.base_url('uploads/images/'.$row['image']).'" alt="" class="img-fluid light-gray-bg mt-3" />
											<h4 class="mb-2 mt-2 text-dark">'.$row['name'].'</h4>
											<div>'.$row['content'].'</div>
										</div> ';  
									  
									/*$col4_content .= '<div class="item"> 
													  
														<img src="'.base_url('uploads/images/'.$row['image']).'" alt="" class="img-fluid" />
														<h4 class="mt-4">'.$row['name'].'</h4>
														
														<div>'.$row['content'].'</div>
												       </div> '; */												
												
											 
									
									       break;			
										   
									


								}								
								
							$ind+=1;
								
							} ?>	
							
							<?php if($col4_content!=''){
								echo $col4_header.$col4_content.$col4_footer;
							 } ?>
							
							</div>
					<?php } ?>	
							<div  id="tab3">
							<section class="page-section dark_bg">
								<div class="container">
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<h2 class="text-white pb-4 text-center">Vidiem <?= @$product['name']; ?> Specification</h2>
											<!--<h2 class="text-white pb-4 text-center">Vidiem <br/>design and functionality</h2>-->
											
											<ul class="product-description-details">
											<?php 
											  for($i=0;$i<=count($product_feature);$i++){ 
											  if($product_feature[$i]['value']!=''){
											  $clsbroder='  class="border-right" ';
											  if(((float)(($i+1) / 3))==0)
											  {
												 $clsbroder=' ';  
											  }	
											  ?>
											  
												<li <?php echo $clsbroder; ?>>
													<?= $product_feature[$i]['name'] ?>
													<span><?= $product_feature[$i]['value'] ?></span>
												</li>
											  <?php } 
											  
											  } ?>		
												
											</ul>
											
										</div>
									</div>
								</div>
							</section>
							</div>
						<!--	<section class="page-section" id="tab4">
								<div class="container">
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<h1 class="text-center" data-aos="fade-up" data-aos-delay="1" data-aos-duration="500" data-aos-offset="10">Customer Review</h1>
											<h2 class="pb-4 text-center" data-aos="fade-up" data-aos-delay="1" data-aos-duration="500" data-aos-offset="10">Top reviews from Our<br/>Valuable Customers</h2>	
										</div>
										<div class="col-sm-12 col-md-12 col-lg-6" data-aos="fade-up" data-aos-delay="1" data-aos-duration="500" data-aos-offset="10">
											<div class="customer-reviews">
												<img src="<?= base_url(); ?>assets/front-end/images/product-details/reviews-image1.png" alt="" />
												<h3 class="text-red">Larry E White</h3>
												<h6>Business Women</h6>
												<p>Neque porro quisquam est, qui dolorem ipsum qiamet, consectetur, adipisci velit, sed quia non numquam eius teimpora incidunt labore et dolore magnam aliquam quaerat voluptatem.</p>
												<h6>Must Buy! Worth The Price</h6>
												<p>23 August 2020</p>
											</div>
										</div>
										<div class="col-sm-12 col-md-12 col-lg-6" data-aos="fade-up" data-aos-delay="1" data-aos-duration="500" data-aos-offset="10">
											<div class="customer-reviews">
												<img src="<?= base_url(); ?>assets/front-end/images/product-details/reviews-image2.png" alt="" />
												<h3 class="text-red">Scott Martin</h3>
												<h6>Employee</h6>
												<p>Neque porro quisquam est, qui dolorem ipsum qiamet, consectetur, adipisci velit, sed quia non numquam eius teimpora incidunt labore et dolore magnam aliquam quaerat voluptatem.</p>
												<h6>Sturdy Motor & Strong Blades</h6>
												<p>05 September 2020</p>
											</div>
										</div>
										<div class="col-sm-12 col-md-12 col-lg-6" data-aos="fade-up" data-aos-delay="1" data-aos-duration="500" data-aos-offset="10">
											<div class="customer-reviews">
												<img src="<?= base_url(); ?>assets/front-end/images/product-details/reviews-image3.png" alt="" />
												<h3 class="text-red">Larry E White</h3>
												<h6>Business Women</h6>
												<p>Neque porro quisquam est, qui dolorem ipsum qiamet, consectetur, adipisci velit, sed quia non numquam eius teimpora incidunt labore et dolore magnam aliquam quaerat voluptatem.</p>
												<h6>Must Buy! Worth The Price</h6>
												<p>23 August 2020</p>
											</div>
										</div>
										<div class="col-sm-12 col-md-12 col-lg-6" data-aos="fade-up" data-aos-delay="1" data-aos-duration="500" data-aos-offset="10">
											<div class="customer-reviews">
												<img src="<?= base_url(); ?>assets/front-end/images/product-details/reviews-image4.png" alt="" />
												<h3 class="text-red">Scott Martin</h3>
												<h6>Employee</h6>
												<p>Neque porro quisquam est, qui dolorem ipsum qiamet, consectetur, adipisci velit, sed quia non numquam eius teimpora incidunt labore et dolore magnam aliquam quaerat voluptatem.</p>
												<h6>Sturdy Motor & Strong Blades</h6>
												<p>05 September 2020</p>
											</div>
										</div>
										<div class="col-sm-12 col-md-12 col-lg-6" data-aos="fade-up" data-aos-delay="1" data-aos-duration="500" data-aos-offset="10">
											<div class="customer-reviews">
												<img src="<?= base_url(); ?>assets/front-end/images/product-details/reviews-image5.png" alt="" />
												<h3 class="text-red">Larry E White</h3>
												<h6>Business Women</h6>
												<p>Neque porro quisquam est, qui dolorem ipsum qiamet, consectetur, adipisci velit, sed quia non numquam eius teimpora incidunt labore et dolore magnam aliquam quaerat voluptatem.</p>
												<h6>Must Buy! Worth The Price</h6>
												<p>23 August 2020</p>
											</div>
										</div>
										<div class="col-sm-12 col-md-12 col-lg-6" data-aos="fade-up" data-aos-delay="1" data-aos-duration="500" data-aos-offset="10">
											<div class="customer-reviews">
												<img src="<?= base_url(); ?>assets/front-end/images/product-details/reviews-image6.png" alt="" />
												<h3 class="text-red">Scott Martin</h3>
												<h6>Employee</h6>
												<p>Neque porro quisquam est, qui dolorem ipsum qiamet, consectetur, adipisci velit, sed quia non numquam eius teimpora incidunt labore et dolore magnam aliquam quaerat voluptatem.</p>
												<h6>Sturdy Motor & Strong Blades</h6>
												<p>05 September 2020</p>
											</div>
										</div>
									</div>
								</div>
							</section>  -->
							
							<!--<section class="page-section" id="tab4">
								<div class="container">
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<h1 class="text-center" data-aos="fade-up" data-aos-delay="1" data-aos-duration="500" data-aos-offset="10">Coming soon...</h1>
												
										</div>
									</div>
								</div>
							</section>-->
                </div>
			</div>
		</div>
	  </section>
	  
	  
  
<script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Product",
      "name": "<?= @$product['name']; ?>",
      "image": [
	  <?php if(!empty($product_img)){
					$cnt=1;
		  		foreach ($product_img as $info) {  
					if($info['type']=='image') {
						if($cnt<count($product_img)){		
									?>
        "<?= base_url('uploads/images/'.$info['url']); ?>",
	  <?php       }else { ?>
		  "<?= base_url('uploads/images/'.$info['url']); ?>"
			<?php	}
				
				
				}
				$cnt+=1;
			}
	  }
        ?>
       ],
	   
      "description": "<?= strip_tags($product['short_description']); ?>",
      "sku": "<?= $product['modal_no']; ?>",
      "mpn": "<?= $product['modal_no']; ?>",
      "brand": {
        "@type": "Brand",
        "name": "Vidiem"
      },
      "review": {
        "@type": "Review",
        "reviewRating": {
          "@type": "Rating",
          "ratingValue": "<?= rand (40, 48) / 10; ?>",
          "bestRating": "5"
        },
        "author": {
          "@type": "Person",
          "name": "Vidiem"
        }
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "<?= rand (40, 48) / 10; ?>",
        "reviewCount": "89"
      },
      "offers": {
        "@type": "Offer",
        "url": "<?= base_url('product/'.$product['slug']); ?>",
        "priceCurrency": "INR",
        "price": "<?= $product['price']; ?>",
        "priceValidUntil": "2023-02-18",
        "itemCondition": "https://schema.org/NewCondition",
        "availability": "https://schema.org/InStock",
        "seller": {
          "@type": "Organization",
          "name": "Vidiem"
        }
      }
    }
</script>
	  
	  	  
	  
<?php include 'container/footer.php';?>
<script>
 jQuery('iframe[src*="https://www.youtube.com/embed/"]').addClass("youtube-iframe");

    jQuery(".carousel-control-next").click(function() {
      // changes the iframe src to prevent playback or stop the video playback in our case
      $('.youtube-iframe').each(function(index) {
        $(this).attr('src', $(this).attr('src'));
        return false;
      });
      
//click function
    });
    
    
    jQuery("#product-details-carousel").click(function() {
      $('.youtube-iframe').each(function(index) {
        $(this).attr('src', $(this).attr('src'));
        return false;
      });
      
//click function
    });
	
	
/*Smooth scrolling*/
$("#s1").click(function() {
     $('html, body').animate({
         scrollTop: $("#tab1").offset().top-130
     });
	 $(".navigation__link").removeClass("active");
	 $(this).addClass("active");
 });

$("#s2").click(function() {
     $('html, body').animate({
         scrollTop: $("#tab2").offset().top-150
     });
	 $(".navigation__link").removeClass("active");
	 $(this).addClass("active");
 });

$("#s3").click(function() {
     $('html, body').animate({
         scrollTop: $("#tab3").offset().top-150
     });
	 $(".navigation__link").removeClass("active");
	 $(this).addClass("active");
 });

$("#s4").click(function() {
     $('html, body').animate({
         scrollTop: $("#tab4").offset().top-140
     });
	 $(".navigation__link").removeClass("active");
	 $(this).addClass("active");
 });

$('#tab1').waypoint(function() {
  $(".navigation__link").removeClass("active");
  $("#s1").addClass("active");
});

$('#tab2').waypoint(function() {
  $(".navigation__link").removeClass("active");
  $("#s2").addClass("active");
},{offset:'150px'});

$('#tab3').waypoint(function() {
  $(".navigation__link").removeClass("active");
  $("#s3").addClass("active");
},{offset:'149px'});

$('#tab4').waypoint(function() {
  $(".navigation__link").removeClass("active");
  $("#s4").addClass("active");
},{offset:'149px'});


</script>
<script>
$(document).ready(function(){
  $("#product-details-carousel .item").click(function(){
  $(this).addClass("active");
});
});
</script>