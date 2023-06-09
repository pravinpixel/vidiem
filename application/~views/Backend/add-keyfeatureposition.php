<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Key Feature Position
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/Keyfeatureposition'); ?>">Key Feature Position</a></li>
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
              <h3 class="box-title">Add Key Feature Position</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?= base_url('Admin/Keyfeatureposition/add'); ?>" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label for="position" class="col-sm-2 control-label">Position Name</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="position" name="position" value="<?= set_value('position'); ?>">
                    <?= form_error('position'); ?>
                  </div>
                </div>
				
                <div class="form-group">
                  <label for="columnname" class="col-sm-2 control-label">Column Name</label>
                  <div class="col-md-6 col-sm-10">
                    <select name="columnname" id="columnname" class="form-control">
                      <option value="">Select Column</option>
					  <option value="col-1">col-1</option>
					  <option value="col-2">col-2</option>
					  <option value="col-3">col-3</option>
					  <option value="col-4">col-4</option>
					  <option value="col-5">col-5</option>
					  <option value="col-6">col-6</option>
					  <option value="col-7">col-7</option>
					  <option value="col-8">col-8</option>
					  <option value="col-9">col-9</option>
					  <option value="col-10">col-10</option>
					  <option value="col-11">col-11</option>
					  <option value="col-12">col-12</option>
                        
                    </select>
                    <?= form_error('columnname'); ?>
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