<?php require_once('container/header.php'); ?>
<div class="bgPro proDetaPage clearfix">
	<section class="checkLeft clearfix light-gray-bg pt-5 pb-5">
		<div class="container">
		<div class="row">
		<div class="col">
		<?php $states=$this->ProjectModel->states(); ?>
		<form method="POST" action="">
		<div id="tab-2" class="tab-content checkOutSingin clearfix current">
			<div class="addreePage clearfix">
				<h4 class="siHead text-dark mb-2">Your address</h4>
				<p class="reFeild"><sub class="text-red">*</sub> Required field</p>
				<div class="bg-white shadow1 mb-4 p-4">
				<div class="row addressFormSet clearfix">
					<input type="hidden" name="shipping_id" value="<?= set_value('shipping_id',@$shipping_id); ?>">
					<input type="hidden" name="billing_id" value="<?= set_value('billing_id',@$billing_id); ?>">
					<input type="hidden" name="same" value="<?= set_value('same',@$same); ?>">
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input type="text" name="name" value="<?= set_value('name',@$Edit_Info['name']); ?>" class="form-control">
							<label for="name">Name <sub class="text-red">*</sub></label>
							<?= form_error('name'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input class="form-control" type="text" name="company" value="<?= set_value('company',@$Edit_Info['company_name']); ?>">
							<label for="company">Company</label>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input class="form-control" type="text" name="address" value="<?= set_value('address',@$Edit_Info['address']); ?>">
							<label for="address">Address <sub class="text-red">*</sub></label>
							<?= form_error('address'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input class="form-control" type="text" name="address2" value="<?= set_value('address2',@$Edit_Info['address2']); ?>">
							<label for="address2">Address2</label>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input class="form-control" type="number" name="zip_code" value="<?= set_value('zip_code',@$Edit_Info['zip_code']); ?>">
							<label for="zip_code">Zip/Postal Code <sub class="text-red">*</sub></label>
							<?= form_error('zip_code'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input class="form-control" type="text" name="city" value="<?= set_value('city',@$Edit_Info['city']); ?>">
							<label for="city">City <sub class="text-red">*</sub></label>
							<?= form_error('city'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<select class="form-control" name="country" id="country">
								<option value="India" <?= set_select('country','India',(@$Edit_Info['country']=='India'?'TRUE':'')); ?>>India</option>
							</select>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<select class="form-control" name="state" id="state">
								<option>Select State</option>
								<?php if(!empty($states)){
									foreach ($states as $info) { ?>
										<option value="<?= $info;?>" <?= set_select('state',$info,(@$Edit_Info['state']==$info?TRUE:''));?>><?= $info;?></option>
								<?php
									} } ?>
							</select>
							<?= form_error('state'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input class="form-control" type="text" name="mobile_no" value="<?= set_value('mobile_no',@$Edit_Info['mobile_no']); ?>">
							<label for="mobile_no">Mobile Number <sub class="text-red">*</sub></label>
							<?= form_error('mobile_no'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input class="form-control" type="text" name="emailid" value="<?= set_value('emailid',@$Edit_Info['emailid']); ?>">
							<label for="emailid">Email ID <sub class="text-red">*</sub></label>
							<?= form_error('emailid'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<textarea class="md-textarea form-control" name="add_information"><?= set_value('add_information',@$Edit_Info['add_information']); ?></textarea>
							<label for="add_information">Additional Information</label>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4">
						<div class="rightAdDet md-form">
							<input class="form-control" type="text" name="title" value="<?= set_value('title',@$Edit_Info['title']); ?>">
							<label for="title">Address Title <sub class="text-red">*</sub></label>
							<?= form_error('title'); ?>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12 text-right">
					
					<button type="submit" class="red-btn small"><i class="lni lni-save"></i> &nbsp; Save</button>
					</div>
				</div>
				</div>
			</div>
		</div>
	</form>
	</div>
	</div>
	</div>
	</section>
</div>
<?php require_once('container/footer.php'); ?>