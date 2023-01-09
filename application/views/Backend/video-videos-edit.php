<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Video
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/video'); ?>">Video</a></li>
        <li><a href="<?= base_url('Admin/video/video/'.$id); ?>">Video</a></li>
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
              <h3 class="box-title">Edit Video - <?= $title; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?= base_url('Admin/video/video_edit'); ?>" enctype="multipart/form-data">
              <div class="box-body">
               <input type="hidden" name="hidden_id" value="<?php echo set_value('hidden_id',$edit_id); ?>" />
                <div class="form-group">
                  <label for="inputOrderNo" class="col-sm-2 control-label">Name</label>
                   <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputname" name="name" value="<?= set_value('name',$Edit_Result['name']); ?>">
                    <?= form_error('name'); ?>
                  </div>
                </div>
				
				<div class="form-group">
                  <label for="title" class="col-sm-2 control-label">Title</label>
                   <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="title" name="title" value="<?= set_value('title',$Edit_Result['title']); ?>">
                    <?= form_error('title'); ?>
                  </div>
                </div>
				
                	<div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Video URL</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputvideourl" name="videourl" value="<?= set_value('videourl','youtube.com/watch?v='.$Edit_Result['video_url']); ?>">
                    <?= form_error('videourl'); ?>
                  </div>
                </div>
				
				<div class="form-group">
                  <label for="urllink" class="col-sm-2 control-label">URL-Link</label>
                  <div class="col-sm-6">
                      <input type="text" class="form-control" id="urllink" name="urllink" value="<?= set_value('urllink',$Edit_Result['urllink']); ?>">
                    <?= form_error('urllink'); ?>
                    </div>
                </div>
				
				<div class="form-group">
                  <label for="image" class="col-sm-2 control-label">Image</label>
                  <div class="col-sm-6">
                      <input type="file" class="form-control imgUpload" id="image" name="image">
                      <?= form_error('image'); ?>
                    </div>
                    <div class="col-sm-4">
					<img src="<?= base_url('uploads/images/'.$Edit_Result['image']); ?>" width="100px" height="100px" class="UploadImgPreview img-responsive">
                </div>
				
				<div class="form-group">
                  <label for="description" class="col-sm-2 control-label">Description</label>
                  <div class="col-md-6 col-sm-10">
                    <textarea id="description" cols="30" rows="3" class="form-control summernote" name="description"><?= set_value('description',@$Edit_Result['description']); ?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputOrderNo" class="col-sm-2 control-label">Sorting</label>
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