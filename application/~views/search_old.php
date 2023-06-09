<?php include('container/header.php'); ?>
<div class="bgPro clearfix">
    
<div class="fixedf">
	<h4 class="filter">Filter 
		<i class="fa fa-filter" aria-hidden="true"></i>
	</h4>
<div class="product_filters">
	<form action="" class="cat_filter_form">
	<div class="pd1">
		<h2>PRODUCTS FILTERS</h2>
		<input type="hidden" name="term" value="<?= @$search_term;?>">
        <input type="hidden" name="sort" value="4" class="input_sort">
	</div>
	<div class="pd1 priceFil">
		<h2>PRICE</h2>
		<div class="slidecontainer">
		  <input id="ex3" type="text" class="span2" value="" data-slider-min="0" data-slider-max="15000" data-slider-step="50" data-slider-value="[0,15000]" name="price"/> 
		    <script> 
                 $("#ex3").slider({});
            </script>       
		</div>
	</div>
	<div class="pd1 priceFil">
		<h2>Availability</h2>
		<div class="pd1_ctn">
		    <li class="clearfix">
				<label class="clearfix filllTT">
					<input name="stock" type="checkbox" class="cat_form_trigger1" value="1"><span>Include Out of Stock</span>
				</label>
			</li>
		</div>	
	</div>
	</form>
</div>
</div>


<div class="proMid serach_listing">
	<div id="tab-1" class="tab-content msec_2 clearfix current">
		<div class="container2">
			<h2>Search</h2>
			<?php if(!empty($products)){ ?>
			<div class="gridListBtn">
				<div class="shortBy">
					<select class="shotOp serch_sort_trigger">
						<option>Sort by</option>
						<option value="1">Best Selling</option>
						<option value="2">Price - Low to High</option>
						<option value="3">Price - High to Low</option>
						<option value="4">New Arrival</option>
					</select>
				</div>

		        <button class="grid glBtn">
		        	<i class="fa fa-th-large active" title="Grid View"></i>
		        </button>
		        <button class="list glBtn">
		        	<i class="fa fa-list-ul" title="List View"></i>
		        </button>
		    </div>
			<ul class="mix_list2 grid clearfix">
				<?php foreach ($products as $data) { ?>
				<li class="clearfix animated zoomIn">
					<div class="proImg prodimg">
						<img src="<?= base_url('uploads/images/'.$data['image']); ?>" alt="" />
						<em class="prHov">
							<a href="javascript:void(0);" class="QVpopup quick_view_trigger" data-id="<?= @$data['id']?>"><i class="fa fa-eye"></i>Quick View</a>
							<a href="<?= base_url('product/'.$data['slug']); ?>"><i class="fa fa-plus"></i>More</a>
						</em>
					</div>
					<div class="mix_det clearfix">
						<div class="listdetCon clearfix">
							<p><?= $data['name']; ?></p>
							<h4><i class="fa fa-inr"></i> <?= @number_format($data['price']); ?>/-</h4>
							<div class="listConSet">
								<?= $data['list_description']; ?>	
						   </div>
						</div>
						<div class="mix_det_rt">
							<?php if($data['status']==1){ ?>

							<?php if($data['outofstock']==0){ ?>
								<a class="mix_det_rt_add btn add_to_cart" href="javascript:void(0);" data-id="<?= @$data['id'];?>">Add to cart</a>
							<?php }else{ ?>
                                 <a class="mix_det_rt_add btn" href="<?= base_url('contact-us'); ?>">Out of Stock</a>
							<?php } ?>
							
							<a class="mix_det_rt_add2 btn add_to_compare" href="#comProList" data-id="<?= @$data['id']?>">Add to compare</a>
							<?php } ?>
						</div>
					</div>
				</li>
			<?php } ?>
			</ul>
			<?php }else{ ?>
				<p>No Products Available</p>
			<?php } ?>	
		</div>
	</div>
</div>
<?php //require_once('container/top_seller.php'); ?>
</div>
<?php require_once('container/footer.php'); ?>