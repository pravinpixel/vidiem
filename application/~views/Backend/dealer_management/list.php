<?php $this->load->view('Backend/container/header','',null); ?>
<?php $this->load->view('Backend/container/sidebar', '', null); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dealer Management
            <!-- <small>new</small> -->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dealers Management</li>
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
                        <h3 class="box-title">View Dealers</h3>
                        <a href="<?= base_url('Admin/dealer_management/add'); ?>" class="btn btn-primary pull-right">Add</a>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Dealer ERP</th>
                                    <th>Vidiem ERP</th>
                                    <th>Location Code</th>
                                    <th>Display Name</th>
                                    <th>Address</th>
                                    <th>Payment Options</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if( isset( $details ) && !empty( $details ) ) {
                                    foreach ($details as $items ) {
                                ?>
                                <tr>
                                    <td><?= $items['id'] ?></td>
                                    <td><?= $items['dealer_erp_code'] ?></td>
                                    <td><?= $items['vidiem_erp_code'] ?></td>
                                    <td><?= $items['location_code'] ?></td>
                                    <td><?= $items['display_name'] ?></td>
                                    <td><?= $items['address'] ?></td>
                                    <td><?= ucfirst( str_replace('_', ' ', $items['payment_option'] ) ) ?></td>
                                    <td> <span class="label label-<?= ($items['status'] == 1 ) ? 'success' : 'danger' ?>" ><?= $items['status'] == 1 ? 'Active' : 'Inactive' ?> </span></td>
                                    <td>
                                        <a href="<?= base_url()?>Admin/dealer_management/add/<?= $items['id'] ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                        <a href="<?= base_url()?>Admin/dealer_management/<?= $items['id'] ?>/location" class="btn btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Locations">
                                            <span class="fa fa-map"></span>
                                        </a>                     
                                        <a href="<?= base_url() ?>Admin/dealer_management/status/<?= $items['id']?>/<?= $items['status'] == 1 ? 2 : 1 ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="<?= $items['status'] == 2 ? 'Active' : 'Inactive' ?> "><span class="fa fa-lock"></span></a>                     

                                        <a href="javascript:void(0);" class="btn btn-danger delete_trigger" data-toggle="tooltip" data-placement="right"  data-original-title="Delete" data-url="<?php echo base_url('Admin/dealer_management/delete/'.$items['id']); ?>">
                                            <span class="fa fa-trash"></span>
                                        </a>
                                        
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

<!-- Client Status Update Modal -->
<div class="modal fade" id="feature">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Filter Items</h4>
            </div>
            <div class="modal-body product_feature_div">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('Backend/container/right-sidebar', '', null); ?>
<?php $this->load->view('Backend/container/footer', '', null); ?>