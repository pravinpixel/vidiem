<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View Orders
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View Orders</li>
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
              <h3 class="box-title">View Orders</h3>
            </div>
            <!-- /.box-header -->
            <?php $order_status=$this->ProjectModel->OrderStatus(); ?>
            <!-- form start -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.No</th>
                  <th>Inv Code</th>
                  <th>Clinet Name</th>
                  <th>Mobile No</th>
                  <th>Email</th>
                  <th>Payment Source</th>
                  <th>Payment Type</th>
                  <th>BankRef. No.</th>
                  <th>Coupon</th>
                  <th>Amount</th>
                  <th>Gst</th>
                  <th>Discount</th>
                  <th>Net Amount</th>
                  <th>Order Status</th>
                  <th>Delivered Date</th>
                  <th>Notes</th>
                  <th>Created</th>
                  <th>Invoice</th>
                  <th>Options</th>
                  <th>Cancel</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($DataResult)){
                  $x=1;
                  foreach ($DataResult as $info) { ?>
                <tr>
                  <td class="col-xs-1"><?= $x; ?></td>
                  <td><?= $info['inv_code']; ?></td>
                  <td><?= $info['name']; ?></td>
                  <td><?= $info['mobile_no']; ?></td>
                  <td><?= $info['email']; ?></td>
                  <td><?= $info['payment_source']; ?></td>
                  <td><?= $info['pg_type']; ?></td>
                  <td><?= $info['bank_ref_num']; ?></td>
                  <td><?= $info['coupon']; ?></td>
                  <td><?= $info['sub_total']; ?></td>
                  <td><?= $info['tax']; ?></td>
                  <td><?= $info['discount']; ?></td>
                  <td><?= $info['amount']; ?></td>
                  <td><?= $order_status[$info['status']]; ?></td>
                  <td><?= ($info['status']==3)?$info['delivered_at']:''; ?></td>
                  <td><?= $info['notes']; ?></td>
                  <td><?= $info['created']; ?></td>
                  <td><a href="<?= base_url('Admin/orders/invoice/'.$info['id']); ?>" class="btn bg-aqua" data-toggle="tooltip" data-placement="top"  data-original-title="Invoice"><span class="fa fa-download"></span></a></td>
                  <td>
                      <a href="javascript:void(0);" class="btn bg-navy order_view_trigger" data-id="<?= $info['id']; ?>" data-toggle="tooltip" data-placement="top"  data-original-title="view"><span class="fa fa-eye"></span></a>
                      <a href="javascript:void(0);" class="btn bg-green trigger_order_status" data-toggle="modal" data-target="#feature" data-id="<?= $info['id']?>"><span class="fa fa-cogs"></span></a></td>
                    <td>
                      <a href="javascript:void(0);" class="btn btn-danger order_cacel_trigger" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-url="<?= base_url('Admin/orders/orderCancel/'.$info['id']);?>">
                    <span class="fa fa-times"></span></a>
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
  </div>
  <!-- /.content-wrapper -->

  <!-- Client Status Update Modal -->
    <div class="modal fade" id="feature">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Order Status</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" action="">
                  <input type="hidden" class="order_id" value="1">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="inputClinetId">Inv Code</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control order_code" id="inputClinetId" disabled="">
                    </div>
                  </div>

                   <div class="form-group">
                    <label class="control-label col-sm-3" for="inputClientStatus">Order Status</label>
                    <div class="col-sm-9">
                      <select id="inputClientStatus" class="form-control order_status">
                        <option value="1">New Order</option>
                        <option value="5">Order in Process</option>
                        <option value="2">Order Shipped</option>
                        <option value="3">Order Delivered</option>
                      </select>
                    </div>
                  </div>
                  <?php $Courier=$this->ProjectModel->Courier(); ?>
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="inputClientStatus">Courier</label>
                    <div class="col-sm-9">
                      <select id="inputClientStatus" class="form-control order_courier">
                          <option value="">Select Partner..</option>
                          <?php if(!empty($Courier)){ 
                            foreach ($Courier as $key => $info) { ?>
                              <option value="<?= $key; ?>"><?= $info; ?></option>
                          <?php }} ?>
                      </select>
                      <p class="courier_error error"></p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3" for="inputClientName">Tracking Id</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control order_tracking_id" id="inputClientName">
                      <p class="tracking_error error"></p>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="inputRemarks">Notes:</label>
                    <div class="col-sm-9"> 
                      <textarea name="" id="inputRemarks" cols="30" rows="4" class="form-control order_notes"></textarea>
                    </div>
                  </div>
                  <div class="form-group"> 
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary update-order-status">Submit</button>
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