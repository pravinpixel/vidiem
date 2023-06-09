<?php $menu_id=12; ?>
<?php include('container/header.php'); ?>

<section class="ban-next inner-page-bg">
    <div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-6">
				<!-- <h1 class="text-red" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Product Registration</h1> -->
				<h2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Vidiem Offers</h2>
				<!-- <h4 class="pb-5 mb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Please fill the form below</h4> -->
			</div>
			<div class="col-sm-12 col-md-6">
				<img src="<?= base_url(); ?>assets/front-end/images/product-registration.svg" alt="" class="img-fluid d-none d-md-block"  data-aos="fade-left" data-aos-delay="50" data-aos-duration="1000"/>
				<div class="text-right overlay-title pb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Vidiem Offers</div>
			</div>
		</div>
	</div>
 
<div class="bgPro contactUs useMan clearfix">
	<div class="container bg-white p-5 shadow1">
		<div class="userManual row">
			<div class="offerSet clearfix col">
				<?php if(!empty($offers)){ ?>
				<ul class="mix_list2 OffProSet clearfix">
					<?php foreach ($offers as $data) { ?>
					<li class="clearfix animated zoomIn">
						<div class="proImg">
							<img src="<?= base_url('uploads/images/'.$data['image']); ?>" alt="" />
							<h4 class="text-dark mt-4 mb-4"><?= $data['name']; ?></h4>
							<a href="<?= base_url('offers/'.$data['slug']); ?>" class="QVpopupa red-btn small">View</a>
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
</section>
<style>
	ul.OffProSet{margin:0px; padding:0px; float:left; width:100%;}
	ul.OffProSet li{width:48%; float:left; list-style:none; padding:10px; margin:0px 1% 50px 1%; border:1px solid rgba(0,0,0,0.1);}
	ul.OffProSet li img{width:100%;}
	ul.OffProSet li:before{display:none;}
	@media (max-width:960px){ul.OffProSet li{width:100%;  margin:0px 0px 30px 0px;}}
</style>
<?php require_once('container/footer.php'); ?>