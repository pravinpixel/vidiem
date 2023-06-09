<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Category
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/category'); ?>">Category</a></li>
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
              <h3 class="box-title">Edit Category</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?= base_url('Admin/category/edit'); ?>" enctype="multipart/form-data">
              <div class="box-body">
               <input type="hidden" name="hidden_id" value="<?php echo set_value('hidden_id',$edit_id); ?>" />
                
               <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Name  <span class="red">*</span></label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputName" name="name" value="<?= set_value('name',@$Edit_Result['name']); ?>">
                    <?= form_error('name'); ?>
                  </div>
                </div>

               <div class="form-group">
                  <label for="inputImage" class="col-sm-2 control-label">Image  <span class="red">*</span></label>
                  <div class="col-sm-6">
                      <input type="file" class="form-control imgUpload" id="inputImage" name="image">
                      <?= form_error('image'); ?>
                    </div>
                    <div class="col-sm-4">
                      <img src="<?= base_url('uploads/images/'.$Edit_Result['image']); ?>" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
                </div>
				
				<div class="form-group">
                  <label for="imageicon" class="col-sm-2 control-label">Category Menu Icon  <span class="red">*</span></label>
                  <div class="col-sm-6">
                      <input type="file" class="form-control imgUpload" id="imageicon" name="imageicon">
                      <?= form_error('imageicon'); ?>
                    </div>
                    <div class="col-sm-4">
                      <img src="<?= base_url('uploads/images/'.$Edit_Result['imageicon']); ?>" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
                </div>
                
                <div class="form-group">
                  <label for="inputfeatured" class="col-sm-2 control-label">Featured Category</label>
                  <div class="col-md-6 col-sm-10">
                    <div class="checkbox icheck">
                      <label for="inputfeatured">
                        <input type="checkbox" value="1" name="featured" id="inputfeatured" <?= set_checkbox('featured','1',($Edit_Result['featured']==1?TRUE:'')); ?>> Yes
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputDescription" class="col-sm-2 control-label">Description</label>
                  <div class="col-md-6 col-sm-10">
                    <textarea id="inputDescription" cols="30" rows="3" class="form-control" name="description"><?= set_value('description',@$Edit_Result['description']); ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputDescription" class="col-sm-2 control-label">Search Keywords</label>
                  <div class="col-md-6 col-sm-10">
                    <textarea id="inputSearchKeywords" cols="30" rows="3" class="form-control" name="search_keywords"><?= set_value('search_keywords',@$Edit_Result['search_keywords']); ?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputOrderNo" class="col-sm-2 control-label">Order No  <span class="red">*</span></label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputOrderNo" name="order_no" value="<?= set_value('order_no',@$Edit_Result['order_no']); ?>">
                    <?= form_error('order_no'); ?>
                  </div>
                </div>

                <h4 class="box-title">Banner Information</h4>

                <div class="form-group">
                  <label for="inputBannerImage" class="col-sm-2 control-label">Banner Image</label>
                  <div class="col-sm-6">
                      <input type="file" class="form-control imgUpload" id="inputBannerImage" name="banner_image">
                      <?= form_error('banner_image'); ?>
                    </div>
                    <div class="col-sm-4">
                      <img src="<?= base_url('uploads/images/'.$Edit_Result['banner_image']); ?>" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
                </div>

                <div class="form-group">
                  <label for="inputBannerUrl" class="col-sm-2 control-label">Banner Url</label>
                  <div class="col-md-6 col-sm-10">
                     <input type="text" class="form-control" id="inputBannerUrl" name="banner_url" value="<?= set_value('banner_url',@$Edit_Result['banner_url']); ?>">
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
                  <label for="inputDescription" class="col-sm-2 control-label">Content</label>
                  <div class="col-md-9 col-sm-10">
                    <textarea id="content" cols="30" rows="3" class="form-control ckeditor" name="content"><?= set_value('content',$Edit_Result['content']); ?></textarea>
                     <?= form_error('content'); ?>
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