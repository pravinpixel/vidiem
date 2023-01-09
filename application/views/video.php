<?php include('container/header.php'); 

//echo "<pre>"; print_r($press); exit;
?>

<section class="ban-next pb-0">
	<div class="container clearfix">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<h1 class="text-red text-center" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">TV Commercials</h1>
				<h2 class="pb-5 text-center" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">advertising &amp;<br/>marketing Videos</h2>
			</div>
		</div>
</div>

</section>		
		
<section class="pt-0 pb-0 position-relative d-none d-md-block">
	<div class="video-bg"></div>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-5">
				<div class="scoll-tabs">
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				    
					<?php if(!empty($video_cat)){
						$cnt=1;
										
					foreach ($video_cat as $info) { 
						$activecls ='';	
						if($cnt==1){
							$activecls ='active';
						}
					?>
					<li role="presentation"><a href="#tab<?= $cnt; ?>" class="<?= $activecls; ?>" aria-controls="tab<?= $cnt; ?>" role="tab" data-toggle="tab"><?= $info['title']; ?></a></li>
					
					<?php $cnt++; } } ?>

				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
				    
					<?php if(!empty($video_cat)){
					$cnt=1;
					 foreach ($video_cat as $info) { 
					  $activecls ='';
					  if($cnt==1){
							$activecls ='active';
						}
					 $videos=$this->FunctionModel->Select('vidiem_media_videos',array('parent_id'=>$info['id'],'status'=>1),'order_no','ASC');
					if(!empty($videos)){
						 ?>
					
					<div role="tabpanel" class="tab-pane <?= $activecls; ?>" id="tab<?= $cnt; ?>">
					
						<div id="sync1" class="slider owl-carousel owl-theme">
						    <?php foreach($videos as $tmp){ ?>
							<div class="item-video"><a class="owl-video" href="https://www.youtube.com/watch?v=<?= $tmp['video_url'];?>"></a></div>
							<?php } ?>
							
						</div>
						<div id="sync2" class="navigation-thumbs owl-carousel">
						 <?php foreach($videos as $tmp){ ?>
						  <div class="item">
						 <img src="<?= base_url(); ?>uploads/images/<?= $tmp['image']; ?>" alt="" class="img-fluid"/>
						 </div>
						  <?php } ?>
						  
						</div>
					</div>
					<?php } $cnt++; }} ?>
				  </div>
				</div>
				
				
			</div>
		</div>
	</div>
</section>

<section class="d-block d-md-none">
	<div class="container">
		<div class="row">
			<div class="col">
				
				<!-- Accordion -->
               <div id="video-accordion" class="accordion">
                  <!-- Accordion item 1 -->
				  <?php if(!empty($video_cat)){
						$cnt=1;
										
					foreach ($video_cat as $info) { 
							
						if($cnt==1){
							$activecls ='active-acc';
							$ariaexpanded ='true';
							$collapse ='show';
						}else{
							$activecls ='';
							$ariaexpanded ='false';
							$collapse ='';
						}
					?>
                  <div class="card">
                     <div id="heading<?= $cnt; ?>" class="card-header <?= $activecls; ?>">
                        <h6 class="mb-0 font-weight-bold"><a href="#" data-toggle="collapse" data-target="#collapse<?= $cnt; ?>" aria-expanded="<?= $ariaexpanded; ?>" aria-controls="collapse<?= $cnt; ?>" class="collapsible-link"><?= $info['title']; ?></a></h6>
                     </div>
					 <?php 
					 $videos=$this->FunctionModel->Select('vidiem_media_videos',array('parent_id'=>$info['id'],'status'=>1),'order_no','ASC');
					if(!empty($videos)){
					 ?>
                     <div id="collapse<?= $cnt; ?>" aria-labelledby="heading<?= $cnt; ?>" data-parent="#video-accordion" class="collapse <?= $collapse; ?>">
                        <div class="card-body">
                           				 
							<div role="tabpanel" class="tab-pane <?= $activecls; ?>" id="tab<?= $cnt; ?>">
						
								<div id="sync1" class="slider owl-carousel owl-theme">
									<?php foreach($videos as $tmp){ ?>
									<div class="item-video"><a class="owl-video" href="https://www.youtube.com/watch?v=<?= $tmp['video_url'];?>"></a></div>
									<?php } ?>
									
								</div>
								<div id="sync2" class="navigation-thumbs owl-carousel">
								 <?php foreach($videos as $tmp){ ?>
								  <div class="item">
								 <img src="<?= base_url(); ?>uploads/images/<?= $tmp['image']; ?>" alt="" class="img-fluid"/>
								 </div>
								  <?php } ?>
								  
								</div>
							</div>
                        </div>
                     </div>
					<?php } ?>
                  </div>
				  <?php $cnt++; } } ?>

               </div>
			</div>
		</div>
	</div>
