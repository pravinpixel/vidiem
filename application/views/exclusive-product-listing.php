<?php include('container/header.php'); ?>
    	<!-- Products Listing Banner -->
		<section class="product-listing-bg" style="background-size: none">
			<div class="container">
				<div class="row flex-column-reverse flex-lg-row">
					<div class="col-sm-12 col-md-12 col-lg-6">
						<img src="<?= base_url('uploads/images/'.$categoryseo[0]['image']); ?>" alt="" class="img-fluid" />
					</div>
					<div class="col-sm-12 col-md-12 col-lg-6">
						<h2 class="pb-4 text-right" data-aos="fade-up" data-aos-delay="0" data-aos-offset="-100" data-aos-duration="500">
							Exclusive Products</h2>
						<nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="0" data-aos-offset="-100" data-aos-duration="500">
							<ol class="breadcrumb justify-content-end">
								<li class="breadcrumb-item">  </li>
							</ol>
						</nav>
					</div>			
				</div>
			</div>
		</section>	  
	  <!-- Products Listing Banner -->
    
        
	<section class="pt-3 pad-md-0">
		<div class="container">
			<div class="row search_div serach_listing tab-content">

			<?php 
				if(count($product_list) > 0) {
			   		foreach($product_list as $data){ 
			?>
				<div class="col-sm-12 col-md-6 col-lg-4 mb-5">
					
				<div class="product-listing-item">
				<!--	<a href="<?= base_url('product/'.$data['slug']); ?>">  -->
	              <?php if($data['id']==114) { ?>
				    	<a href="<?= base_url('vidiem-adc'); ?>">
				    <?php } else if($data['id']==122) { ?>
				    	<a href="<?= base_url('vidiem-iris'); ?>">
					   <?php } else if($data['id']==137) { ?>
				    	<a href="<?= base_url('vidiem-tusker'); ?>">	
				    <?php } else { ?>
					<a href="<?= base_url('product/'.$data['slug']); ?>">
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
				</div>
			   <?php } 
				} else { ?>
					<h6 class="text-center w-100 my-5"> No data found </h6>
				<?php 
				} ?>
			
			</div>
		</div>
	</section>
<?php include('container/footer.php'); ?>

<script> 

    $("#exclusive-ex3").slider({});

</script>
<script>
jQuery(document).ready(function($) {
  var alterClass = function() {
    var ww = document.body.clientWidth;
    if (ww < 760) {
      $('#filter1').removeClass('show');
    } else if (ww >= 761) {
      $('#filter1').addClass('show');
    };
  };
  alterClass();
});
</script>