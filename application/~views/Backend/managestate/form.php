<?php $this->load->view('Backend/container/header'); ?>
<?php $this->load->view('Backend/container/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <?php
  
     if($action=="Create")
	 {
		$actionurl=	base_url('Admin/managestate/save/'); 
		$actionbtn="Submit";
	 }
	 else
	 {
		$actionurl=	base_url('Admin/managestate/update/'.$dataitems->state_id); 
		$actionbtn="Update";
	 }	 

  
  ?>
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Manage State
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('Admin/managestate'); ?>">Manage State</a></li>
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
              <h3 class="box-title"><?php echo $action; ?> State</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" id="frmcolor" name="frmcolor" method="post" action="<?php echo $actionurl; ?>">
              <div class="box-body">
			  
			
				 <input type="hidden" id="country_id" name="country_id" value="1">
                                  
                 
               <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">State Name<span class="red">*</span></label>
                  <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control" id="inputName" name="statename" value="<?= set_value('statename',@$dataitems->statename); ?>">
                    <?= form_error('statename'); ?>
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
 </script>