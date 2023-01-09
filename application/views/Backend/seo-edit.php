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
              <h3 class="box-title">Edit SEO</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?= base_url('Admin/seo/edit'); ?>" enctype="multipart/form-data">
              <div class="box-body">
               <input type="hidden" name="hidden_id" value="<?php echo set_value('hidden_id',$edit_id); ?>" />

                <div class="form-group">
                  <label for="inputLocation" class="col-sm-2 control-label">Title</label>
                  <div class="col-md-6 col-sm-10">
				 
                    <input type="text" class="form-control" id="inputLocation" name="title" value="<?= set_value('title',$Edit_Result['title']); ?>">
                    <?= form_error('title'); ?>
                  </div>
                </div>
                 <div class="form-group">
                  <label for="inputPhone" class="col-sm-2 control-label">Meta Title</label>
                  <div class="col-md-6 col-sm-10">
                  <input type="text" class="form-control" id="inputMetaTitle" name="meta_title" value="<?= set_value('meta_title',$Edit_Result['meta_title']); ?>">
                    <?= form_error('meta_title'); ?>
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputPhone" class="col-sm-2 control-label">Meta Description</label>
                  <div class="col-md-6 col-sm-10">
                  <input type="text" class="form-control" id="inputMetaDescription" name="meta_description" value="<?= set_value('meta_description',$Edit_Result['meta_description']); ?>">
                    <?= form_error('meta_description'); ?>
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputPhone" class="col-sm-2 control-label">Meta Keywords</label>
                  <div class="col-md-6 col-sm-10">
                  <input type="text" class="form-control" id="inputPhone" name="meta_keywords" value="<?= set_value('meta_keywords',$Edit_Result['meta_keywords']); ?>">
                    <?= form_error('meta_keywords'); ?>
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