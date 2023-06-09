<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Banners
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/banner'); ?>">Banners</a></li>
        <li class="active">Add</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
       <?php if(($this->session->flashdata('msg'))){ ?>
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
              <h3 class="box-title">Add Banner</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?= base_url('Admin/Banner/add'); ?>" enctype="multipart/form-data">
              <div class="box-body">
                
                <div class="form-group">
                  <label for="inputPage" class="col-sm-2 control-label">Page</label>
                  <div class="col-md-6 col-sm-10">
                    <select name="page" id="inputPage" class="form-control">
                      <option value="">Select Page</option>
                          <option value="1">home</option>
                       
                    </select>
                    <?= form_error('page'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Name</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputName" name="name" value="<?= set_value('name'); ?>">
                    <?= form_error('name'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputImage" class="col-sm-2 control-label">Image</label>
                  <div class="col-sm-6">
                      <input type="file" class="form-control imgUpload" id="inputImage" name="image">
                      <?= form_error('image'); ?>
                    </div>
                    <div class="col-sm-4">
                      <img src="" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
                </div>
				
				 <div class="form-group">
                  <label for="mobileimage" class="col-sm-2 control-label">Mobile Image</label>
                  <div class="col-sm-6">
                      <input type="file" class="form-control imgUpload" id="mobileimage" name="mobileimage">
                      <?= form_error('mobileimage'); ?>
                    </div>
                    <div class="col-sm-4">
                      <img src="" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
                </div>
				
                <div class="form-group">
                  <label for="inputBannerUrl" class="col-sm-2 control-label">Banner Url</label>
                  <div class="col-md-6 col-sm-10">
                     <input type="text" class="form-control" id="inputBannerUrl" name="banner_url" value="<?= set_value('banner_url'); ?>">
                  </div>
                </div>
				
				<div class="form-group">
                  <label for="content" class="col-sm-2 control-label">Content</label>
                  <div class="col-md-9 col-sm-10">
                    <textarea id="contents" cols="30" rows="3" class="form-control summernote" name="contents"><?= set_value('description'); ?></textarea>
                     
                  </div>
                </div>
				
                <div class="form-group">
                  <label for="inputOrderNo" class="col-sm-2 control-label">Order No.</label>
                   <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputOrderNo" name="order_no" value="<?= set_value('order_no'); ?>">
                    <?= form_error('order_no'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"></label>
                  <div class="col-md-6 col-sm-10">
                     <button type="submit" class="btn btn-info col-sm-3">Add</button>
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