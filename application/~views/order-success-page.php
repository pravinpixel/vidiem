 <?php include('container/header.php'); ?>

<div class="bgPro SignUpPage clearfix">
	<section class="signsec clearfix">
		<div class="siginInSetTop clearfix">
			<form class="signInput" method="post" action="" style="margin: 0 auto;float: none;">
				<h4 class="siHead" style="color:green;">Order Completed Successfully</h4>
				<ul class="createAcc">
					<li>
						<h5>Your Invoice Number</h5>
						<input type="text" placeholder="Enter your Invoice code" value="<?= @$code; ?>" name="code" disabled>
					</li>
				</ul>
			</form>
		</div>
	</section>
</div>
<?php require_once('container/footer.php')?>