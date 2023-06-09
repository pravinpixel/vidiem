<?php $this->load->view('Backend/container/header','',null); ?>
<?php $this->load->view('Backend/container/sidebar', '', null); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">     
           
              <h1>
             ARD Service Charge 
            <!-- <small>new</small> -->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">ARD Service Charge</li>
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
                    
             <h3 class="box-title">View Service Charge</h3>
           
           
                       
                        <a href="<?= base_url('Admin/dealer_management/edit_ard'); ?>" class="btn btn-primary pull-right">Add</a>
        </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th> Type</th>
                                    <th>Service Charge %</th>                                  
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i=1;
                                if( isset( $details_ard ) && !empty( $details_ard ) ) {
                                    //print_r($data['details_ard']);
                                    foreach ($details_ard as $items ) {
                                        if($items['dealer_type'] =='ard')
                                        {
                                            $dealer_type='ARD';
                                        }
                                        else
                                        {
                                            $dealer_type='Sub Dealer';
                                        }

                                ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $dealer_type ?></td>
                                    <td><?= $items['service_charge'] ?>% </td>
                                  
                                    <td>
                                        <a href="<?= base_url()?>Admin/dealer_management/edit_ard/<?= $items['id'] ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                            <span class="fa fa-edit"></span>
                                        </a>                                       
                                        
                                    </td>
                                </tr>
                                <?php   
                                $i++;
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