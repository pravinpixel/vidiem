<?php include('container/header.php'); 

?>
<style type="text/css">
    iframe.iframe-service-center{
        width: 100%;
        height: 580px;
    }
    @media (max-width:760px){
        iframe.iframe-service-center{
            height: 1130px;
        }
    }
</style>
<section class="inner-page-bg">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-8">
				<h1 class="text-red" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Customer Care Centers</h1>
				<h2 class="pb-5 mb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Customer Care Centers</h2>
			</div>
			<div class="col-sm-12 col-md-4 d-none d-md-block">
				<img src="<?= base_url(); ?>assets/front-end/images/dealer-locator.svg" alt="" class="img-fluid"  data-aos="fade-left" data-aos-delay="50" data-aos-duration="1000"/>
				<div class="text-right overlay-title pb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Customer Care Centers</div>
			</div>
		</div>		
	
</div>

<div class="bgPro videoGal clearfix">
	<div class="container mt-5 bg-white p-5 shadow1">
	<iframe src="https://www.vidiem.in/map/embed.php?locator=service" class="iframe-service-center" scrolling=no frameborder=no allowtransparency="true"></iframe>
	<!--<iframe src="https://www.vidiem.in/map1/embed.php" width="100%" height="630px"  scrolling=no frameborder=no></iframe>-->
	</div>
</div>

</section>
<?php require_once('container/footer1.php')?>
