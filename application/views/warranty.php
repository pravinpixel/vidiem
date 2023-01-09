<?php include('container/header.php'); ?>
<div class="inner-page-bg">
<section class="service-cta-bg pb-5">
	<div class="container p-xl-0">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-8">
				<h1 class="text-red" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Warranty</h1>
				<h2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Believes In Helping Its Customers As Far As Possible</h2>
			</div>
			<div class="col-sm-12 col-md-12 col-lg-4">
				<img src="<?= base_url(); ?>assets/front-end/images/terms-conditions.svg" alt="" class="img-fluid d-none d-md-block"  data-aos="fade-left" data-aos-delay="50" data-aos-duration="1000"/>
				<div class="overlay-title" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Warranty</div>
			</div>
		</div>
	</div>
</section>

<section class="service-section pt-0">
	<div class="container service-cta p-0">		
		<div class="row no-gutters">
			<div class="col-sm-12 col-md-3 col-lg-3 service-cta-light-bg">
				<ul class="service-tab d-none d-md-block">
					<li><a href="<?= base_url(); ?>terms-conditions">Terms &amp; Condition</a></li>
					<li class="active"><a href="<?= base_url(); ?>warranty">Warranty Terms</a></li>
					<li><a href="<?= base_url(); ?>shipping-delivery">Shipping &amp; Delivery</a></li>
					<li><a href="<?= base_url(); ?>return-refund-policy">Return &amp; Refund Policy</a></li>
					<li><a href="<?= base_url(); ?>cancellation-policy">Cancellation Policy</a></li>
					<li><a href="<?= base_url(); ?>privacy-policy">Privacy Policy</a></li>
				</ul>
				<div class="btn-group d-block d-md-none pl-3 pr-4 mt-3 mb-3">
				  <button type="button" class="btn btn-danger dropdown-toggle w-100" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					More
				  </button>
				  <div class="dropdown-menu mt-0 mobile-dropdown">
					<a class="dropdown-item" href="<?= base_url(); ?>terms-conditions">Terms &amp; Condition</a>
					<a class="dropdown-item" href="<?= base_url(); ?>warranty">Warranty Terms</a>
					<a class="dropdown-item" href="<?= base_url(); ?>shipping-delivery">Shipping &amp; Delivery</a>
					<a class="dropdown-item" href="<?= base_url(); ?>return-refund-policy">Return &amp; Refund Policy</a>
					<a class="dropdown-item" href="<?= base_url(); ?>cancellation-policy">Cancellation Policy</a>
				  </div>
				</div>
			</div>
			<div class="col-sm-12 col-md-9 col-lg-9 pt-5 px-2 p-xl-5 service-tabdesc">
				<div class="bgPro contactUs useMan clearfix">
						<div class="userManual">
							<h3>Warranty Terms</h3>
							<?php if(!empty($warranty)){ $x=1;
								foreach($warranty as $info){?>
								<h4>Category : <?= $info['title']; ?></h4>
							<ul class="clearfix warrantySet">
								
									<?= $info['content']; ?>
								
								
							</ul>
							<?php $x++; } } ?>
							
						</div>
				</div>
			</div>
		</div>
	</div>
</section>
</div>


<?php require_once('container/footer.php')?>