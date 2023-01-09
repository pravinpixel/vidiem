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

<section class="pt-0 pb-0 first-page">	
   <div class="container">
     	<div class="row align-items-center justify-content-between">
        	<div class="col-sm-12 col-md-12 col-lg-6">
				<div class="product-image">
					<img src="<?= base_url(); ?>assets/front-end/images/vidiem-by-you/Full_bg1.jpg" alt="" class="img-fluid full-width"/>
				</div>
         	</div>
			<div class="col-sm-12 col-md-12 col-lg-6 text-center">
				<h2 class="get-started-heading p-0 mb-3"><strong>Designed by You for You</strong></h2>
             <p class="text-center">For the <strong style="font-weight: 700;">1st time in the world</strong>, the house of Maya Appliances brings you the opportunity to build your very own Mixer Grinder to perfectly suit your everyday cooking needs. With Vidiem By You, you can make cooking the most joyous thing you do every day by making your favourite dishes in a mixer grinder designed by you!  <br/><br/>Pick from a wide variety of body styles, colours, motors, & jars and customize your mixie with a personalised message too. There are over 3 Million combinations to choose from! <br>At Maya Appliances we bring you kitchen solutions and innovations that make life in the kitchen easy, convenient and most of all fun!  <br/><strong style="font-weight: 700; color:#000; font-size:16px;">Vidiem by you</strong> <strong class="text-red" style="font-weight: 700; font-size:16px;">– My Vidiem, My Choice!</strong></p>
             <a href="<?= base_url(); ?>vidiem-by-you-customization/" class="red-btn d-inline-block w-auto start-customize-btn">Start Customizing</a>
				<iframe src="https://www.youtube.com/embed/SuJTgr5GgqM" title="Vidiem" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="get-started-video" allowfullscreen></iframe>
         	</div>
        </div>
    </div> 
</section>



<?php require_once('container/footer-customize.php')?>