<?php $menu_id=12; ?>
<?php include('container/header.php'); ?>

<section class="ban-next">
	<div class="container clearfix">
		<h2>Offers</h2>
	</div>
</section>
 
<div class="bgPro contactUs useMan clearfix">
	<div class="container">
		<div class="userManual">
			<h3><?= @$name;?></h3>
			<div class="offerSet clearfix">
				<?php if(!empty($products)){ ?>
				<ul class="mix_list2 OffProSet clearfix">
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
							<a class="mix_det_rt_add btn add_to_cart" href="javascript:void(0);" data-id="<?= @$data['id'];?>">Add to cart</a>
							<a class="mix_det_rt_add2 btn add_to_compare" href="#comProList" data-id="<?= @$data['id']?>">Add to compare</a>
						</div>
					</div>
				</li>
					<?php } ?>
				</ul>
				<?php } else{ ?>
				<p>No Data Available</p>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php require_once('container/footer.php'); ?>