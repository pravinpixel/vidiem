<?php include('container/header.php'); ?>

<section class="inner-page-bg pb-0">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-8">
				<h1 class="text-red" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Quick Info</h1>
				<h2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Our professional team<br/>is here for you</h2>
				<p data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Our professional team is here for you. Please don’t hesitate to contact us if you have any queries, problems or suggestions. We would love to hear from you.</p>
				<p data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Kindly fill in the form on the right to send us a message. You can also meet with us in person, at the address below, after booking an appointment using the contact number mentioned below.</p>
			</div>
			<div class="col-sm-12 col-md-4">
				<img src="<?= base_url(); ?>assets/front-end/images/contact-us.svg" alt="" class="img-fluid mb-5 d-none d-md-block"  data-aos="fade-left" data-aos-delay="50" data-aos-duration="1000"/>
				<div class="text-right overlay-title pb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Contact</div>
			</div>
		</div>
</div>
<div class="bgPro pb-5 contactUs clearfix" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
	<div class="container bg-white shadow1 p-0">
		<div class="row no-gutters">

			<div class="col-sm-12 col-md-12 col-lg-8">
				<div class="conTitleSet pt-4 pb-5 pl-5 pr-5 mr-1">
					<h2>Contact us</h2>
					<h4>Send Us A Message</h4>
				<form class="enqureyForm mt-5" method="post" enctype="multipart/form-data">
					<div class="enForm row">
						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="md-form">
							<input type="text" class="form-control" name="name" id="name" value="<?= set_value('name'); ?>" />
							<label for="">Name</label>
							<?= form_error('name'); ?>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="md-form">
							<input type="text" class="form-control" name="location" id="location" value="<?= set_value('location'); ?>"/>
							<label for="">Location <small>(City / Town / District)</small></label>
						  <?= form_error('location'); ?>
						  </div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="md-form">
							<input type="number" class="form-control" name="phone" id="phone" value="<?= set_value('phone'); ?>"/>
							<label for="">Phone</label>
							<?= form_error('phone'); ?>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="md-form">
							<input type="email" class="form-control" name="emailid" id="emailid" value="<?= set_value('emailid'); ?>"/>
							<label for="">Email</label>
							<?= form_error('emailid'); ?>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6 pt-4 mt-4">
						<select class="selectpicker js-states form-control" data-live-search="true" name="enquire" id="menucategory">
                                <option value="">Enquire For</option>
                                <option  <?php if(  set_value('enquire')=='Feedback'){ echo "Selected"; } ?> value="Feedback">Feedback</option>
                                <option <?php if(  set_value('enquire')=='Distribution'){ echo "Selected"; } ?> value="Distribution">Distribution</option>
                                <option <?php if(  set_value('enquire')=='Dealership'){ echo "Selected"; } ?> value="Dealership">Dealership</option>
                                <option <?php if(  set_value('enquire')=='Service Center'){ echo "Selected"; } ?> value="Service Center">Service Center</option>
                                <option <?php if(  set_value('enquire')=='Career'){ echo "Selected"; } ?> value="Career">Career</option>
                                <option <?php if(  set_value('enquire')=='Other'){ echo "Selected"; } ?> value="Other">Other</option>

                            </select>
						<?= form_error('enquire'); ?>

						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="md-form">
							<textarea class="md-textarea form-control" name="message" id="message"><?= set_value('message'); ?></textarea>
							<label for="">Message</label>
							<?= form_error('message'); ?>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<p>Validation code:</p>
                           <div class="g-recaptcha" data-sitekey="6Letm3cUAAAAAM6uqYzzeHWdADiNGLaGztKkAJma"></div>				
                              	<?= form_error('g-recaptcha-response'); ?>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-12 pt-4">
							<button class="red-btn small">Submit</button>
						</div>
					</div>
				</form>
				
				</div>
			</div>
			
			<div class="col-sm-12 col-md-12 col-lg-4 gray-bg">
				<div class="conTitleSet p-4">
					<h2>Quick Info</h2>
					<h4>Where you can find us</h4>
				</div>
					<div class="addressVi pb-5">
						<h4 class="text-center"><i class="fa fa-home"></i> Address:</h4>
						<p class="text-center">
							No:3/140,Old Mahabalipuram Road,<br>
							Oggiam Thoraipakkam,<br>
							Chennai - 600097, Tamilnadu, INDIA
						</p>
					</div>

					<div class="addressVi phoneNoFre pb-5">
						<h4 class="text-center"><i class="fa fa-envelope"></i> Mail:</h4>
						<h3><a class="text-center d-block" href="mailto:care@vidiem.in">
							care@vidiem.in
						</a></h3>
					</div>

					<div class="addressVi phoneNoFre pb-5">
						<h4 class="text-center"><i class="fa fa-phone"></i> Call Us</h4>
						<h3 class="text-center"><a href="tel:044-6635 6635" >044-6635 6635</a></br>
						<a href="tel:7711006635" >77110 06635</a></h3>
					</div>
			</div>
		</div>
	</div>
</div>
</section>
<script src='https://www.google.com/recaptcha/api.js'></script>

<?php require_once('container/footer.php')?>