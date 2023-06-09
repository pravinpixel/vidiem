<?php $this->load->view('Backend/container/header'); ?>
<?php $this->load->view('Backend/container/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Role List
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Role List</li>
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
              <h3 class="box-title"> Role List</h3>
               <div class="pull-right">
                 <a href="<?php echo base_url('Admin/Role/create');?>" class="btn btn-success">Add Role <span class=""></span></a> 
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body table-responsive">
              <table id="roleTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Description</th>
                    <!-- <th> Status </th> -->
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    if(count($DataResult) > 0) {
                        foreach( $DataResult as $key => $row ) {?>
                            <tr>
                                <td> <?= $key+1; ?> </td>
                                <td> <?= $row['name']; ?> </td>
                                <td> <?= $row['description']; ?> </td>
                                <!-- <td> <?= ($row['status'] == 1) ? '<span class="label label-success status-span">Active</span>' : '<span class="label label-info status-span">Inactive</span>'; ?> </td> -->
                                <td> 
                                
                                    <a href="<?php echo base_url('Admin/Role/edit/'.$row['id']);?>" class="btn btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Edit">  <span class="fa fa-pencil"></span></a>
                                    <a href="<?php echo base_url('Admin/Permission/index/'.$row['id']);?>" class="btn btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Permission"><span class="fa fa-lock"></span></a>
                                    <a href="javascript:void(0);" data-url="<?php echo base_url('Admin/Role/delete/'.$row['id']);?>" class="btn btn-danger delete_trigger" data-toggle="tooltip" data-placement="right" data-original-title="Delete">
                                      <span class="fa fa-trash"></span>
                                    </a>
                                </td>
                            </tr>
                    <?php }
                    }?>
                </tbody>
              </table>
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
