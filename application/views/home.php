<?php include('container/header.php'); 
//echo "<pre>"; print_r($homepage_video); exit;
?>
<!-- Home Slider -->
    <div id="carousel" class="carousel slide hero-slides" data-ride="carousel">
         <ol class="carousel-indicators">
		    <?php if(!empty($banner)){
					$x=0;
			foreach($banner as $info){ ?>
            <li class="<?php if($x==0){ echo "active"; } ?>" data-target="#carousel" data-slide-to="<?php echo $x; ?>"></li>
			<?php $x++; } } ?>
            
         </ol>
         <div class="carousel-inner" role="listbox">
		 
			<?php if(!empty($banner)){
					$x=1;
			foreach($banner as $info){ ?>
            <div class="carousel-item <?php if($x==1){ echo "active"; } ?>" >
                  <?php if($info['banner_url']!=''){ ?>
                  <a class="animated fadeInUp" href="<?= $info['banner_url']; ?>">
                    <?php } ?>  
					<picture>
					  <source media="(max-width:960px)" srcset="<?= base_url('uploads/mobileimage/'.$info['mobileimage']); ?>" />
					  <img src="<?= base_url('uploads/banner/'.$info['image']); ?>" alt="">
					</picture>
				     <?php if($info['banner_url']!=''){ ?>
                  </a>
                    <?php } ?>  	
					<?php if($info['description']!=''){ ?>
                        <div class="caption animated fadeIn">
							<?=  $info['description']; ?>
							
                           <?php if($info['banner_url']!=''){ ?>
						   <p class="animated fadeInRight">
						   <a class="animated fadeInUp" href="<?= $info['banner_url']; ?>"><i class="lni lni-chevron-right"></i></a>
						   </p>
						   <?php } ?>
                        </div>
                    <?php } ?>    
            </div>
			<?php $x++; } } ?>

         </div>
		 
         <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
         <span class="sr-only">Previous</span>
         </a>
         <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
         <span class="carousel-control-next-icon" aria-hidden="true"></span>
         <span class="sr-only">Next</span>
         </a>
    </div>
	  
	  
	  <!-- Home Products -->
	<section class="bg-white pt-0" id="new-launch">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<h1 class="no-capitalize" data-aos="fade-up" data-aos-delay="0" data-aos-offset="-100" data-aos-duration="500"><?= $newlaunch['name']; ?></h1>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-6 col-xl-5">
					<h2 class="pb-4 no-capitalize" data-aos="fade-up" data-aos-delay="0" data-aos-offset="-100" data-aos-duration="500"><?= $newlaunch['content']; ?></h2>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-6 col-xl-7" data-aos-offset="-100" data-aos="fade-up" data-aos-delay="0" data-aos-duration="500">
					<ul id="responsive-tabs" class="nav nav-tabs" role="tablist">
					
						<?php if (!empty($feature_category)) {
						 $i=0;	
						  foreach ($feature_category as $info) { ?>
						  <li class="nav-item">
							<a id="tab<?= $info['id']; ?>"  href="#pane<?= $info['id']; ?>" class="<?php if($i=='0'){ echo "active" ;}?> nav-link" role="tab" data-toggle="tab"><?= $info['name']; ?></a>
							</li>
						<?php $i++; }
						} 
						?>	
					
					</ul>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" data-aos-offset="-100" data-aos="fade-up" data-aos-delay="0" data-aos-duration="500">
					<div id="responsive-tab-content" class="tab-content" role="tablist">
					
					  <?php if(!empty($feature_category)){ 
					   $i = 0;
					foreach($feature_category as $info){ ?> 
					
						
						<div id="pane<?= $info['id']; ?>" class="card tab-pane fade <?php echo $i == 0 ? ' show active ' : '' ?> " role="tabpanel" aria-labelledby="tab<?= $info['id']; ?>">
							<div class="card-header active-acc" role="tab" id="heading<?= $info['id']; ?>">
								<h5 class="mb-0">
									<!-- Note: `data-parent` removed from here -->
									<a data-toggle="collapse" href="#collapse<?= $info['id']; ?>" aria-expanded="true" aria-controls="collapse<?= $info['id']; ?>">
										<?= $info['name']; ?>
									</a>
								</h5>
							</div>
						
					
							<div id="collapse<?= $info['id']; ?>" class="collapse  <?php echo $i == 0 ? ' show ' : '' ?>" data-parent="#responsive-tab-content" role="tabpanel" aria-labelledby="heading<?= $info['id']; ?>">
								<div class="card-body">
									<div class="carousel-wrap">
							  <div class="owl-carousel product-carousel">
							  
							  <?php 
							  
							  
		  $this->db->select('p.id,p.slug,p.name,p.image,p.price,p.old_price,p.outofstock,p.list_description');
          $this->db->join('vidiem_category c','c.id=p.sub_cat_id and c.status=1 AND c.parent_id='.$info['id'].'','inner');
          $this->db->order_by("c.order_no", "asc");
		  $this->db->order_by("p.price", "desc");
		  //$this->db->limit(10,0);
          $query=$this->db->get_where('vidiem_products p',array('p.cat_id'=>$info['id'],'p.status'=>1));
		
				 $product_list=$query->result_array();
			//echo $this->db->last_query();
			//die();
				 
			//print_r($product_list); 
								
								
								if(!empty($product_list)){ 
								
								 foreach ($product_list as $data) { 
								?>
							  
								<div class="item">
								    <?php if($data['id']==114) { ?>
								    	<a href="<?= base_url('vidiem-adc'); ?>">
								    <?php } else if($data['id']==122) { ?>
								    	<a href="<?= base_url('vidiem-iris'); ?>">
									  <?php } else if($data['id']==137) { ?>
								    	<a href="<?= base_url('vidiem-tusker'); ?>">	
								    <?php } else { ?>
									<!--<a href="<?= base_url('product/'.$data['slug']); ?>">-->
									<a href="<?= base_url($info["slug"].'/'.$data['slug']); ?>">
									<?php } ?>
									<h3><strong>Vidiem</strong> <?= $data['name']; ?></h3>
									<p class="price">₹ <?= @number_format($data['price']); ?> <span class="strike"> <?php if(isset($data['old_price']) && $data['old_price']>0){ ?> ₹ <?= @number_format($data['old_price']); } ?></span></p>
									<?php if($data['image']!=''){?> 
									<img src="<?= base_url('uploads/images/'.$data['image']); ?>" alt="" />
									<?php } else{ ?>
									<img src="<?= base_url('assets/front-end/images/NoImageAvailable.png'); ?>" alt="" />
									<?php } ?>
									</a>
									<p class="product-link">
									<?php if($data['outofstock']==0){ ?>
									<a id="<?= $data['slug']; ?>-buy-now" href="<?= base_url('buy-now/'.$data['id']); ?>" class="buy-now">Buy Now</a><a id="<?= $data['slug']; ?>-add-to-cart" class="add-to-cart add_to_cart" href="javascript:void(0);" data-id="<?= @$data['id'];?>" ><i class="lni lni-cart"></i></a>
									<?php } else{ ?>
									<a href="<?= base_url('contact-us'); ?>" class="buy-now">Out of Stock</a><a class="add-to-cart" href="javascript:void(0);"><i class="lni lni-cart"></i></a>
									<?php } ?>
									</p>
									<a href="#comProList" class="add-to-compare add_to_compare" data-toggle="modal" data-target="#AddToCompareModal" data-id="<?= @$data['id']?>"><i class="lni lni-reload"></i> Add to Compare</a>									
								</div>
								
								<?php } } ?>

								
							  </div>
							</div>
								</div>
							
							<p class="text-center mb-0">
								<a href="<?= base_url('category/'.$info['slug']); ?>" class="black-button">View All Products</a>
							</p>	
								
							</div>
                       
							
						</div>
					   <?php $i++; } 
					    } ?>
					
					</div>
				</div>
			</div>
		
		</div>
	</section>
	  
	  
	<section class="bg-white pt-0" id="new-launch">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<h1 class="new-launches" data-aos="fade-up" data-aos-delay="0" data-aos-offset="-100" data-aos-duration="500"><span>New Launch</span></h1>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-6 col-xl-5">
					<h2 class="pb-4 no-capitalize" data-aos="fade-up" data-aos-delay="0" data-aos-offset="-100" data-aos-duration="500">Our Latest Home Collections</h2>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-6 col-xl-7" data-aos-offset="-100" data-aos="fade-up" data-aos-delay="0" data-aos-duration="500">
					<ul id="responsive-tabs" class="nav nav-tabs" role="tablist">
					
					
					<?php 
					// $this->db->select('cat_id,id,new_launches,status');
					$this->db->select('vp.cat_id,vp.id as product_id,vp.new_launches,vp.status,vc.id,vc.name,vc.image,vc.slug');
					$this->db->from('vidiem_products as vp');
					$this->db->join('vidiem_category as vc','vc.id = vp.cat_id');
					$this->db->where('vp.status',1);
					$this->db->where('vp.new_launches',1);
					$this->db->group_by('vp.cat_id',1);
					$feature_category = $this->db->get()->result_array();
					
					?>
					<br>
					<br>
					
						<?php if (!empty($feature_category)) {
						 $i=0;	
						  foreach ($feature_category as $info) { ?>
						  <li class="nav-item">
							<a id="tab<?= $info['id']; ?>"  href="#panes<?= $info['id']; ?>" class="<?php if($i=='0'){ echo "active" ;}?> nav-link" role="tab" data-toggle="tab"><?= $info['name']; ?></a>
							</li>
						<?php $i++; }
						} 
						?>	
					
					</ul>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" data-aos-offset="-100" data-aos="fade-up" data-aos-delay="0" data-aos-duration="500">
					<div id="responsive-tab-content" class="tab-content" role="tablist">
					
					  <?php if(!empty($feature_category)){ 
					   $i = 0;
					foreach($feature_category as $info){ ?> 
					
						
						<div id="panes<?= $info['id']; ?>" class="card tab-pane fade <?php echo $i == 0 ? ' show active ' : '' ?> " role="tabpanel" aria-labelledby="tab<?= $info['id']; ?>">
							<div class="card-header active-acc" role="tab" id="heading<?= $info['id']; ?>">
								<h5 class="mb-0">
									<!-- Note: `data-parent` removed from here -->
									<a data-toggle="collapse" href="#collapse<?= $info['id']; ?>" aria-expanded="true" aria-controls="collapse<?= $info['id']; ?>">
										<?= $info['name']; ?>
									</a>
								</h5>
							</div>
						
					
							<div id="collapse<?= $info['id']; ?>" class="collapse  <?php echo $i == 0 ? ' show ' : '' ?>" data-parent="#responsive-tab-content" role="tabpanel" aria-labelledby="heading<?= $info['id']; ?>">
								<div class="card-body">
									<div class="carousel-wrap">
							  <div class="owl-carousel product-carousel">
							  
							  <?php 
							  
							  
		  $this->db->select('p.id,p.slug,p.name,p.image,p.price,p.old_price,p.outofstock,p.list_description');
          $this->db->join('vidiem_category c','c.id=p.sub_cat_id and c.status=1 AND c.parent_id='.$info['id'].'','inner');
          $this->db->order_by("c.order_no", "asc");
		  $this->db->order_by("p.price", "desc");
		  //$this->db->limit(10,0);
          $query=$this->db->get_where('vidiem_products p',array('p.cat_id'=>$info['id'],'p.status'=>1,'p.new_launches'=>1));
		
				 $product_list=$query->result_array();
			//echo $this->db->last_query();
			//die();
				 
			//print_r($product_list); 
								
								
								if(!empty($product_list)){ 
								
								 foreach ($product_list as $data) { 
								?>
							  
								<div class="item">
								    <?php if($data['id']==114) { ?>
								    	<a href="<?= base_url('vidiem-adc'); ?>">
								    <?php } else if($data['id']==122) { ?>
								    	<a href="<?= base_url('vidiem-iris'); ?>">
									  <?php } else if($data['id']==137) { ?>
								    	<a href="<?= base_url('vidiem-tusker'); ?>">	
								    <?php } else { ?>
									<!--<a href="<?= base_url('product/'.$data['slug']); ?>">-->
									<a href="<?= base_url($info['slug'].'/'.$data['slug']); ?>">
									<?php } ?>
									<h3><strong>Vidiem</strong> <?= $data['name']; ?></h3>
									<p class="price">₹ <?= @number_format($data['price']); ?> <span class="strike"> <?php if(isset($data['old_price']) && $data['old_price']>0){ ?> ₹ <?= @number_format($data['old_price']); } ?></span></p>
									<?php if($data['image']!=''){?> 
									<img src="<?= base_url('uploads/images/'.$data['image']); ?>" alt="" />
									<?php } else{ ?>
									<img src="<?= base_url('assets/front-end/images/NoImageAvailable.png'); ?>" alt="" />
									<?php } ?>
									</a>
									<p class="product-link">
									<?php if($data['outofstock']==0){ ?>
									<a id="<?= $data['slug']; ?>-buy-now" href="<?= base_url('buy-now/'.$data['id']); ?>" class="buy-now">Buy Now</a><a id="<?= $data['slug']; ?>-add-to-cart" class="add-to-cart add_to_cart" href="javascript:void(0);" data-id="<?= @$data['id'];?>" ><i class="lni lni-cart"></i></a>
									<?php } else{ ?>
									<a href="<?= base_url('contact-us'); ?>" class="buy-now">Out of Stock</a><a class="add-to-cart" href="javascript:void(0);"><i class="lni lni-cart"></i></a>
									<?php } ?>
									</p>
									<a href="#comProList" class="add-to-compare add_to_compare" data-toggle="modal" data-target="#AddToCompareModal" data-id="<?= @$data['id']?>"><i class="lni lni-reload"></i> Add to Compare</a>									
								</div>
								
								<?php } } ?>

								
							  </div>
							</div>
								</div>
							
							<p class="text-center mb-0">
								<a href="<?= base_url('category/'.$info['slug']); ?>" class="black-button">View All Products</a>
							</p>	
								
							</div>
                       
							
						</div>
					   <?php $i++; } 
					    } ?>
					
					</div>
				</div>
			</div>
		
		</div>
	</section>
	  
	  <!-- Customize Product -->
	  <!--<section class="pt-0 vidiem-by-you">
		<div class="container-fluid p-0">
			<div class="row justify-content-center">
				<div class="col-sm-12 col-md-12 col-lg-1">
				</div>
				<div class="col-sm-12 col-md-12 col-lg-4 pb-4">
					<h1 data-aos="fade-up" data-aos-delay="50" data-aos-duration="500">vidiem by you</h1>
					<h2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="500">customise your own product</h2>
					<h4 class="color-dark pt-4" data-aos="fade-up" data-aos-delay="50" data-aos-duration="500"><strong>Duis aute irure dolor in reprehenderit</strong></h4>
					<p class="pb-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="500">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dos qui ratione voluptatem sequi magni nesciunt.</p>
					<h4 class="color-dark pt-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="500"><strong>Color Options</strong></h4>
					<ul class="colors" data-aos="fade-up" data-aos-delay="50" data-aos-duration="500">
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
					</ul>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-7 pb-4 text-right" data-aos="fade-left" data-aos-delay="50" data-aos-duration="500">
					<img src="<?= base_url(); ?>assets/front-end/images/customize-image1.jpg" alt="" class="img-fluid" />
				</div>
			</div>
	  </section>-->
	  
	  <!-- Home Video -->
	  <section class="light-gray-bg">
		<div class="container">
			<div class="row align-items-end">
				<div class="col-sm-12 col-md-12 col-lg-6 pb-4">
					<h1 class="text-red no-capitalize" data-aos="fade-up" data-aos-offset="-100" data-aos-delay="0" data-aos-duration="1000"><?= $knowyourvidiem['name']; ?></h1>
					<h2 class="no-capitalize" data-aos="fade-up"  data-aos-offset="-100" data-aos-delay="0" data-aos-duration="500"><?= $knowyourvidiem['content']; ?></h2>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-6 pb-4">
					<p class="text-right watch-on-youtube" data-aos="fade-up" data-aos-delay="0" data-aos-offset="-100" data-aos-duration="500">
						Watch on <a href="https://www.youtube.com/channel/UCLJE5AoP7y7ccfFrMFyAv8g" target="_blank">Youtube <i class="lni lni-youtube"></i></a>
					</p>
				</div>
			</div>
			<div class="row">				
				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" data-aos="fade-up" data-aos-delay="0" data-aos-offset="-100" data-aos-duration="500">					
					<div id="video-carousel" class="carousel slide hero-slides" data-ride="carousel">
					
					 <!-- <ol class="carousel-indicators">
					 <?php 
					 $i=0;
					 foreach($homepage_video as $data) { ?>
						<li class="<?php if($i=='0'){ echo "active"; } ?>" data-target="#video-carousel" data-slide-to="<?php echo $i; ?>"></li>
						
					 <?php $i++; } ?>
					 </ol> -->
					 
					 <div class="carousel-inner" role="listbox">
					 <?php 
					 $i=0;
					 foreach($homepage_video as $data) { ?>
						<div class="carousel-item <?php if($i=='0'){ echo "active";} ?> dark_bg">
						   <div class="row">
								<div class="col-sm-12 col-md-12 col-lg-4">
									<div class="p-5">
										<h4 class="text-white no-capitalize"><?php echo $data['title'];?></h4>
										<p class="text-white mb-5 no-capitalize"><?php echo $data['description'];?><br/><a href="<?php echo$data['urllink']; ?>" class="know-more">Know More</a></p>
										<img src="<?= base_url(); ?>uploads/images/<?php echo $data['image']; ?>" alt="" class="img-fluid" />
									</div>
								</div>
								
								<div class="col-sm-12 col-md-12 col-lg-8">
									 <iframe src="https://www.youtube.com/embed/<?php echo $data['video_url']; ?>?autoplay=0&showinfo=0&controls=0&rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="product-video"  allowscriptaccess="always"></iframe>
								</div>
								
						   </div>
						</div>
						<?php $i++; } ?>
						
					 </div>
					 <a class="carousel-control-prev stop-video" href="#video-carousel" role="button" data-slide="prev">
					 <span class="carousel-control-prev-icon" aria-hidden="true"></span>
					 <span class="sr-only">Previous</span>
					 </a>
					 <a class="carousel-control-next stop-video" href="#video-carousel" role="button" data-slide="next">
					 <span class="carousel-control-next-icon" aria-hidden="true"></span>
					 <span class="sr-only">Next</span>
					 </a>
				  </div>
				</div>
			</div>
		</div>
	  </section>
	  
	  
	  <!-- Best Offer -->
	  <section class="pb-5" style="display:none;">
		<div class="container-fluid p-0">
			<div class="row justify-content-center">
				<div class="col-sm-12 col-md-12 col-lg-6 pb-4">
					<h1 class="text-red text-center no-capitalize" data-aos="fade-up" data-aos-offset="-100" data-aos-delay="0" data-aos-duration="500"><?= $bestoffer['name']; ?></h1>
					<h2 class="text-center no-capitalize" data-aos="fade-up" data-aos-offset="-100" data-aos-delay="0" data-aos-duration="500"><?= $bestoffer['content']; ?></h2>
				</div>
			</div>
			<div class="row justify-content-center no-gutters">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<div id="add-carousel" class="carousel slide hero-slides" data-ride="carousel">
						 <ol class="carousel-indicators">
							<?php 
							 $i=0;
							 foreach($homepage_bestoffer as $data) { ?>
							
								<li class="<?php if($i=='0'){ echo "active"; } ?>" data-target="#carousel" data-slide-to="<?php echo $i; ?>"></li>
								
							 <?php $i++; } ?>

						 </ol>
						 <div class="carousel-inner" role="listbox">
						 <?php 
						 $i=0;
						 foreach($homepage_bestoffer as $data){ ?>
							<div class="carousel-item <?php if($i=='0'){ echo "active";} ?>">
							   <img src="<?= base_url(); ?>uploads/images/<?php echo $data['image']; ?>" alt="" class="img-fluid w-100"  data-aos="zoom-out-up" data-aos-offset="-100" data-aos-delay="0" data-aos-duration="500" />
							</div>
						 <?php $i++; } ?>
						 </div>
						 <a class="carousel-control-prev" href="#add-carousel" role="button" data-slide="prev">
						 <span class="carousel-control-prev-icon" aria-hidden="true"></span>
						 <span class="sr-only">Previous</span>
						 </a>
						 <a class="carousel-control-next" href="#add-carousel" role="button" data-slide="next">
						 <span class="carousel-control-next-icon" aria-hidden="true"></span>
						 <span class="sr-only">Next</span>
						 </a>
					  </div>
				</div>
			</div>
		</div>
	  </section>
	  
	  <!-- Customer Favourites -->
	  <section class="pb-0" style="display:none;">
		<div class="container-fluid p-0">
			<div class="row justify-content-center">
				<div class="col-sm-12 col-md-12 col-lg-6 pb-4">
					<h1 class="text-center" data-aos="fade-up" data-aos-offset="-100" data-aos-delay="0" data-aos-duration="500"><?= $customersfavourites['name']; ?></h1>
					<h2 class="text-center" data-aos="fade-up" data-aos-offset="-100" data-aos-delay="0" data-aos-duration="500"><?= $customersfavourites['content']; ?></h2>
				</div>
			</div>
			
			   <?php //foreach($blockmng as $info) {
					echo $blockmng['content'];
			    //} ?>
			
		</div>
	  </section>
	  
	  <!-- Testimonials -->
	  <section class="border-bottom pb-0">
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-12 col-md-12 col-lg-5">
					<div class="pl-5 pr-5">
						<img src="<?= base_url(); ?>assets/front-end/images/testimonial-image.webp" alt="" class="img-fluid"  data-aos="zoom-out-up" data-aos-offset="-100" data-aos-delay="0" data-aos-duration="500" />
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-7 testimonial_section">
					<h1 class="mt-5 no-capitalize" data-aos="fade-up" data-aos-offset="-100" data-aos-delay="0" data-aos-duration="500"><?= $customersfeedback['name']; ?></h1>
					<h2 class="no-capitalize" data-aos="fade-up" data-aos-offset="-100" data-aos-delay="0" data-aos-duration="500"><?= $customersfeedback['content']; ?></h2>
					<div class="testimonial_box"  data-aos="fade-up" data-aos-offset="0" data-aos-delay="0" data-aos-duration="500">
                            <div class="testimonial_container">
                                <div class="layer_content">
                                    <div class="testimonial_owlCarousel owl-carousel">
									  <?php foreach($testimonial as $data){ ?>
                                        <div class="testimonials"> 
											<h6 class="text-red"><?= $data['title']; ?></h6>
                                                <?= $data['content']; ?>
                                            <h6><?= $data['name']; ?></h6>
                                                <span><?= $data['designation']; ?></span>
												<img src="<?= base_url('uploads/testimonial/'.$data['image']); ?>" alt="" />
                                        </div>
									  <?php } ?>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
				</div>
			</div>
			<!-- <div class="row home-testimonial-bottom">
				<div class="col-sm-12 col-md-12 col-lg-4 pt-5 mt-5" data-aos-offset="-100"  data-aos="fade-up" data-aos-delay="0" data-aos-duration="500">
					<div class="find-offer-support">
						<a class="d-block" href="<?= base_url(); ?>dealer-locator">
						<i class="lni lni-map-marker"></i>
					  <?php 
					echo $homefindvidiem['content'];
			         ?>
						</a>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-4 pt-5 mt-5" data-aos="fade-up" data-aos-delay="0" data-aos-offset="-100" data-aos-duration="500">
					<div class="find-offer-support">
						<i class="lni lni-gift"></i>
					 <?php //foreach($blockmng as $info) {
					echo $homespecialoffer['content'];
			    //} ?>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-4 pt-5 mt-5" data-aos="fade-up" data-aos-delay="0" data-aos-offset="-100" data-aos-duration="500">
					<div class="find-offer-support">
						<a class="d-block" href="<?= base_url(); ?>complaint-registration">
						<i class="lni lni-cog"></i>
					 <?php //foreach($blockmng as $info) {
					echo $homeoursupport['content'];
			    //} ?>
						</a>
					</div>
				</div>
			</div> -->
		</div>
	  </section>
<?php include('container/footer.php'); ?>


<!-- Modal -->
<div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
          <button style="position:absolute;  top:8px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <iframe width="100%" height="375" id="home-video-popup" src="https://www.youtube.com/embed/SuJTgr5GgqM?autoplay=0&showinfo=0&controls=0&rel=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
      
    </div>
  </div>
</div> 




<script>
jQuery(window).load(function() {
    $('#video-carousel.carousel').carousel('pause');
});


$(window).on('load',function(){
    var delayMs = 500; // delay in milliseconds
      $('#basicExampleModal').modal('show');
    setTimeout(function(){
        $('#basicExampleModal').modal('show');
    }, delayMs);
});

</script>