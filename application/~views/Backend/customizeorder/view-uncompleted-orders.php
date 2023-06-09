<?php $this->load->view('Backend/container/header'); ?>
<?php $this->load->view('Backend/container/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View Un Completed Orders
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View Un Completed Orders</li>
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
              <h3 class="box-title">View Un Completed Orders</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.No</th>
                  <th>Booking Code</th>
                  <th>Clinet Name</th>
                  <th>Mobile No</th>
                  <th>Email</th>
                  <th>Amount</th>
                  <th>Created</th>
                  <th>Options</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($DataResult)){
                  $x=1;
                  foreach ($DataResult as $info) { ?>
                <tr>
                  <td class="col-xs-1"><?= $x; ?></td>
                  <td><?= $info['code']; ?></td>
                  <td><?= $info['name']; ?></td>
                  <td><?= $info['mobile_no']; ?></td>
                  <td><?= $info['email']; ?></td>
                  <td><?= $info['amount']; ?></td>
                  <td><?= $info['created']; ?></td>
                  <td>
                  <a href="#" class="btn bg-green customize_uncompleted_order" data-toggle="modal" data-target="#customizeuncompleted-order" data-id="<?= $info['id']; ?>" ><span class="fa fa-cogs"></span></a>
                      <a href="javascript:void(0);" class="btn bg-navy booking_view_trigger" data-id="<?= $info['id']; ?>" data-toggle="tooltip" data-placement="top"  data-original-title="view"><span class="fa fa-eye"></span></a>
                  </td>
                </tr>
                <?php  $x++; }
                }else { ?>
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
       <!-- modal  -->
       <div class="modal fade" id="customizeuncompleted-order">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Order Status</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="inputClientStatus">Invoice No</label>
                        <input type="hidden" name="customize_uncompleted_order_id" id="customize_uncompleted_order_id">
                        <div class="col-sm-9">
                            <input type="text" name="invoice_no" id="invoice_no"  class="form-control invoice_no">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="inputClientStatus">Order Reference No</label>
                       
                        <div class="col-sm-9">
                        <input type="text" name="order_ref_no" id="order_ref_no"  class="form-control order_no">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="inputClientStatus">Bank Reference No</label>
                       
                        <div class="col-sm-9">
                        <input type="text" name="bank_ref_no" id="bank_ref_no"  class="form-control bank_ref_no">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="inputClientStatus">Order Status</label>
                       
                        <div class="col-sm-9">
                            <select id="order_status_id" class="form-control order_status">
							                <option value="">Select</option>
                              <option value="1">Payment Received</option>
                            </select>
                        </div>
                      </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="pull-right"> 
                      <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary update_customize_uncompleted_order_status">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal  end -->
  </div>
  <!-- /.content-wrapper -->


<?php include_once(__DIR__.'/../container/right-sidebar.php'); ?>
<?php include_once(__DIR__.'/../container/footer.php'); ?>
