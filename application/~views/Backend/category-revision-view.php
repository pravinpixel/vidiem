<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Deleted Category List
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Deleted Category List</li>
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
              <h3 class="box-title">View Category</h3>
              <a href="<?= base_url('Admin/category/add'); ?>" class="btn btn-primary pull-right">Add</a>
            </div>
      </div>
      </div>
      </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.No</th>
                  <th>User</th>
                  <th>Name</th>
                  <th>Image</th>
                  <th>Order No</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Options</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($DataResult)){
                  $x=1;
                  foreach ($DataResult as $info) { ?>
                <tr>
                  <td class="col-xs-1"><?= $x; ?></td>
                  <td><?= $info['user_name']; ?></td>
                  <td><?= $info['name']; ?></td>
                  <td><?= $info['cat_name']; ?></td>
                  <td><?= $info['sub_cat_name']; ?></td>
                  <td><img src="<?= base_url('uploads/images/'.$info['image']); ?>" width="50px" height="50px" class="img-responsive img_view" data-url="<?= base_url('uploads/images/'.$info['image']); ?>"></td>
                  <td><?= $info['order_no']; ?></td>
                  <td><?php if($info['status']==1){ ?>
                     <span class="label label-success status-span">Active</span>
                     <?php }elseif($info['status']==2){ ?>
                     <span class="label label-warning status-span">Inactive</span>
                  <?php } ?></td>
                  <td><?= $info['created']; ?></td>
                  <td>
                      <a href="javascript:void(0);" class="btn bg-navy revision_category_view" data-id="<?= $info['id']; ?>" data-toggle="tooltip" data-placement="left"  data-original-title="view"><span class="fa fa-eye"></span></a>
                  </td>
                </tr>
                <?php  $x++; }
                }else { ?>
                <tr>
                  <td colspan="10">No Data Available...</td>
                </tr>
                <?php } ?>
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

<!-- Product Filter Model -->
<div class="modal fade" id="filters">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Product Filters</h4>
              </div>
              <div class="modal-body product_filter_div">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
  <!-- Client Status Update Modal -->
  <!-- Client Status Update Modal -->
    <div class="modal fade" id="feature">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Product Features</h4>
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

<?php include_once('container/right-sidebar.php'); ?>
<?php include_once('container/footer.php'); ?>