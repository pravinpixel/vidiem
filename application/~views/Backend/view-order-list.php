<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product Wise View Orders
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Product Wise View Orders</li>
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
              <h3 class="box-title">Product Wise View Orders</h3>
            </div>
            <!-- /.box-header -->
            <?php $order_status=$this->ProjectModel->OrderStatus(); ?>
            <!-- form start -->
            <div class="box-body table-responsive">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-sm-3" for="inputDate">Date Range</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control daterangepicker1" id="inputDate" name="date">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="button" class="btn btn-info" value="Submit" id="submitFilter">
                  <a href="javascript:void(0);" class="btn btn-success view-order-export-list">Export <span class="fa fa-download"></span></a> 
                </div>
   
              </div>
            </div>
            <div class="box-body table-responsive">
              <table id="viewOrderTable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Sl No</th>
                    <th>Month</th>
                    <th>Date</th>
                    <th>E-shop Inovice</th>
                    <th>E-shop Invoice Date</th>
                    <th>To Delivery Name</th>
                    <th>Delivery Address</th>
                    <th>Delivery Mobile</th>
                    <th>Delivery Mail-ID</th>
                    <th>Delivery City</th>
                    <th>Delivery State</th>
                    <th>Delivery Pin</th>
                    <th>Category</th>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Bank Reference No</th>
                    <!-- <th>Action</th> -->
                  </tr>
                </thead>
                <tbody>
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