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
   

    <?php if($dealer_type=='dealer')
            { ?>
   
   <section class="content-header">
        <h1>
            Dealer Branch Location Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url().'Admin/dealer_management/'.$dealer_id.'/location'; ?>"> Dealer Branch Management </a></li>
            <li class="active">Add</li>
        </ol>
    </section>
    <?php } else { ?> 
        <section class="content-header">
        <h1>
            ARD Sub Dealer Management
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url().'Admin/dealer_management/'.$dealer_id.'/location'; ?>"> ARD Sub Location Management </a></li>
            <li class="active">Add</li>
        </ol>
    </section>
<?php 
    }
    ?>
    <?php $states = $this->ProjectModel->states(); ?>
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
                <?php if($dealer_type=='dealer')
            { ?>
   
   <div class="box-header with-border">
                        <h3 class="box-title">Add Dealer Locations</h3>
                    </div>
    <?php } else { ?> 
        <div class="box-header with-border">
                        <h3 class="box-title">Add ARD Dealer Locations</h3>
                    </div>
<?php 
    }
    ?>
                   
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="text-center">
                        <?php echo validation_errors(); ?>
                    </div>

                    <form class="" enctype="multipart/form-data" id="location_form"
                        action="<?= base_url()?>Admin/dealer_management/location_save" name="location_form" method="post">
                        <div class="row box-body">
                            <input type="hidden" name="id" value="<?= $id ?? '' ?>">
                            <input type="hidden" name="dealer_id" value="<?= $dealer_id ?>">
                            <div class="col-sm-6 text-right">
                                <!-- <label>Location Detail</label> -->
                                <div class="form-group">
                                    <label for="location_name" class=" col-sm-4 control-label">
                                        Location Name
                                        <span class="red">*</span>
                                    </label>
                                    <div class="col-sm-8 form-margin-10">
                                        <input type="text" class="form-control" required id="location_name"
                                            name="location_name"
                                            value="<?= set_value('location_name',@$info->location_name); ?>">
                                        <?= form_error('location_name'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="location_code" class=" col-sm-4 control-label">
                                        Location Code
                                        <span class="red">*</span>
                                    </label>
                                    <div class="col-sm-8 form-margin-10">
                                        <input type="text" class="form-control" required id="location_code"
                                            name="location_code"
                                            value="<?= set_value('location_code',@$info->location_code); ?>">
                                        <?= form_error('location_code'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="dealer_erp_code" class=" col-sm-4 control-label">
                                    Dealer ERP Code
                                        <span class="red">*</span>
                                    </label>
                                    <div class="col-sm-8 form-margin-10">
                                        <input type="text" class="form-control" required id="dealer_erp_code"
                                            name="dealer_erp_code"
                                            value="<?= set_value('dealer_erp_code',@$info->dealer_erp_code); ?>">
                                        <?= form_error('dealer_erp_code'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="vidiem_erp_code" class=" col-sm-4 control-label">
                                    Vidiem ERP Code
                                        <span class="red">*</span>
                                    </label>
                                    <div class="col-sm-8 form-margin-10">
                                        <input type="text" class="form-control" required id="vidiem_erp_code"
                                            name="vidiem_erp_code"
                                            value="<?= set_value('vidiem_erp_code',@$info->vidiem_erp_code); ?>">
                                        <?= form_error('vidiem_erp_code'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class=" col-sm-4 control-label">
                                    Email
                                        <span class="red">*</span>
                                    </label>
                                    <div class="col-sm-8 form-margin-10">
                                        <input type="text" class="form-control" required id="email" name="email"
                                            value="<?= set_value('email',@$info->email); ?>">
                                        <?= form_error('email'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mobile_no" class="col-sm-4 control-label">
                                        Mobile No
                                        <span class="red">*</span>
                                    </label>
                                    <div class="col-sm-8 form-margin-10">
                                        <input type="text" class="form-control" required id="mobile_no" name="mobile_no"
                                            value="<?= set_value('mobile_no',@$info->mobile_no); ?>">
                                        <?= form_error('mobile_no'); ?>
                                    </div>
                                </div>
                                <input type="hidden" name="sub_dealer" id="sub_dealer" value="<?php echo $dealer_type; ?>">
                                <?php if($dealer_type=='ard')
                                { ?>                                   

                    <div class="form-group">
                                    <label for="service_charge_id" class="col-sm-4 control-label">  Dealer Service Charge<span
                                            class="red">*</span></label>
                                    <div class="col-sm-8 form-margin-10">
                                    <select name="service_charge_id" id="service_charge_id" class="form-control" required>
                                <option value="">Sub Dealer Service Charge</option>
                                <?php foreach($ard_charge as $ard_charges) {
                                    ?>
                                    <option value="<?php echo $ard_charges['id']; ?>"  <?php if($ard_charges['id']==$info->sub_dealer_service_charge_id){
                                        echo 'selected';
                                    } ?>> <?php echo $ard_charges['service_charge']; ?>% </option>
                                <?php 
                                } ?>
                               
                            </select>
                                    </div>
                                </div>
                                
                                 <div class="form-group">
                                    <label for="logo" class=" col-sm-4 control-label">
                                       Sub Dealer Logo
                                      
                                    </label>
                                    <div class="col-sm-8 form-margin-10">
                                        <input type="file" class="form-control"  id="logo" name="logo"
                                            >
                                        
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="gst_no" class=" col-sm-4 control-label">
                                       GST No
                                        <span class="red">*</span>
                                    </label>
                                    <div class="col-sm-8 form-margin-10">
                                        <input type="text" class="form-control" required id="gst_no" name="gst_no"
                                            value="<?= set_value('gst_no',@$info->sub_dealer_gst_no); ?>">
                                        <?= form_error('gst_no'); ?>
                                    </div>
                                </div>
                              
                              
                              <div class="form-group">
                                    <label for="cin_no" class=" col-sm-4 control-label">
                                       CIN No
                                        <span class="red">*</span>
                                    </label>
                                    <div class="col-sm-8 form-margin-10">
                                        <input type="text" class="form-control" required id="cin_no" name="cin_no"
                                            value="<?= set_value('cin_no',@$info->sub_dealer_cin_no); ?>">
                                        <?= form_error('cin_no'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pan_no" class=" col-sm-4 control-label">
                                        PAN No
                                        <span class="red">*</span>
                                    </label>
                                    <div class="col-sm-8 form-margin-10">
                                        <input type="text" class="form-control" required id="pan_no" name="pan_no"
                                            value="<?= set_value('pan_no',@$info->sub_dealer_pan_no); ?>">
                                        <?= form_error('pan_no'); ?>
                                    </div>
                                </div>

                              

                            <?php }?>
                               
                                <div class="form-group">
                                    <label for="address" class="col-sm-4 control-label">Address<span
                                            class="red">*</span></label>
                                    <div class="col-sm-8 form-margin-10">
                                        <textarea id="address" name="address" required class="form-control" row="5"
                                            col="17"><?= set_value('address',@$info->location_address); ?></textarea>
                                        <?= form_error('address'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="area" class="col-sm-4 control-label"> Area </label>
                                    <div class="col-sm-8 form-margin-10">
                                        <input type="text" class="form-control" id="area" name="area"
                                            value="<?= set_value('area',@$info->area); ?>">
                                        <?= form_error('area'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="state" class="col-sm-4 control-label">State </label>
                                    <div class="col-sm-8 form-margin-10">
                                        <select name="state" id="state" class="form-control">
                                            <option value=""> -select- </option>
                                            <?php if (!empty($states)) {
                                                foreach ($states as $staInfo) {
                                                    $selected = '';
                                                    if( isset( $info->state ) && $info->state == $staInfo ) {
                                                        $selected = 'selected';
                                                    }
                                                    ?>
                                                    <option value="<?= $staInfo; ?>" <?= $selected ?>><?= $staInfo; ?></option>
                                            <?php
                                                }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="city" class="col-sm-4 control-label">City </label>
                                    <div class="col-sm-8 form-margin-10" id="divcity">
                                        <input type="text" class="form-control" id="city" name="city"
                                            value="<?= set_value('city',@$info->city); ?>">
                                        <?= form_error('city'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="district" class="col-sm-4 control-label">District </label>
                                    <div class="col-sm-8 form-margin-10" id="divcity">
                                        <input type="text" class="form-control" id="district" name="district"
                                            value="<?= set_value('district',@$info->district); ?>">
                                        <?= form_error('district'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="post_code" class="col-sm-4 control-label">Post Code </label>
                                    <div class="col-sm-8 form-margin-10" id="divcity">
                                        <input type="text" class="form-control" id="post_code" name="post_code"
                                            value="<?= set_value('post_code',@$info->post_code); ?>">
                                        <?= form_error('post_code'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Sales Promoter Login</div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <input type="hidden" name="sale_user_id"
                                                value="<?= $info->sale_user_id ?? '' ?>">
                                            <label for="s_user_code" class="col-sm-4 control-label">User Code </label>
                                            <div class="col-sm-8 form-margin-10" id="s_user_code_div">
                                                <input type="text" class="form-control" id="s_user_code"
                                                    name="s_user_code"
                                                    value="<?= set_value('s_user_code',@$info->s_user_code); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="s_user_name" class="col-sm-4 control-label">Username / Login Id </label>
                                            <div class="col-sm-8 form-margin-10" id="s_user_name_div">
                                                <input type="text" class="form-control" id="s_user_name"
                                                    name="s_user_name"
                                                    value="<?= set_value('s_user_name',@$info->s_user_name); ?>">
                                            </div>
                                        </div>
                                       
                                        <?php 
                                        $sale_display            = 'none';
                                        $sale_input_display      = 'block';
                                        if( isset( $info->c_password ) && !empty( $info->c_password ) ) {
                                            $sale_display        = 'block';
                                            $sale_input_display  = 'none';
                                        }
                                        ?>
                                         <div class="form-group" id="sale_reset_pane" style="text-align:center;display:<?= $sale_display ?>">
                                            <a href="javascript:void(0);" id="sale_reset_btn" > Reset Password </a>
                                        </div>
                                        <div class="form-group" id="sale_input_display" style="display: <?= $sale_input_display ?>;">
                                            <label for="s_password" class="col-sm-4 control-label">Password </label>
                                            <div class="col-sm-8 form-margin-10" id="s_password_div">
                                                <input type="password" class="form-control"  id="s_password" name="s_password"
                                                    value="">
                                                    <span toggle="#s_password" role="button" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                <?= form_error('s_password'); ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <span>https://www.vidiem.in/vidiem-dealer/qrlogin?userid=<?= @$info->s_user_name ?>&password=<?= @base64_encode($info->open_password) ?></span>
                                        </div>
                                        
                                    </div>
                                </div>
                               
                                <div class="panel panel-primary">
                                    <div class="panel-heading"> Counter account login </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <input type="hidden" name="counter_user_id"
                                                value="<?= $info->counter_user_id ?? '' ?>">
                                            <label for="c_user_code" class="col-sm-4 control-label">User Code </label>
                                            <div class="col-sm-8 form-margin-10" id="c_user_code_div">
                                                <input type="text" class="form-control" id="c_user_code"
                                                    name="c_user_code"
                                                    value="<?= set_value('c_user_code',@$info->c_user_code); ?>">
                                                <?= form_error('c_user_code'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="c_user_name" class="col-sm-4 control-label">Username / Login Id</label>
                                            <div class="col-sm-8 form-margin-10" id="c_user_name_div">
                                                <input type="text" class="form-control" id="c_user_name"
                                                    name="c_user_name"
                                                    value="<?= set_value('c_user_name',@$info->c_user_name); ?>">
                                                <?= form_error('c_user_name'); ?>
                                            </div>
                                        </div>
                                        
                                        <?php 
                                        $counter_display            = 'none';
                                        $counter_input_display      = 'block';
                                        if( isset( $info->c_password ) && !empty( $info->c_password ) ) {
                                            $counter_display        = 'block';
                                            $counter_input_display  = 'none';
                                        }
                                        ?>
                                        <div class="form-group" id="counter_reset_pane" style="text-align:center;display:<?= $counter_display ?>">
                                            <a href="javascript:void(0);" id="counter_reset_btn" > Reset Password </a>
                                        </div>
                                        <div class="form-group" id="counter_input_display" style="display: <?= $counter_input_display ?>;">
                                            <label for="c_password" class="col-sm-4 control-label">Password </label>
                                            <div class="col-sm-8 form-margin-10" id="c_password_div">
                                                <input type="password" class="form-control"  id="c_password" name="c_password"
                                                    value="">
                                                <span toggle="#c_password" role="button" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                <?= form_error('c_password'); ?>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"></label>
                                <div class="col-md-6 col-sm-10">
                                    <button type="submit" id="location-submit" class="btn btn-success col-sm-3"
                                        style="margin-right:10px;">
                                        <?php echo $action_btn; ?>
                                    </button>

                                    <input type="reset" class="btn  col-sm-3 reset" id="reset" value="Reset"
                                        style="margin-right:10px;" />
                                    <a href="<?= base_url() ?>Admin/dealer_management/<?= $dealer_id ?>/location"
                                        class="btn btn-dark bg-gray col-sm-3" style="margin-right:10px;"> Back </a>
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
    $('#location_form').validate();
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


$('#counter_reset_btn').click(function(){
    $('#counter_reset_pane').hide();
    $('#counter_input_display').show();
});

$('#sale_reset_btn').click(function(){
    $('#sale_reset_pane').hide();
    $('#sale_input_display').show();
});
</script>