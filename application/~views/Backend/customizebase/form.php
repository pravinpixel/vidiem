<?php $this->load->view('Backend/container/header'); ?>
<?php $this->load->view('Backend/container/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <?php
  
     if($action=="Create")
	 {
		$actionurl=	base_url('Admin/customizebase/save/'); 
		$actionbtn="Submit";
	 }
	 else
	 {
		$actionurl=	base_url('Admin/customizebase/update/'.$dataitems->base_id); 
		$actionbtn="Update";
	 }	 

  
  ?>
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Customize Base
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/customizebase'); ?>">Customize Base</a></li>
        <li class="active"><?php echo $action; ?></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
       <?php if(!empty($this->session->flashdata('msg'))){ ?>
    <div class="alert <?= $this->session->flashdata('class'); ?> alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa <?= $this->session->flashdata('icon'); ?>"></i> Alert!</h4>
      <?= $this->session->flashdata('msg'); ?>
    </div>
    <?php } ?>
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $action; ?> Customize Base</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" id="frmcustmotor" name="frmcustmotor" method="post" action="<?php echo $actionurl; ?>"  enctype="multipart/form-data">
              <div class="box-body">
			  
			   <!--  <div class="form-group">
                  <label for="inputCategory" class="col-sm-2 control-label">Category *</label>
                  <div class="col-md-6 col-sm-10">
                  <select class="selectpicker required js-states form-control custome-select registration_category" data-live-search="true" name="category_id" id="category_id">
                      <option value="">Select Category</option>
                      <?php if(!empty($categories)){ 
                          foreach($categories as $info){ ?>
                          <option  value="<?= $info['id'] ?>"   <?= set_select('category_id', $info['id'] ,($info['id'] == $dataitems->category_id ? TRUE:'') );?> ><?= $info['name']; ?></option>
                        <?php } } ?>  
                    </select>
                
                    <?= form_error('category_id'); ?>
                  </div>
                </div>  -->
				 <input type="hidden" id="category_id" name="category_id" value="1">
                                  
                 
               <div class="form-group">
                  <label for="basetitle" class="col-sm-2 control-label">Base Title<span class="red">*</span></label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" required id="basetitle" name="basetitle" value="<?= set_value('basetitle',@$dataitems->basetitle); ?>">
                    <?= form_error('basetitle'); ?>
                  </div>
                </div>
				
				    <div class="form-group">
                  <label for="code" class="col-sm-2 control-label">Base Code<span class="red">*</span></label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" required id="code" name="code" value="<?= set_value('code',@$dataitems->code); ?>">
                    <?= form_error('code'); ?>
                  </div>
                </div>
				
				<div class="form-group">
                  <label for="description" class="col-sm-2 control-label">Description</label>
                  <div class="col-md-9 col-sm-10">
                    <textarea id="description" cols="30"  rows="3" class="form-control ckeditor" name="description"><?= set_value('description',@$dataitems->description); ?></textarea>
                     <?= form_error('description'); ?>
                  </div>
                </div>
				
				   <div class="form-group">
                  <label for="basepath" class="col-sm-2 control-label">Image</label>
                  <div class="col-sm-6">
                      <input type="file" class="form-control imgUpload"  id="basepath" name="basepath">
                      <?= form_error('basepath'); ?>
					  <small>(image size should be upload: 1000 * 1000)</small>
                    </div>
                   <div class="col-sm-4">
                      <img src="<?= base_url('uploads/customizeimg/'.$dataitems->basepath); ?>" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
                </div>
				 <input type="hidden" class="form-control" id="price" onkeypress="return isNumber(this.event);" required name="price" value="0">
				<!-- <div class="form-group">
                  <label for="price" class="col-sm-2 control-label">Price<span class="red">*</span></label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="price" onkeypress="return isNumber(this.event);" required name="price" value="<?= set_value('price',@$dataitems->price); ?>">
                    <?= form_error('price'); ?>
                  </div>
                </div>  -->
				<?php 
				$disableddefault=" ";
				if(isset($defaultexist[0]['base_id']) && $defaultexist[0]['base_id']!="" &&  $dataitems->isdefault==0) {  
					$disableddefault="  disabled ";
				} ?>
				<div class="form-group">
                  <label for="isdefault" class="col-sm-2 control-label">Is default</label>
                  <div class="col-md-6 col-sm-10">
                    <div class="checkbox icheck">
                      <label for="isdefault">
                        <input type="checkbox" value="1" <?php echo $disableddefault; ?>  <?php echo $dataitems->isdefault==1?'checked="checked"':''; ?>  name="isdefault" id="isdefault" <?= set_checkbox('isdefault','1',($Edit_Result['isdefault']==1?TRUE:'')); ?>> 
                      </label>
                    </div>
                  </div>
                </div>
				
				 <div class="form-group">
                  <label for="sortby" class="col-sm-2 control-label">Sortby<span class="red">*</span></label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="sortby" onkeypress="return isNumber(this.event);" name="sortby" value="<?= set_value('sortby',@$dataitems->sortby); ?>">
                    <?= form_error('sortby'); ?>
                  </div>
                </div>
				
			
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"></label>
                  <div class="col-md-6 col-sm-10">				 
                     <button type="submit" class="btn btn-success col-sm-3" style="margin-right:10px;"><?php echo $actionbtn; ?></button>
					 <input type="reset" class="btn  col-sm-3 reset" id="reset" value="Reset"/>					 
                  </div>
				  
                </div>
                
              </div>
              <!-- /.box-body -->
            </form>
          </div>
      </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('Backend/container/right-sidebar'); ?>
<?php $this->load->view('Backend/container/footer'); ?>
<script>
  $(document).ready(function(){
          $('select').select2();
		  
		  $(".reset").click(function() {
			  $('input[type=text]').attr('value', ''); 
			  $("select").val('').trigger('change')
			  $('input:checkbox').iCheck('uncheck');
			  $('input:radio').iCheck('uncheck');
});

      });
 </script>