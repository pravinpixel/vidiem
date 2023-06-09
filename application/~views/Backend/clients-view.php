<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Clients
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Clients</li>
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
              <h3 class="box-title">View Clients</h3>
                <form method="get" action="<?= @$tmp_url; ?>">
              <div class="input-group margin col-sm-3 pull-right">
                <input type="text" class="form-control" value="<?= @$search; ?>" name="search">
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-info btn-flat">Search..</button>
                    </span>
               <a href="<?= base_url('Admin/clients/export/'.@(empty($search)?'1':$search).'/'.@$c_status); ?>" class="btn btn-primary pull-right" target="_blank">Export</a> 
              </div>
                 </form>   
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped" data-page-type="100">
                <thead>
                  <tr>
                  <td colspan="10" class="text-right"><?php echo @$pagination; ?></td>
                </tr>
                <tr>
                  <th>S.No</th>
                  <th>Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Options</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($DataResult)){
                  foreach ($DataResult as $info) { $x++; ?>
                <tr>
                  <td class="col-xs-1"><?= $x; ?></td>
                  <td><?= $info['name']; ?></td>
                  <td><?= $info['mobile_no']; ?></td>
                  <td><?= $info['email']; ?></td>
                  <td><?php if($info['status']==1){ ?>
                     <span class="label label-success status-span">Active</span>
                     <?php }elseif($info['status']==2){ ?>
                     <span class="label label-warning status-span">Inactive</span>
                  <?php } ?></td>
                  <td><?= $info['created']; ?></td>
                  <td>
                    <?php if($info['status']==1){ ?>
                    <a href="<?php echo base_url('Admin/clients/status/'.$info['id'].'/2'); ?>" class="btn btn-info" data-toggle="tooltip" data-placement="top"  data-original-title="Inactive"><span class="fa fa-lock"></span></a>                     
                    <?php }elseif($info['status']==2) { ?>
                    <a href="<?php echo base_url('Admin/clients/status/'.$info['id'].'/1'); ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="top"  data-original-title="Active"><span class="fa fa-unlock"></span></a> 
                    <?php } ?>
                  </td>
                </tr>
                <?php   }?>
                <tr>
                  <td colspan="10" class="text-right"><?php echo @$pagination; ?></td>
                </tr>
               <?php }else { ?>
                <tr>
                  <td colspan="10">No Data Available...</td>
                </tr>
                <?php } ?>
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

  <!-- Client Status Update Modal -->
    <div class="modal fade" id="clientStatus">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Client Remarks</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" action="">
                  <input type="hidden" class="client_status_id">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="inputClinetId">Client Id</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control client_status_code" id="inputClinetId" disabled="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="inputClientName">Client Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control client_status_name" id="inputClientName" disabled="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="inputRemarks">Remarks:</label>
                    <div class="col-sm-9"> 
                      <textarea name="" id="inputRemarks" cols="30" rows="4" class="form-control client_status_remarks"></textarea>
                    </div>
                  </div>
                  <div class="form-group"> 
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary remark-status">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
<?php include_once('container/right-sidebar.php'); ?>
<?php include_once('container/footer.php'); ?>