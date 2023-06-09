<?php $this->load->view('Backend/dealers/layouts/header') ?>
<?php $this->load->view('Backend/dealers/layouts/sidebar') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php if($dealer_type=='dealer')
            { ?>
   
    <section class="content-header">
        <h1>
            Locations
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('vidiem-dealer'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Manage Locations</li>
        </ol>
    </section>
    <?php } else 
    {?>
     <section class="content-header">
        <h1>
            ARD
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('vidiem-dealer'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">ARD Locations</li>
        </ol>
    </section>
    <?php 
    }
    ?>
    <!-- Main content -->
    <section class="content">
        <?php if(!empty($this->session->flashdata('msg'))){ ?>
        <div class="alert <?= $this->session->flashdata('class'); ?> alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa <?= $this->session->flashdata('icon'); ?>"></i> <?= $this->session->flashdata('head_alert'); ?>!</h4>
            <?= $this->session->flashdata('msg'); ?>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                    <?php if($dealer_type=='dealer')
            { ?>
                        <h3 class="box-title">Locations List</h3>
                        <?php } else {
                            ?>
                             <h3 class="box-title">ARD List</h3>
                        <?php } ?>
                        <div class="pull-right">
                            <a href="<?php echo base_url('dealer-admin/'.$dealer_id.'/location/add');?>"
                                class="btn btn-success">
                                <?php if($dealer_type=='dealer')
            { ?>
                                Add Dealer Location
                                <?php } else {
                            ?> 
                             Add Sub Dealer
                              <?php } ?><span class="">
                                    
                                </span></a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body table-responsive">
                        <table id="manageDealer" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Location Name</th>
                                    <th>Location Code</th>
                                 
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if( isset( $details ) && !empty( $details ) ) {
                                    $i=0;
                                    foreach ($details as $locationRow ) {
                                        $i++;
                                ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $locationRow->location_name; ?></td>
                                    <td><?= $locationRow->location_code; ?></td>
                                    <td><?= $locationRow->location_address; ?></td>
                                    <td>
                                        <a href="<?= base_url()?>dealer-admin/<?= $dealer_id ?>/location/add/<?= $locationRow->id; ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                            <span class="fa fa-edit"></span>
                                        </a>           
                                        <a href="javascript:void(0);" data-url="<?= base_url() ?>dealers/location/delete_status_update" class="btn btn-<?= $locationRow->status == 2 ? 'warning' : 'success' ?>  delete_trigger_click" data-toggle="tooltip" data-placement="top" data-id="<?= $locationRow->id;?>" data-value="<?= $locationRow->status == 1 ? 2 : 1 ?>" data-update-to="status" data-original-title="<?= $locationRow->status == 2 ? 'Active' : 'Inactive' ?> "><span class="fa fa-<?= $locationRow->status == 2 ? 'lock' : 'unlock' ?>"></span></a>                     
                                        
                                        <a href="javascript:void(0);" class="btn btn-danger delete_trigger_click " data-toggle="tooltip"  data-value="0" data-placement="right" data-update-to="delete"  data-id="<?= $locationRow->id;?>" data-original-title="Delete" data-url="<?= base_url() ?>dealers/location/delete_status_update">
                                        <span class="fa fa-trash"></span></a>
                                        
                                    </td>
                                </tr>
                                <?php     
                                    }
                                }
                                ?>
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
<!-- ./wrapper -->
<?php $this->load->view('Backend/dealers/layouts/footer') ?>