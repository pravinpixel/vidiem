<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        SEO
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/seo'); ?>">SEO</a></li>
        <li class="active">Add</li>
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
              <h3 class="box-title">Add SEO</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?= base_url('Admin/seo/add'); ?>" enctype="multipart/form-data">
              <div class="box-body">
                
                <div class="form-group">
                  <label for="inputLocation" class="col-sm-2 control-label">Title</label>
                  <div class="col-md-6 col-sm-10">
				  <select name="title" id="inputtitle" class="form-control">
                      <option value="">Select Page</option>
                      <option <?php if(  set_value('title')=='Home'){ echo "Selected"; } ?> value="Home">Home</option>
					  <option <?php if(  set_value('title')=='About Us'){ echo "Selected"; } ?> value="About Us">About Us</option>
					  <option <?php if(  set_value('title')=='Product Registration'){ echo "Selected"; } ?> value="Product Registration">Product Registration</option>
					  <option <?php if(  set_value('title')=='User Manual'){ echo "Selected"; } ?> value="User Manual">User Manual</option>
					  <option <?php if(  set_value('title')=='FAQ'){ echo "Selected"; } ?> value="FAQ">FAQ</option>
					  <option <?php if(  set_value('title')=='Demo Videos'){ echo "Selected"; } ?> value="Demo Videos">Demo Videos</option>
					  <option <?php if(  set_value('title')=='Dealer Locator'){ echo "Selected"; } ?> value="Dealer Locator">Dealer Locator</option>
					  <option <?php if(  set_value('title')=='Service Center'){ echo "Selected"; } ?> value="Service Center">Service Center</option>
					  <option <?php if(  set_value('title')=='Warranty Terms'){ echo "Selected"; } ?> value="Warranty Terms">Warranty Terms</option>
					  <option <?php if(  set_value('title')=='Events'){ echo "Selected"; } ?> value="Events">Events</option>
					  <option <?php if(  set_value('title')=='Videos'){ echo "Selected"; } ?> value="Videos">Videos</option>
					  <option <?php if(  set_value('title')=='Press Release'){ echo "Selected"; } ?> value="Press Release">Press Release</option>
					  <option <?php if(  set_value('title')=='Recipe'){ echo "Selected"; } ?> value="Recipe">Recipe</option>
					  <option <?php if(  set_value('title')=='Contact'){ echo "Selected"; } ?> value="Contact">Contact</option>
					  <option <?php if(  set_value('title')=='Offers'){ echo "Selected"; } ?> value="Offers">Offers</option>
					  <option <?php if(  set_value('title')=='Cancellation Policy'){ echo "Selected"; } ?> value="Cancellation Policy">Cancellation Policy</option>
					  <option <?php if(  set_value('title')=='Disclaimer'){ echo "Selected"; } ?> value="Disclaimer">Disclaimer</option>
					  <option <?php if(  set_value('title')=='Privacy Policy'){ echo "Selected"; } ?> value="Privacy Policy">Privacy Policy</option>
					  <option <?php if(  set_value('title')=='Return Policy'){ echo "Selected"; } ?> value="Return Policy">Return Policy</option>
					  <option <?php if(  set_value('title')=='Shipping & Delivery'){ echo "Selected"; } ?> value="Shipping & Delivery">Shipping & Delivery</option>
					  <option <?php if(  set_value('title')=='Sitemap'){ echo "Selected"; } ?> value="Sitemap">Sitemap</option>
					  <option <?php if(  set_value('title')=='Terms and conditions'){ echo "Selected"; } ?> value="Terms and conditions">Terms and conditions</option>
					  <option <?php if(  set_value('title')=='Vidiem by You'){ echo "Selected"; } ?> value="Vidiem by You">Vidiem by You</option>
                    </select>
                    
                    <?= form_error('title'); ?>
                  </div>
                </div>
                 <div class="form-group">
                  <label for="inputMetaTitle" class="col-sm-2 control-label">Meta Title</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputMetaTitle" name="meta_title" value="<?= set_value('meta_title'); ?>">
                   <?= form_error('meta_title'); ?>
				  </div>
                </div>

                <div class="form-group">
                  <label for="inputMetaDescription" class="col-sm-2 control-label">Meta Description</label>
                  <div class="col-md-6 col-sm-10">
                    <textarea id="inputMetaDescription" cols="30" rows="3" class="form-control" name="meta_description"><?= set_value('meta_description'); ?></textarea>
                    <?= form_error('meta_description'); ?>                 
				 </div>
                </div>

                <div class="form-group">
                  <label for="inputMetaKeywords" class="col-sm-2 control-label">Meta Keywords</label>
                  <div class="col-md-6 col-sm-10">
                    <textarea id="inputMetaKeywords" cols="30" rows="3" class="form-control" name="meta_keywords"><?= set_value('meta_keywords'); ?></textarea>
                   <?= form_error('meta_keywords'); ?>
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