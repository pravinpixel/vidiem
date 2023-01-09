<?php $this->load->view('Backend/dealers/layouts/header') ?>
<?php $this->load->view('Backend/dealers/layouts/sidebar') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Report
            <small>Sale Reports</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Report</li>
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
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sale Dealers Report</h3>
                        <div class="pull-right">
                            <a href="javascript:void(0);" class="btn btn-success" data-toggle="modal"
                                data-target="#clientStatus"> <i class="fa fa-filter"></i> Filter</a>
                            <a href="javascript:void(0)" onclick="return exportExcelReport()" class="btn btn-primary"> <i class="fa fa-download"></i> Export </a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body table-responsive">
                        <table id="manageDealer" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Date&Time</th>
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
                                    <td><?= $items->order_no ?></td>
                                    <td><?= $items->location_name ?></td>
                                    <td><?= $items->location_code ?></td>
                                    <td><?= $items->code ?></td>
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
                                </tr>
                                <?php     
                                  }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <?= $this->load->view('Backend/dealers/report/_filter', '', TRUE) ?>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- ./wrapper -->
<?php $this->load->view('Backend/dealers/layouts/footer') ?>
<script>
    $('#manageDealer').dataTable({
        "pageLength": 100,
        aaSorting: [[0, 'desc']]
    });

    function clearFilter() {
        
        $('#inputDate').val('');
        $('#payment_status').val('');
        $('#inputPaymentType').val('');
        $('#export').val('');
        $('#report_filter_form')[0].submit();
    }
    setTimeout(() => {
        var dates   = '<?= $_POST['date'] ?? '' ?>';
        dates       = dates.split('-');
        $('#inputDate').daterangepicker({ startDate: dates[0].trim(), endDate: dates[1].trim() });
        // $('#inputDate').datepicker('setDate', dates);
    }, 200);
    

    function exportExcelReport() {
        $('#export').val('excel');
        $('#report_filter_form')[0].submit();
    }


</script>