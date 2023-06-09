<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Coupen
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/coupen'); ?>">Coupen</a></li>
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
              <h3 class="box-title">Edit Coupen</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?= base_url('Admin/coupen/edit'); ?>" enctype="multipart/form-data">
              <div class="box-body">
               <input type="hidden" name="hidden_id" value="<?php echo set_value('hidden_id',$edit_id); ?>" />
                
               <div class="box-body">
                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Name</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputName" name="name" value="<?= set_value('name',@$Edit_Result['name']); ?>">
                    <?= form_error('name'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputCode" class="col-sm-2 control-label">Coupen Code</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputCode" name="code" value="<?= set_value('code',@$Edit_Result['code']); ?>">
                    <?= form_error('code'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputType" class="col-sm-2 control-label">Discount Type</label>
                  <div class="col-md-6 col-sm-10">
                    <select name="type" id="inputType" class="form-control">
                      <option value="">Select Type</option>
                          <option value="1" <?= set_select('type',1,(@$Edit_Result['type']==1?TRUE:FALSE));?>>Percentage %</option>
                          <option value="2" <?= set_select('type',2,(@$Edit_Result['type']==2?TRUE:FALSE));?>>Fixed Amount</option>
                    </select>
                     <?= form_error('type'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputDiscountValue" class="col-sm-2 control-label">Discount Value</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputDiscountValue" name="discount_value" value="<?= set_value('discount_value',@$Edit_Result['discount_value']); ?>">
                    <?= form_error('discount_value'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputMinOrder" class="col-sm-2 control-label">Min. Order Value</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputMinOrder" name="min_order" value="<?= set_value('min_order',@$Edit_Result['min_order']); ?>">
                    <?= form_error('min_order'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputMaxDiscount" class="col-sm-2 control-label">Max. Discount Amount</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputMaxDiscount" name="max_discount" value="<?= set_value('max_discount',@$Edit_Result['max_discount']); ?>">
                    <?= form_error('max_discount'); ?>
                  </div>
                </div>
      <h4 class="box-title">Coupen Code Usage</h4>          
                <div class="form-group">
                  <label for="inputMaxUsage" class="col-sm-2 control-label">Max. Time Coupen Usage</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputMaxUsage" name="max_usage" value="<?= set_value('max_usage',@$Edit_Result['max_usage']); ?>">
                    <?= form_error('max_usage'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputMaxPerUser" class="col-sm-2 control-label">Max. Time Coupen Usage Per User</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputMaxPerUser" name="max_per_user" value="<?= set_value('max_per_user',@$Edit_Result['max_per_user']); ?>">
                    <?= form_error('max_per_user'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputOnlyFirstOrder" class="col-sm-2 control-label">Only For First Order</label>
                  <div class="col-md-6 col-sm-10">
                    <div class="checkbox icheck">
                        <label for="inputOnlyFirstOrder">
                          <input type="checkbox" value="1" name="only_first_order" id="inputOnlyFirstOrder" <?= set_checkbox('only_first_order','1',(@$Edit_Result['only_first_order']==1?TRUE:FALSE)); ?>> Yes
                        </label>
                      </div>
                  </div>    
                </div>

                <div class="form-group">
                  <label for="inputStatDate" class="col-sm-2 control-label">Start Date</label>
                  <div class="col-md-6 col-sm-10">
                      <div class="input-group date">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                            <input type="text" class="form-control code_datepicker" id="inputStatDate" name="start_date" value="<?= set_value('start_date',@$Edit_Result['start_date']); ?>">
                      </div>
                    <?= form_error('start_date'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEndDate" class="col-sm-2 control-label">End Date</label>
                  <div class="col-md-6 col-sm-10">
                      <div class="input-group date">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                            <input type="text" class="form-control code_datepicker" id="inputEndDate" name="end_date" value="<?= set_value('end_date',@$Edit_Result['end_date']); ?>">
                      </div>
                    <?= form_error('end_date'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"></label>
                  <div class="col-md-6 col-sm-10">
                     <button type="submit" class="btn btn-info col-sm-3">Update</button>
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
<?php include_once('container/right-sidebar.php'); ?>
<?php include_once('container/footer.php'); ?>