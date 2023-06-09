<?php include('container/header.php'); ?>

<section class="ban-next">
	<div class="container clearfix">
		<h2>Warranty Terms</h2>
	</div>
</section>

<div class="bgPro contactUs useMan clearfix">
	<div class="container">
		<div class="userManual">
			<h3>Warranty Terms</h3>
			<?php if(!empty($warranty)){ $x=1;
				foreach($warranty as $info){?>
			<ul class="clearfix warrantySet">
				<h4>Category : <?= $info['title']; ?></h4>
				
					<?= $info['content']; ?>
				
				
			</ul>
			<?php $x++; } } ?>
			
		</div>
	</div>
</div>



<?php require_once('container/footer.php')?>
