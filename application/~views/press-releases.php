<?php include('container/header.php'); ?>

<section class="ban-next light-gray-bg pb-0">
	<div class="container">
		<div class="row">
			<div class="col">
				<h2 class="pb-5 mb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Press Releases</h2>
			</div>
		</div>
	</div>
</section>

<!--<section class="ban-next light-gray-bg pt-0">
<div class="bgPro videoGal clearfix">
	<div class="container videoBack clearfix">

		<div class="videoSet pressRelSet p-5 bg-white shadow1">
			<h3>News Paper Advertisements</h3>
			<div class="addSet clearfix row" id="myList">
				<?php if(!empty($press)){
				    foreach ($press as $info) { ?>
				<div class="col-sm-12 col-md-4 mb-5">
				    <a class="bg-white shadow1 p-4 d-block" href="<?= (!empty($info['file'])?base_url('uploads/press/pdf/'.$info['file']):'javascript:void(0);')?>" target="_blank">
						<div class="addImg">
							<img src="<?= base_url('uploads/press/'.$info['image']); ?>" alt="press" class="img-fluid" />
						</div>
						<div class="addCn">
							<h4 class="text-dark mt-3 mb-3"><?= $info['name']; ?></h4>
							<p class="mb-0"><?= $info['place']; ?></p>
							<p><small><?= $info['pressdate']; ?></small></p>
						</div>
					</a>
				</div>
				<?php } } ?>
			</div>
			<a id="loadMore" class="red-btn small">Older Posts</a>
		</div>

	</div>
</div>

</section>-->

<section class="light-gray-bg">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<h1 class="text-red" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">media</h1>
				<h2 class="pb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">News Paper<br/>Advertisements</h2>
			</div>
		</div>
		<div class="row">
		
			<?php if(!empty($press)){

					 foreach ($press as $info) { ?>
			<div class="col-sm-12 col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
			    <a href="<?= (!empty($info['file'])?base_url('uploads/press/pdf/'.$info['file']):'javascript:void(0);')?>" target="_blank">
				<img src="<?= base_url('uploads/press/'.$info['image']); ?>" alt="" class="img-fluid"/>
				<h4 class="mt-3"><?= $info['name']; ?></h4>
				<p></p>
				</a>
			</div>
			<?php } } else{  ?>
			
			<div class="col-sm-12 col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
				
				<h4 class="mt-3">Coming Soon...</h4>
				
			</div>
			
			<?php }  ?>
			
			
		</div>
	</div>

</section>


<?php require_once('container/footer.php'); ?>
<!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script>-->
<script>
	$(document).ready(function () {
    size_li = $("#myList li").size();
    x=3;
    $('#myList li:lt('+x+')').show();
    $('#loadMore').click(function () {
        x= (x+5 <= size_li) ? x+5 : size_li;
        $('#myList li:lt('+x+')').show();
         $('#showLess').show();
        if(x == size_li){
            $('#loadMore').hide();
        }
        if(x == 3){
            $('#loadMore').hide();
        }
    });
    $('#showLess').click(function () {
        x=(x-5<0) ? 3 : x-5;
        $('#myList li').not(':lt('+x+')').hide();
        $('#loadMore').show();
         $('#showLess').show();
        if(x == 3){
            $('#showLess').hide();
        }
    });
});
</script>
<style>
	#myList li{ display:none;
}

</style>