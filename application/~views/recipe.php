<?php include('container/header.php'); ?>
<?php if(!empty($recipe_banner)){
		   foreach ($recipe_banner as $info) { 
             $banner_image = $info['image'];
             $banner_title = $info['title'];
             $banner_name = $info['name'];
		   }}?>
<div class="banrecipe">
	<img src="<?= base_url('uploads/recipe/banner/'.$info['image']); ?>" alt="" />
	<div class="banConOutLine">
		<a href="javascript:void(0);" class="reCiprCn">
			<h3><?= $banner_title; ?></h3>
			<p><?= $banner_name; ?></p>
		</a>
	</div> 
</div> 

<div class="recipeList clearfix"> 
	<div class="container clearfix">
		 <form method="get" action="<?= @$tmp_url; ?>">
		<div class="searchRecipe">
			<input type="text" placeholder="Look for a recipe" value="<?= @$search; ?>" name="search">
			<button class="searchAroRe"></button>
		</div>
	</form>
	</div>
</div>

<div class="container clearfix">
	<ul class="menuListINREci clearfix search_div">
		<?php if(!empty($DataResult)){
		   foreach ($DataResult as $info) { ?>
		<li class="animatable zoomIn">
			<a href="javascript:void(0);" class=" recipe_view_trigger" data-id="<?= @$info['id']?>">
				<div class="reCipeImg">
					<img src="<?= base_url('uploads/recipe/'.$info['image']); ?>" alt="" />
				</div>
				<div class="recipeTitleNameOF">
					<p class="recipeNameTi"><?= $info['name']; ?></p>
					<p class="btnHoveConRe">View Recipe</p>
				</div>
			</a>
		</li>
           <?php } }
           else { ?>
           	<h4>No Result Available...</h4>
           <?php } ?>
	</ul>
</div>

<div class="poppupRecipe">
    <span class="popUpCloseInreci" id="recipeCloseB"></span>
	<div class="popConSetRecipe">
	</div>
</div>


<?php require_once('container/footer.php')?>

<?php if(!empty($scroll)){ ?>
<script>
$(document).ready(function(){
	 $('html, body').animate({
     'scrollTop' : $(".search_div").position().top-500
});
});
</script>
<?php } ?>