<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Complaint Registration Edit
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Complaint Registration Edit</li>
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
              <h3 class="box-title">Complaint Registration Edit</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?= base_url('Admin/registration/edit_complaint_registration/'.$productComplaint->id); ?>">
              <div class="box-body">
               <div class="form-group">
                  <label for="inputCode" class="col-sm-2 control-label">Code *</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" readonly class="form-control" id="code" name="code" value="<?= set_value('code',$productComplaint->code); ?>">
                    <?= form_error('code'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputCategory" class="col-sm-2 control-label">Category *</label>
                  <div class="col-md-6 col-sm-10">
                  <select class="selectpicker js-states form-control complaint_category custome-select" data-live-search="true" name="category" id="category">
                      <option value="">Select Category</option>
                      <?php if(!empty($category)){ 
                          foreach($category as $info){ ?>
                          <option value="<?= $info['id']; ?>"  <?= set_select('category',$info['category_name'],($info['category_name'] == $productComplaint->category_name?TRUE:''));?>><?= $info['category_name']; ?></option>
                        <?php } } ?>  
                    </select>
                    <?= form_error('category'); ?>
                  </div>
                </div>


                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Product Name</label>
                  <div class="col-md-6 col-sm-10">
                  <select name="product_name" id="inputProduct" class="form-control complaint_pro_list custome-select">
                      <option value="">Select Product</option>
                      <?php if(!empty($products)){ 
                          foreach($products as $product){ ?>
                          <option value="<?= $product['product_name']; ?>" <?= set_select('product_name',$product['product_name'],($product['id']==$productComplaint->product?TRUE:''));?>><?= $product['product_name']; ?></option>
                        <?php } } ?>  
                    </select>
                    <?= form_error('product_name'); ?>
                  </div>
                </div>
				
				

                <div class="form-group">
                  <label for="serial_number" class="col-sm-2 control-label">Serial No *</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="serial_number" name="serial_number" value="<?= set_value('serial_number',$productComplaint->serialnumer); ?>">
                    <?= form_error('serial_number'); ?>
                  </div>
                </div>
              

                <div class="form-group">
                  <label for="dealer_name" class="col-sm-2 control-label">Dealer Name *</label>
                    <div class="col-sm-6 col-sm-10">
                        <input type="text" class="form-control" id="dealer_name" name="dealer_name" value="<?= set_value('dealer_name',$productComplaint->dealername); ?>">
                            <?= form_error('dealer_name'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                  <label for="purchase_date" class="col-sm-2 control-label">Purchase Date *</label>
                  <div class="col-md-6 col-sm-10">
                      <div class="input-group date">
                        <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                        </div>
                            <input type="text" class="form-control code_datepicker" id="purchase_date" name="purchase_date" value="<?= set_value('purchase_date',$productComplaint->purchase_date); ?>">
                      </div>
                    <?= form_error('purchase_date'); ?>
                  </div>
                </div>


                <div class="form-group">
                  <label for="gender" class="col-sm-2 control-label">Gender *</label>
                  <div class="col-md-6 col-sm-10">
                    <select name="gender" id="inputgender" class="form-control product_cat_trigger">
                      <option value="">Select gender</option>
                      <?php if(!empty($category)){ 
                          foreach(['Male', 'Female'] as $info){ ?>
                          <option value="<?= $info ?>" <?= set_select('gender',$info ,($info == $productComplaint->gender?TRUE:''));?>><?= $info; ?></option>
                        <?php } } ?>  
                    </select>
                    <?= form_error('gender'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label"> Name *</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name',$productComplaint->name); ?>">
                    <?= form_error('name'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail" class="col-sm-2 control-label"> Email *</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="email" class="form-control" id="age" name="email" value="<?= set_value('email',$productComplaint->email); ?>">
                    <?= form_error('email'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputMobile" class="col-sm-2 control-label"> Mobile *</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="mobile" name="mobile" onkeypress="return isNumber(event)" value="<?= set_value('mobile',$productComplaint->mobile); ?>">
                    
                    <?= form_error('mobile'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputAlterMobile" class="col-sm-2 control-label"> Alter Native Mobile * </label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="alternative_mobile" name="alternative_mobile"  onkeypress="return isNumber(event)" value="<?= set_value('alternative_mobile',$productComplaint->alternative_mobile); ?>">
                    <?= form_error('alternative_mobile'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputRemarks" class="col-sm-2 control-label"> Remarks * </label>
                  <div class="col-md-6 col-sm-10">
                    <textarea type="text" class="form-control" id="remarks" name="remarks"> <?= set_value('address',$productComplaint->remarks); ?> </textarea>
                    <?= form_error('remarks'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputOccupation" class="col-sm-2 control-label"> Occupation * </label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="occupation" name="occupation" value="<?= set_value('occupation',$productComplaint->occupation); ?>">
                    <?= form_error('occupation'); ?>
                  </div>
                </div>


                <div class="form-group">
                  <label for="inputAddress" class="col-sm-2 control-label"> Address * </label>
                  <div class="col-md-6 col-sm-10">
                    <textarea type="text" class="form-control" id="address" name="address"> <?= set_value('address',$productComplaint->address); ?> </textarea>
                    <?= form_error('address'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputCity" class="col-sm-2 control-label"> City *</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="city" name="city" value="<?= set_value('city',$productComplaint->city); ?>">
                    <?= form_error('city'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputState" class="col-sm-2 control-label"> State * </label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="state" name="state" value="<?= set_value('state',$productComplaint->state); ?>">
                    <?= form_error('state'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputState" class="col-sm-2 control-label"> Country *</label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="country" name="country" value="<?= set_value('country',$productComplaint->country); ?>">
                    <?= form_error('country'); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPincode" class="col-sm-2 control-label"> Pincode * </label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="pincode" name="pincode"  maxLength= "6"  value="<?= set_value('pincode',$productComplaint->pincode); ?>">
                    <?= form_error('pincode'); ?>
                  </div>
                </div>
                

                <div class="form-group">
                  <label for="" class="col-sm-2 control-label"></label>
                  <div class="col-md-6 col-sm-10">
                     <button type="submit" class="btn btn-info col-sm-3">Update</button>
                  </div>
                </div>    

              </div>
              <!-- /.box-body -->
            </form>
             <!-- /.box-body -->
          </div>
      </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include_once('container/right-sidebar.php'); ?>
<?php include_once('container/footer.php'); ?>

<script>

    $('#input_purchase_from').change(function(e) {
       let purchase_from = $(this).val();
       if(purchase_from == "Amazon") {
         $("#dealer_name").val("Amazon");
       } else if(purchase_from == "Vidiem E-commerce") {
          $("#dealer_name").val("Vidiem");
       } else {
          $("#dealer_name").val('');
       }
    });
    $("#purchase_date").datepicker({
        format: 'yyyy-mm-dd',
        endDate: '+0d',
        autoclose: true
    });
    $('.complaint_category').change(function(){
        var base_url=tmp_base_url;
            var cat_id= $(this).val();
            if(cat_id==''){
                $('.complaint_pro_list').html('<option value="">Select</option>');
            }else{
                $.ajax({
                    url:base_url+'home/complaintProductFetch',
                    data:{cat_id:cat_id},
                    dataType:'json',
                    type:'POST',
                    success:function(data){
                        $('.complaint_pro_list').html('<option value="">Select</option>');
                        if(data.status==1){
                            $.each(data.products,function(index,product){
                                $('.complaint_pro_list').append(`<option value="${product.name}">${product.name}</option>`);
                            });
                        }
                    }
                });
            }
    })
    $(document).ready(function(){
        $('select').select2();
    });
</script>