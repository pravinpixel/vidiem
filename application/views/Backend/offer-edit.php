<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Offers
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/offers'); ?>">Offers</a></li>
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
              <h3 class="box-title">Edit Offers</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?= base_url('Admin/offers/edit'); ?>" enctype="multipart/form-data">
              <div class="box-body">
               <input type="hidden" name="hidden_id" value="<?php echo set_value('hidden_id',$edit_id); ?>" />
                <div class="form-group">
                  <label for="inputPage" class="col-sm-2 control-label">Page</label>
                  <div class="col-md-6 col-sm-10">
                    <select name="page" id="inputPage" class="form-control">
                      <option value="">Select Page</option>
                      <?php if(!empty($Pages)){
                        foreach ($Pages as $key => $info) { ?>
                          <option value="<?= $key; ?>" <?= set_select('page',$key,($Edit_Result['type']==$key?TRUE:'')); ?>><?= $info ?></option>
                       <?php }  } ?>
                    </select>
                    <?= form_error('page'); ?>
                  </div>
                </div>
               <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Name</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputName" name="name" value="<?= set_value('name',@$Edit_Result['name']); ?>">
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
                      <img src="<?= base_url('uploads/images/'.$Edit_Result['image']); ?>" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
                </div>
                
                <div class="form-group">
                  <label for="inputProduct" class="col-sm-2 control-label">Product Lists</label>
                  <div class="col-sm-6">
                     <select name="products[]" id="inputProduct" class="form-control select2" multiple="">
                       <?php if(!empty($products)){ 
                              foreach ($products as $info) { ?>
                                 <option value="<?= $info['id'];?>" <?= (in_array($info['id'], $old_products))?'selected':''; ?>><?= $info['name'];?></option>
                       <?php } } ?>
                     </select>
                      <?= form_error('products'); ?>
                    </div>
                    <div class="col-sm-4">
                      <img src="" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
                </div>

                <h4 class="box-title">Seo Information</h4>

                <div class="form-group">
                  <label for="inputMetaTitle" class="col-sm-2 control-label">Meta Title</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputMetaTitle" name="meta_title" value="<?= set_value('meta_title',@$Edit_Result['meta_title']); ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputMetaDescription" class="col-sm-2 control-label">Meta Description</label>
                  <div class="col-md-6 col-sm-10">
                    <textarea id="inputMetaDescription" cols="30" rows="3" class="form-control" name="meta_description"><?= set_value('meta_description',@$Edit_Result['meta_description']); ?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputMetaKeywords" class="col-sm-2 control-label">Meta Keywords</label>
                  <div class="col-md-6 col-sm-10">
                    <textarea id="inputMetaKeywords" cols="30" rows="3" class="form-control" name="meta_keywords"><?= set_value('meta_keywords',@$Edit_Result['meta_keywords']); ?></textarea>
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