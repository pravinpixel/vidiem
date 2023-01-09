<?php include('container/header.php'); ?>
<section class="ban-next inner-page-bg">
    <div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-6">
				<!-- <h1 class="text-red" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Product Registration</h1> -->
				<h2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Combo Offers</h2>
				<h4 class="pb-5 mb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Please fill the form below</h4>
			</div>
			<div class="col-sm-12 col-md-6">
				<img src="<?= base_url(); ?>assets/front-end/images/product-registration.svg" alt="" class="img-fluid d-none d-md-block"  data-aos="fade-left" data-aos-delay="50" data-aos-duration="1000"/>
				<div class="text-right overlay-title pb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Combo Offers</div>
			</div>
		</div>
	</div>
<div class="bgPro SignUpPage clearfix">
    <div class="container bg-white p-5 shadow1">
        <form class="signInput" method="post" action="">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <h3 class="text-red">Combo Offers</h3>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="md-form">
					<input class="form-control" type="text" value="<?= set_value('name'); ?>" name="name">
					<label for="">Your Name</label>
					<?= form_error('name'); ?>
				</div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="md-form">
					<input class="form-control" type="email" value="<?= set_value('email'); ?>" name="email">
					<label for="">Mail Address</label>
					<?= form_error('email'); ?>
				</div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="md-form">
					<input class="form-control" type="number" value="<?= set_value('mobile'); ?>" name="mobile">
					<label for="">Mobile Number</label>
					<?= form_error('mobile'); ?>
				</div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="md-form">
					<input class="form-control" type="text" value="<?= set_value('city'); ?>" name="city">
					<label for="">City</label>
					<?= form_error('city'); ?>
				</div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 text-right mt-4">
                <button class="red-btn small">Submit</button>
            </div>
        </div>
        </form>
</div>
</section>
<?php require_once('container/footer.php')?>