<?php $this->load->view('Backend/container/header','',null); ?>
<?php $this->load->view('Backend/container/sidebar', '', null); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <style>
        .field-icon {
            float: right;
            margin-left: -25px;
            margin-top: -25px;
            margin-right:5px;
            position: relative;
            z-index: 2;
            
        }
    </style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        ARD / Sub Dealer Service Charge        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/dealer_management'); ?>">   ARD / Sub Dealer  Service Charge </a></li>
        <li class="active">Edit</li>
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
              <h3 class="box-title">ARD / Sub Dealer Charge edit</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="text-center">
                <?php echo validation_errors(); ?>
            </div>
       
            <form class="form-horizontal" enctype="multipart/form-data" id="dealer_form" action="<?= base_url(); ?>Admin/dealer_management/save_ard" name="dealer_form" method="post">
                <div class="box-body">
                    <input type="hidden" name="id" value="<?= $info->id ?? '' ?>">
                    
                    <div class="form-group">
                        <label for="ard_service_charge" class="col-sm-2 control-label">
                        For ARD
                            <span class="red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-10">
                            <select name="dealer_type" id="dealer_type" class="form-control" required>
                                <option value="">Select Dealer Type</option>
                                <option  <?php if($info->dealer_type =='ard')
                                    { echo 'selected'; }?> value="ard">ARD</option>
                                <option  <?php if($info->dealer_type=='sub_dealer')
                                    { echo 'selected'; }?>  value="sub_dealer">Sub Dealer</option>
                            </select>
                            <?= form_error('dealer_type'); ?>
                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="service_charge" class="col-sm-2 control-label">
                        Service Charge
                            <span class="red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-10">
                            <input type="text" class="form-control" required id="service_charge" name="service_charge"
                                value="<?= set_value('service_charge',@$info->service_charge); ?>">
                            <?= form_error('service_charge'); ?>
                        </div>
                    </div>                   

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"></label>
                        <div class="col-md-6 col-sm-10">
                            <button type="submit" id="dealer-submit" class="btn btn-success col-sm-3" style="margin-right:10px;">
                                <?php echo $action_btn; ?>
                            </button>

                            <input type="reset" class="btn  col-sm-3 reset" id="reset" value="Reset" />
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
            </form>
          </div>
      </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('Backend/container/right-sidebar', '', null); ?>
<?php $this->load->view('Backend/container/footer', '', null); ?>

<script>
    
$(document).ready(function() {
    $('#dealer_form').validate({
        submitHandler: function (form) {
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>dealers/dealers/save",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#dealer-submit').attr('disabled', true);
                },
                success: function (res) {
                    $('#dealer-submit').attr('disabled', false);
                    
                    if( res.status == 1 ) {
                       
                    } else {
                        toastr.error('Error', res.message);
                    }
                }
            });
            return false; // required to block normal submit since you used ajax
        }
    });
});

$(".toggle-password").click(function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});


$('#sale_reset_btn').click(function(){
    $('#sale_reset_pane').hide();
    $('#sale_input_display').show();
});

</script>