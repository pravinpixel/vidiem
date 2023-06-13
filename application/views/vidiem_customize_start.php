<?php include('container/header.php'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front-end/css/vidiem-by-you.css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap" rel="stylesheet">
<div class="by-you-header">
    <a href="<?= base_url(); ?>"><img src="<?= base_url(); ?>assets/front-end/images/logo.png" alt="" /></a>
	<!-- <div class="header-text">Vidiem by You</div> -->
    <div class="by-you-cart"><img src="<?= base_url(); ?>assets/front-end/images/cart-icon.svg" atl="" /> <span class="count cart_total_product"><?= @$cart_count; ?></span></div>
    <a href="<?= base_url(); ?>" class="red-btn back-to-home"><i class="fa fa-home" aria-hidden="true"></i></a>
</div>
<!--<div class="cart-coupon">Please note that due to the Year End Process our shipments will be delayed by a few days. Normal delivery will resume from April 8th Onwards.</div>-->
<section class="pt-0 pb-0 first-page">	
   <div class="container">
     	<div class="row align-items-center justify-content-between">
        	<div class="col-sm-12 col-md-12 col-lg-6">
				<div class="product-image">
					<img src="<?= base_url(); ?>assets/front-end/images/vidiem-by-you/Full_bg1.jpg" alt="" class="img-fluid full-width"/>
				</div>
         	</div>
			<div class="col-sm-12 col-md-12 col-lg-6 text-center">
				<h2 class="get-started-heading p-0 mb-3 mt-3"><strong>Designed by You for You</strong></h2>
             <p class="text-center">For the <strong style="font-weight: 700;">1st time in the world</strong>, the house of Maya Appliances brings you the opportunity to build your very own Mixer Grinder to perfectly suit your everyday cooking needs. With Vidiem By You, you can make cooking the most joyous thing you do every day by making your favourite dishes in a mixer grinder designed by you!  <br/><br/>Pick from a wide variety of body styles, colours, motors, & jars and customize your mixie with a personalised message too. There are over 3 Million combinations to choose from! <br>At Maya Appliances we bring you kitchen solutions and innovations that make life in the kitchen easy, convenient and most of all fun!  <br/><strong style="font-weight: 700; color:#000; font-size:16px;">Vidiem by you</strong> <strong class="text-red" style="font-weight: 700; font-size:16px;">– My Vidiem, My Choice!</strong></p>
             <a href="<?= base_url(); ?>vidiem-by-you-customization/" class="red-btn d-inline-block w-auto start-customize-btn">Start Customizing</a>
			 <ul id="video-tabs" class="nav nav-tabs">
                <li class="nav-item"><a href="" data-target="#tamil" id="video1Play" data-toggle="tab" class="nav-link active">Tamil</a></li>
                <li class="nav-item"><a href="" data-target="#english" id="video2Play" data-toggle="tab" class="nav-link">English</a></li>
                <li class="nav-item"><a href="" data-target="#malayalam" id="video3Play" data-toggle="tab" class="nav-link">Malayalam</a></li>
				<li class="nav-item"><a href="" data-target="#hindi" id="video4Play" data-toggle="tab" class="nav-link">Hindi</a></li>
            </ul>
            <div id="video-tabs-Content" class="tab-content">
                <div id="tamil" class="tab-pane active show">
                    <iframe src="https://www.youtube.com/embed/ai2OPonHtcQ?rel=0" id="video1" title="Vidiem" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="get-started-video" allowfullscreen></iframe>
                </div>
                <div id="english" class="tab-pane">
                    <iframe src="https://www.youtube.com/embed/eUcNTFeQvWM?rel=0" id="video2" title="Vidiem" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="get-started-video" allowfullscreen></iframe>
                </div>
                <div id="malayalam" class="tab-pane">
                    <iframe src="https://www.youtube.com/embed/a9AhaAlqyQk?rel=0" id="video3" title="Vidiem" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="get-started-video" allowfullscreen></iframe>
                </div>
				<div id="hindi" class="tab-pane">
                    <iframe src="https://www.youtube.com/embed/6DSbGbp03Bw?rel=0" id="video4" title="Vidiem" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="get-started-video" allowfullscreen></iframe>
                </div>
            </div>				
         	</div>
        </div>
    </div> 
</section>



<?php require_once('container/footer-customize.php')?>
<script>
 $("#video1Play").click(function() {
      $("#video2").each(function(index) {
        $(this).attr('src', $(this).attr('src'));
        return false;
      });
	  $("#video3").each(function(index) {
        $(this).attr('src', $(this).attr('src'));
        return false;
      });
	  $("#video4").each(function(index) {
        $(this).attr('src', $(this).attr('src'));
        return false;
      });
 });

 $("#video2Play").click(function() {
      $("#video1").each(function(index) {
        $(this).attr('src', $(this).attr('src'));
        return false;
      });
	  $("#video3").each(function(index) {
        $(this).attr('src', $(this).attr('src'));
        return false;
      });
	  $("#video4").each(function(index) {
        $(this).attr('src', $(this).attr('src'));
        return false;
      });
 });
 
 $("#video3Play").click(function() {
      $("#video1").each(function(index) {
        $(this).attr('src', $(this).attr('src'));
        return false;
      });
	  $("#video2").each(function(index) {
        $(this).attr('src', $(this).attr('src'));
        return false;
      });
	  $("#video4").each(function(index) {
        $(this).attr('src', $(this).attr('src'));
        return false;
      });
 });
 
  $("#video4Play").click(function() {
      $("#video1").each(function(index) {
        $(this).attr('src', $(this).attr('src'));
        return false;
      });
	  $("#video2").each(function(index) {
        $(this).attr('src', $(this).attr('src'));
        return false;
      });
	  $("#video3").each(function(index) {
        $(this).attr('src', $(this).attr('src'));
        return false;
      });
 });
</script>
