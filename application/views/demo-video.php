<?php include('container/header.php'); ?>

<section class="ban-next">
	<div class="container clearfix">
		<h2>Video Gallery</h2>
	</div>
</section>

<div class="bgPro videoGal clearfix">
	<div class="container videoBack clearfix">
		<?php if(!empty($demovideo)){
				 foreach ($demovideo as $info) { 
				 $videos=$this->FunctionModel->Select('vidiem_video_videos',array('parent_id'=>$info['id'],'status'=>1),'order_no','ASC');
			if(!empty($videos)){
				 ?>
		<div class="videoSet">
			<h3><?= $info['title']; ?></h3>
			<ul class="vidGal clearfix">
				<?php foreach($videos as $tmp){ ?>
				<li class="animatable zoomIn">
					<iframe src="https://www.youtube.com/embed/<?= $tmp['video_url'];?>?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
					<div class="VideiConAl">	
						<p><?= @$tmp['name']; ?></p>
					</div>
				</li>
				 <?php } ?>
			</ul>
		</div>
			<?php }}} ?>

		

	</div>
</div>



<?php require_once('container/footer.php'); ?>