<?php $this->load->view('Backend/container/header'); ?>
<?php $this->load->view('Backend/container/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Type of Handle
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Type of Handle</li>
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
              <h3 class="box-title"> Type of Handle View</h3>
               <div class="pull-right">
                 <a href="<?php echo base_url('Admin/typeofhandle/create');?>" class="btn btn-success">Add Type of Handle <span class=""></span></a> 
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body table-responsive">
              <table id="typeofhandle" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th></th>
                  <th>S.No</th>
				  <th>Type of Handle</th>				 
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
              <!-- /.box-body -->
          </div>
      </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('Backend/alert-modal'); ?>
<?php $this->load->view('Backend/container/right-sidebar'); ?>


<?php
$ajaxurl="typeofhandle/display_datatble_list";
$frmname="typeofhandle";
$columns_arr=array("typeofhandlename");
$drawCustomizeDataTable='<script>var js_array = ["'.implode('","',  $columns_arr ).'"];
							$(document).ready(function() {
							CustomizeDatatableDraw("'.$frmname.'","'.$ajaxurl.'",js_array);
								
							});
							</script>';
	
?>

<?php include_once(__DIR__.'/../container/footer.php'); ?>
