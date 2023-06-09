  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= base_url('uploads/profile/'.$this->session->userdata('user_image')); ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= ucfirst($this->session->userdata('user_name')); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
         <li><a href="<?= base_url('Admin/dashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
         <li class="header">Category & Product</li>
         <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Category</span>
            <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?= base_url('Admin/category/add'); ?>"><i class="fa fa-plus"></i> Add Category</a></li>
            <li><a href="<?= base_url('Admin/category'); ?>"><i class="fa fa-list-alt"></i> View Category</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Products</span>
            <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?= base_url('Admin/products/add'); ?>"><i class="fa fa-plus"></i> Add Product</a></li>
            <li><a href="<?= base_url('Admin/products'); ?>"><i class="fa fa-list-alt"></i> View Products</a></li>
          </ul>
        </li>      

        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Orders</span>
            <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?= base_url('Admin/orders'); ?>"><i class="fa fa-list-alt"></i> View Orders</a></li>
            <li><a href="<?= base_url('Admin/orders/uncompleted'); ?>"><i class="fa fa-list-alt"></i> Un Completed Orders</a></li>
            <li><a href="<?= base_url('Admin/orders/cancelled'); ?>"><i class="fa fa-list-alt"></i> Cancelled Orders</a></li>
          </ul>
        </li>      

         <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Reports</span>
            <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?= base_url('Admin/report/sales_report'); ?>"><i class="fa fa-list-alt"></i> Sales Report</a></li>
            <!-- <li><a href="<?= base_url('Admin/report/sales_products'); ?>"><i class="fa fa-list-alt"></i> View Product Sales</a></li> -->
          </ul>
        </li>  

         <li><a href="<?= base_url('Admin/clients');?>"><i class="fa fa-users"></i> Clients</a></li>     

        <li class="header">Extras</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Filters</span>
            <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?= base_url('Admin/filters/add'); ?>"><i class="fa fa-plus"></i> Add Filter</a></li>
            <li><a href="<?= base_url('Admin/filters'); ?>"><i class="fa fa-list-alt"></i> View Filters</a></li>
          </ul>
        </li>    


        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Coupen</span>
            <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?= base_url('Admin/coupen/add'); ?>"><i class="fa fa-plus"></i> Add Coupen</a></li>
            <li><a href="<?= base_url('Admin/coupen'); ?>"><i class="fa fa-list-alt"></i> View Coupens</a></li>
          </ul>
        </li>    

         <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Product Availability</span>
            <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?= base_url('Admin/availability/add'); ?>"><i class="fa fa-plus"></i> Add Availability</a></li>
            <li><a href="<?= base_url('Admin/availability'); ?>"><i class="fa fa-list-alt"></i> View Product Availability</a></li>
          </ul>
        </li>    

        <li><a href="<?= base_url('Admin/enquiry'); ?>"><i class="fa fa-envelope"></i> Enquiry</a></li>
        <li><a href="<?= base_url('Admin/comboenquiry'); ?>"><i class="fa fa-envelope"></i> Combo Enquiry</a></li>
          </ul>
        </li>
        
    </section>
    <!-- /.sidebar -->
  </aside>