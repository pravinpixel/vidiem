  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
              <div class="pull-left image">
                  <img src="<?= base_url('uploads/profile/'.$this->session->userdata('user_image')); ?>"
                      class="img-circle" alt="User Image">
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
                      <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                              class="fa fa-search"></i>
                      </button>
                  </span>
              </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
              <li><a href="<?= base_url('Admin/dashboard');?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
              </li>
              <?php if(hasPermission('category_index') || hasPermission('category_add') ) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Category</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('category_add')) {?>
                      <li><a href="<?= base_url('Admin/category/add'); ?>"><i class="fa fa-plus"></i> Add Category</a>
                      </li>
                      <?php } if(hasPermission('category_index'))  {?>
                      <li><a href="<?= base_url('Admin/category'); ?>"><i class="fa fa-list-alt"></i> View Category</a>
                      </li>
                      <?php } if(hasPermission('category_index'))  {?>
                      <li><a href="<?= base_url('Admin/category/revisions'); ?>"><i class="fa fa-list-alt"></i> Deleted
                              Category</a></li>
                      <?php } ?>
                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('product_index') || hasPermission('product_add') ) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Products</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('product_add')) {?>
                      <li><a href="<?= base_url('Admin/products/add'); ?>"><i class="fa fa-plus"></i> Add Product</a>
                      </li>
                      <?php } if(hasPermission('product_index'))  {?>
                      <li><a href="<?= base_url('Admin/products'); ?>"><i class="fa fa-list-alt"></i> View Products</a>
                      </li>
                      <?php } if(hasPermission('product_index'))  { ?>
                      <li><a href="<?= base_url('Admin/products/revisions'); ?>"><i class="fa fa-list-alt"></i> Deleted
                              Products</a></li>
                      <?php } ?>
                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('customizable_index') ) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Customizable</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>

                  <ul class="treeview-menu">

                      <li><a href="<?= base_url('Admin/CustomizeColor'); ?>"><i class="fa fa-plus"></i> Manage
                              Colors</a></li>

                      <li><a href="<?= base_url('Admin/Customizemotor'); ?>"><i class="fa fa-plus"></i> Manage
                              Motors</a></li>

                      <li><a href="<?= base_url('Admin/Customizebase'); ?>"><i class="fa fa-plus"></i> Manage Base</a>
                      </li>

                      <li><a href="<?= base_url('Admin/Customizejar'); ?>"><i class="fa fa-plus"></i> Manage Jar</a>
                      </li>

                      <li><a href="<?= base_url('Admin/Customizepackage'); ?>"><i class="fa fa-plus"></i> Manage
                              Package</a></li>

                      <li><a href="<?= base_url('Admin/Typeofjar'); ?>"><i class="fa fa-plus"></i> Manage Type of
                              Jar</a></li>

                      <li><a href="<?= base_url('Admin/Typeofhandle'); ?>"><i class="fa fa-plus"></i> Manage Type of
                              Handle</a></li>

                      <li><a href="<?= base_url('Admin/Typeoflid'); ?>"><i class="fa fa-plus"></i> Manage Type of
                              Lid</a></li>

                      <li><a href="<?= base_url('Admin/Capacity'); ?>"><i class="fa fa-plus"></i> Manage Capacity</a>
                      </li>

                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('service_center_index')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Service Center</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>

                  <ul class="treeview-menu">
                      <li><a href="<?= base_url('Admin/Managestate'); ?>"><i class="fa fa-plus"></i> Manage State</a>
                      </li>
                      <li><a href="<?= base_url('Admin/Managecity'); ?>"><i class="fa fa-plus"></i> Manage City</a></li>
                      <li><a href="<?= base_url('Admin/ManageServiceCenter'); ?>"><i class="fa fa-plus"></i> Manage
                              Serivce Center</a></li>

                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('dealer_locator_index')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Dealer Locator</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>

                  <ul class="treeview-menu">
                      <li><a href="<?= base_url('Admin/ManageDealerLocator'); ?>"><i class="fa fa-plus"></i> Manage
                              Dealer Locator</a></li>

                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('key_feature_index') || hasPermission('key_feature_add') ) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Key Feture Position</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('key_feature_add')) {?>
                      <li><a href="<?= base_url('Admin/Keyfeatureposition/add'); ?>"><i class="fa fa-plus"></i> Add Key
                              Feture</a></li>
                      <?php } if(hasPermission('key_feature_index'))  {?>
                      <li><a href="<?= base_url('Admin/Keyfeatureposition'); ?>"><i class="fa fa-list-alt"></i> View Key
                              Feture</a></li>
                      <?php } ?>
                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('other_product_index') || hasPermission('other_product_add') ) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Other Product</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('other_product_add')) {?>
                      <li><a href="<?= base_url('Admin/Otherproduct/add'); ?>"><i class="fa fa-plus"></i> Add Other
                              Product</a></li>
                      <?php } if(hasPermission('other_product_index'))  {?>
                      <li><a href="<?= base_url('Admin/Otherproduct'); ?>"><i class="fa fa-list-alt"></i> View Other
                              Product</a></li>
                      <?php } ?>

                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('seo_index') || hasPermission('seo_add') ) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>SEO</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('seo_add')) {?>
                      <li><a href="<?= base_url('Admin/seo/add'); ?>"><i class="fa fa-circle-o"></i> Add Seo</a></li>
                      <?php } if(hasPermission('seo_index'))  {?>
                      <li><a href="<?= base_url('Admin/seo'); ?>"><i class="fa fa-circle-o"></i> View Seo</a></li>
                      <?php } ?>
                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('offer_index') || hasPermission('offer_add') ) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Offers</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('offer_add')) {?>
                      <li><a href="<?= base_url('Admin/offers/add'); ?>"><i class="fa fa-plus"></i> Add Offer</a></li>
                      <?php } ?>
                      <?php if(hasPermission('offer_index')) {?>
                      <li><a href="<?= base_url('Admin/offers'); ?>"><i class="fa fa-list-alt"></i> View Offers</a></li>
                      <?php } ?>
                  </ul>
              </li>
              <?php } ?>
              <?php if(hasPermission('review_index')) {?>
              <li><a href="<?= base_url('Admin/reviews');?>"><i class="fa fa-dashboard"></i> <span>Reviews</span></a></li>
              <?php } ?>
              <?php if(hasPermission('order_index')) {?>
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
                      <li><a href="<?= base_url('Admin/orders/viewOrder'); ?>"><i class="fa fa-list-alt"></i> Product
                              Wise View Orders</a></li>
                      <li><a href="<?= base_url('Admin/orders/uncompleted'); ?>"><i class="fa fa-list-alt"></i> Un
                              Completed Orders</a></li>
                      <li><a href="<?= base_url('Admin/orders/cancel_request'); ?>"><i class="fa fa-list-alt"></i> View
                              Cancel Request</a></li>
                      <li><a href="<?= base_url('Admin/orders/cancelled'); ?>"><i class="fa fa-list-alt"></i> Cancelled
                              Orders</a></li>
                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('customize_order_index')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Customize Orders</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <li><a href="<?= base_url('Admin/Customizeorders'); ?>"><i class="fa fa-list-alt"></i> View
                              Orders</a></li>
                      <li><a href="<?= base_url('Admin/Customizeorders/uncompleted'); ?>"><i class="fa fa-list-alt"></i>
                              Un Completed Orders</a></li>
                      <li><a href="<?= base_url('Admin/Customizeorders/cancel_request'); ?>"><i
                                  class="fa fa-list-alt"></i> View Cancel Request</a></li>
                      <li><a href="<?= base_url('Admin/Customizeorders/cancelled'); ?>"><i class="fa fa-list-alt"></i>
                              Cancelled Orders</a></li>
                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('user_add')) { ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-files-o"></i>
                        <span>Reports</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?= base_url('Admin/report/sales_report'); ?>"><i class="fa fa-list-alt"></i> Sales
                                Report</a></li>
                        <li><a href="<?= base_url('Admin/report/sales_products'); ?>"><i class="fa fa-list-alt"></i> View
                                Product Sales</a></li>
                        <li>
                            <a href="<?= base_url('Admin/report/dealer_sales_report'); ?>"><i class="fa fa-list-alt"></i> 
                            View Dealer Sales Report
                            </a>
                        </li>
                    </ul>
                </li>
              <?php } ?>

              <?php if(hasPermission('client_index')) {?>
              <li><a href="<?= base_url('Admin/clients');?>"><i class="fa fa-users"></i> <span>Clients</span></a></li>
              <?php } ?>

              <?php if(hasPermission('dealer_management_index') || hasPermission('dealer_management_add')) {?>

              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Dealers Management</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('dealer_management_add')) {?>
                      <li><a href="<?= base_url('Admin/dealer_management/add'); ?>"><i class="fa fa-plus"></i> Add Dealers </a></li>
                      <?php } ?>
                      <?php if(hasPermission('dealer_management_index')) {?>
                      <li><a href="<?= base_url('Admin/dealer_management'); ?>"><i class="fa fa-list-alt"></i> View Dealers</a>
                      </li>
                      <?php } ?>
                     
                      <li><a href="<?= base_url('Admin/ard_management'); ?>"><i class="fa fa-list-alt"></i> View ARD</a>
                      </li>
                      <li><a href="<?= base_url('Admin/dealer_management/ard_service_list'); ?>"><i class="fa fa-list-alt"></i> View ARD Service Charge</a>
                      </li>
                     
                  </ul>
              </li>

              <?php } ?>
              <li class="header">Extras</li>

              <?php if(hasPermission('filter_index') || hasPermission('filter_add')) {?>

              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Filters</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('filter_add')) {?>
                      <li><a href="<?= base_url('Admin/filters/add'); ?>"><i class="fa fa-plus"></i> Add Filter</a></li>
                      <?php } ?>
                      <?php if(hasPermission('filter_index')) {?>
                      <li><a href="<?= base_url('Admin/filters'); ?>"><i class="fa fa-list-alt"></i> View Filters</a>
                      </li>
                      <?php } ?>
                  </ul>
              </li>

              <?php } ?>

              <?php if(hasPermission('coupen_index') || hasPermission('coupen_add')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Coupon</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('coupen_add')) {?>
                      <li><a href="<?= base_url('Admin/coupen/add'); ?>"><i class="fa fa-plus"></i> Add Coupon</a></li>
                      <?php } ?>
                      <?php if(hasPermission('coupen_index')) {?>
                      <li><a href="<?= base_url('Admin/coupen'); ?>"><i class="fa fa-list-alt"></i> View Coupons</a>
                      </li>
                      <?php } ?>
                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('product_availability_index') || hasPermission('product_availability_add')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Product Availability</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('product_availability_add')) { ?>
                      <li><a href="<?= base_url('Admin/availability/add'); ?>"><i class="fa fa-plus"></i> Add
                              Availability</a></li>
                      <?php } ?>
                      <?php if(hasPermission('product_availability_index')) {?>
                      <li><a href="<?= base_url('Admin/availability'); ?>"><i class="fa fa-list-alt"></i> View Product
                              Availability</a></li>
                      <?php } ?>
                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('enquiry_index')) {?>
              <li><a href="<?= base_url('Admin/enquiry'); ?>"><i class="fa fa-envelope"></i> <span>Enquiry</span></a></li>
              <?php } ?>

              <?php if(hasPermission('combo_enquiry_index')) {?>
              <li><a href="<?= base_url('Admin/comboenquiry'); ?>"><i class="fa fa-envelope"></i> <span>Combo Enquiry</span></a></li>
              <?php } ?>

              <?php if(hasPermission('banner_index') || hasPermission('banner_add')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Banner</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">

                      <?php if(hasPermission('banner_index')) { ?>
                      <li><a href="<?= base_url('Admin/Banner/add'); ?>"><i class="fa fa-plus"></i> Add Banner</a></li>
                      <?php } ?>

                      <?php if(hasPermission('banner_add')) {?>
                      <li><a href="<?= base_url('Admin/Banner'); ?>"><i class="fa fa-list-alt"></i> View Banners</a>
                      </li>
                      <?php } ?>

                  </ul>


              </li>
              <?php } ?>

              <?php if(hasPermission('block_management_index') || hasPermission('block_management_add')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Block Management</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>

                  <ul class="treeview-menu">
                      <?php if(hasPermission('block_management_add')) { ?>
                      <li><a href="<?= base_url('Admin/Block/add'); ?>"><i class="fa fa-plus"></i> Add Block</a></li>
                      <?php } ?>
                      <?php if(hasPermission('block_management_index')) { ?>
                      <li><a href="<?= base_url('Admin/Block'); ?>"><i class="fa fa-list-alt"></i> View Block</a></li>
                      <?php } ?>
                  </ul>

              </li>
              <?php } ?>

              <?php if(hasPermission('press_index') || hasPermission('press_add')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Press</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('press_add')) { ?>
                      <li><a href="<?= base_url('Admin/press/add'); ?>"><i class="fa fa-circle-o"></i> Add Press</a>
                      </li>
                      <?php } ?>
                      <?php if(hasPermission('press_index')) { ?>
                      <li><a href="<?= base_url('Admin/press'); ?>"><i class="fa fa-circle-o"></i> View Press</a></li>
                      <?php } ?>

                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('event_index') || hasPermission('event_add')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Event</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('event_add')) { ?>
                      <li><a href="<?= base_url('Admin/event/add'); ?>"><i class="fa fa-circle-o"></i> Add Event</a>
                      </li>
                      <?php } ?>
                      <?php if(hasPermission('event_index')) { ?>
                      <li><a href="<?= base_url('Admin/event'); ?>"><i class="fa fa-circle-o"></i> View Events</a></li>
                      <?php } ?>
                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('testimonial_index') || hasPermission('testimonial_add')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Testimonial</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('testimonial_add')) { ?>
                      <li><a href="<?= base_url('Admin/testimonial/add'); ?>"><i class="fa fa-circle-o"></i> Add
                              Testimonial</a></li>
                      <?php } ?>

                      <?php if(hasPermission('testimonial_index')) { ?>
                      <li><a href="<?= base_url('Admin/testimonial'); ?>"><i class="fa fa-circle-o"></i> View
                              Testimonial</a></li>
                      <?php } ?>
                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('team_index') || hasPermission('team_add')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Team</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('team_add') ) { ?>
                      <li><a href="<?= base_url('Admin/team/add'); ?>"><i class="fa fa-circle-o"></i> Add Team
                              Member</a></li>
                      <?php } ?>
                      <?php if(hasPermission('team_index') ) { ?>
                      <li><a href="<?= base_url('Admin/team'); ?>"><i class="fa fa-circle-o"></i> View Team Members</a>
                      </li>
                      <?php } ?>
                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('video_index') || hasPermission('video_add')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Video</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">

                      <?php if(hasPermission('video_add')) { ?>
                      <li><a href="<?= base_url('Admin/video/add'); ?>"><i class="fa fa-circle-o"></i> Add Video</a>
                      </li>
                      <?php } ?>

                      <?php if(hasPermission('video_index')) { ?>
                      <li><a href="<?= base_url('Admin/video'); ?>"><i class="fa fa-circle-o"></i> View Videos</a></li>
                      <?php } ?>

                      <?php if(hasPermission('video_add')) { ?>
                      <li><a href="<?= base_url('Admin/mediavideo/add'); ?>"><i class="fa fa-circle-o"></i> Add
                              MediaVideo</a></li>
                      <?php } ?>

                      <?php if(hasPermission('video_index')) { ?>
                      <li><a href="<?= base_url('Admin/mediavideo'); ?>"><i class="fa fa-circle-o"></i> View
                              MediaVideos</a></li>
                      <?php } ?>

                      <?php if(hasPermission('video_add')) { ?>
                      <li><a href="<?= base_url('Admin/recipevideo/add'); ?>"><i class="fa fa-circle-o"></i> Add
                              RecipeVideo</a></li>
                      <?php } ?>

                      <?php if(hasPermission('video_index')) { ?>
                      <li><a href="<?= base_url('Admin/recipevideo'); ?>"><i class="fa fa-circle-o"></i> View
                              RecipeVideos</a></li>
                      <?php } ?>

                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('site_registration_index')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Site Registration</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <li><a href="<?= base_url('Admin/registration/product_registration'); ?>"><i
                                  class="fa fa-circle-o"></i> Product Registration</a></li>
                      <li><a href="<?= base_url('Admin/registration/complaint_registration'); ?>"><i
                                  class="fa fa-circle-o"></i> Complaint Registration</a></li>
                      <li><a href="<?= base_url('Admin/CategoryRegistration'); ?>"><i class="fa fa-circle-o"></i>
                              Registration Category </a></li>
                      <li><a href="<?= base_url('Admin/ProductRegistration'); ?>"><i class="fa fa-circle-o"></i>
                              Registration Product </a></li>
                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('delivery_partner_index') || hasPermission('delivery_partner_add')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Delivery Partners</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>

                  <ul class="treeview-menu">
                      <?php if(hasPermission('delivery_partner_add')) {?>
                      <li><a href="<?= base_url('Admin/partners/add'); ?>"><i class="fa fa-circle-o"></i>Add Partner</a>
                      </li>
                      <?php } ?>

                      <?php if(hasPermission('delivery_partner_index')){ ?>
                      <li><a href="<?= base_url('Admin/partners'); ?>"><i class="fa fa-circle-o"></i> View Partners</a>
                      </li>
                      <?php } ?>
                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('faq_index') || hasPermission('faq_add')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>FAQ</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">

                      <?php if(hasPermission('faq_add')) {?>
                      <li><a href="<?= base_url('Admin/faq/add'); ?>"><i class="fa fa-circle-o"></i>Add FAQ</a></li>
                      <?php } ?>

                      <?php if(hasPermission('faq_index')) {?>
                      <li><a href="<?= base_url('Admin/faq'); ?>"><i class="fa fa-circle-o"></i> View FAQ</a></li>
                      <?php } ?>
                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('user_manual_index') || hasPermission('user_manual_add')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>User Manual</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('user_manual_add')){ ?>
                      <li><a href="<?= base_url('Admin/usermanual/add'); ?>"><i class="fa fa-circle-o"></i> Add User
                              Manual</a></li>
                      <?php } ?>
                      <?php if(hasPermission('user_manual_index')) { ?>
                      <li><a href="<?= base_url('Admin/usermanual'); ?>"><i class="fa fa-circle-o"></i> View User
                              Manual</a></li>
                      <?php } ?>
                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('recipe_index') || hasPermission('recipe_add')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Recipe</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('recipe_add')) { ?>
                      <li><a href="<?= base_url('Admin/recipe/add'); ?>"><i class="fa fa-circle-o"></i> Add Recipe</a>
                      </li>
                      <?php } ?>

                      <?php if(hasPermission('recipe_index')) { ?>
                      <li><a href="<?= base_url('Admin/recipe'); ?>"><i class="fa fa-circle-o"></i> View Recipe</a></li>
                      <?php } ?>

                      <?php if(hasPermission('recipe_add')) { ?>
                      <li><a href="<?= base_url('Admin/recipe/banneradd'); ?>"><i class="fa fa-circle-o"></i> Add Banner
                          </a></li>
                      <?php } ?>

                      <?php if(hasPermission('recipe_index')) { ?>
                      <li><a href="<?= base_url('Admin/recipe/bannerview'); ?>"><i class="fa fa-circle-o"></i> View
                              Banner</a></li>
                      <?php } ?>

                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('notification_index') || hasPermission('notification_add')) {?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Notification</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('notification_add')) { ?>
                      <li><a href="<?= base_url('Admin/notification/add'); ?>"><i class="fa fa-circle-o"></i> Add
                              Notification</a></li>
                      <?php } ?>
                      <?php if(hasPermission('notification_index')) { ?>
                      <li><a href="<?= base_url('Admin/notification'); ?>"><i class="fa fa-circle-o"></i> View
                              Notification</a></li>
                      <?php } ?>
                  </ul>
              </li>
              <?php } ?>

              <?php if(hasPermission('warranty_index') || hasPermission('warranty_add')) {?>

              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Warranty Terms</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('warranty_add')) { ?>
                      <li><a href="<?= base_url('Admin/Warranty/add'); ?>"><i class="fa fa-circle-o"></i> Add
                              Warranty</a></li>
                      <?php } ?>

                      <?php if(hasPermission('warranty_index')) { ?>
                      <li><a href="<?= base_url('Admin/Warranty'); ?>"><i class="fa fa-circle-o"></i> View Warranty</a>
                      </li>
                      <?php } ?>
                  </ul>
              </li>

              <?php } ?>

              <?php if( hasPermission('user_index') || hasPermission('user_add') ) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Users</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('user_add')) { ?>
                      <li><a href="<?= base_url('Admin/users/add'); ?>"><i class="fa fa-plus"></i> Add User</a></li>
                      <?php }?>
                      <?php if(hasPermission('user_index')) { ?>
                      <li><a href="<?= base_url('Admin/users'); ?>"><i class="fa fa-list-alt"></i> View Users</a></li>
                      <?php }?>
                  </ul>
              </li>
              <?php } ?>

              <?php if( hasPermission('role_index') || hasPermission('role_add') ) { ?>
              <li class="treeview">
                  <a href="#">
                      <i class="fa fa-files-o"></i>
                      <span>Role and Permission</span>
                      <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                      <?php if(hasPermission('role_add')) { ?>
                      <li><a href="<?= base_url('Admin/Role/create'); ?>"><i class="fa fa-circle-o"></i> Add Role</a>
                      </li>
                      <?php }?>
                      <?php if(hasPermission('role_index')) { ?>
                      <li><a href="<?= base_url('Admin/Role'); ?>"><i class="fa fa-circle-o"></i>Role list</a></li>
                      <?php }?>
                  </ul>
              </li>
              <?php } ?>
          </ul>
          </li>

      </section>
      <!-- /.sidebar -->
  </aside>