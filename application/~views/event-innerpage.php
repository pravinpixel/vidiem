<?php include('container/header.php'); ?>

<section class="ban-next">
	<div class="container clearfix">
		<h2>News and Events</h2>
	</div>
</section>

<section class="bgPro sectOfeventInner">
	<div class="container">
		<div class="eventsInnerPageCon clearfix">
		    <div class="innerEventImg">
				    <?php if(!empty($event_img)){
                       foreach ($event_img as $info) { ?>
		          <img src="<?= base_url('uploads/event/eventcat/'.$info['image']); ?>" alt="" />
				    <?php }} ?>
			</div>
		        <?php if(!empty($sub_cat)){
                     foreach ($sub_cat as $info) { ?>
			<h4><?= @$info['title']; ?></h4>
			<p>Visit: <a target="_blank" href="http://www.superbikeschoolindia.com/"><?= @$info['link']; ?></a></p>
		    <?= @$info['content']; ?>
			    <?php } } ?>
		</div>
			<div class="eventPhotoSSet clearfix">
			
			<ul class="eventsPhotoGal clearfix"> 
				<?php if(!empty($event_image)){?> 
			<p>Event Photos</p>
                    <?php   foreach ($event_image as $info) { ?>
				<li>
					<a class="fancybox" href="<?= base_url('uploads/event/event-cat/'.$info['image']); ?>" data-fancybox-group="gallery">
						<img src="<?= base_url('uploads/event/event-cat/'.$info['image']); ?>" alt="" />
		            </a>
				</li>
				<?php } } else{ ?>
					
					<center><h5>No Data Available...</h5></center>
				<?php } ?>
			</ul>
		</div>

		
	</div>
</section>

<?php require_once('container/footer.php'); ?>