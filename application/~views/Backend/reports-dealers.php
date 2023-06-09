<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sales Dealers Report
            <!-- <small>new</small> -->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Sale Dealers Report</li>
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
                            <a href="javascript:void(0);" class="btn btn-success" data-toggle="modal"
                                data-target="#clientStatus"> <i class="fa fa-filter"></i> Filter</a>
                            <a href="javascript:void(0)" onclick="return exportExcelReport()" class="btn btn-primary"> <i class="fa fa-download"></i> Export</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Date&Time</th>
                                    <th>Dealer</th>
                                    <th>Order No</th>
                                    <th>Location</th>
                                    <th>Location Code</th>
                                    <th>Order ID</th>
                                    <th>Category</th>
                                    <th>Model Name</th>
                                    <th>Customer Info</th>
                                    <th>Amount Paid</th>
                                    <th>Pay Mode</th>
                                    <th>Payment Id</th>
                                    <th>Payment Status</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                if( isset( $orders ) && !empty( $orders ) ) {
                    foreach ($orders as $items ) {
                        
                        $showItems = current($items->items);
                        
                ?>
                                <tr>
                                    <td><?= $items->id ?></td>
                                    <td><?= date( 'd-M-Y H:i A', strtotime($items->created)) ?></td>
                                    <td><?= $items->display_name ?></td>
                                    <td><?= $items->order_no ?></td>
                                    <td><?= $items->location_name ?></td>
                                    <td><?= $items->location_code ?></td>
                                    <td><?= $items->inv_code ?></td>
                                    <td><?= $showItems->catname ?? '' ?></td>
                                    <td><?= $showItems->basetitle ?? '' ?></td>
                                    <td>
                                        <div>
                                            <b>
                                                <?= $items->client_name ?? $items->billing_name ?? '' ?>
                                            </b>
                                        </div>
                                        <div>
                                            <b>
                                                <?= $items->client_mobile_no ?? $items->billing_mobile_no ?? '' ?>
                                            </b>
                                        </div>
                                        <div>
                                            <?= $items->billing_address.' '.$items->billing_city.', '.$items->billing_state, ','.$items->billing_zip
                            .' '.$items->billing_country
                            ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?= $items->amount ?>
                                    </td>
                                    <td>
                                        <?= ucfirst( $items->payment_source ?? '' ) ?>
                                    </td>
                                    <td>
                                        <?= $items->pg_type ?? '' ?>
                                    </td>
                                    <td>
                                        <?= ucfirst($items->payment_status ?? '') ?>
                                    </td>
                                    <td>
                                    <a href="javascript:void(0);" class="btn bg-navy custom_order_view_trigger" data-id="<?= $items->id; ?>" data-toggle="tooltip" data-placement="top"  data-original-title="view"><span class="fa fa-eye"></span></a>
                                    </td>
                                </tr>
                                <?php     
                    }
                } else { ?>
                                <tr>
                                    <td colspan="12">No Data Available...</td>
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
                <h4 class="modal-title">Payment Filters</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="report_filter_form" action="<?= base_url('Admin/report/dealer_sales_report'); ?>" method="POST">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="inputDate">Date Range</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control daterangepicker1" id="inputDate" name="date"
                                value="04/14/2018">
                        </div>
                    </div>
                    <input type="hidden" name="export" id="export">
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
<?php include_once('container/right-sidebar.php'); ?>
<?php include_once('container/footer.php'); ?>
<script>
     $('#manageDealer').dataTable({
        "pageLength": 100,
        aaSorting: [[0, 'desc']]
    });

    function exportExcelReport() {
        $('#export').val('excel');
        $('#report_filter_form')[0].submit();
    }


</script>