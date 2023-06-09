<?php include('container/header.php'); ?>
<section class="ban-next inner-page-bg">
	
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-8">
				<h1 class="text-red" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Complaint Registration</h1>
				<h2 class="pb-5 mb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Register Your Complaint</h2>
			</div>
			<div class="col-sm-12 col-md-4">
				<img src="<?= base_url(); ?>assets/front-end/images/product-registration.svg" alt="" class="img-fluid d-none d-md-block"  data-aos="fade-left" data-aos-delay="50" data-aos-duration="1000"/>
				<div class="text-right overlay-title pb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Complaint</div>
			</div>
		</div>
	</div>	
	
<div class="bgPro contactUs">
	<div class="container bg-white p-5 shadow1">
		<div class="clearfix condetails regForm row">
			<div class="col-sm-12 col-md-8 col-lg-8 contLeft regLeft">
				<h3 class="text-red">Registration Form</h3>
				 <?php if($this->session->flashdata('class')){?>
 						     <div class="alert <?php echo $this->session->flashdata('class'); ?>">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                 <?php echo $this->session->flashdata('success'); ?>
                                 <?php echo $this->session->flashdata('error'); ?>
                             </div>
							<?php } ?>
				<form class="enqureyForm registerPro" method="post" enctype="multipart/form-data" action="<?= base_url('complaint-registration'); ?>">
					<div class="enForm row">
						 <div class="col-sm-12 col-md-6 pb-3 mt-3">
							 <select class="selectpicker js-states form-control complaint_category" data-live-search="true" name="category" id="category">
		                        <option value="">Select Category</option>
		                        <?php if(!empty($category)){ 
		                          foreach($category as $info){ ?>
		                          <option value="<?= $info['id']; ?>" <?= set_select('category',$info['id']);?>><?= $info['name']; ?></option>
		                        <?php } } ?>  
	                        </select>
							<?= form_error('product'); ?>
						</div>
						<div class="col-sm-12 col-md-6 pb-3 mt-3">
							 <select class="selectpicker js-states form-control complaint_pro_list" data-live-search="true" name="product" id="product">
		                        <option value="">Select Product</option>
		                        <?php if(!empty($products)){ 
		                          foreach($products as $info){ ?>
		                          <option value="<?= $info['id']; ?>" <?= set_select('product',$info['id']);?>><?= $info['name']; ?></option>
		                        <?php } } ?>  
	                        </select>
						 	<?= form_error('product'); ?>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="md-form">
							<input type="text" class="form-control" name="serialnumer" value="<?= set_value('serialnumer'); ?>"/>
							<label for="">Serial Number</label>
							<?= form_error('serialnumer'); ?>
							<div class="d-block d-md-none">
								<small><strong><a href="#serial-number" class="text-red">Where can I find the product serial number?</a></strong></small>
							</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="md-form">
							<input type="text" class="datepicker form-control" id="J-demo-01" name="jdate" value="<?= set_value('jdate'); ?>">
							<label for="">Date of Purchase</label>
							<script type="text/javascript">
					            $('#J-demo-01').dateTimePicker();
					        </script>
							<?= form_error('jdate'); ?>
							</div>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="md-form">
							<input type="text" class="form-control" name="dealername" value="<?= set_value('dealername'); ?>"/>
							<label for="">Purchased from : <small>(Dealer Name/ Online Website)</small></label>
							<?= form_error('dealername'); ?>
							</div>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="md-form">
							<input type="text" class="form-control" name="remarks" value="<?= set_value('remarks'); ?>"/>
							<label for="">Complaint Remarks</label>
							<?= form_error('remarks'); ?>
							</div>
						</div>
						<div class="col-sm-12 col-md-12 mt-5">
							<h3 class="text-red">Personal Details</h3>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="md-form">
							<input type="text" class="form-control" name="name" value="<?= set_value('name'); ?>"/>
							<label for="">Name <strong class="text-red">*</strong></label>
						 	<?= form_error('name'); ?>
							</div>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="md-form">
							<input type="text" class="form-control" name="email" value="<?= set_value('email'); ?>" />
							<label for="">Email</label>
						 	<?= form_error('email'); ?>
							</div>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="md-form">
							<input type="text" class="form-control"  minlength="10"   maxlength="10" name="mobile" value="<?= set_value('mobile'); ?>"/>
							<label for="">Mobile <strong class="text-red">*</strong></label>
						 	<?= form_error('mobile'); ?>
							</div>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="md-form">
							<input type="text" class="form-control"  minlength="10"   maxlength="10" name="mobile2" value="<?= set_value('mobile'); ?>"/>
							<label for="">Alternative Mobile</label>
							 <?= form_error('mobile'); ?>
							 </div>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="md-form">
							<textarea class="md-textarea form-control" name="address"><?= set_value('address'); ?></textarea>
							<label for="">Address <strong class="text-red">*</strong></label>
						 	<?= form_error('address'); ?>
							</div>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="md-form">
							<input type="text" class="form-control" name="city" value="<?= set_value('city'); ?>"/>
							<label for="">City <strong class="text-red">*</strong></label>
						 	<?= form_error('city'); ?>
							</div>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="md-form">
							 <select class="selectpicker form-control" data-live-search="true" name="state" id="state">
                                <option value="">Select State</option>
                                    <?php if(!empty($city)){
                                   		foreach ($city as $info) { ?>
									<option value="<?= $info;?>" <?= set_select('state',$info);?>><?= $info;?></option> 
									<?php } } ?>
                             </select>
							<?= form_error('state'); ?>
							</div>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="md-form">
							<input type="text" class="form-control" name="pincode" value="<?= set_value('pincode'); ?>">
							<label for="">Pincode <strong class="text-red">*</strong></label>
						 	<?= form_error('pincode'); ?>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 mb-4">
							<p>Validation code:</p>
                              <div class="g-recaptcha" data-sitekey="6Letm3cUAAAAAM6uqYzzeHWdADiNGLaGztKkAJma"></div>				
                              	<?= form_error('g-recaptcha-response'); ?>
						</div>
						<div class="col-sm-12 col-md-12">
							<button class="red-btn small">Submit</button>
						</div>
					</div>
				</form>
			</div>

			<div class="col-sm-12 col-md-4 col-lg-4 regRight" id="serial-number">
				<div class="conTitleSet">
					<h3 class="text-dark mb-3">Where can I find the product serial number?</h3>
					<p class="findRegSer">
						Register your Vidiem product to enable us to server you better. Refer the below image to find your product's serial number.
					</p>
					<img src="<?= base_url();?>assets/front-end/images/bill.jpg" alt="" class="img-fluid" />
				</div> 
			</div>
		</div>
	</div>
</div>
</section>
<style>
	li p i{color:red;}
</style>
 
     <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });
    </script>


<script src='https://www.google.com/recaptcha/api.js'></script>
<?php require_once('container/footer.php')?>