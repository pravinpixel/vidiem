<?php $this->load->view('Backend/dealers/layouts/header') ?>
<?php $this->load->view('Backend/dealers/layouts/sidebar') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Sale Report Dashboard</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <?php if( !empty( $this->session->flashdata('msg') ) ) { ?>
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
                        <h3 class="box-title">Sale Report Dashboard</h3>
                        <div class="pull-right">
                            <a href="javascript:void(0);" class="btn btn-success" data-toggle="modal"
                                data-target="#clientStatus"> <i class="fa fa-filter"></i> Filter</a>
                            <!-- <a href="<?= base_url('Admin/report/sales_report_export/'.@$data_string); ?>"
                                class="btn btn-primary"> <i class="fa fa-download"></i> Export</a> -->
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
                                    <th>Category</th>
                                    <th>Model Name</th>
                                    <th>Customer Info</th>
                                    <th>Amount Paid</th>
                                    <th>Pay Mode</th>
                                    <th>Payment Id</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                global $order_status_name;
                               
                                if( isset( $orders ) && !empty( $orders ) ) {
                                    foreach ($orders as $items ) {

                                      
                                        $showItems = current($items->items);
                                  
                                ?>
                                <tr>
                                    <td><?= $items->id ?></td>
                                    <td><?= date( 'd-M-Y H:i A', strtotime($items->created)) ?></td>
                                    <td><?= $items->inv_code ?? $items->order_no ?></td>
                                    <td><?= $items->location_name ?></td>
                                    <td><?= $items->location_code ?></td>
                                    <!-- <td><?= $items->code ?></td> -->
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

                                    <?php 
                                        // show($items->status);
                                    if( isset( $items->payment_status ) && $items->payment_status == 'success' ) {
                                    echo '<a href="javascript:void(0)" class="label label-success"> Paid </a>';
                                    } else {
                                    echo '<a href="javascript:void(0)" class="label label-warning"> Pending </a>';
                                    }
                                    if( $items->payment_source == 'counter' && $items->status == 1 && $items->payment_status != 'success'  ) {
                                        echo '<br><a href="javascript:void(0)" class="label label-primary"> Showing Interest </a> ';
                                    } else {
                                    ?>
                                        <a href="javascript:void(0)" class="label label-<?= $items->status == 4 ? 'danger' : ($items->status == 3 ? 'success' : 'info' ) ?>"> <?= $order_status_name[(int)$items->status] ?></a> 
                                    <?php } ?>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <div style="margin:10px;">
                                            <a href="javascript:void(0);" class="btn bg-navy dealer_custom_order_view_trigger col-sm-12" data-id="<?= $items->id; ?>" data-toggle="tooltip" data-placement="top"  data-original-title="view" style="margin: 3px">
                                                View Orders
                                            </a>
                                        <?php 
                                            if( isset( $items->status ) && $items->status != 4 ) {

                                                ?>
                                            <a href="<?= base_url() ?>dealer-admin/payment/update/<?= $items->id ?>" class="btn btn-success col-sm-12" data-toggle="tooltip"
                                                data-placement="top" data-original-title="Update Payment"
                                                style="margin: 3px">
                                                Update Payment
                                            </a>
                                        <?php         
                                                if( isset( $items->payment_status ) && $items->payment_status == 'success' ) {
                                                } else {
                                        
                                        ?>
                                                <a href="javascript:;" class="btn btn-danger col-sm-12" data-toggle="tooltip" data-placement="top" data-original-title="Cancel Order" style="margin: 3px" onclick="return cancelDealerOrder('<?= $items->id ?>')">
                                                Cancel Order
                                                </a>
                                            <?php 
                                            }
                                            ?>
                                           
                                            <?php } else { 
                                            ?>
                                            <!-- <a href="javascript:void(0)" class="btn btn-danger col-sm-12"> Cancelled </a> -->
                                            <?php } ?>

                                            
                                            
                                        </div>
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
        <?= $this->load->view('Backend/dealers/dashboard/_filter_modal', '', TRUE) ?>
        <?= $this->load->view('Backend/dealers/dashboard/_cancel_modal', '',TRUE) ?>
        
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- ./wrapper -->
<?php $this->load->view('Backend/dealers/layouts/footer') ?>
<script>
  $('#manageDealer').dataTable({
    "pageLength": 50,
    aaSorting: [[0, 'desc']]
  });

  function cancelDealerOrder( orderId ) {
    $('#cancelForm')[0].reset();
    $('#cancelModal').modal('show');
    $('#order_id').val(orderId);
  }

  $('#order_cancel').click(function(){

      var cancel_reason   = $('#cancel_reason').val();
      var order_id        = $('#order_id').val();

      if( cancel_reason == '' || cancel_reason == null || cancel_reason == undefined ){
        $('#cancel_reason').focus();
        toastr.error('Error', 'Cancel reason is required');
        return false;
      }

      $.ajax({
        url: '<?= base_url()?>dealer-admin/cancel_order',
        data:{cancel_reason:cancel_reason, order_id:order_id},
        type:'POST',
        dataType: 'json',
        beforeSend:function() {
            $('#order_cancel').html( "Submitting..");
            $('#order_cancel').attr('disabled', true);
        },
        success:function(res){

          $('#order_cancel').html( "Cancel Order");
          $('#order_cancel').attr('disabled', false);
          
          if( res.error == 1 ) {
            toastr.success('Success', 'Order Cancelled successfully');
            setTimeout(() => {
              location.reload();
            }, 500);
          }

        } 
      })

  });
</script>