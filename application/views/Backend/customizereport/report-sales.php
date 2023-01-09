<?php $this->load->view('Backend/container/header'); ?>
<?php $this->load->view('Backend/container/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sales Report
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Sales Report</li>
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
     <?php $order_status=$this->ProjectModel->OrderStatus(); ?>
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">View Sales Report</h3>
              <div class="pull-right">
                <a href="javascript:void(0);" class="btn btn-success" data-toggle="modal" data-target="#clientStatus"> <i class="fa fa-filter"></i> Filter</a>  
                <a href="<?= base_url('Admin/CustomReport/sales_report_export/'.@$data_string); ?>" class="btn btn-primary"> <i class="fa fa-download"></i> Export</a>
              </div>
            </div>
            <!-- /.box-header -->
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
                  <th>Notes</th>
                  <th>Created</th>
                  <th>Options</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($DataResult)){
                  $x=1; $sub_total=0; $discount=0; $tax=0; $amount=0;
                  foreach ($DataResult as $info) { ?>
               <tr>
                  <td class="col-xs-1"><?= $x; ?></td>
                  <td><?= $info['inv_code']; ?></td>
                  <td><?= $info['delivery_name']; ?></td>
                  <td><?= $info['delivery_mobile_no']; ?></td>
                  <td><?= $info['delivery_emailid']; ?></td>
                  <td><?= $info['payment_source']; ?></td>
                  <td><?= $info['pg_type']; ?></td>
                  <td><?= $info['bank_ref_num']; ?></td>
                  <td><?= $info['coupon']; ?></td>
                  <td><?= $info['sub_total']; ?></td>
                  <td><?= $info['tax']; ?></td>
                  <td><?= $info['discount']; ?></td>
                  <td><?= $info['amount']; ?></td>
                  <td><?= $order_status[$info['status']]; ?></td>
                  <td><?= $info['notes']; ?></td>
                  <td><?= $info['created']; ?></td>
                  <td>
                      <a href="javascript:void(0);" class="btn bg-navy order_view_trigger" data-id="<?= $info['id']; ?>" data-toggle="tooltip" data-placement="top"  data-original-title="view"><span class="fa fa-eye"></span></a>
                  </td>
                </tr>
                <?php  $x++; $sub_total+=$info['sub_total']; 
                $discount+=$info['discount'];
                $tax+=$info['tax'];
                $amount+=$info['amount'];
              }
                }else { ?>
                <tr>
                  <td colspan="16">No Data Available...</td>
                </tr>
                <?php } ?>
                </tbody>
                <?php if(!empty($DataResult)){ ?>
                <tfoot>
                    <tr>
                  <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                  <td><?= number_format($sub_total,2); ?></td>
                  <td><?= number_format($tax,2); ?></td>
                  <td><?= number_format($discount,2); ?></td>
                  <td><?= number_format($amount,2); ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                </tfoot>
                <?php } ?>
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
                <h4 class="modal-title">Payment Filters</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" action="<?= base_url('Admin/CustomReport/sales_report'); ?>"  method="POST">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="inputDate">Date Range</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control daterangepicker1" id="inputDate" name="date" value="04/14/2018">
                    </div>
                  </div>

                  <div class="form-group">
                  <label for="inputPaymentType" class="col-sm-3 control-label">Payment Type</label>
                  <div class="col-sm-9">
                    <select name="status" id="inputPaymentType" class="form-control">
                        <option value="">All</option>
                        <option value="1" <?= set_select('status','1'); ?>>New Order</option>
                        <option value="2" <?= set_select('status','2'); ?>>Shipped Order</option>
                        <option value="3" <?= set_select('status','3'); ?>>Delivered Order</option>
                    </select>
                    <?= form_error('status'); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPaymentType" class="col-sm-3 control-label">User</label>
                  <div class="col-sm-9">
                    <select name="reportuser" id="inputuser" class="form-control">
                        <option value="">All</option>
                        <?php 
                            if(!empty($DataResult)){
                              foreach($DataResult as $info){ ?>                 
                                <option value="<?= $info['client_id']; ?>"><?= $info['name']; ?></option>
                        <?php } } ?>
                    </select>
                    <?= form_error('reportuser'); ?>
                  </div>
                </div>
                
                  <div class="form-group"> 
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary">Submit</button>
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
<?php $this->load->view('Backend/container/right-sidebar'); ?>
<?php $this->load->view('Backend/container/footer'); ?>