<?php include('container/header.php'); ?>
<script type="text/javascript">
    fbq('track', 'ViewProduct');
</script>
<div class="bgPro proDetaPage clearfix">
	<div class="proDetails clearfix">
		<ul class="proImgDet clearfix">
			<li>
				<section id="magnific">
				    <div class="row">
				      <div class="large-5 column">
				        <div class="xzoom-container">
				          <img class="xzoom5" id="xzoom-magnific" src="<?= base_url('uploads/images/'.$product['image']); ?>" xoriginal="<?= base_url('uploads/images/'.$product['image']); ?>" />
				          <div class="xzoom-thumbs">
				          	<a class="inNextProImg" href="<?= base_url('uploads/images/'.$product['image']); ?>">
				              <img class="xzoom-gallery5" src="<?= base_url('uploads/images/'.$product['image']); ?>"  xpreview="<?= base_url('uploads/images/'.$product['image']); ?>" >
				            </a>
				            <?php if(!empty($product_img)){ 
				            		foreach ($product_img as $info) { ?>
				            <a class="inNextProImg" href="<?= base_url('uploads/images/'.$info['image']); ?>">
				              <img class="xzoom-gallery5" src="<?= base_url('uploads/images/'.$info['image']); ?>"  xpreview="<?= base_url('uploads/images/'.$info['image']); ?>" >
				            </a>
				        <?php } } ?>
				          </div>
				        </div>        
				      </div>
				    </div>
				</section> 
			</li>
			<li class="prodeCon clearfix">
				<div class="conRightProDetails">
					<h3 class="proDeName"><?= @$product['name']; ?></h3>
					<?= @$product['short_description']; ?>
					<div class="priceDePro"> 
						<p>Model No : <?= @$product['modal_no']; ?></p>
						<div class="offerdisleft">
							<h4 class="newpri"><i class="fa fa-inr"></i> <?= @number_format($product['price']); ?>/-</h4>
							<?php if(!empty($product['old_price'])){ ?>
							<h5 class="oldpri"> <i class="fa fa-inr"></i> <?= @number_format($product['old_price']); ?>/-</h5>
							<?php } ?>
						</div>
						
						<?php 
						$this->db->select('MAX(rating) as rating');
						 $this->db->group_by('parent_id');
        				 $reviews_product=$this->db->get_where('vidiem_products_reviews',array('parent_id'=>$product['id'],'rating !='=>0,'status' =>1));

						//print_r($reviews_product);exit;
						if(!empty($reviews_product)){
							foreach($reviews_product->result_array() as $info){?>
						<div class="ratignOFUserStar clearfix">
							    <i class="<?php if ($info['rating'] >= 1) {
				                    echo 'fa fa-star';
				                }else{ echo 'fa fa-star-o';} ?>" data-rating="1"></i>
				                <i class="<?php if ($info['rating'] >= 2) {
				                    echo 'fa fa-star';
				                }else{ echo 'fa fa-star-o';} ?>" data-rating="2"></i>
				                <i class="<?php if ($info['rating'] >= 3) {
				                    echo 'fa fa-star';
				                }else{ echo 'fa fa-star-o';} ?>" data-rating="3"></i>
				                <i class="<?php if ($info['rating'] >= 4) {
				                    echo 'fa fa-star';
				                }else{ echo 'fa fa-star-o';} ?>" data-rating="4"></i>
				                <i class="<?php if ($info['rating'] >= 5) {
				                    echo 'fa fa-star';
				                }else{ echo 'fa fa-star-o';} ?>" data-rating="5"></i>
                            <input type="hidden" name="whatever1" class="rating-value" value="0">
						</div>
					<?php } } ?>
					</div>
					<div class="prowar">
						<?= @$product['warranty']; ?>
					</div>
					
					<div class="proOrderBtn clearfix">
						<?php if($product['status']==1 && $product['outofstock']==0){ ?>
						<a href="<?= base_url('buy-now/'.$product['id']); ?>" class="btn buy_now_btn">Buy Now</a>
						<?php } ?>
						<?php if(!empty($product['manual'])){?>
							<a href="<?= base_url('uploads/manual/'.$product['manual']); ?>" class="btn commanBtn">Manual</a>
						<?php } ?>
						<?php if($product['status']==1){ ?>
						<a href="javascript:void(0);" class="btn commanBtn add_to_compare" data-id="<?= @$product['id']?>">Compare</a>
						<?php if($product['outofstock']==0){ ?>
								<a href="javascript:void(0);" class="btn add_to_cart" data-id="<?= @$product['id'];?>">Add To Cart</a>
							<?php }else{ ?>
                                 <a class="btn" href="<?= base_url('contact-us'); ?>">Out of Stock</a>
							<?php } ?>
						
						<?php } ?>
					</div>
					<div class="pincode">
						<?php if($product['status']==1){ ?>
							<form method="POST" action="" class="product_availability">
						<label>
							<i class="fa fa-map-marker"></i>
							<input type="number" name="location" placeholder="Enter delivery pincode" class="pin_code">
						</label><br>
						<div class="availabile_status"></div>
							</form>
						<?php } ?>	
					</div>
				</div>
			</li>
		</ul>
		
		<ul class="keySpec clearfix">
			<li class="tab-link current" data-tab="tab-1">
				<a href="#featureMenu">Features</a>
			</li>
			<li class="tab-link" data-tab="tab-2">
				<a href="#featureMenu">Specifications</a>
			</li>
			<li class="tab-link" data-tab="tab-3">
				<a href="#featureMenu">Reviews &amp; Rating</a>
			</li>
		</ul>

		<div class="fullTbSep clearfix" id="featureMenu">

			<div class="keyFeatures clearfix tab-content current" id="tab-1">
				<h3 class="keyTi">Key Features</h3>
				<ul class="keyTop clearfix">
					<li class="feleftImg">
						<?php if(!empty($product['key_feature_image'])){ ?>
						<div class="featuresImg">
							<a class="fancybox" href="<?= base_url('uploads/images/'.$product['key_feature_image']); ?>" data-fancybox-group="gallery">
								<img src="<?= base_url('uploads/images/'.$product['key_feature_image']); ?>" alt="" />
							</a>
						</div>
						<?php } ?>
					</li>
					<li class="feRightCon">
						<?= @$product['key_feature']; ?>
					</li>
				</ul>
				<?php if(!empty($keynotes)){ ?>
				<ul class="motorSpec clearfix">
					<?php foreach ($keynotes as $info) { ?>
					<li class="clearfix">
						<div class="detailMoSec clearfix">
							<h4 class="motSpecHead"><?php if(!empty($info['image'])){?> <img src="<?= base_url('assets/front-end/images/'.$info['image']); ?>"><?php } ?><?= @$info['name']; ?></h4>
							<p class="detSpecMot">
								<?= @$info['content']; ?>
							</p>
						</div>
					</li>
					<?php } ?>
				</ul>
				<?php } ?>
				<?php if(!empty($keyfeautre)){ ?>
				<ul class="jarImgSet clearfix">
					<?php foreach ($keyfeautre as $info) { ?>
					<li class="clearfix">
						<h4><?= $info['name'];?></h4>
						<div class="clearfix conTfeature">
							<div class="jarImgLeft">
								<a class="fancybox" href="<?= base_url('uploads/images/'.$info['image']); ?>" data-fancybox-group="gallery">
									<img src="<?= base_url('uploads/images/'.$info['image']); ?>" alt="" />
								</a>
							</div>
							<div class="feInListFor">
								<?= $info['content'];?>
							</div>
						</div>
					</li>
				<?php } ?>
				</ul>
			<?php } ?>
				<p style="font-size: 14px;">*In pursuance with our policy of continues product improvement, specifications are subject to change without notice.</p>
			</div>

			<div class="prospecSet clearfix tab-content specTable" id="tab-2">
				<h3 class="keyTi">Product Specification</h3>
					<?= $product['description'];?>
			</div>


			<div class="keyFeatures reviewRatingS tab-content clearfix" id="tab-3">
				<h3 class="keyTi">Reviews &amp; Rating</h3>
				
				<div class="reviewFullSet clearfix">
					<!-- If condistion review-->
					<?php 
					$reviews=$this->FunctionModel->Select('vidiem_products_reviews',array('parent_id'=>$product['id'],'rating !='=>0,'status' =>1));
					if(!empty($reviews)){?>
					<div class="reviewOutPut clearfix">
						<?php 
						foreach ($reviews as $info) {
						?>
						<div class="userRatingS clearfix">
							<h5 class="RateUserName"><?= @$info['name']; ?></h5>
							<div class="ratignOFUserStar clearfix">
								<i class="<?php if ($info['rating'] >= 1) {
				                    echo 'fa fa-star';
				                }else{ echo 'fa fa-star-o';} ?>" data-rating="1"></i>
				                <i class="<?php if ($info['rating'] >= 2) {
				                    echo 'fa fa-star';
				                }else{ echo 'fa fa-star-o';} ?>" data-rating="2"></i>
				                <i class="<?php if ($info['rating'] >= 3) {
				                    echo 'fa fa-star';
				                }else{ echo 'fa fa-star-o';} ?>" data-rating="3"></i>
				                <i class="<?php if ($info['rating'] >= 4) {
				                    echo 'fa fa-star';
				                }else{ echo 'fa fa-star-o';} ?>" data-rating="4"></i>
				                <i class="<?php if ($info['rating'] >= 5) {
				                    echo 'fa fa-star';
				                }else{ echo 'fa fa-star-o';} ?>" data-rating="5"></i>
                

	                            <input type="hidden" name="whatever1" class="rating-value" value="0">
							</div>
							<p class="clientCmd">
								<?= @$info['content']; ?>
							</p>
						</div>
					    <?php } ?>

						
					</div>
				 <?php } else { ?>
					
					<!-- Else condistion review-->
					<div class="reviewOutPut clearfix">
						<p class="noReview">No reviews of this product</p>
					</div>
				<?php } ?>
				</div>

				<div class="writeUrReviews clearfix">
					<h5 class="writeReTitle">Write your Review:</h5>
					<div class="rateAndWrite clearfix">
						<form action="" method="POST">
							<div class="ratePro">
								<p>Rate this Product</p>
								<div class="ratignOFUserStar star-rating clearfix">
									<i class="fa fa-star-o" data-rating="1"></i>
		                            <i class="fa fa-star-o" data-rating="2"></i>
		                            <i class="fa fa-star-o" data-rating="3"></i>
		                            <i class="fa fa-star-o" data-rating="4"></i>
		                            <i class="fa fa-star-o" data-rating="5"></i>
		                            <input type="hidden" name="whatever1" class="rating-value input_fb_rating" value="0">
								</div>
							</div>
							<div class="nameDet">
								<label>
									<input type="hidden" class="input_fb_id" value="<?= @$product['id']; ?>">
									<input type="text" name="name" placeholder="Name" class="input_fb_name">
								</label>
								<label>
									<textarea name="review" placeholder="Write your Review anad Camments" class="input_fb_comment"></textarea>
								</label>
							</div>
							<!--<button class="reviewSbmitBtn btn feedback_trigger">Submit</button>-->
							<?php  if(empty($this->session->userdata('client_id'))){?>
							<a class="reviewSbmitBtn btn signIn" href="<?= base_url('sign-in'); ?>">Submit</a> 
							<?php }?>
                            <?php if(!empty($this->session->userdata('client_id'))){?>
                            <button class="reviewSbmitBtn btn feedback_trigger">Submit</button>
                            <?php } ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="relatedPro clearfix">
		<div class="relprohol clearfix">
			<h3>Related Products</h3>
			<?php if(!empty($rel_products)){ ?>
			<ul class="clearfix reProRi">
			 <?php foreach ($rel_products as $info) { ?>
				<li class="clearfix">
					<a href="<?= base_url('product/'.$info['slug']); ?>" class="clearfix">
						<div class="relaProImg">
							<img src="<?= base_url('uploads/images/'.$info['image']); ?>" alt="" />
						</div>
						<div class="reProCon">
							<p><?= $info['name']; ?></p>
						</div>
					</a>
				</li>
			<?php } ?>
				<a href="<?= base_url('category/'.$cat_slug); ?>" class="reProView">View All<i class="fa fa-long-arrow-right"></i></a>
			</ul>
		<?php } ?>
		</div>
	</div>

</div>
<style type="text/css">
	li.error,p.error{color:#333!important}
input.error{background-color:#fff!important;color:#333!important; border: solid 1px red !important;}
select.error{background-color:#fff!important;color:#333!important; border: solid 1px red !important;}
textarea.error{background-color:#fff!important;color:#333!important; border: solid 1px red !important;}
input.error::-webkit-input-placeholder{color:#777!important;opacity:1}
textarea.error::-webkit-input-placeholder{color:#777!important;opacity:1}
</style> 
<script type="text/javascript">
var buyNowButton = document.querySelector('a.buy_now_btn');
buyNowButton.addEventListener("click", () => {
    fbq('track', 'BuyNowButton');
});
</script>
<?php require_once('container/footer.php')?>