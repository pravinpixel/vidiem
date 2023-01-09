<?php include('container/header.php'); 
//echo "<pre>"; print_r($categoryseo); exit;

?>

	  
	  <!-- Products Listing Banner -->
	  <section class="product-listing-bg">
		<div class="container">
			<div class="row flex-column-reverse flex-lg-row">
				<div class="col-sm-12 col-md-12 col-lg-6">
					<img src="<?= base_url('uploads/images/'.$categoryseo[0]['image']); ?>" alt="" class="img-fluid" />
				</div>
				<div class="col-sm-12 col-md-12 col-lg-6">
					<h2 class="pb-4 text-right" data-aos="fade-up" data-aos-delay="0" data-aos-offset="-100" data-aos-duration="500"><?= $categoryseo[0]['name']?><br/><?= $categoryseo[0]['description']?></h2>
					<nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="0" data-aos-offset="-100" data-aos-duration="500">
						<ol class="breadcrumb justify-content-end">
							<li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
							<li class="breadcrumb-item"> <?= $categoryseo[0]['name']; ?> </li>
						</ol>
					</nav>
				</div>				
			</div>
		</div>
	  </section>	  
	  <!-- Products Listing Banner -->
	  <section class="light-gray-bg pt-3 pb-2" id="product-filters">
		<div class="container">
			<div class="row">
			<div class="col">
			<div class="accordion" id="filter">
                    <div class="card">
                        <div class="card-header" id="filterhead1">
                            <a href="#" data-toggle="collapse" data-target="#filter1"
                            aria-expanded="true" aria-controls="filter1"><i class="fa fa-filter" aria-hidden="true"></i> Filters</a>
                        </div>

                        <div id="filter1" class="collapse in show" aria-labelledby="filterhead1" data-parent="#filter">
                            <div class="card-body">
                                <form method="" class="cat_filter_form">
			<div class="d-flex">
				<input type="hidden" name="cat_id" value="<?= $cat_id;?>">
				<input type="hidden" name="type" value="1">
				<input type="hidden" name="sort" value="0" class="input_sort">
				<div class="pd1 priceFil">
					<h4 class="color-dark">Price Range</h4>
					
					<input id="ex2" type="text" class="span2 custom-checkbox price_slide_trigger" value="" data-slider-min="0" data-slider-max="15000" data-slider-step="50" data-slider-value="[0,15000]" name="price"/> 
					
					
				</div>
				
				
				
			
				
				
				<?php if(!empty($filters)){ $f_ind=2; ?>
				<?php foreach($filters as $info){ 
					$name=$this->FunctionModel->Select_Field('name','vidiem_filters',array('id'=>$info['filter_id']));
					$fil_item=$this->FunctionModel->Select_Fields('id,name','vidiem_filter_option',array('parent_id'=>$info['filter_id'],'status'=>1));
					if(!empty($fil_item)){
						//print_r($fil_item);
				?>
				
				<div class="filter-checkbox2 <?php echo $categoryseo[0]['slug']."-".$f_ind; ?>">
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
				
				<?php } $f_ind++; } } ?>
				
					<div class="filter-checkbox1 <?php echo $categoryseo[0]['slug']."-1"; ?>">
					<h4 class="color-dark">Products Filters</h4>
					<?php if(!empty($filter_sub_cat)){ $x=1;
				foreach($filter_sub_cat as $info){ 
				  
				  $chk='';
				  if($info['id']==$subcatid){
					  $chk="checked='checked'";
				  }
				?>
					<div class="custom-checkbox">
						<label class="filllTT">
						<input type="checkbox" data-ng-model="example.check" name="sub_filters[]" class="cat_form_trigger" <?= $chk; ?> value="<?= $info['id']; ?>">
						  <span class="box"></span>
						  <?= $info['name']; ?>
						</label>
					</div>
					<?php $x++; } } ?>

				</div>	
				
			</div>
			</form>
                            </div>
                        </div>
                    </div>
                </div>
				</div>
				</div>
			<!--	<form method="" class="cat_filter_form">
			<div class="row">
				<input type="hidden" name="cat_id" value="<?= $cat_id;?>">
				<input type="hidden" name="type" value="1">
				<input type="hidden" name="sort" value="4" class="input_sort">
				<div class="col-sm-12 col-md-6 col-lg-3 pd1 priceFil" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
					<h4 class="color-dark">Price Range</h4>
					
					<input id="ex2" type="text" class="span2 custom-checkbox price_slide_trigger" value="" data-slider-min="0" data-slider-max="15000" data-slider-step="50" data-slider-value="[0,15000]" name="price"/> 
					
					
				</div>
				
				
				
				<div class="col-sm-12 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
					<h4 class="color-dark">PRODUCTS FILTERS</h4>
					<?php if(!empty($filter_sub_cat)){ $x=1;
				foreach($filter_sub_cat as $info){ 
				  
				  $chk='';
				  if($info['id']==$subcatid){
					  $chk="checked='checked'";
				  }
				?>
					<div class="custom-checkbox">
						<label class="filllTT">
						<input type="checkbox" data-ng-model="example.check" name="sub_filters[]" class="cat_form_trigger" <?= $chk; ?> value="<?= $info['id']; ?>">
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
			</form> -->
		</div>
	  </section>

	  <!-- Products Listing -->
	  <section class="pt-3 pad-md-0">
		<div class="container">
			
			<div class="row justify-content-end">
				<div class="col-sm-12 col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="0" data-aos-offset="-100" data-aos-duration="500">
					<select name="filters" id="filters" class="js-states form-control shotOp cat_sort_trigger">
						<option selected value="0" >-- Filter --</option>
					<!--	<option value="1">Best Selling</option> -->
						<option value="2">Price - Low to High</option>
						<option  value="3">Price - High to Low</option>
						<option value="4">New Arrival</option>						
					</select>
					
					
				</div>
			</div>
				
			<div class="row search_div serach_listing tab-content">
			   <?php foreach($product_list as $data){ ?>
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
			   <?php } ?>
				
				<!--<div class="col-sm-12 col-md-12 col-lg-12" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
					<p class="text-center">
						<a href="#" class="black-button">View All Products</a>
					</p>
				</div>-->
			</div>
		</div>
	  </section>
	  
	  <!-- Products Listing Banner -->
	  <section class="light-gray-bg">
		<div class="container">
			<div class="row">
			    <?php  if(count($otherproduct_list)>0){ ?>
				<div class="col-sm-12 col-md-12 col-lg-12">
					<h1 class="text-center">Vidiem mixers</h1>
					<h2 class="text-center mb-5" data-aos="fade-up" data-aos-delay="0" data-aos-offset="-100" data-aos-duration="500">Other Popular Models</h2>					
				</div>
				<?php 
				
				foreach($otherproduct_list as $data){ ?>
				<div class="col-sm-12 col-md-6 col-lg-6 mb-5">
					<div class="bg-white p-4 mb-5">
						<div class="row align-items-end">
							<div class="col-sm-12 col-md-12 col-lg-6">							
								<h1 class="text-red">Vidiem</h1>
								<h2 class="h3"><?= $data['name']; ?></h2>
								<p class="popular-text"><?= $data['content']; ?></p>
								<p class="popular-text"><a href="<?= $data['productlink']; ?>">View Product <i class="lni lni-chevron-right"></i></a></p>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-6">
								<img src="<?= base_url('uploads/images/'.$data['image']); ?>" alt="" class="img-fluid popular-img" />
							</div>
						</div>
					</div>
				</div>
				 <?php } } ?>

			</div>
		</div>
	  </section>
<?php include('container/footer.php'); ?>

<script> 

    $("#ex2").slider({});

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