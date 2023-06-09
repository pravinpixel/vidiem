<?php include_once('container/header.php'); ?>
<?php include_once('container/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product Registration View
        <!-- <small>new</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url('Admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Product Registration View</li>
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
              <h3 class="box-title">Product Registration View</h3>
              <!-- <div class="pull-right">
                  <a href="javascript:void(0);" class="btn btn-success product-export-list">Export <span class="fa fa-download"></span></a> 
              </div>-->
               <div class="pull-right">
                  <a onclick="ExportToExcel('xlsx')" class="btn btn-success">Export <span class="fa fa-download"></span></a> 
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body table-responsive">
              <table id="registerProductTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <!-- <th></th> -->
                  <th>S.No</th>
                  <th>Ref.No</th>
                  <th>Code</th>
				  <th>Category</th>
                  <th>Product Name</th>
                  <th>Serial Numer</th>
                  <th>Purchase Date</th>
				  <th>Purchased From</th>
                  <th>Dealer Name</th>
                  <th>Gender</th>
                  <th>Name</th>
                  <th>Age</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Occupation</th>
                  <th>Address</th>
                  <th>City</th>
                  <th>State</th>
                  <th>Country</th>
                  <th>Pincode</th>
                  <th>Created</th>
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
  
  <table id="export_table" style="display:none;">
      <thead>
                <tr>
                  <!-- <th></th> -->
                  <th>Ref.No</th>
                  <th>Code</th>
				  <th>Category</th>
                  <th>Product Name</th>
                  <th>Serial Numer</th>
                  <th>Purchase Date</th>
				  <th>Purchased From</th>
                  <th>Dealer Name</th>
                  <th>Gender</th>
                  <th>Name</th>
                  <th>Age</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Occupation</th>
                  <th>Address</th>
                  <th>City</th>
                  <th>State</th>
                  <th>Country</th>
                  <th>Pincode</th>
                  <th>Created</th>
                </tr>
                </thead>
                <tbody>
                    
                     <?php 
                     $i=1;
                     foreach($data as $data_hidden) { ?>
                    <tr>
                        <td>
                           <?php echo $i; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['code']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['category']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['Product']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['serialnumer']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['jdate']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['dealername']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['purchasefrom']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['gender']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['name']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['age']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['email']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['mobile']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['occupation']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['address']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['city']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['state']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['country']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['pincode']; ?>
                        </td>
                        <td>
                           <?php echo $data_hidden['created']; ?>
                        </td>
                    </tr>
                   <?php $i++; } ?>
                </tbody>
              </table>
  <!-- /.content-wrapper -->
<?php include_once('container/right-sidebar.php'); ?>
<?php include_once('container/footer.php'); ?>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script>

    function ExportToExcel(type, fn, dl) {
       
       var elt = document.getElementById('export_table');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('Product_Export.' + (type || 'xlsx')));
        
    }

</script>