<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Block Management
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/block'); ?>">Block</a></li>
        <li class="active">Edit</li>
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
              <h3 class="box-title">Edit Block</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?= base_url('Admin/block/edit'); ?>" enctype="multipart/form-data">
              <div class="box-body">
               <input type="hidden" name="hidden_id" value="<?php echo set_value('hidden_id',$edit_id); ?>" />

                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Block Name</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputName" name="name" value="<?= set_value('name',$Edit_Result['name']); ?>">
                    <?= form_error('name'); ?>
                  </div>
                </div>

                <!--<div class="form-group">
                  <label for="inputBannerUrl" class="col-sm-2 control-label">Block Slug</label>
                  <div class="col-md-6 col-sm-10">
                     <input type="text" class="form-control" id="blockslug" name="blockslug" value="<?= set_value('blockslug',$Edit_Result['blockslug']); ?>">
                  </div>
                </div>-->
				
				<div class="form-group">
                  <label for="content" class="col-sm-2 control-label">Content</label>
                  <div class="col-md-9 col-sm-10">
                    <textarea id="contents" cols="30" rows="3" class="form-control summernote" name="contents"><?= set_value('content',$Edit_Result['content']); ?></textarea>
                     <?= form_error('contents'); ?>
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