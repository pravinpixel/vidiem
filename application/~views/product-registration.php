<?php include('container/header.php'); ?>

<section class="ban-next inner-page-bg">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-8">
				<h1 class="text-red" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Product Registration</h1>
				<h2 data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Register Your Products</h2>
				<h4 class="pb-5 mb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">within 30 days from the date of purchase.</h4>
			</div>
			<div class="col-sm-12 col-md-4">
				<img src="<?= base_url(); ?>assets/front-end/images/product-registration.svg" alt="" class="img-fluid d-none d-md-block"  data-aos="fade-left" data-aos-delay="50" data-aos-duration="1000"/>
				<div class="text-right overlay-title pb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Registration</div>
			</div>
		</div>
	</div>
<div class="bgPro contactUs clearfix">
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
				<form class="enqureyForm registerPro" method="post" enctype="multipart/form-data" action="<?= base_url('product-registration'); ?>">
					<div class="row enForm clearfix">
					<!--	<div class="col-sm-12 col-md-6 pt-4 mt-3">
						 <select class="selectpicker js-states form-control" data-live-search="true" name="menucategory" id="menucategory">
                                <option value="">Select Product</option>
                               <?php if(!empty($category)){ 
                          foreach($category as $info){ ?>
                          <option value="<?= $info['name']; ?>" <?= set_select('menucategory',$info['name']);?>><?= $info['name']; ?></option>
                        <?php } } ?>  

                            </select>
							
						 <?= form_error('menucategory'); ?>
						</div>  -->
						
						<div class="col-sm-12 col-md-6 pb-2 mt-3 registry">
							 <select class="selectpicker js-states form-control complaint_category" data-live-search="true" name="category" id="category">
		                        <option value="">Select Category</option>
		                        <?php if(!empty($category)){ 
		                          foreach($category as $info){ ?>
		                          <option value="<?= $info['id']; ?>" <?= set_select('category',$info['id']);?>><?= $info['name']; ?></option>
		                        <?php } } ?>  
	                        </select>
						
						</div>
						<div class="col-sm-12 col-md-6 pb-2 mt-3 registry">
							 <select class="selectpicker js-states form-control complaint_pro_list" data-live-search="true" name="product" id="product">
		                        <option value="">Select Product</option>
		                        <?php if(!empty($products)){ 
		                          foreach($products as $info){ ?>
		                          <option value="<?= $info['id']; ?>" <?= set_select('product',$info['id']);?>><?= $info['name']; ?></option>
		                        <?php } } ?>  
	                        </select>
						 	<?= form_error('product'); ?>
						</div>
						
						<div class="col-sm-12 col-md-6 pb-2 mt-3 registry">
							<div class="md-form">
							<input type="text" class="form-control" name="serialnumer" id="serialnumer" value="<?= set_value('serialnumer'); ?>"/>
							<label for="">Serial Number</label>
							<?= form_error('serialnumer'); ?>							
							<div class="d-block d-md-none">
								<small><strong><a href="#serial-number" class="text-red">Where can I find the product serial number?</a></strong></small>
							</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 pb-2 mt-3 registry">
							<div class="md-form">
							<input type="text" class="form-control datepicker" id="J-demo-01" name="jdate" value="<?= set_value('jdate'); ?>">
							<label for="">Date of Purchase</label>
							
							<?= form_error('jdate'); ?>
							</div>
						</div>
						
						<div class="col-sm-12 col-md-6 pb-2 mt-3 registry">
							<div class="md-form">
														
							 <select class="selectpicker js-states form-control js-example-basic-single" data-live-search="true" name="purchasefrom" id="registration-purchasefrom" onchange="fnpurchasefrom(this.value);">  
								<option value="">Select Purchased From</option>    		
								<option <?= set_select('purchasefrom',"Amazon");?> value="Amazon">Amazon</option>    								
								<option <?= set_select('purchasefrom',"Vidiem E-commerce");?> value="Vidiem E-commerce">Vidiem E-commerce</option>    
								<option <?= set_select('purchasefrom',"Retailer / Dealer");?>  value="Retailer / Dealer">Retailer / Dealer</option>    
								<option <?= set_select('purchasefrom',"Other Online Shop");?> value="Other Online Shop">Other Online Shop</option>    
							 </select>
							
							
							<?= form_error('purchasefrom'); ?>
							</div>
						</div>
						
						<div class="col-sm-12 col-md-6 pb-2 mt-3 registry">
							<div class="md-form">
							<input type="text" class="form-control" name="dealername" id="dealername" value="<?= set_value('dealername'); ?>"/>
							<label id="lbldealer" for="">Dealer Name : <small>(Dealer Name/Online Website)</small></label>
							<?= form_error('dealername'); ?>
							</div>
						</div>
						
						 
						 
						<div class="col-sm-12 col-md-12 pt-5">
							<h3 class="text-red">Personal Details</h3>
						</div>
						<div class="col-sm-12 col-md-6 mrMrs clearfix">
							<h6 class="mt-3 text-dark">Gender</h6>
							<div class="form-check form-check-inline">
							<input type="radio" name="gender" class="form-check-input" id="male" value="Male" <?= set_radio('gender','Male',true); ?>> 
							<label class="form-check-label text-dark" for="male"> Male</label>
							</div>
							<div class="form-check form-check-inline">
							<input type="radio" name="gender" id="female" value="Female" <?= set_radio('gender','Female');?>> 
							<label class="form-check-label text-dark" for="female"> Female</label>
							</div>
							
						</div>
						<?= form_error('gender'); ?>
						<div class="col-sm-12 col-md-6">
							<div class="md-form">
							<input type="text" class="form-control" name="name" id="name" value="<?= set_value('name'); ?>"/>
							<label for="">Name</label>
							<?= form_error('name'); ?>
							</div>
						</div>
						
						<div class="col-sm-12 col-md-6">
						<div class="md-form">
							<input type="text" name="age" class="form-control" id="age" value="<?= set_value('age'); ?>"/>
							<label for="">Age</label>
						 <?= form_error('age'); ?>
						 </div>
						</div>
						
						<div class="col-sm-12 col-md-6">
						<div class="md-form">
							<input type="text" class="form-control" name="email" id="email" value="<?= set_value('email'); ?>" />
							<label for="">Email</label>
						 <?= form_error('email'); ?>
						 </div>
						</div>
						<div class="col-sm-12 col-md-6">
						<div class="md-form">
							<input type="text" class="form-control" minlength="10"   maxlength="10" name="mobile" id="mobile" value="<?= set_value('mobile'); ?>"/>
							<label for="">Mobile</label>
						 <?= form_error('mobile'); ?>
						</div>
						</div>
						<div class="col-sm-12 col-md-6">
						<div class="md-form">
							<input type="text" class="form-control" name="occupation" id="occupation" value="<?= set_value('occupation'); ?>" />
							<label for="">Occupation</label>
						 <?= form_error('occupation'); ?>
						</div>
						</div>
						<div class="col-sm-12 col-md-6">
						<div class="md-form">
							<textarea name="address" class="md-textarea form-control" id="address"><?= set_value('address'); ?></textarea>
							<label for="">Address</label>
						 <?= form_error('address'); ?>
						</div>
						</div>
						<div class="col-sm-12 col-md-6 mt-2">
						<div class="md-form">
							<input type="text" class="form-control" name="city" id="city" value="<?= set_value('city'); ?>"/>
							<label for="">City</label>
						 <?= form_error('city'); ?>
						</div>
						</div>
						<div class="col-sm-12 col-md-6 pt-3 mt-4">
							 <select class="selectpicker js-states form-control" data-live-search="true" name="state" id="registration-state">
                                <option value="">Select State</option>
                                    <?php if(!empty($city)){
                                   		foreach ($city as $info) { ?>
									<option value="<?= $info;?>" <?= set_select('state',$info);?>><?= $info;?></option> 
									<?php } } ?>
                             </select>
							<?= form_error('state'); ?>
						</div>
						<div class="col-sm-12 col-md-6">
						<div class="md-form">
							<input type="text" class="form-control" name="pincode"   maxlenght="6" id="pincode" value="<?= set_value('pincode'); ?>">
							<label for="">Pincode</label>
						 <?= form_error('pincode'); ?>
						</div>
						</div>
						<!--<div class="col-sm-12 col-md-6">
							<p>Validation code:</p>
                              <div class="g-recaptcha" data-sitekey="6Letm3cUAAAAAM6uqYzzeHWdADiNGLaGztKkAJma"></div>				
                              	<?= form_error('g-recaptcha-response'); ?>
						</div>-->
						<div class="col-sm-12 col-md-12 pt-4">
						   <button class="red-btn small">Submit</button>
						</div>
					</div>
				</form>
			</div>

			<div class="col-sm-12 col-md-4 col-lg-4 regRight" id="serial-number">
				<div class="conTitleSet">
					<h3 class="text-dark mb-3">Where can I find the product serial number?</h3>
					<p class="findRegSer">
						Register your Vidiem product to enable us to serve you better. Refer the below image to find your product's serial number.
					</p>
					<img src="<?= base_url();?>assets/front-end/images/bill.jpg" alt="" class="img-fluid" />
				</div> 
				<div class="bill-ecopy">
				
				</div>
			</div>
		</div>
	</div>
</div>
</section>
<script src='https://www.google.com/recaptcha/api.js'></script>

<?php require_once('container/footer.php')?>
<script>
$("#registration-state").select2({
     allowClear: false
});
function fnpurchasefrom(val)
{
	if(val=="Amazon" || val=="Vidiem E-commerce"){
		if(val=="Amazon")
			$("#dealername").val('Amazon');
	    else
			$("#dealername").val('Vidiem');
	  if(!$("#lbldealer").hasClass("active"))	
		$("#lbldealer").addClass("active");	
	}else{
		$("#dealername").val('');
		$("#lbldealer").removeClass("active");	
	}	
}

</script>

<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>

					            
