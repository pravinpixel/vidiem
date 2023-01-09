<?php $this->load->view('Backend/container/header'); ?>
<?php $this->load->view('Backend/container/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Registration Product
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/ProductRegistration'); ?>">Registration Product</a></li>
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
              <h3 class="box-title">Edit Product</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?= base_url('Admin/ProductRegistration/update/'.$registrationProduct->id); ?>">
              <div class="box-body">
                
               <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Product Name  <span class="red">*</span></label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputName" name="product_name" value="<?= set_value('product_name',@$registrationProduct->product_name); ?>">
                    <?= form_error('product_name'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputCategory" class="col-sm-2 control-label">Category *</label>
                  <div class="col-md-6 col-sm-10">
                  <select class="selectpicker required js-states form-control custome-select registration_category" data-live-search="true" name="category_id" id="category_id">
                      <option value="">Select Category</option>
                      <?php if(!empty($registration_categories)){ 
                          foreach($registration_categories as $info){ ?>
                          <option  value="<?= $info['id'] ?>"   <?= set_select('category_id', $info['id'] ,($info['id'] == $registrationProduct->category_id ? TRUE:'') );?> ><?= $info['category_name']; ?></option>
                        <?php } } ?>  
                    </select>
                  <!-- <select class="selectpicker js-states form-control custome-select registration_category" data-live-search="true" name="category_id" id="category_id">
                      <option value="">Select Category</option>
                      <?php if(!empty($registration_categories)){ 
                          foreach($registration_categories as $info){ ?>
                          <option  value="<?= $info['id'] ?>" ><?= $info['category_name']; ?></option>
                        <?php } } ?>  
                    </select> -->
                    <?= form_error('category_id'); ?>
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
<?php $this->load->view('Backend/container/right-sidebar'); ?>
<?php $this->load->view('Backend/container/footer'); ?>
<script>
  $(document).ready(function(){
          $('select').select2();
      });
</script>