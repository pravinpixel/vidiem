<?php 
include('header-top.php');
 
$cat_menu = $this->FunctionModel->Select_Fields('id,slug,name,image', 'vidiem_category', array('parent_id' => 0, 'status' => 1, 'slug !=' => "commercial"), 'order_no', 'ASC'); 
$exclusiveMenu = $this->FunctionModel->getExclusiveMenu();
$dealer_session = $this->session->userdata('dealer_session'); 
?>


<header id="header">
    <!-- header start -->
    <div class="header-classic">
        <!-- top header start -->
		<?php 
        
		if( isset( $dealer_session['user']) ) { 
			if( $dealer_session['user']['user_type'] != 'sale_person' ) {
				// redirect();
			}
		} else {
		?>
        <div class="top-header">
            <div class="container p-0">
                <div class="row">
                    <div class="col-xl-5 col-lg-6 col-md-6 col-sm-6">
                        <span class="text-white"><img src="<?= base_url(); ?>assets/front-end/images/phone.svg"
                                atl="" /> &nbsp; Call Us : </span>
                        <a class="top-phone" href="tel:044-6635 6635">044-6635 6635</a> <span class="text-white">&nbsp;
                            / &nbsp;</span>
                        <a class="top-phone" href="tel:7711006635">77110 06635</a>
                    </div>
                    <div class="col-xl-7 col-lg-6 col-md-6 col-sm-6 d-flex justify-content-end">
                        <ul class="list-unstyled">
                            <li class="d-none d-xl-block d-lg-block">
                                <a href="<?= base_url('product-registration'); ?>">Product Registration</a>
                            </li>
                            <li class="d-none d-xl-block d-lg-block">
                                <a href="<?= base_url('track-order'); ?>">Track Order</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
		<?php } ?>
        <!-- top header close -->
        <!-- navigation start -->
        <div class="container p-0">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <nav class="navbar navbar-expand-xl navbar-classic">
                        <a class="navbar-brand" href="<?= base_url(); ?>"><img
                                src="<?= base_url(); ?>assets/front-end/images/logo.png" alt="" /></a>

						<?php 
						if( isset( $dealer_session['user']) ) { 
							if( $dealer_session['user']['user_type'] != 'sale_person' ) {
								// redirect();
							} ?>
						
						<a href="<?= base_url(); ?>vidiem-dealer" class="dealer-logo">
							<!-- <img src="<?= base_url(); ?>assets/front-end/images/dealer.png" alt="Dealer logo"  class="img-fluid" style="max-width: 200px;"/>  -->
                            <img src="<?= base_url(); ?>uploads/dealer/<?= $this->session->userdata('dealer_session')['dealer']['image'] ?>" alt="Dealer logo" class="img-fluid" style="max-width: 200px;" width="100" />
                            <?= $this->session->userdata('dealer_session')['location']['location_name'] ?> &nbsp;
					        <?= $this->session->userdata('dealer_session')['location']['location_address'] ?? '' ?>
						</a>	
						<div class="ml-auto">							
							<img src="<?= base_url(); ?>assets/front-end/images/vidiem-by-you/vidiem-by-you-logo.png" alt="logo"  class="img-fluid mr-4" style="max-width: 130px;"/>
							<a href="<?= base_url()?>dealer/logout" class="red-btn w-auto d-inline" title="Logout" data-toggle="tooltip" data-placement="bottom"><i class="lni lni-exit"></i></a>
						</div>
						
						<?php 
						} else {
						?>
                        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                            data-target="#navbar-classic" aria-controls="navbar-classic" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="icon-bar top-bar mt-0"></span>
                            <span class="icon-bar middle-bar"></span>
                            <span class="icon-bar bottom-bar"></span>
                        </button>
						
                        <div class="collapse navbar-collapse" id="navbar-classic">
                            <ul class="navbar-nav ml-auto mt-2 mt-lg-0 mr-3">
                                <li class="nav-item  <?php if($this->uri->segment(1)==""){echo "active";}?>">
                                    <a class="nav-link" href="<?= base_url(); ?>">Home</a>
                                </li>

                                <li
                                    class="nav-item vidiem-by-you <?php if($this->uri->segment(1)=="vidiem-by-you"){echo "active";}?>">
                                    <a class="nav-link" href="<?= base_url('vidiem-by-you'); ?>">Vidiem By You</a>
                                </li>

                                <li
                                    class="nav-item dropdown <?php if($this->uri->segment(1)=="category"){echo "active";}?>">
                                    <a class="nav-link dropdown-toggle" href="" id="menu-1" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Products
                                    </a>
                                    <ul class="dropdown-menu mega-menu" aria-labelledby="menu-1">
                                        <li class="row">
                                            <!--<ul class="col">
										  <li class="heading1">Shop by Products</li>
                                          <li>
											<?php if (!empty($cat_menu)) {
											  foreach ($cat_menu as $info) { ?>
												<a href="<?= base_url('category/' . $info['slug']); ?>" class="<?= (!empty($cat_slug) && $cat_slug == $info['slug']) ? 'active' : ''; ?> dropdown-item"><?= $info['name']; ?></a>
											<?php }
											} ?>
                                          </li>
                                       </ul>-->

                                            <!-- <ul class="col">
										  <li class="heading1">Shop by Model</li>
										  
										 <?php if (!empty($cat_menu)) {
										$cnt=1;	 
										  foreach ($cat_menu as $info) { 
										  if($cnt==1 || $cnt==3){
										  ?>
										      
											  <li class="heading2"><?= $info['name']; ?></li>
										  <?php }
											   $subcat_menu = $this->FunctionModel->Select_Fields('id,slug,name,image', 'vidiem_category', array('parent_id' => $info['id'] , 'status' => 1, 'slug !=' => "commercial"), 'order_no', 'ASC'); 
											   if (!empty($subcat_menu)) {
												foreach ($subcat_menu as $subinfo) {
													if($cnt==1 || $cnt==3){
											   ?>
											  <li>
												<a class="dropdown-item" href="javascript:void(0)" onclick="subcatfunction('<?= $subinfo['id']; ?>','<?= $info['slug']; ?>');"><?= $subinfo['name']; ?></a>
											  </li>
													<?php } } } $cnt++; } } ?>
										
                                       </ul>   -->


                                            <!--	   <ul class="col">
										  <li class="heading1">&nbsp;</li>
										  
										 <?php if (!empty($cat_menu)) {
										$cnt=1;	 
										  foreach ($cat_menu as $info) { 
										  if($cnt==2 || $cnt==4){
										  ?>
										      
											  <li class="heading2"><?= $info['name']; ?></li>
										  <?php }
											   $subcat_menu = $this->FunctionModel->Select_Fields('id,slug,name,image', 'vidiem_category', array('parent_id' => $info['id'] , 'status' => 1, 'slug !=' => "commercial"), 'order_no', 'ASC'); 
											   if (!empty($subcat_menu)) {
												foreach ($subcat_menu as $subinfo) {
													if($cnt==2 || $cnt==4){
											   ?>
											  <li>
												<a class="dropdown-item" href="javascript:void(0)" onclick="subcatfunction('<?= $subinfo['id']; ?>','<?= $info['slug']; ?>');"><?= $subinfo['name']; ?></a>
											  </li>
													<?php } } } $cnt++; } } ?>
										
                                       </ul>   -->

                                            <?php if (!empty($cat_menu)) {
											  foreach ($cat_menu as $info) { ?>
                                            <ul class="col">
                                                <li class="has-image"><a class="dropdown-item"
                                                        href="<?= base_url('category/' . $info['slug']); ?>">
                                                        <?= $info['name']; ?> <img
                                                            src="<?= base_url(); ?>uploads/images/<?= $info['image']; ?>"
                                                            alt="" /></a>
                                                </li>
                                            </ul>
                                            <?php }
											} ?>

                                        </li>
                                    </ul>
                                </li>
                                <!-- <li
                                    class="nav-item dropdown <?php if($this->uri->segment(1)=="exclusive-products"){echo "active";}?>">
                                    <a class="nav-link" href="<?= base_url('exclusive-products'); ?>">Online
                                        Exclusives</a>
                                </li> -->
                                <li
                                    class="nav-item dropdown <?php if($this->uri->segment(1)=="exclusive-products"){echo "active";}?>">
                                    <a class="nav-link dropdown-toggle" href="<?= base_url('exclusive-products'); ?>" id="menu-1" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">Online
                                        Exclusives</a>
                                        <ul class="dropdown-menu" aria-labelledby="menu-1">
                                            <?php if (!empty($exclusiveMenu)) {
											  foreach ($exclusiveMenu as $info) { ?>
                                            
                                                <li class="has-image"><a class="dropdown-item"
                                                        href="<?= base_url('exclusive-products/' . $info->slug); ?>">
                                                        <?= $info->name; ?></a>
                                                </li>
                                          
                                            <?php }
											} ?>
                                    </ul>
                                </li>

                                <li class="nav-item dropdown">

                                    <?php 
							   $mediacls='';
                               $slug = '';
							   if(($slug== 'events') || ($slug== 'videos') || ($slug== 'press-release')){
								 $mediacls='active';  
								   
							   } ?>
                                    <a class="nav-link dropdown-toggle <?= $mediacls; ?>" href="#" id="menu-3"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Media
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="menu-3">
                                        <!-- <li>
									  <a class="dropdown-item <?php if($slug== 'events'){ echo 'active'; } ?>" href="<?= base_url('events'); ?>">Events</a>
									</li>-->
                                        <li>
                                            <a class="dropdown-item <?php if($slug== 'videos'){ echo 'active'; } ?>"
                                                href="<?= base_url('videos'); ?>">Videos</a>
                                        </li>
                                        <!--	<li>
									  <a class="dropdown-item <?php if($slug== 'press-release'){ echo 'active'; } ?>" href="<?= base_url('press-release'); ?>">Press Releases</a>
									</li>-->

                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url('about-us'); ?>">About Vidiem</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url('contact-us'); ?>">Contact Us</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="menu-2" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Support
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="menu-2">
                                        <li>
                                            <a class="dropdown-item"
                                                href="<?= base_url('product-registration'); ?>">Product Registration</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="<?= base_url('complaint-registration'); ?>">Complaint
                                                Registration</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('user-manual'); ?>">User
                                                Manual</a>
                                        </li>
                                        <!--	<li>
									  <a class="dropdown-item" href="<?= base_url('faqs'); ?>">FAQs</a>
									</li>  -->
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('videos'); ?>">Demo Videos</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('dealer-locator'); ?>">Dealer
                                                Locator</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('service-centers'); ?>">Service
                                                Centers</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('warranty'); ?>">Warranty
                                                terms</a>
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <ul class="top-signin">
                            <?php $client_id = $this->session->userdata('client_id');
							if (!empty($client_id)) { ?>
                            <li class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="menu-3" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="lni lni-user"></i> <span>Hi,
                                        <?= $this->session->userdata('client_name'); ?></span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="menu-3">
                                    <li><a class="dropdown-item" href="<?= base_url('user/dashboard'); ?>">
                                            <i class="lni lni-user"></i> My Account</a>
                                    </li>

                                    <li><a class="dropdown-item" href="<?= base_url('logout'); ?>">
                                            <i class="lni lni-exit"></i> Logout</a>
                                    </li>
                                </ul>
                            </li>
                            <?php } else { ?>
                            <li>
                                <a href="<?= base_url('sign-in'); ?>"><span>Sign In</span> <img
                                        src="<?= base_url(); ?>assets/front-end/images/sign-in.svg" atl="" /></a>
                            </li>
                            <?php } ?>
                            <li>
                                <a class="top-search"><img
                                        src="<?= base_url(); ?>assets/front-end/images/search-icon.svg" atl="" /></a>
                            </li>
                            <li class="dropdown cart header_cart_section">
                                <?php $cart_count = count($this->cart->contents() ); 
							  //print_r($this->cart->contents()); exit;
							  ?>
                                <a class="nav-link dropdown-toggle" href="#" id="menu-4" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <img src="<?= base_url(); ?>assets/front-end/images/cart-icon.svg" atl="" /> <span
                                        class="count cart_total_product"><?= @$cart_count; ?></span>
                                </a>

                                <?php if ($cart_count == 0) { ?>

                                <div class="dropdown-menu" aria-labelledby="menu-4">
                                    <div class="cart-table">
                                        <table class="table table-bordered">
                                            Cart Empty
                                        </table>
                                    </div>
                                </div>

                                <?php } else { ?>
                                <div class="dropdown-menu " aria-labelledby="menu-4">
                                    <div class="cart-table">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Description</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $content = $this->cart->contents();
											  foreach ($content as $key => $info) { ?>
                                                <tr>
                                                    <td>
                                                        <img src="<?= base_url('uploads/images/' . $info['image']); ?>"
                                                            alt="" />
                                                    </td>
                                                    <td>
                                                        <p><strong>Vidiem</strong> <?= $info['name']; ?></p>

                                                        <p class="price">₹
                                                            <?= number_format($info['price']); if(isset($info['old_price'])){ ?>
                                                            <span class="strike">₹
                                                                <?= number_format($info['old_price']); ?> </span>
                                                            <?php } ?></p>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-xs btn-danger remove_from_cart"
                                                            data-id="<?= $key; ?>">
                                                            <i class="lni lni-trash"></i>
                                                        </button>

                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="cart-buttons">
                                        <a href="<?= base_url('cart'); ?>" class="nav-buy-now"><img
                                                src="<?= base_url(); ?>assets/front-end/images/cart-icon1.svg" atl="" />
                                            View Cart</a>
                                        <a class="nav-add-to-cart" href="<?= base_url('checkout'); ?>"><img
                                                src="<?= base_url(); ?>assets/front-end/images/cart-icon1.svg" atl="" />
                                            Checkout</a>
                                    </div>
                                </div>
                                <?php } ?>

                            </li>
                        </ul>
                        <div class="top-search-open">
                            <form method="get" action="<?= base_url('search'); ?>">
                                <div class="input-group md-form form-sm">
                                    <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                                        name="term" value="<?= @$search_term; ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-link" id="basic-text1"><img
                                                src="<?= base_url(); ?>assets/front-end/images/search-icon.svg"
                                                atl="" /></button>
                                    </div>
                                </div>
                            </form>
                            <button class="search-close"><i class="lni lni-close"></i></button>
                        </div>
						<?php } ?>
                    </nav>
                </div>
            </div>
        </div>
        <!-- navigation close -->
    </div>
    <!-- header close -->
</header>