<?php include('container/header.php'); ?>
<div class="bgPro clearfix">
    <div class="fixedf">
	<h4 class="filter">Filter 
		<i class="fa fa-filter" aria-hidden="true"></i>
	</h4>
<div class="product_filters">
	<form method="" class="cat_filter_form">
		<input type="hidden" name="cat_id" value="<?= $cat_id;?>">
		<input type="hidden" name="type" value="1">
		<input type="hidden" name="sort" value="4" class="input_sort">
	<div class="pd1">
		<h2>PRODUCTS FILTERS</h2>
		<div class="pd1_ctn">
			<?php if(!empty($filter_sub_cat)){ $x=1;
				foreach($filter_sub_cat as $info){ ?>
			<li class="clearfix">
				<label class="clearfix filllTT">
					<input name="sub_cat" type="radio" class="sub_cat_filter filter_cat_trigger" value="<?= $info['id']; ?>" data-tri="<?= $info['id']; ?>" <?= ($x==1)?'checked':''; ?>><span><?= $info['name']; ?></span>
				</label>
			</li>
		<?php $x++; } } ?>
		</div>
	</div>
	  <?php if(!empty($filters)){ ?>
		<?php foreach($filters as $info){ 
			$name=$this->FunctionModel->Select_Field('name','vidiem_filters',array('id'=>$info['filter_id']));
			$fil_item=$this->FunctionModel->Select_Fields('id,name','vidiem_filter_option',array('parent_id'=>$info['filter_id'],'status'=>1));
			if(!empty($fil_item)){
		?>
		<div class="pd1">
		<h2><?= $name; ?></h2>
		<div class="pd1_ctn">
			<?php	foreach($fil_item as $tmp){?>
			<li class="clearfix">
				<label class="clearfix filllTT">
					<input name="filters[<?= $info['id']?>][]" type="checkbox" class="cat_form_trigger" value="<?= $tmp['id']; ?>"><span><?= $tmp['name']; ?></span>
				</label>
			</li>
		<?php } ?>
		</div>
		</div>
		<?php } } ?>
	<?php } ?>

	<div class="pd1 priceFil">
		<h2>PRICE</h2>
		    <input id="ex2" type="text" class="span2 price_slide_trigger" value="" data-slider-min="0" data-slider-max="15000" data-slider-step="50" data-slider-value="[0,15000]" name="price"/> 
		    <script> 
                 $("#ex2").slider({});
            </script>         
	</div>

	<div class="pd1 priceFil">
		<h2>Availability</h2>
		<div class="pd1_ctn">
		    <li class="clearfix">
				<label class="clearfix filllTT">
					<input name="stock" type="checkbox" class="cat_form_trigger" value="1"><span>Include Out of Stock</span>
				</label>
			</li>
		</div>	
	</div>
	</form>
</div>
</div>

<div class="proMid">
	<section class="bannerful clearfix">
		<div class="pro-banners">
			<div class="container2">
				<div class="mix_ban owl-carousel" id="owl-demo5">
					<div class="item">
						<?php if(!empty($cat['banner_image'])){ ?>
					<a href="<?= (!empty($cat['banner_url'])?base_url($cat['banner_url']):'javascript:void(0);')?>">
						<img src="<?= base_url('uploads/images/'.$cat['banner_image']); ?>" />
					</a>
	<?php } ?>
	
					</div>
					<?php if(!empty($category_img)){ 
				    foreach ($category_img as $info) { ?>
					<div class="item">
					<a href="<?= (!empty($info['banner_url'])?base_url($info['banner_url']):'javascript:void(0);')?>">
						<img src="<?= base_url('uploads/images/'.$info['image']); ?>" />
					</a>
					</div>
					<?php }} ?>
				</div>
			</div>
		</div>
	</section> 
	<?php if(!empty($sub_cat)){ $x=1;?>
	<div class="msec_1 clearfix">
		<div class="container2">
			<ul class="mix_list clearfix">
				<?php foreach ($sub_cat as $info) { ?>
				<li class="tab-link filter_cat_trigger <?= ($x==1)?'current':''; ?>" data-tab="tab-<?= $x; ?>" data-tri="<?= $info['id']; ?>">
					<div class="proImg prodimg">
						<img src="<?= base_url('uploads/images/'.$info['image']); ?>" alt="" />
					</div>
					<h3><span class="mix_name"><?= @$info['name']; ?></span></h3>
				</li>
				<?php $x++; } ?>
			</ul>
		</div>
	</div>
	<?php } ?> 

<div class="serach_listing tab-content">
</div>	
<span class="search_div"></span>
<?php if(!empty($sub_cat)){ $x=1;
				foreach($sub_cat as $info){?>
	<div id="tab-<?= $x; ?>" class="tab-content msec_2 clearfix <?= ($x==1?'current':'');?>">
		<div class="container2">
			<h2><?= $info['name']; ?></h2>
			<?php 
				$product_list=$this->FunctionModel->Select_Fields('id,slug,name,image,price,old_price,outofstock,list_description','vidiem_products',array('sub_cat_id'=>$info['id'],'status'=>1),'order_no','ASC');
				if(!empty($product_list)){ ?>
			<div class="gridListBtn">
				<div class="shortBy">
					<select class="shotOp cat_sort_trigger">
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
				<?php foreach ($product_list as $data) { ?>
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
							<div class="offerdis">
								<h4 class="newpri"><i class="fa fa-inr"></i> <?= @number_format($data['price']); ?>/-</h4>
							<?php if($data['old_price']!=0){ ?>
							<h5 class="oldpri"> Rs: <?= @number_format($data['old_price']); ?>/-</h5>
							<?php } ?>
							</div>
							<div class="listConSet">
								<?= $data['list_description']; ?>	
						   </div>
						</div>
						<div class="mix_det_rt">
							<?php if($data['outofstock']==0){ ?>
								<a class="mix_det_rt_add btn add_to_cart" href="javascript:void(0);" data-id="<?= @$data['id'];?>">Add to cart</a>
							<?php }else{ ?>
                                 <a class="mix_det_rt_add btn" href="<?= base_url('contact-us'); ?>">Out of Stock</a>
							<?php } ?>
							<a class="mix_det_rt_add2 btn add_to_compare" href="#comProList" data-id="<?= @$data['id']?>">Add to compare</a>
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
	<?php $x++; } } ?>
</div>
<?php //require_once('container/top_seller.php'); ?>
</div>
<?php
$cat_content=$this->FunctionModel->Select_Field('content','vidiem_category',array('slug'=>$cat['slug']));
?>
<section class="secoContBlock clearfix">
    <div class="container clearfix">
        <div class="condesSEO clearfix">
            <?=$cat_content; ?>
        </div>
    </div>
</section>




<?php require_once('container/footer.php'); ?>