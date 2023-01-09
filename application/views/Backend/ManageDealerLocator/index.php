<?php $this->load->view('Backend/container/header'); ?>
<?php $this->load->view('Backend/container/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Manage Dealer Locator
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage Dealer Locator</li>
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
              <h3 class="box-title">Manage Dealer Locator View</h3>
               <div class="pull-right">
                 <a href="<?php echo base_url('Admin/ManageDealerLocator/create');?>" class="btn btn-success">Add Dealer Locator <span class=""></span></a> 
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body table-responsive">
              <table id="managedealerlocator" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th></th>
                  <th>S.No</th>
				  <th>Title</th>		
				  <th>Address</th>		
				  <th>Phone</th>		
				  <th>Email</th>		
				  <th>State Name</th>		
				  <th>City Name</th>					  
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
$ajaxurl="ManageDealerLocator/display_datatble_list";
$frmname="managedealerlocator";
$columns_arr=array("title","address","phone","email","statename","cityname");
$drawCustomizeDataTable='<script>var js_array = ["'.implode('","',  $columns_arr ).'"];
							$(document).ready(function() {
							CustomizeDatatableDraw("'.$frmname.'","'.$ajaxurl.'",js_array);
								
							});
							</script>';
	
?>

<?php include_once(__DIR__.'/../container/footer.php'); ?>
