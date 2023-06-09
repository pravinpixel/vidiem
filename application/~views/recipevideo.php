<?php include('container/header.php'); ?>

<section class="ban-next">
	<div class="container clearfix">
		<h2>Recipe Video</h2>
	</div>
</section>

<div class="bgPro videoGal clearfix">
	<div class="container videoBack clearfix">
		<?php if(!empty($video_cat)){
				 foreach ($video_cat as $info) { 
				 $videos=$this->FunctionModel->Select('vidiem_recipe_videos',array('parent_id'=>$info['id'],'status'=>1),'order_no','ASC');
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