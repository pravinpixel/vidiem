<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Other Product
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/otherproduct'); ?>">Products</a></li>
        <li class="active">Edit</li>
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
              <h3 class="box-title">Other Product</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?= base_url('Admin/otherproduct/edit'); ?>" enctype="multipart/form-data">
              <div class="box-body">
               <input type="hidden" name="hidden_id" value="<?php echo set_value('hidden_id',$edit_id); ?>" />
			   
				<div class="form-group">
                  <label for="productkeyfeature" class="col-sm-2 control-label">Other Product</label>
                  <div class="col-md-6 col-sm-10">
                    <select name="productkeyfeature" id="productkeyfeature" class="form-control">
                      <option value="">Select Key Feature</option>
					  <option value="1" <?= set_select('productkeyfeature',1,(1==$Edit_Result['productkeyfeature']?TRUE:''));?>>About Product</option>
					  <option value="2" <?= set_select('productkeyfeature',2,(2==$Edit_Result['productkeyfeature']?TRUE:''));?>>Product Details</option>
                      
                    </select>
                    <?= form_error('productkeyfeature'); ?>
                  </div>
                </div>
				
				<div class="form-group">
                  <label for="productkeyfeature" class="col-sm-2 control-label">Position</label>
                  <div class="col-md-6 col-sm-10">
                    <select name="position" id="position" class="form-control">
                      <option value="">Select Position</option>
					  <?php if(!empty($position)){ 
                          foreach($position as $info){ ?>
                          <option value="<?= $info['id']; ?>" <?= set_select('position',$info['id'],($info['id']==$Edit_Result['position']?TRUE:''));?>><?= $info['position']; ?></option>
                        <?php } } ?> 
                      
                    </select>
                    <?= form_error('position'); ?>
                  </div>
                </div>
				
				<div class="form-group">
                  <label for="imageposition" class="col-sm-2 control-label">Image Position</label>
                  <div class="col-md-6 col-sm-10">
                    <select name="imageposition" id="imageposition" class="form-control">
                      <option value="">Select Image Position</option>
					  <option value="0" <?= set_select('imageposition',0,(0==$Edit_Result['imageposition']?TRUE:''));?>>None</option>
					  <option value="1" <?= set_select('imageposition',1,(1==$Edit_Result['imageposition']?TRUE:''));?>>Left</option>
					  <option value="2" <?= set_select('imageposition',2,(2==$Edit_Result['imageposition']?TRUE:''));?>>Right</option>
                    </select>
                    <?= form_error('imageposition'); ?>
                  </div>
                </div>				
				
                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Name</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputName" name="name" value="<?= set_value('name',$Edit_Result['name']); ?>">
                    <?= form_error('name'); ?>
                  </div>
                </div>
				
				<div class="form-group">
                  <label for="productlink" class="col-sm-2 control-label">Product Link</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="productlink" name="productlink" value="<?= set_value('productlink',$Edit_Result['productlink']); ?>">
                    <?= form_error('productlink'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputImage" class="col-sm-2 control-label">Image</label>
                  <div class="col-sm-6">
                      <input type="file" class="form-control imgUpload" id="inputImage" name="image">
                      <?= form_error('image'); ?>
                    </div>
                    <div class="col-sm-4">
                      <img src="<?= base_url('uploads/images/'.$Edit_Result['image']); ?>" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
                </div>

                <div class="form-group">
                  <label for="inputDescription" class="col-sm-2 control-label">Content</label>
                  <div class="col-md-9 col-sm-10">
                    <textarea id="inputDescription" cols="30" rows="3" class="form-control ckeditor" name="content"><?= set_value('content',@$Edit_Result['content']); ?></textarea>
                     <?= form_error('content'); ?>
                  </div>
                </div>
				


                <div class="form-group">
                  <label for="inputOrderNo" class="col-sm-2 control-label">Order No.</label>
                   <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputOrderNo" name="order_no" value="<?= set_value('order_no',$Edit_Result['order_no']); ?>">
                    <?= form_error('order_no'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"></label>
                  <div class="col-md-6 col-sm-10">
                     <button type="submit" class="btn btn-info col-sm-3">Update</button>
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
<?php include_once('container/right-sidebar.php'); ?>
<?php include_once('container/footer.php'); ?>