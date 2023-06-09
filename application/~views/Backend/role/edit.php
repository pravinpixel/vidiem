<?php $this->load->view('Backend/container/header'); ?>
<?php $this->load->view('Backend/container/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Edit Role
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Role</li>
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
              <h3 class="box-title"> Add Role</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <form action="<?php echo base_url('Admin/Role/update/'.$role['id']);?>" method="post">
                    <div class="row">
                           <div class="col-md-6">
                                <label for="name">Name</label>
                                <input id="name" name="name" type="text" class="form-control" value="<?= $role['name'];?>" placeholder="name">
                            </div>
                           <div class="col-md-6">
                              <label for="description">Description</label>
                              <textarea class="form-control" name="description" id="description" cols="10" rows="2"> <?= $role['description'];?></textarea>
                           </div>
                    </div>
                    <br>
                    <button class="btn btn-primary pull-right">Update</button>
                </form>
            </div>
              <!-- /.box-body -->
          </div>
      </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('Backend/alert-modal'); ?>
<?php $this->load->view('Backend/container/right-sidebar'); ?>
<?php $this->load->view('Backend/container/footer'); ?>
