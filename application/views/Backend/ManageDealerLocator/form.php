<?php $this->load->view('Backend/container/header'); ?>
<?php $this->load->view('Backend/container/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <?php
  
     if($action=="Create")
	 {
		$actionurl=	base_url('Admin/ManageDealerLocator/save/'); 
		$actionbtn="Submit";
	 }
	 else
	 {
		$actionurl=	base_url('Admin/ManageDealerLocator/update/'.$dataitems->center_id); 
		$actionbtn="Update";
	 }	 

  
  ?>
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage Dealer Locator
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/ManageDealerLocatorList'); ?>"> Manage Dealer Locator</a></li>
        <li class="active"><?php echo $action; ?></li>
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
              <h3 class="box-title"><?php echo $action; ?> Dealer Locator</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" id="frmcolor" name="frmcolor" method="post" enctype="multipart/form-data" action="<?php echo $actionurl; ?>">
              <div class="box-body">
			  
				 <div class="form-group">
                  <label for="title" class="col-sm-2 control-label">Title<span class="red">*</span></label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="title" name="title" value="<?= set_value('title',@$dataitems->title); ?>">
                    <?= form_error('title'); ?>
                  </div>
                </div>
			           
			 <div class="form-group">
                  <label for="address" class="col-sm-2 control-label">Address<span class="red">*</span></label>
                  <div class="col-md-6 col-sm-10">
				  <textarea id="address" name="address" class="form-control"  row="5" col="17" ><?= set_value('address',@$dataitems->address); ?></textarea>
                
                    <?= form_error('address'); ?>
                  </div>
                </div>
		 <div class="form-group">
                  <label for="phone" class="col-sm-2 control-label">Phone<span class="red">*</span></label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="phone" name="phone" value="<?= set_value('phone',@$dataitems->phone); ?>">
                    <?= form_error('phone'); ?>
                  </div>
                </div>
				
		 <div class="form-group">
                  <label for="email" class="col-sm-2 control-label">Email<span class="red">*</span></label>
                  <div class="col-md-6 col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email',@$dataitems->email); ?>">
                    <?= form_error('email'); ?>
                  </div>
                </div>		
				
           <div class="form-group">
                  <label for="googleurl" class="col-sm-2 control-label">Google URL<span class="red">*</span></label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="googleurl" name="googleurl" value="<?= set_value('googleurl',@$dataitems->googleurl); ?>">
                    <?= form_error('googleurl'); ?>
                  </div>
                </div>       
             
				
				
				 <div class="form-group">
                  <label for="inputCategory" class="col-sm-2 control-label">State *</label>
                  <div class="col-md-6 col-sm-10">
                  <select class="selectpicker required js-states form-control custome-select registration_category" data-live-search="true" name="state_id" id="state_id" onchange="fnloadcity(this.value);">
                      <option value="">Select State</option>
                      <?php if(!empty($state)){ 
                          foreach($state as $info){ ?>
                          <option  value="<?= $info['id'] ?>"   <?= set_select('state_id', $info['id'] ,($info['id'] == $dataitems->state_id ? TRUE:'') );?> ><?= $info['name']; ?></option>
                        <?php } } ?>  
                    </select>
                
                    <?= form_error('state_id'); ?>
                  </div>
                </div>
				
					
				 <div class="form-group">
                  <label for="inputCategory" class="col-sm-2 control-label">City *</label>
                  <div class="col-md-6 col-sm-10" id="divcity">
                  <select class="selectpicker required js-states form-control custome-select registration_category" data-live-search="true" name="city_id" id="city_id">
                      <option value="">Select City</option>
                      <?php if(!empty($city)){ 
                          foreach($city as $info){ ?>
                          <option  value="<?= $info['id'] ?>"   <?= set_select('city_id', $info['id'] ,($info['id'] == $dataitems->city_id ? TRUE:'') );?> ><?= $info['name']; ?></option>
                        <?php } } ?>  
                    </select>
                
                    <?= form_error('city_id'); ?>
                  </div>
                </div>
		
		 <div class="form-group">
                  <label for="sortby" class="col-sm-2 control-label">Sort By<span class="red">*</span></label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="sortby" name="sortby" value="<?= set_value('sortby',@$dataitems->sortby); ?>">
                    <?= form_error('sortby'); ?>
                  </div>
                </div>	

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"></label>
                  <div class="col-md-6 col-sm-10">
				 
                     <button type="submit" class="btn btn-success col-sm-3" style="margin-right:10px;"><?php echo $actionbtn; ?></button>
					
					 <input type="reset" class="btn  col-sm-3 reset" id="reset" value="Reset"/>
								
					 
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
		  
		  $(".reset").click(function() {
			  $('input[type=text]').attr('value', ''); 
			  $("select").val('').trigger('change')
			  $('input:checkbox').iCheck('uncheck');
			  $('input:radio').iCheck('uncheck');
});

      });
function fnloadcity(sid)
{
	 $.ajax({
								url:'<?php echo base_url("Admin/AjaxAction/loadcity"); ?>',
								dataType: 'text',
								type:'POST',
								data:'sid='+sid,
								success:function(data){
									$("#divcity").html("");	
								$("#divcity").html(data);	
									$("#city_id").select2();
								}
							});	
		
		

}	
	  
 </script>