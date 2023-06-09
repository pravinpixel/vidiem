<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">

  <link href="<?= base_url(); ?>assets/front-end/images/favicon.png" type="images/gif" rel="icon" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, initial-scale=1.0, maximum-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <?php
  if (!empty($categoryseo)) {
    foreach ($categoryseo as $info) { ?>
      <meta name="description" content="<?php echo $info['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info['meta_keywords']; ?>">
      <title><?php echo $info['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($productseo)) {
    foreach ($productseo as $info1) { ?>
      <meta name="description" content="<?php echo $info1['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info1['meta_keywords']; ?>">
      <title><?php echo $info1['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($homeseo)) {
    foreach ($homeseo as $info2) { ?>
      <meta name="description" content="<?php echo $info2['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info2['meta_keywords']; ?>">
      <title><?php echo $info2['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($aboutseo)) {
    foreach ($aboutseo as $info3) { ?>
      <meta name="description" content="<?php echo $info3['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info3['meta_keywords']; ?>">
      <title><?php echo $info3['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($productregistrationseo)) {
    foreach ($productregistrationseo as $info4) { ?>
      <meta name="description" content="<?php echo $info4['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info4['meta_keywords']; ?>">
      <title><?php echo $info4['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($usermanualseo)) {
    foreach ($usermanualseo as $info5) { ?>
      <meta name="description" content="<?php echo $info5['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info5['meta_keywords']; ?>">
      <title><?php echo $info5['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($FAQseo)) {
    foreach ($FAQseo as $info6) { ?>
      <meta name="description" content="<?php echo $info6['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info6['meta_keywords']; ?>">
      <title><?php echo $info6['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($demovideoseo)) {
    foreach ($demovideoseo as $info7) { ?>
      <meta name="description" content="<?php echo $info7['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info7['meta_keywords']; ?>">
      <title><?php echo $info7['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($dealerlocatorseo)) {
    foreach ($dealerlocatorseo as $info8) { ?>
      <meta name="description" content="<?php echo $info8['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info8['meta_keywords']; ?>">
      <title><?php echo $info8['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($servicecenterseo)) {
    foreach ($servicecenterseo as $info9) { ?>
      <meta name="description" content="<?php echo $info9['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info9['meta_keywords']; ?>">
      <title><?php echo $info9['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($warrantyseo)) {
    foreach ($warrantyseo as $info10) { ?>
      <meta name="description" content="<?php echo $info10['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info10['meta_keywords']; ?>">
      <title><?php echo $info10['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($eventsseo)) {
    foreach ($eventsseo as $info11) { ?>
      <meta name="description" content="<?php echo $info11['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info11['meta_keywords']; ?>">
      <title><?php echo $info11['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($eventsvideoseo)) {
    foreach ($eventsvideoseo as $info12) { ?>
      <meta name="description" content="<?php echo $info12['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info12['meta_keywords']; ?>">
      <title><?php echo $info12['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($pressseo)) {
    foreach ($pressseo as $info13) { ?>
      <meta name="description" content="<?php echo $info13['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info13['meta_keywords']; ?>">
      <title><?php echo $info13['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($recipeseo)) {
    foreach ($recipeseo as $info14) { ?>
      <meta name="description" content="<?php echo $info14['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info14['meta_keywords']; ?>">
      <title><?php echo $info14['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($contactseo)) {
    foreach ($contactseo as $info15) { ?>
      <meta name="description" content="<?php echo $info15['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info15['meta_keywords']; ?>">
      <title><?php echo $info15['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($offersseo)) {
    foreach ($offersseo as $info16) { ?>
      <meta name="description" content="<?php echo $info16['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info16['meta_keywords']; ?>">
      <title><?php echo $info16['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($cancellationpolicyseo)) {
    foreach ($cancellationpolicyseo as $info17) { ?>
      <meta name="description" content="<?php echo $info17['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info17['meta_keywords']; ?>">
      <title><?php echo $info17['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($Disclaimerseo)) {
    foreach ($Disclaimerseo as $info18) { ?>
      <meta name="description" content="<?php echo $info18['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info18['meta_keywords']; ?>">
      <title><?php echo $info18['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($privacypolicyseo)) {
    foreach ($privacypolicyseo as $info19) { ?>
      <meta name="description" content="<?php echo $info19['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info19['meta_keywords']; ?>">
      <title><?php echo $info19['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($shippingseo)) {
    foreach ($shippingseo as $info20) { ?>
      <meta name="description" content="<?php echo $info20['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info20['meta_keywords']; ?>">
      <title><?php echo $info20['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($sitemapseo)) {
    foreach ($sitemapseo as $info21) { ?>
      <meta name="description" content="<?php echo $info21['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info21['meta_keywords']; ?>">
      <title><?php echo $info21['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($termsconditionseo)) {
    foreach ($termsconditionseo as $info22) { ?>
      <meta name="description" content="<?php echo $info22['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info22['meta_keywords']; ?>">
      <title><?php echo $info22['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($returnrefundseo)) {
    foreach ($returnrefundseo as $info23) { ?>
      <meta name="description" content="<?php echo $info23['meta_description']; ?>">
      <meta name="keywords" content="<?php echo $info23['meta_keywords']; ?>">
      <title><?php echo $info23['meta_title']; ?></title>
  <?php }
  } ?>

  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front-end/css/style.css?v=1.1" />
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front-end/css/responsive.css?v=1.1">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front-end/css/font-awesome.css" />
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front-end/css/owl.carousel.css" />
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front-end/css/owl.theme.css" />
  <!-- <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front-end/css/range-slider.min.css" /> -->
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front-end/css/bootstrap-slider.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front-end/css/xzoom.css" />
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front-end/css/jquery.fancybox.css" />
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front-end/css/animate.min.css">

  <script type="text/javascript">
    var tmp_base_url = '<?= base_url(); ?>';
  </script>

  <script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/jquery-1.11.3.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/developer.js"></script>
  <script type="text/javascript" src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/owl.carousel.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/style_js.js"></script>
  <!-- <script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/range-slider.min.js"></script> -->
  <script src="<?= base_url(); ?>assets/front-end/js/bootstrap-slider.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/xzoom.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/setup.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/jquery.fancybox.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/date-time-picker.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

  <?php $cat_menu = $this->FunctionModel->Select_Fields('slug,name', 'vidiem_category', array('parent_id' => 0, 'status' => 1, 'slug !=' => "commercial"), 'order_no', 'ASC'); ?>
  
  <!-- Facebook Pixel Code -->
  <script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '964277054065572');
  fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=964277054065572&ev=PageView&noscript=1"
  /></noscript>
  <!-- End Facebook Pixel Code -->

  <script>
    (function(i, s, o, g, r, a, m) {
      i['GoogleAnalyticsObject'] = r;
      i[r] = i[r] || function() {
        (i[r].q = i[r].q || []).push(arguments)
      }, i[r].l = 1 * new Date();
      a = s.createElement(o),
        m = s.getElementsByTagName(o)[0];
      a.async = 1;
      a.src = g;
      m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-55669788-1', 'auto');
    ga('send', 'pageview');
  </script>
</head>

<body>

  <section class="header clearfix">
    <div class="headtop clearfix">
      <div class="container clearfix">
        <ul class="menuRight oonam">
          <li><a class="signIn" href="javascript:void(0);">Sign in</a></li>
        </ul>
        <ul class="socialMediaHeaSet clearfix">
          <li>
            <a target="_blank" href="https://www.facebook.com/VidiemTM/">
              <i class="fa fa-facebook"></i>
            </a>
          </li>
          <li>
            <a target="_blank" href="https://twitter.com/vidiemmaya">
              <i class="fa fa-twitter"></i>
            </a>
          </li>
          <li>
            <a target="_blank" href="https://www.instagram.com/vidiemtm/">
              <i class="fa fa-instagram"></i>
            </a>
          </li>
          <li>
            <a target="_blank" href="https://www.youtube.com/channel/UCLJE5AoP7y7ccfFrMFyAv8g">
              <i class="fa fa-youtube-play"></i>
            </a>
          </li>
        </ul>
        
        <a class="headCall" href="tel:18001238436">
          1800 123 8436
          <i class="fa fa-phone"></i>
        </a>
      </div>
    </div>

    <div class="headerBottom">
      <div class="container">
        <div class="logoSet clearfix">
          <a class="logo" href="<?= base_url(); ?>">
            <img src="<?= base_url(); ?>assets/front-end/images/logo.png" alt="vidiem" />
          </a>
          <div class="logoRight">
            <form method="get" action="<?= base_url('search'); ?>" class="search_form">
              <input class="itog" type="search" name="term" placeholder="Search Products" value="<?= @$search_term; ?>" />
              <i class="iclk fa fa-search"></i>
            </form>
          </div>
        </div>

        <div class="menuSet clearfix">
          <div class="res_menu">
            <a href="javascript:void(0);"><i class="fa fa-bars"></i></a>
          </div>
          <ul class="menu">
            <li><a href="<?= base_url(); ?>" <?= ($menu_id == 1) ? 'class="active"' : '' ?>>Home</a></li>

            <li class="homenu"><a href="javascript:void(0);" <?= ($menu_id == 2) ? 'class="active"' : '' ?>>About<i class="fa fa-caret-down"></i></a>
              <ul class="innermenu clearfix">
                <li>
                  <a href="<?= base_url('about-us'); ?>">About maya appliances</a>
                </li>
                <li>
                  <a href="<?= base_url('about-us#ourTeamMeb'); ?>">Our Team</a>
                </li>
                <li>
                  <a href="<?= base_url('about-us#whatSets'); ?>">What sets us apart</a>
                </li>
                <li>
                  <a href="<?= base_url('about-us#awardReg'); ?>">Awards and Recognition</a>
                </li>
              </ul>

            </li>

            <li class="homenu"><a href="javascript:void(0);" <?= ($menu_id == 2) ? 'class="active"' : '' ?>>Home Products<i class="fa fa-caret-down"></i></a>

              <ul class="innermenu clearfix">
                <?php if (!empty($cat_menu)) {
                  foreach ($cat_menu as $info) { ?>
                    <li><a href="<?= base_url('category/' . $info['slug']); ?>" class="<?= (!empty($cat_slug) && $cat_slug == $info['slug']) ? 'active' : ''; ?>"><?= $info['name']; ?></a></li>
                <?php }
                } ?>
              </ul>

            </li>
			
			
            <li class="homenu"><a href="<?= base_url('category/commercial'); ?>" <?= ($menu_id == 3) ? 'class="active"' : '' ?>>Commercial Products<i class="fa fa-caret-down"></i></a>           
            </li>

            <li class="homenu"><a href="javascript:void(0);" <?= ($menu_id == 5) ? 'class="active"' : '' ?>>Support<i class="fa fa-caret-down"></i></a>

              <ul class="innermenu clearfix">
                <li>
                  <a href="<?= base_url('product-registration'); ?>">Product Registration</a>
                </li>
                <li>
                  <a href="<?= base_url('complaint-registration'); ?>">Complaint Registration</a>
                </li>
                <li>
                  <a href="<?= base_url('user-manual'); ?>">User Manual</a>
                </li>
                <li>
                  <a href="<?= base_url('faqs'); ?>">FAQs</a>
                </li>
                <li>
                  <a href="<?= base_url('demo-videos'); ?>">Demo Videos</a>
                </li>
                <li>
                  <a href="<?= base_url('dealer-locator'); ?>">Dealer Locator</a>
                </li>
                <li>
                  <a href="<?= base_url('service-centers'); ?>">Service Centers</a>
                </li>
                <li>
                  <a href="<?= base_url('warranty'); ?>">Warranty terms</a>
                </li>
              </ul>

            </li>

            <li class="homenu"><a href="javascript:void(0);" <?= ($menu_id == 5) ? 'class="active"' : '' ?>>Media<i class="fa fa-caret-down"></i></a>

              <ul class="innermenu clearfix">
                <li>
                  <a href="<?= base_url('events'); ?>">Events</a>
                </li>
                <li>
                  <a href="<?= base_url('videos'); ?>">Videos</a>
                </li>
                <li>
                  <a href="<?= base_url('press-release'); ?>">Press Releases</a>
                </li>
              </ul>

            </li>
            <li class="homenu hide"><a href="javascript:void(0);" <?= ($menu_id == 9) ? 'class="active"' : '' ?>>Recipe<i class="fa fa-caret-down"></i></a>

              <ul class="innermenu clearfix">
                <li>
                  <a href="<?= base_url('Recipe'); ?>">Recipe</a>
                </li>
                <li>
                  <a href="<?= base_url('recipe-videos'); ?>">Recipe Videos</a>
                </li>
                <li>
                  <a href="javascript:void(0);">contest</a>
                </li>

              </ul>

            </li>



               <li><a href="<?= base_url('contact-us'); ?>" <?= ($menu_id == 6) ? 'class="active"' : '' ?>>Contact Us</a></li>
            <li> <a href="<?= base_url('product-registration'); ?>">Product Registration</a></li>

            <li><a href="<?= base_url('blog'); ?>" <?= ($menu_id == 7) ? 'class="active"' : '' ?>>Blog</a></li>

            <li><a href="<?= base_url('offers'); ?>" <?= ($menu_id == 12) ? 'class="active"' : '' ?>>Offers</a></li>
          </ul>

          <ul class="menuRight">
            <?php $client_id = $this->session->userdata('client_id');
            if (empty($client_id)) {
              ?>
              <li class="signOpt"><a target="_blank" class="signIn track" href="<?= base_url('track-order'); ?>">Track Order</a></li>
              <li class="signOpt"><a class="signIn" href="javascript:void(0);">Sign in</a>
                <ul class="signUpOpt">
                  <li><a class="signIn" href="<?= base_url('sign-in'); ?>">Sign in</a></li>
                  <li><a class="signIn" href="<?= base_url('register'); ?>">Register</a></li>
                </ul>
              </li>
            <?php } else { ?>
              <li class="signOpt"><a class="signIn" href="javascript:void(0);">Hi, <?= $this->session->userdata('client_name'); ?> </a>
                <ul class="signUpOpt">
                  <li><a class="signIn" href="<?= base_url('user/dashboard'); ?>">Dashboard</a></li>
                  <li><a class="signIn" href="<?= base_url('logout'); ?>">Logout</a></li>
                </ul>
              </li>
            <?php } ?>
            <?php
            $notification = $this->ProjectModel->Notification();
            ?>
            <li class="notifiCatioHo"><a class="iconmenu" href="javascript:void(0);">
                <i class="fa fa-bell-o"><span class="addCardNo notifoNo"><?= count($notification); ?></span></i></a>
              <?php if (!empty($notification)) { ?>
                <ul class="innermenu notifoConSet clearfix">
                  <?php foreach ($notification as $info) { ?>
                    <li>
                      <a href="<?= empty($info['url']) ? 'javascript:void(0);' : base_url($info['url']); ?>"><?= $info['title']; ?></a>
                    </li>
                  <?php } ?>
                </ul>
              <?php } ?>
            </li>

            <li class="comPiconSet"><a class="iconmenu compare_trigger" href="javascript:void(0);">
                <p class="compIconSetHead"></p>
              </a></li>

            <li class="AddCarHo"><a class="iconmenu" href="javascript:void(0);">
                <?php $cart_count = count($this->cart->contents()); ?>
                <p class="cart"><span class="addCardNo cart_total_product"><?= @$cart_count; ?></span></p></a>
              <ul class="addCartSmIn header_cart_section">
                <?php if ($cart_count == 0) { ?>
                  <li>Cart Empty</li>
                  <?php } else {
                    $content = $this->cart->contents();
                    foreach ($content as $key => $info) { ?>
                    <li class="clearfix">
                      <div class="addSmimg">
                        <img src="<?= base_url('uploads/images/' . $info['image']); ?>" alt="" />
                      </div>
                      <div class="addCartProde">
                        <p class="proAdti"><?= $info['name']; ?></p>
                        <p class="proItem">Item:<span><?= $info['qty']; ?></span></p>
                        <h4><i class="fa fa-inr"></i> <?= number_format($info['price']); ?>/-</h4>
                      </div>
                      <a href="javascript:void(0);" class="remove_from_cart" data-id="<?= $key; ?>"><i class="smcartClo fa fa-close"></i></a>
                    </li>
                  <?php } ?>
                  <li class="addTotal clearfix">
                    <div class="shipAd clearfix">
                      <p>Shipping</p>
                      <p>Free Shipping</p>
                    </div>
                    <div class="shipAd clearfix">
                      <p>Total</p>
                      <p><i class="fa fa-inr"></i> <?= number_format($this->cart->total()); ?>/-</p>
                    </div>
                    <a class="btn" href="<?= base_url('cart'); ?>">View Cart</a>
                  </li>
                <?php } ?>
              </ul>

            </li>
          </ul>


        </div>
      </div>
    </div>
  </section>