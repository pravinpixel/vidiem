
<?php $this->load->view('Backend/dealers/layouts/header') ?>
<?php $this->load->view('Backend/dealers/layouts/sidebar') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) --> 
    <section class="content-header">
        <h1>
            Update Counter Payment Information
            <small>Dealer Sale Payment</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Update Counter Payment Information</li>
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
            <div class="col-sm-5">
                <?= $this->load->view('Backend/dealers/form/_form', '', TRUE)?>
            </div>
           
            <div class="col-sm-7">
                <?= $this->load->view('Backend/dealers/_item_info', '', TRUE) ?>
            </div>
        </div>
       
    </section>
    <?= $this->load->view('Backend/dealers/dashboard/_cancel_modal', '', TRUE) ?>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- ./wrapper -->
<?php $this->load->view('Backend/dealers/layouts/footer') ?>
<script>


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

$(document).ready(function() {                 
    $("#counter_form").validate({
        rules:{
            receipt_no:{
                required: true,
            },
           
        },
        messages:{
            receipt_no:{
                required: "This Receipt No is required",
            },
           
        },
        submitHandler: function(form) { 

            var formData = new FormData(form);    

            $.ajax({
                url:'<?= base_url() ?>dealer-admin/do_counter_payment',
                type:'POST',
                processData: false,
                contentType: false,
                data: formData,
                dataType: 'json',
                beforeSend: function() {
                    $('#pay-submit').html('Processing...');
                    $('#pay-submit').attr('disabled', true );
                },
                success: function(res) {
                    $('#pay-submit').html('Pay');
                    $('#pay-submit').attr('disabled', false );
                    if( res.status == 1 ) {
                        setTimeout(() => {
                            window.location.href='<?= base_url() ?>dealer-admin';
                        }, 500);
                    } else {
                        toastr.error('Error', res.error_message);
                    }
                }
            });
            return false; 
            // required to block normal submit since you used ajax
        }
    });
});

</script>