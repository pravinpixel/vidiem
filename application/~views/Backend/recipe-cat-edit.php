<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) --> 
    <section class="content-header">
      <h1>
        Recipe
        <!-- <small>new</small> --> 
      </h1> 
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
              <li><a href="<?= base_url('Admin/recipe'); ?>">Recipe</a></li>
        <li><a href="<?= base_url('Admin/recipe/recipecat/'.$id); ?>">Recipe</a></li>
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
              <h3 class="box-title">Edit Recipe </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
          <form class="form-horizontal" method="post" action="<?= base_url('Admin/recipe/recipecatedit/'); ?>" enctype="multipart/form-data">
             <div class="box-body">
               <input type="hidden" name="hidden_id" value="<?php echo set_value('hidden_id',$edit_id); ?>" />
                <div class="form-group">
                  <label for="inputQuestion" class="col-sm-2 control-label">Title</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputTitle" name="title" value="<?= set_value('title',$Edit_Result['title']); ?>">
                    <?= form_error('title'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputAnswer" class="col-sm-2 control-label">Content</label>
                  <div class="col-md-6 col-sm-10">
                    <textarea class="form-control ckeditor" id="inputAnswer" name="content"><?= set_value('content',$Edit_Result['content']); ?></textarea>
                    <?= form_error('content'); ?>
                  </div>
                </div>
                <h4 class="box-title">IncredeDetail</h4>
                 <div class="form-group">
                  <label for="inputAnswer" class="col-sm-2 control-label">Content</label>
                  <div class="col-md-6 col-sm-10">
                    <textarea class="form-control ckeditor" id="inputincrecontent" name="increcontent"><?= set_value('increcontent',$Edit_Result['increcontent']); ?></textarea>
                    
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