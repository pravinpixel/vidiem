<!DOCTYPE html>
<html lang="en">
   <head>
       <?php
       $currentURL = current_url(); //http://myhost/main

$params   = $_SERVER['QUERY_STRING']; //my_id=1,3

$fullURL = $currentURL ; 

//echo $fullURL;
       ?>
   <link rel="canonical" href="<?php echo $fullURL; ?>" />
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
       <?php
  if (!empty($categoryseo)) {
    foreach ($categoryseo as $info) { ?>
      <meta name="description" content="<?php echo $info['meta_description']; ?>">
     <!-- <meta name="keywords" content="<?php echo $info['meta_keywords']; ?>">-->
      <title><?php echo $info['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($productseo)) {
    foreach ($productseo as $info1) { ?>
      <meta name="description" content="<?php echo $info1['meta_description']; ?>">
    <!--  <meta name="keywords" content="<?php echo $info1['meta_keywords']; ?>"> -->
      <title><?php echo $info1['meta_title']==''?$info1['name']:$info1['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($homeseo)) {
    foreach ($homeseo as $info2) { ?>
      <meta name="description" content="<?php echo $info2['meta_description']; ?>">
     <!-- <meta name="keywords" content="<?php echo $info2['meta_keywords']; ?>"> -->
      <title><?php echo $info2['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($aboutseo)) {
    foreach ($aboutseo as $info3) { ?>
      <meta name="description" content="<?php echo $info3['meta_description']; ?>">
     <!-- <meta name="keywords" content="<?php echo $info3['meta_keywords']; ?>"> -->
      <title><?php echo $info3['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($productregistrationseo)) {
    foreach ($productregistrationseo as $info4) { ?>
      <meta name="description" content="<?php echo $info4['meta_description']; ?>">
     <!-- <meta name="keywords" content="<?php echo $info4['meta_keywords']; ?>"> -->
      <title><?php echo $info4['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($usermanualseo)) {
    foreach ($usermanualseo as $info5) { ?>
      <meta name="description" content="<?php echo $info5['meta_description']; ?>">
     <!-- <meta name="keywords" content="<?php echo $info5['meta_keywords']; ?>"> -->
      <title><?php echo $info5['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($FAQseo)) {
    foreach ($FAQseo as $info6) { ?>
      <meta name="description" content="<?php echo $info6['meta_description']; ?>">
    <!--  <meta name="keywords" content="<?php echo $info6['meta_keywords']; ?>"> -->
      <title><?php echo $info6['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($demovideoseo)) {
    foreach ($demovideoseo as $info7) { ?>
      <meta name="description" content="<?php echo $info7['meta_description']; ?>">
     <!-- <meta name="keywords" content="<?php echo $info7['meta_keywords']; ?>"> -->
      <title><?php echo $info7['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($dealerlocatorseo)) {
    foreach ($dealerlocatorseo as $info8) { ?>
      <meta name="description" content="<?php echo $info8['meta_description']; ?>">
    <!--  <meta name="keywords" content="<?php echo $info8['meta_keywords']; ?>"> -->
      <title><?php echo $info8['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($servicecenterseo)) {
    foreach ($servicecenterseo as $info9) { ?>
      <meta name="description" content="<?php echo $info9['meta_description']; ?>">
   <!--   <meta name="keywords" content="<?php echo $info9['meta_keywords']; ?>"> -->
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
   <!--   <meta name="keywords" content="<?php echo $info11['meta_keywords']; ?>"> -->
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
    <!--  <meta name="keywords" content="<?php echo $info13['meta_keywords']; ?>"> -->
      <title><?php echo $info13['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($recipeseo)) {
    foreach ($recipeseo as $info14) { ?>
      <meta name="description" content="<?php echo $info14['meta_description']; ?>">
    <!--  <meta name="keywords" content="<?php echo $info14['meta_keywords']; ?>"> -->
      <title><?php echo $info14['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($contactseo)) {
    foreach ($contactseo as $info15) { ?>
      <meta name="description" content="<?php echo $info15['meta_description']; ?>">
    <!--  <meta name="keywords" content="<?php echo $info15['meta_keywords']; ?>"> -->
      <title><?php echo $info15['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($offersseo)) {
    foreach ($offersseo as $info16) { ?>
      <meta name="description" content="<?php echo $info16['meta_description']; ?>">
  <!--    <meta name="keywords" content="<?php echo $info16['meta_keywords']; ?>"> -->
      <title><?php echo $info16['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($cancellationpolicyseo)) {
    foreach ($cancellationpolicyseo as $info17) { ?>
      <meta name="description" content="<?php echo $info17['meta_description']; ?>">
   <!--   <meta name="keywords" content="<?php echo $info17['meta_keywords']; ?>"> -->
      <title><?php echo $info17['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($Disclaimerseo)) {
    foreach ($Disclaimerseo as $info18) { ?>
      <meta name="description" content="<?php echo $info18['meta_description']; ?>">
    <!--  <meta name="keywords" content="<?php echo $info18['meta_keywords']; ?>"> -->
      <title><?php echo $info18['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($privacypolicyseo)) {
    foreach ($privacypolicyseo as $info19) { ?>
      <meta name="description" content="<?php echo $info19['meta_description']; ?>">
   <!--   <meta name="keywords" content="<?php echo $info19['meta_keywords']; ?>"> -->
      <title><?php echo $info19['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($shippingseo)) {
    foreach ($shippingseo as $info20) { ?>
      <meta name="description" content="<?php echo $info20['meta_description']; ?>">
    <!--  <meta name="keywords" content="<?php echo $info20['meta_keywords']; ?>"> -->
      <title><?php echo $info20['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($sitemapseo)) {
    foreach ($sitemapseo as $info21) { ?>
      <meta name="description" content="<?php echo $info21['meta_description']; ?>">
   <!--   <meta name="keywords" content="<?php echo $info21['meta_keywords']; ?>"> -->
      <title><?php echo $info21['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($termsconditionseo)) {
    foreach ($termsconditionseo as $info22) { ?>
      <meta name="description" content="<?php echo $info22['meta_description']; ?>">
  <!--    <meta name="keywords" content="<?php echo $info22['meta_keywords']; ?>"> -->
      <title><?php echo $info22['meta_title']; ?></title>
  <?php }
  } ?>
    <?php
  if (!empty($vidiemadcseo)) {
    foreach ($vidiemadcseo as $info22) { ?>
      <meta name="description" content="<?php echo $info22['meta_description']; ?>">
    <!--  <meta name="keywords" content="<?php echo $info22['meta_keywords']; ?>"> -->
      <title><?php echo $info22['meta_title']; ?></title>
  <?php }
  } ?>
    <?php
  if (!empty($vidiemirisseo)) {
    foreach ($vidiemirisseo as $info22) { ?>
      <meta name="description" content="<?php echo $info22['meta_description']; ?>">
   <!--   <meta name="keywords" content="<?php echo $info22['meta_keywords']; ?>"> -->
      <title><?php echo $info22['meta_title']; ?></title>
  <?php }
  } ?>
    <?php
  if (!empty($vidiemtuskerseo)) {
    foreach ($vidiemtuskerseo as $info22) { ?>
      <meta name="description" content="<?php echo $info22['meta_description']; ?>">
    <!--  <meta name="keywords" content="<?php echo $info22['meta_keywords']; ?>"> -->
      <title><?php echo $info22['meta_title']; ?></title>
  <?php }
  } ?>
  <?php
  if (!empty($returnrefundseo)) {
    foreach ($returnrefundseo as $info23) { ?>
      <meta name="description" content="<?php echo $info23['meta_description']; ?>">
    <!--  <meta name="keywords" content="<?php echo $info23['meta_keywords']; ?>"> -->
      <title><?php echo $info23['meta_title']; ?></title>
  <?php }
  } ?>
  
   <?php
  if (!empty($vidiemforyouseo)) {
    foreach ($vidiemforyouseo as $info23) { ?>
      <meta name="description" content="<?php echo $info23['meta_description']; ?>">
    <!--  <meta name="keywords" content="<?php echo $info23['meta_keywords']; ?>"> -->
      <title><?php echo $info23['meta_title']; ?></title>
  <?php }
  }?>
  
  <?php
  if (!empty($fullURL) & $fullURL=='https://www.vidiem.in/vidiem-by-you') {?>
      <meta name="description" content="<?php echo @$desc ?>">
      <title><?php echo @$title ?></title>
  <?php }?>
  
   <?php
  if (!empty($fullURL) & $fullURL=='https://www.vidiem.in/customize-cart') {?>
      <meta name="description" content="Vidiem By You, Customized cart for your customized Mixer Grinder">
      <title>Videm By You - Customized Cart</title>
  <?php }?>
  
  
      <!-- Favicons -->
      <link href="<?= base_url(); ?>assets/front-end/images/favicon.png" rel="icon">
      <!-- Vendor CSS Files -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
      <!-- Material Design Bootstrap -->
	  <link href="<?= base_url(); ?>assets/front-end/css/mdb.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" />
      <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
      <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"  />	  
	  <link href="<?= base_url(); ?>assets/front-end/css/bootstrap-slider.css" rel="stylesheet">
	  <link href="<?= base_url(); ?>assets/front-end/css/jquery.scrolling-tabs.css" rel="stylesheet">	  
	  <!-- custom scrollbar stylesheet -->
	  <link rel="stylesheet" href="<?= base_url(); ?>assets/front-end/css/jquery.mCustomScrollbar.css">
      <!-- Template Main CSS File -->
      <link href="<?= base_url(); ?>assets/front-end/css/menu.css" rel="stylesheet">
      <link href="<?= base_url(); ?>assets/front-end/css/style.css" rel="stylesheet">
	  <!--<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />-->
	<script type="text/javascript">
    var tmp_base_url = '<?= base_url(); ?>'; 
	var client_id = '<?= $client_id; ?>';
	</script>
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
<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DDV2M09YRE"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-DDV2M09YRE');
    </script>
    
    
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
<meta name="facebook-domain-verification" content="dh80vy82h3u8yn3tk00gyihq35a62g" />

<script type='text/javascript'> 
window.__lo_site_id = 321709;

(function() {
var wa = document.createElement('script'); wa.type = 'text/javascript'; wa.async = true;
wa.src = 'https://d10lpsik1i8c69.cloudfront.net/w.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(wa, s);
 })();
</script>


<!-- Global site tag (gtag.js) - Google Analytics --> 
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-55669788-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-55669788-3');
</script>

<script async defer src="https://tools.luckyorange.com/core/lo.js?site-id=715bd2cd"></script>


<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WPJZTJ');</script>
<!-- End Google Tag Manager -->

   </head>
   <body>
       
       <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WPJZTJ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
