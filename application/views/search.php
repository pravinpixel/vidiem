<?php include('container/header.php'); 
//echo "<pre>"; print_r($products); exit;

?>

	  
	  <!-- Products Listing Banner -->
	  <section class="product-listing-bg">
		<div class="container">
			<div class="row flex-column-reverse flex-lg-row">
				<div class="col-sm-12 col-md-12 col-lg-6">
					<img src="<?= base_url('uploads/images/gasa_1dc7b.jpg'); ?>" alt="" class="img-fluid" />
				</div>
				<div class="col-sm-12 col-md-12 col-lg-6">
					<h2 class="pb-4 text-right" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000"><?= $categoryseo[0]['description']?></h2>
					<nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
						<ol class="breadcrumb justify-content-end">
							<li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
							<li class="breadcrumb-item"> Search </li>
						</ol>
					</nav>
				</div>				
			</div>
		</div>
	  </section>	  
	  <!-- Products Listing Banner -->
	  <section class="light-gray-bg pt-5 pb-5">
		<div class="container">
				<form method="" class="cat_filter_form">
			<div class="row">
				<input type="hidden" name="term" value="<?= @$search_term;?>">
				<input type="hidden" name="sort" value="4" class="input_sort">
				
				<div class="col-sm-12 col-md-6 col-lg-3 pd1 priceFil" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
					<h4 class="color-dark">Price Range</h4>
					
					<input id="ex3" type="text" class="span2 custom-checkbox price_slide_trigger" value="" data-slider-min="0" data-slider-max="15000" data-slider-step="50" data-slider-value="[0,15000]" name="price"/> 
					
					
				</div>
				
				
				<div class="col-sm-12 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
					<h4 class="color-dark">PRODUCTS FILTERS</h4>
					<?php if(!empty($filter_sub_cat)){ $x=1;
				foreach($filter_sub_cat as $info){ ?>
					<div class="custom-checkbox">
						<label class="filllTT">
						<input type="checkbox" data-ng-model="example.check" name="sub_filters[]" class="cat_form_trigger" value="<?= $info['id']; ?>">
						  <span class="box"></span>
						  <?= $info['name']; ?>
						</label>
					</div>
					<?php $x++; } } ?>

				</div>	
				
				
				<?php if(!empty($filters)){ ?>
				<?php foreach($filters as $info){ 
					$name=$this->FunctionModel->Select_Field('name','vidiem_filters',array('id'=>$info['filter_id']));
					$fil_item=$this->FunctionModel->Select_Fields('id,name','vidiem_filter_option',array('parent_id'=>$info['filter_id'],'status'=>1));
					if(!empty($fil_item)){
						//print_r($fil_item);
				?>
				
				<div class="col-sm-12 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
					<h4 class="color-dark"><?= $name; ?></h4>
					<?php	foreach($fil_item as $tmp){?>
					<div class="custom-checkbox">
						<label class="filllTT">
						  <input type="checkbox" data-ng-model="example.check" name="filters[<?= $info['id']?>][]" class="cat_form_trigger" value="<?= $tmp['id']; ?>">
						  <span class="box"></span>
						  <?= $tmp['name']; ?>
						</label>
					</div>
					<?php } ?>

				</div>
				
				<?php } } } ?>
			</div>
			</form>
		</div>
	  </section>

	  <!-- Products Listing -->
	  <section class="pt-5">
		<div class="container">
			
			<div class="row justify-content-end">
				<div class="col-sm-12 col-md-4 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
					<select name="filters" id="filters" class="js-states form-control shotOp serch_sort_trigger">
						<option>-- Filter --</option>
						<option value="1">Best Selling</option>
						<option value="2">Price - Low to High</option>
						<option value="3">Price - High to Low</option>
						<option value="4">New Arrival</option>						
					</select>
					
					
				</div>
			</div>
				
			<div class="row search_div serach_listing tab-content">
			   <?php foreach($products as $data){ ?>
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
					<a href="<?= base_url('buy-now/'.$data['id']); ?>" class="buy-now">Buy Now</a><a class="add-to-cart add_to_cart" href="javascript:void(0);" data-id="<?= @$data['id'];?>" ><i class="lni lni-cart"></i></a>
					<?php } else{ ?>
					<a href="<?= base_url('contact-us'); ?>" class="buy-now">Out of Stock</a><a class="add-to-cart" href="javascript:void(0);"><i class="lni lni-cart"></i></a>
					<?php } ?>
					</p>
					<a href="#comProList" class="add-to-compare add_to_compare" data-toggle="modal" data-target="#AddToCompareModal" data-id="<?= @$data['id']?>"><i class="lni lni-reload"></i> Add to Compare</a>									
				</div>
				</div>
			   <?php } ?>
				

			</div>
		</div>
	  </section>

<?php include('container/footer.php'); ?>

<script> 
    $("#ex3").slider({});
</script>