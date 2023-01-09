<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Course Failure Booking
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Course Failure Booking</li>
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
              <h3 class="box-title">View Course Failure Booking</h3>
                <form method="get" action="<?= @$tmp_url; ?>">
              <div class="input-group margin col-sm-3 pull-right">
                <input type="text" class="form-control" value="<?= @$search; ?>" name="search">
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-info btn-flat">Search..</button>
                    </span>
               <a href="<?= base_url('Admin/booking/export/'.$tmp_title.'/'.@$search); ?>" class="btn btn-primary pull-right" target="_blank">Export</a> 
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
                  <th>Booking Code</th>
                  <th>Client Id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>City</th>
                  <th>Payment Mode</th>
                  <th>Card Name</th>
                  <th>Order Status</th>
                  <th>Status Message</th>
                  <th>Created</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($DataResult)){
                  foreach ($DataResult as $info) { $x++; ?>
                <tr>
                  <td class="col-xs-1"><?= $x; ?></td>
                  <td><?= $info['code']; ?></td>
                  <td><?= $info['client_code']; ?></td>
                  <td><?= $info['name']; ?></td>
                  <td><?= $info['email']; ?></td>
                  <td><?= $info['mobile_no']; ?></td>
                  <td><?= $info['city']; ?></td>
                  <td><?= $info['payment_mode']; ?></td>
                  <td><?= $info['card_name']; ?></td>
                  <td><?= $info['order_status']; ?></td>
                  <td><?= $info['status_message']; ?></td>
                  <td><?= $info['created']; ?></td>
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
<?php include_once('container/right-sidebar.php'); ?>
<?php include_once('container/footer.php'); ?>