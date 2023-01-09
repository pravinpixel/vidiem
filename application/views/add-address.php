<?php require_once('container/header.php'); ?>
<div class="bgPro proDetaPage clearfix">
	<section class="checkLeft clearfix light-gray-bg pt-5">
	<div class="container">
	<div class="row">
			<div class="col">
				<h2>Add New Address</h2>
				<h3>Your address</h3>
			</div>
		</div>
			<div class="row">
				<div class="col"> 
		<?php $states=$this->ProjectModel->states(); ?>
		<form method="POST" action="">
		<div id="tab-2" class="tab-content checkOutSingin clearfix current  bg-white shadow1 p-5 mt-4">
			<div class="addreePage clearfix">
				<p class="reFeild text-red"><sub>*</sub> Required field</p>
				<div class="row addressFormSet clearfix">
					<div class="col-sm-12 col-md-12 col-lg-12">
					<input type="hidden" name="type" value="<?= set_value('type',@$type); ?>">
					<input type="hidden" name="shipping_id" value="<?= set_value('shipping_id',@$shipping_id); ?>">
					<input type="hidden" name="billing_id" value="<?= set_value('billing_id',@$billing_id); ?>">
					<input type="hidden" name="same" value="<?= set_value('same',@$same); ?>">
					</div>
					
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input type="text" class="form-control" name="name" value="<?= set_value('name',$this->session->userdata('client_name')); ?>">
							<label for="">Name <sub class="text-red">*</sub></label>
							<?= form_error('name'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input type="text" class="form-control" name="company" value="<?= set_value('company'); ?>">
							<label for="">Company</label>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input type="text" class="form-control" name="address" value="<?= set_value('address'); ?>">
							<label for="">Address <sub class="text-red">*</sub></label>
							<?= form_error('address'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input type="text" class="form-control" name="address2" value="<?= set_value('address2'); ?>">
							<label for="">Address2</label>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input type="number" class="form-control" name="zip_code" value="<?= set_value('zip_code'); ?>">
							<label for="">Zip/Postal Code <sub class="text-red">*</sub></label>
							<?= form_error('zip_code'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input type="text" class="form-control" name="city" value="<?= set_value('city'); ?>">
							<label for="">City <sub class="text-red">*</sub></label>
							<?= form_error('city'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet pt-2">
							<label for="">Country <sub class="text-red">*</sub></label>
							<select name="country" id="country" class="js-states form-control">
								<option>India</option>
							</select>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet pt-2">
							<label for="">State <sub class="text-red">*</sub></label>
							<select name="state" id="state" class="js-states form-control">
								<option>Select State</option>
								<?php if(!empty($states)){
									foreach ($states as $info) { ?>
										<option value="<?= $info;?>" <?= set_select('state',$info);?>><?= $info;?></option>
								<?php
									} } ?>
							</select>
							<?= form_error('state'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input type="text"  minlength="10"   maxlength="10" class="form-control" name="mobile_no" value="<?= set_value('mobile_no'); ?>">
							<label for="">Mobile Number <sub class="text-red">*</sub></label>
							<?= form_error('mobile_no'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input type="text" class="form-control" name="emailid" value="<?= set_value('emailid'); ?>">
							<label for="">Email<sub class="text-red">*</sub></label>
							<?= form_error('emailid'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<textarea class="md-textarea form-control" name="add_information"><?= set_value('add_information'); ?></textarea>
							<label for="">Additional Information</label>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input type="text" class="form-control" name="title" value="<?= set_value('title','My Address'); ?>">
							<label for="">Address Title <sub class="text-red">*</sub></label>
							<?= form_error('title'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12 text-right">
						<button type="submit" class="red-btn small"><i class="lni lni-save"></i> &nbsp; Save</button>
					</div>
				</div>
				
			</div>
		</div>
	</form>
	</div>
	</div>
	</div>
	</section>
<?php //require_once('container/top_seller.php'); ?>
</div>
<?php require_once('container/footer.php'); ?>