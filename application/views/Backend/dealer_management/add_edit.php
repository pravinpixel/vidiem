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
        Dealer Management        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/dealer_management'); ?>"> Dealer Management </a></li>
        <li class="active">Add</li>
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
              <h3 class="box-title">Add Dealer Management</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="text-center">
                <?php echo validation_errors(); ?>
            </div>

            <form class="form-horizontal" enctype="multipart/form-data" id="dealer_form" action="<?= base_url(); ?>Admin/dealer_management/save" name="dealer_form" method="post">
                <div class="box-body">
                    <input type="hidden" name="id" value="<?= $info->id ?? '' ?>">
                    <div class="form-group">
                        <label for="dealer_erp_code" class="col-sm-2 control-label">
                            Dealer Code
                            <span class="red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-10">
                            <input type="text" class="form-control" id="dealer_erp_code" required name="dealer_erp_code"
                                value="<?= set_value('dealer_erp_code',@$info->dealer_erp_code); ?>">
                            <?= form_error('dealer_erp_code'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vidiem_erp_code" class="col-sm-2 control-label">
                            Sap Code
                            <span class="red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-10">
                            <input type="text" class="form-control" required id="vidiem_erp_code" name="vidiem_erp_code"
                                value="<?= set_value('vidiem_erp_code',@$info->vidiem_erp_code); ?>">
                            <?= form_error('vidiem_erp_code'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="location_code" class="col-sm-2 control-label">
                            Location Code
                            <span class="red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-10">
                            <input type="text" class="form-control" required id="location_code" name="location_code"
                                value="<?= set_value('location_code',@$info->location_code); ?>">
                            <?= form_error('location_code'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="display_name" class="col-sm-2 control-label">
                            Display Name
                            <span class="red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-10">
                            <input type="text" class="form-control" required id="display_name" name="display_name"
                                value="<?= set_value('display_name',@$info->display_name); ?>">
                            <?= form_error('display_name'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="logo" class="col-sm-2 control-label">
                            Dealers Logo
                            <span class="red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-10">
                            <?php 
                            $required = 'required';
                            if( isset( $info->image ) && !empty( $info->image ) ) {
                                $required = '';
                            }
                            ?>
                            <input type="file" name="logo" id="logo" class="form-control" <?= $required ?>>
                            <?php 
                            if( isset( $info->image ) && !empty( $info->image ) ) {
                            ?>
                            <div style="float:right">
                                <img src="<?= base_url()?>uploads/dealer/<?= $info->image ?>" alt="dealer image" width="200">
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php 
                        $selectedPay = [];
                        if( isset( $info->payment_option ) && !empty( $info->payment_option ) ) {
                            $selectedPay = explode(',', $info->payment_option);
                        }
                        
                    ?>
                    <div class="form-group">
                        <label for="payment_options" class="col-sm-2 control-label">
                            Payment Options
                            <span class="red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-10">
                            <input type="checkbox" name="payment_option[]" id="payment_option_online" value="online" <?php if(in_array('online', $selectedPay) ){echo 'checked';} ?>>
                            <label for="payment_option_online" role="button" class="" style="padding-right: 5px;"> Online </label>
                            
                            <input type="checkbox" name="payment_option[]" class="mx-3" id="payment_option_counter" value="counter_pay" <?php if(in_array('counter_pay', $selectedPay) ){echo 'checked';} ?>>
                            <label for="payment_option_counter" role="button"> Counter Pay </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contact_person" class="col-sm-2 control-label">
                            Contact Person Name
                            <span class="red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-10">
                            <input type="text" class="form-control" required id="contact_person" name="contact_person"
                                value="<?= set_value('contact_person',@$info->contact_person); ?>">
                            <?= form_error('contact_person'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="col-sm-2 control-label">
                            Phone No
                            <span class="red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-10">
                            <input type="text" class="form-control" required id="phone" name="phone"
                                value="<?= set_value('phone',@$info->phone); ?>">
                            <?= form_error('phone'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">
                            Email /LoginId
                            <span class="red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-10">
                            <input type="email" class="form-control" required id="email" name="email"
                                value="<?= set_value('email',@$info->email); ?>">
                            <?= form_error('email'); ?>
                        </div>
                    </div>
                    <?php 
                    
                        $sale_display            = 'none';
                        $sale_input_display      = 'block';
                        if( isset( $info->password ) && !empty( $info->password ) ) {
                            $sale_display        = 'block';
                            $sale_input_display  = 'none';
                        }
                    ?>
                    <div class="form-group" id="sale_reset_pane" style="text-align:center;display:<?= $sale_display ?>">
                        <a href="javascript:void(0);" id="sale_reset_btn" > Reset Password </a>
                    </div>

                    <div class="form-group" id="sale_input_display" style="display: <?= $sale_input_display ?>;">
                        <label for="email" class="col-sm-2 control-label">
                            Password
                            <span class="red">*</span>
                        </label>
                        <div class="col-md-6 col-sm-10">
                            <input type="password" class="form-control" required id="password" name="password"
                                value="<?= set_value('password'); ?>">
                            <span toggle="#password" role="button" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            <?= form_error('password'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label">Address<span
                                class="red">*</span></label>
                        <div class="col-md-6 col-sm-10">
                            <textarea id="address" name="address" required class="form-control" row="5"
                                col="17"><?= set_value('address',@$info->address); ?></textarea>
                            <?= form_error('address'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="area" class="col-sm-2 control-label"> Area </label>
                        <div class="col-md-6 col-sm-10">
                            <textarea id="area" name="area" class="form-control" row="5"
                                col="17"><?= set_value('area',@$info->area); ?></textarea>
                            <?= form_error('area'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="state" class="col-sm-2 control-label" >State *</label>
                        <div class="col-md-6 col-sm-10">
                            <input type="text" class="form-control" required id="state" name="state"
                                value="<?= set_value('state',@$info->state); ?>">
                            <?= form_error('state'); ?>
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputCategory" class="col-sm-2 control-label">City *</label>
                        <div class="col-md-6 col-sm-10" id="divcity">
                            <input type="text" class="form-control" required id="city" name="city"
                                value="<?= set_value('city',@$info->city); ?>">
                            <?= form_error('city'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="district" class="col-sm-2 control-label">District *</label>
                        <div class="col-md-6 col-sm-10" id="divcity">
                            <input type="text" class="form-control" required id="district" name="district"
                                value="<?= set_value('district',@$info->district); ?>">
                            <?= form_error('district'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="post_code" class="col-sm-2 control-label">Post Code</label>
                        <div class="col-md-6 col-sm-10" id="divcity">
                            <input type="text" class="form-control"  id="post_code" name="post_code"
                                value="<?= set_value('post_code',@$info->post_code); ?>">
                            <?= form_error('post_code'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gstin_no" class="col-sm-2 control-label">GSTIN</label>
                        <div class="col-md-6 col-sm-10" id="divcity">
                            <input type="text" class="form-control"  id="gstin_no" name="gstin_no"
                                value="<?= set_value('gstin_no',@$info->gstin_no); ?>">
                            <?= form_error('gstin_no'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bank_name" class="col-sm-2 control-label">Bank</label>
                        <div class="col-md-6 col-sm-10" id="divcity">
                            <input type="text" class="form-control"  id="bank_name" name="bank_name"
                                value="<?= set_value('bank_name',@$info->bank_name); ?>">
                            <?= form_error('bank_name'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bank_ac_no" class="col-sm-2 control-label">Bank Ac No</label>
                        <div class="col-md-6 col-sm-10" id="divcity">
                            <input type="text" class="form-control"  id="bank_ac_no" name="bank_ac_no"
                                value="<?= set_value('bank_ac_no',@$info->bank_ac_no); ?>">
                            <?= form_error('bank_ac_no'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ifsc_code" class="col-sm-2 control-label">IFSC Code</label>
                        <div class="col-md-6 col-sm-10" id="divcity">
                            <input type="text" class="form-control"  id="ifsc_code" name="ifsc_code"
                                value="<?= set_value('ifsc_code',@$info->ifsc_code); ?>">
                            <?= form_error('ifsc_code'); ?>
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