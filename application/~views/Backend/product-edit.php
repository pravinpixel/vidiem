<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Products
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/products'); ?>">Products</a></li>
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
              <h3 class="box-title">Edit Product</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?= base_url('Admin/products/edit'); ?>" enctype="multipart/form-data">
              <div class="box-body">
               <input type="hidden" name="hidden_id" value="<?php echo set_value('hidden_id',$edit_id); ?>" />
                
                <div class="form-group">
                  <label for="inputCategory" class="col-sm-2 control-label">Category</label>
                  <div class="col-md-6 col-sm-10">
                    <select name="category" id="inputCategory" class="form-control product_cat_trigger">
                      <option value="">Select Category</option>
                      <?php if(!empty($category)){ 
                          foreach($category as $info){ ?>
                          <option value="<?= $info['id']; ?>" <?= set_select('category',$info['id'],($info['id']==$Edit_Result['cat_id']?TRUE:''));?>><?= $info['name']; ?></option>
                        <?php } } ?>  
                    </select>
                    <?= form_error('category'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputSubCategory" class="col-sm-2 control-label">Sub Category</label>
                  <div class="col-md-6 col-sm-10">
                    <select name="sub_category" id="inputSubCategory" class="form-control sub_category">
                      <option value="">Select Sub Category</option>
                       <?php if(!empty($sub_category)){ 
                          foreach($sub_category as $info){ ?>
                          <option value="<?= $info['id']; ?>" <?= set_select('sub_category',$info['id'],($info['id']==$Edit_Result['sub_cat_id']?TRUE:''));?>><?= $info['name']; ?></option>
                        <?php } } ?>  
                    </select>
                    <?= form_error('sub_category'); ?>
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
                  <label for="inputModal" class="col-sm-2 control-label">Modal No.</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputModal" name="modal_no" value="<?= set_value('modal_no',$Edit_Result['modal_no']); ?>">
                    <?= form_error('modal_no'); ?>
                  </div>
                </div>

                 <div class="form-group">
                  <label for="inputImage" class="col-sm-2 control-label">Image</label>
                  <div class="col-sm-6">
                      <input type="file" class="form-control imgUpload" id="inputImage" name="image">
                      <?= form_error('image'); ?>
					  <small>(image size should be upload: 1000 * 1000)</small>
                    </div>
                    <div class="col-sm-4">
                      <img src="<?= base_url('uploads/images/'.$Edit_Result['image']); ?>" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
                </div>
                
                <div class="form-group">
                  <label for="inputexclusive" class="col-sm-2 control-label">Exclusive Product</label>
                  <div class="col-md-6 col-sm-10">
                    <div class="checkbox icheck">
                      <label for="inputexclusive">
                        <input type="checkbox" value="1" name="exclusive" id="inputexclusive" <?= set_checkbox('exclusive','1',($Edit_Result['exclusive']==1?TRUE:'')); ?>> Yes
                      </label>
                    </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputfeatured" class="col-sm-2 control-label">Featured Products</label>
                  <div class="col-md-6 col-sm-10">
                    <div class="checkbox icheck">
                      <label for="inputfeatured">
                        <input type="checkbox" value="1" name="featured" id="inputfeatured" <?= set_checkbox('featured','1',($Edit_Result['featured']==1?TRUE:'')); ?>> Yes
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputnew" class="col-sm-2 control-label">New Launches</label>
                  <div class="col-md-6 col-sm-10">
                    <div class="checkbox icheck">
                      <label for="inputnew">
                        <input type="checkbox" value="1" name="new_launches" id="inputnew" <?= set_checkbox('new_launches','1',($Edit_Result['new_launches']==1?TRUE:'')); ?>> Yes
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputOutofStock" class="col-sm-2 control-label">Out of Stock</label>
                  <div class="col-md-6 col-sm-10">
                    <div class="checkbox icheck">
                      <label for="inputOutofStock">
                        <input type="checkbox" value="1" name="outofstock" id="inputOutofStock" <?= set_checkbox('outofstock','1',($Edit_Result['outofstock']==1?TRUE:'')); ?>> Yes
                      </label>
                    </div>
                  </div>
                </div>
				
				<div class="form-group">
                  <label for="popularproduct" class="col-sm-2 control-label">Popular Product</label>
                  <div class="col-md-6 col-sm-10">
                    <div class="checkbox icheck">
                      <label for="popularproduct">
                        <input type="checkbox" value="1" name="popularproduct" id="popularproduct" <?= set_checkbox('popularproduct','1',($Edit_Result['popularproduct']==1?TRUE:'')); ?>> Yes
                      </label>
                    </div>
                  </div>
                </div>
				
				<div class="form-group">
                  <label for="iscustomized" class="col-sm-2 control-label">Is Customized</label>
                  <div class="col-md-6 col-sm-10">
                    <div class="checkbox icheck">
                      <label for="iscustomized">
                        <input type="checkbox" value="1" name="iscustomized" id="iscustomized" <?= set_checkbox('iscustomized','1',($Edit_Result['iscustomized']==1?TRUE:'')); ?>> Yes
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputShortDescription" class="col-sm-2 control-label">Short Description</label>
                  <div class="col-md-9 col-sm-10">
                    <textarea id="inputShortDescription" cols="30" rows="3" class="form-control ckeditor" name="short_description"><?= set_value('short_description',$Edit_Result['short_description']); ?></textarea>
                     <?= form_error('short_description'); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputShortDescription" class="col-sm-2 control-label">List View Content</label>
                  <div class="col-md-9 col-sm-10">
                    <textarea id="inputListDescription" cols="30" rows="3" class="form-control ckeditor" name="list_description"><?= set_value('list_description',$Edit_Result['list_description']); ?></textarea>
                     <?= form_error('list_description'); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputDescription" class="col-sm-2 control-label">Description</label>
                  <div class="col-md-9 col-sm-10">
                    <textarea id="inputDescription" cols="30" rows="3" class="form-control ckeditor" name="description"><?= set_value('description',$Edit_Result['description']); ?></textarea>
                     <?= form_error('description'); ?>
                  </div>
                </div>
                 <div class="form-group">
                  <label for="inputDescription" class="col-sm-2 control-label">Search Keywords</label>
                  <div class="col-md-6 col-sm-10">
                    <textarea id="inputSearchKeywords" cols="30" rows="3" class="form-control" name="search_keywords"><?= set_value('search_keywords',@$Edit_Result['search_keywords']); ?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputKeyImage" class="col-sm-2 control-label">Key Feature Image</label>
                  <div class="col-sm-6">
                      <input type="file" class="form-control imgUpload" id="inputKeyImage" name="key_feature_image">
                      <?= form_error('key_feature_image'); ?>
                    </div>
                    <div class="col-sm-4">
                      <img src="<?= base_url('uploads/images/'.$Edit_Result['key_feature_image']); ?>" width="100px" height="100px" class="UploadImgPreview img-responsive">
                    </div>
                </div>
                
                <div class="form-group">
                  <label for="inputKeyFeature" class="col-sm-2 control-label">Key Feature</label>
                  <div class="col-md-9 col-sm-10">
                    <textarea id="inputKeyFeature" cols="30" rows="3" class="form-control ckeditor" name="key_feature"><?= set_value('key_feature',$Edit_Result['key_feature']); ?></textarea>
                     <?= form_error('key_feature'); ?>
                  </div>
                </div>
                

                <div class="form-group">
                  <label for="inputWarrenty" class="col-sm-2 control-label">Warranty</label>
                  <div class="col-md-9 col-sm-10">
                    <textarea id="inputWarrenty" cols="30" rows="3" class="form-control ckeditor" name="warranty"><?= set_value('warranty',$Edit_Result['warranty']); ?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputManual" class="col-sm-2 control-label">Product Manual</label>
                  <div class="col-sm-6">
                      <input type="file" class="form-control" id="inputManual" name="manual">
                      <?= form_error('manual'); ?>
                    </div>
                    <div class="col-sm-4">
                    </div>
                </div>

                <div class="form-group">
                  <label for="inputOrderNo" class="col-sm-2 control-label">Order No.</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputOrderNo" name="order_no" value="<?= set_value('order_no',$Edit_Result['order_no']); ?>">
                    <?= form_error('order_no'); ?>
                  </div>
                </div>

                <h4 class="box-title">Price Information</h4>

                <div class="form-group">
                  <label for="inputPrice" class="col-sm-2 control-label">Price</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputPrice" name="price" value="<?= set_value('price',$Edit_Result['price']); ?>">
                    <?= form_error('price'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputOldPrice" class="col-sm-2 control-label">Mrp.</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputOldPrice" name="old_price" value="<?= set_value('old_price',$Edit_Result['old_price']); ?>">
                    <?= form_error('old_price'); ?>
                  </div>
                </div>

                <h4 class="box-title">Seo Information</h4>

                <div class="form-group">
                  <label for="inputMetaTitle" class="col-sm-2 control-label">Meta Title</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputMetaTitle" name="meta_title" value="<?= set_value('meta_title',$Edit_Result['meta_title']); ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputMetaDescription" class="col-sm-2 control-label">Meta Description</label>
                  <div class="col-md-6 col-sm-10">
                    <textarea id="inputMetaDescription" cols="30" rows="3" class="form-control" name="meta_description"><?= set_value('meta_description',$Edit_Result['meta_description']); ?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputMetaKeywords" class="col-sm-2 control-label">Meta Keywords</label>
                  <div class="col-md-6 col-sm-10">
                    <textarea id="inputMetaKeywords" cols="30" rows="3" class="form-control" name="meta_keywords"><?= set_value('meta_keywords',$Edit_Result['meta_keywords']); ?></textarea>
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