</section>
<section class="bg-dark">
<div class="container clearfix">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<h1 class="text-white text-center" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000"><?=$video_dealertestimonials['title']; ?></h1>
				<h2 class="pb-5 text-white text-center" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">advertising &amp;<br/>marketing Videos</h2>
			</div>
		</div>
		<div class="row">
		    
			<?php if(!empty($video_dealertestimonials)){
				
				$dealertestimonials_details=$this->FunctionModel->Select('vidiem_media_videos',array('status'=>1,'parent_id' =>$video_dealertestimonials['id']),'order_no','ASC');
					
					 foreach ($dealertestimonials_details as $info) { ?>
			<div class="col-sm-12 col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
				<iframe class="testimonials" src="https://www.youtube.com/embed/<?= $info['video_url']; ?>?autoplay=0&showinfo=0&controls=0&rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				<h4 class="text-white mt-3"><?= $info['name']; ?></h4>
				<!--<p class="text-light">Tirunelveli</p>-->
			</div>
			<?php } } ?>

			
		</div>
</div>
	
</section>

<!--<section class="light-gray-bg">
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

</section>-->



<?php require_once('container/footer.php'); ?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css" rel="stylesheet">

<script>
	 $('.scoll-tabs .nav-tabs').scrollingTabs();
	 
var sync1 = $(".slider");
var sync2 = $(".navigation-thumbs");

var thumbnailItemClass = '.owl-item';

var slides = sync1.owlCarousel({
  video:true,
  startPosition: 0,
  items:1,
  loop:true,
  margin:0,
  autoplay:true,
  autoplayTimeout:6000,
  autoplayHoverPause:false,
  nav: false,
  dots: true
}).on('changed.owl.carousel', syncPosition);

function syncPosition(el) {
  $owl_slider = $(this).data('owl.carousel');
  var loop = $owl_slider.options.loop;

  if(loop){
    var count = el.item.count-1;
    var current = Math.round(el.item.index - (el.item.count/2) - .5);
    if(current < 0) {
        current = count;
    }
    if(current > count) {
        current = 0;
    }
  }else{
    var current = el.item.index;
  }

  var owl_thumbnail = sync2.data('owl.carousel');
  var itemClass = "." + owl_thumbnail.options.itemClass;


  var thumbnailCurrentItem = sync2
  .find(itemClass)
  .removeClass("synced")
  .eq(current);

  thumbnailCurrentItem.addClass('synced');

  if (!thumbnailCurrentItem.hasClass('active')) {
    var duration = 300;
    sync2.trigger('to.owl.carousel',[current, duration, true]);
  }   
}
var thumbs = sync2.owlCarousel({
  startPosition: 0,
  items:5,
  loop:false,
  margin:0,
  autoplay:false,
  nav: true,
  dots: false,
  onInitialized: function (e) {
    var thumbnailCurrentItem =  $(e.target).find(thumbnailItemClass).eq(this._current);
    thumbnailCurrentItem.addClass('synced');
  },
})
.on('click', thumbnailItemClass, function(e) {
    e.preventDefault();
    var duration = 300;
    var itemIndex =  $(e.target).parents(thumbnailItemClass).index();
    sync1.trigger('to.owl.carousel',[itemIndex, duration, true]);
}).on("changed.owl.carousel", function (el) {
  var number = el.item.index;
  $owl_slider = sync1.data('owl.carousel');
  $owl_slider.to(number, 100, true);
});

</script>

