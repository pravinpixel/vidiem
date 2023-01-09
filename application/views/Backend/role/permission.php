<?php $this->load->view('Backend/container/header'); ?>
<?php $this->load->view('Backend/container/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Permissions 
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Permissions</li>
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
              <h3 class="box-title"> Permissions </h3>
               <div class="pull-right">
                 <a href="<?php echo base_url('Admin/Role');?>" class="btn btn-success">Go to Role <span class=""></span></a> 
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body table-responsive">
            <form action="<?php echo base_url('Admin/Permission/update/'.$id);?>" method="post">
                <table class="table table-bordered table-centered text-center tr-sm table-hover">
                    <thead class="bg-primary-2 text-white">
                        <tr>
                            <th rowspan="2" width="200px">Menus</th>
                            <th colspan="4"> Permissions</th>
                        </tr>
                        <tr>
                            <th>View</th>
                            <th>Add</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php 
                    foreach($this->config->item('permission') as $key => $permission_menu){
                    ?>
                            <tr>
                                
                            <th><?= str_replace('_',' ',ucfirst($key)) ?></th> 

                                <?php 
                                    foreach($permission_menu as $key => $filed){
                                        if($filed == '') {
                                 ?> 
                                          <td> - </td>  
                               
                                <?php 
                                        } else {
                                ?>
                               
                                            <td><input type="checkbox" value="1" class="view " name="<?= $filed;?>" <?= $permission[$filed] == 1 ? "checked":"" ?>></td>
                                <?php       
                                        } 
                                        
                                    }
                                ?>
                        </tr>
                    <?php 
                    }
                    ?>
                        
                        </form>
                    </tbody>
                </table>
                <button class="btn btn-info pull-right">Update</button>
            </div>
              <!-- /.box-body -->
          </div>
      </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
    	function toggle(source) {
		var checkboxes = document.querySelectorAll('input[type="checkbox"]');
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i] != source)
				checkboxes[i].checked = source.checked;
		}
	}
	function view_alls(source) {
		var checkboxes = document.getElementsByClassName('view');
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i] != source)
				checkboxes[i].checked = source.checked;
		}
	}
	function add_alls(source) {
		var checkboxes = document.getElementsByClassName('add');
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i] != source)
				checkboxes[i].checked = source.checked;
		}
	}
	function edit_alls(source) {
		var checkboxes = document.getElementsByClassName('edit');
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i] != source)
				checkboxes[i].checked = source.checked;
		}
	}
	function delete_alls(source) {
		var checkboxes = document.getElementsByClassName('delete');
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i] != source)
				checkboxes[i].checked = source.checked;
		}
	}
</script>
<?php $this->load->view('Backend/alert-modal'); ?>
<?php $this->load->view('Backend/container/right-sidebar'); ?>
<?php $this->load->view('Backend/container/footer'); ?>

