<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Enquiry
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Enquiry</li>
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
              <h3 class="box-title">View Enquiry</h3>
              <!-- <a href="<?= base_url('Admin/clients/export'); ?>" class="btn btn-primary pull-right">Export</a> -->
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.No</th>
                  <th>Ref.No</th>
                  <th>Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>City</th>
                  <th>Enquiry</th>
                  <th>Message</th>
                  <th>Reply Msg</th>
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
                  <td><?= $info['ref_no']; ?></td>
                  <td><?= $info['name']; ?></td>
                  <td><?= $info['mobile']; ?></td>
                  <td class="mail_data"><?= $info['email']; ?></td>
                  <td><?= $info['city']; ?></td>
                  <td><?= $info['enquiry']; ?></td>
                  <td><?= $info['message']; ?></td>
                  <td><?= $info['reply_msg']; ?></td>
                  <td><?= $info['created']; ?></td>
                  <td>
                    <a href="javascript:void(0);" class="btn btn-primary enquiry_replay" data-toggle="modal" data-target="#reply" data-id="<?= $info['id']; ?>">
                    <span class="fa fa-reply"></span></a>
                    <a href="javascript:void(0);" class="btn btn-danger delete_trigger" data-toggle="tooltip" data-placement="right"  data-original-title="Delete" data-url="<?php echo base_url('Admin/enquiry/delete/'.$info['id']); ?>">
                    <span class="fa fa-trash"></span></a>
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

  <div class="modal fade" id="reply">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Enquiry Reply</h4>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" action="">
                  <input type="hidden" class="enquiry_id">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Client Email:</label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control enquiry_email" id="email" placeholder="Enter email" disabled="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd">Reply Message:</label>
                    <div class="col-sm-9"> 
                      <textarea name="" id="" cols="30" rows="4" class="form-control reply_msg"></textarea>
                    </div>
                  </div>
                  <div class="form-group"> 
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary enquiry-mail">Submit</button>
                    </div>
                  </div>
                </form>
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