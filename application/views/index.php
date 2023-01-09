<?php include('container/header.php'); ?>

<section class="bannerful clearfix">
	<div class="banner">
		<div id="owl-demo1" class="owl-carousel">
				<?php if(!empty($banner)){
					$x=1;
			foreach($banner as $info){ ?>
			<div class="item">
			    <a href="<?= (!empty($info['banner_url'])?base_url($info['banner_url']):'javascript:void(0);')?>">
			<img src="<?= base_url('uploads/banner/'.$info['image']); ?>" />
</a>
			<!--<img src="<!?= base_url('uploads/banner/'.$info['image']); ?>" />-->

			</div>
			<?php $x++; } } ?>
		</div>
	</div>
</section>

<?php if(!empty($new_launches)){ ?>
<section class="newLaunches">
	<div class="container">
		<h3 class="title">New Launches</h3>
		<p class="newprocon">Check out our latest products. We’re Sure you'll find something interesting.</p>
		<div id="owl-demo2" class="owl-carousel newPro">
			<?php foreach ($new_launches as $info) { ?>
			<div class="item">
				<a href="<?= base_url('product/'.$info['slug']); ?>">
				<div class="proImg">
					<img src="<?= base_url('uploads/images/'.$info['image']); ?>" alt="" />
					<em class="prHov">
						<span>View</span>
					</em>
				</div>
				<div class="proNewLanSetName">
					<p class="proName"><?= $info['name'];?></p>
				</div>
				</a>
			</div>
			<?php } ?>
		</div>
	</div>
</section>
<?php } ?>


<section class="product">
	<div class="container">
		<h3 class="title">INNOVATIVE PRODUCT RANGE</h3>
		<ul class="proList clearfix">
			<?php if(!empty($feature_category)){ 
					foreach($feature_category as $info){ ?> 
			<li>
				<!--<div class="proImg">
					<img src="<?= base_url('uploads/images/'.$info['image']); ?>" alt="" />
					<em class="prHov">
						<a href="<?= base_url('category/'.$info['slug']); ?>">View All</a>
					</em>
				</div> -->
				<a href="<?= base_url('category/'.$info['slug']); ?>" class="proName"><?= @$info['name']; ?></a>
				<?php 
				
				$product_list=$this->FunctionModel->Select_Fields('id,slug,name,image,price,old_price,outofstock,list_description','vidiem_products',array('cat_id'=>$info['id'],'status'=>1),'order_no','ASC',10,0);
					if(!empty($product_list)){ ?>
			
			<ul class="mix_list2 grid clearfix">
				<?php foreach ($product_list as $data) { ?>
				<li class="clearfix animated zoomIn">
					<div class="proImg prodimg">
						<img src="<?= base_url('uploads/images/'.$data['image']); ?>" alt="" />
						<em class="prHov">
							<a href="javascript:void(0);" class="QVpopup quick_view_trigger" data-id="<?= @$data['id']?>"><i class="fa fa-eye"></i>Quick View</a>
							<a href="<?= base_url('product/'.$data['slug']); ?>"><i class="fa fa-plus"></i>More</a>
						</em>
					</div>
					<div class="mix_det clearfix">
						<div class="listdetCon clearfix">
							<p><?= $data['name']; ?></p>
							<div class="offerdis">
								<h4 class="newpri"><i class="fa fa-inr"></i> <?= @number_format($data['price']); ?>/-</h4>
							<?php if($data['old_price']!=0){ ?>
							<h5 class="oldpri"> Rs: <?= @number_format($data['old_price']); ?>/-</h5>
							<?php } ?>
							</div>
							<div class="listConSet">
								<?= $data['list_description']; ?>	
						   </div>
						</div>
						<div class="mix_det_rt">
							<?php if($data['outofstock']==0){ ?>
								<a class="mix_det_rt_add btn add_to_cart" href="javascript:void(0);" data-id="<?= @$data['id'];?>">Add to cart</a>
							<?php }else{ ?>
                                 <a class="mix_det_rt_add btn" href="<?= base_url('contact-us'); ?>">Out of Stock</a>
							<?php } ?>
							<a class="mix_det_rt_add2 btn add_to_compare" href="#comProList" data-id="<?= @$data['id']?>">Add to compare</a>
						</div>
					</div>
				</li>
			<?php } ?>
			</ul>
			<?php }else{ ?>
				<p>No Products Available</p>
			<?php } ?>	
					
				
				
			</li>
		<?php } } ?>
		</ul>
		<ul class="proList support clearfix">
			<li>
			    <a href="<?= base_url('dealer-locator'); ?>">
				<img class="suIcon" src="<?= base_url(); ?>assets/front-end/images/locaIcon.png" alt="" />
				<h3 class="subtitle">Where can i find Vidiem</h3>
				<p class="subPara">
					Find out the nearest dealer to indulge yourself in Vidiem’s wide range of Kitchen Appliances.
				</p>
				<span class="supPlus"><i class="fa fa-plus"></i></span>
				</a>
			</li>
			<li>
			    <a href="<?= base_url('offers'); ?>">
				<img class="suIcon" src="<?= base_url(); ?>assets/front-end/images/giftIcon.png" alt="" />
				<h3 class="subtitle">Special Offers</h3>
				<p class="subPara">
					Explore the latest and the best offers on our majestic range of Kitchen Appliances.
				</p>
				<span class="supPlus"><i class="fa fa-plus"></i></span>
				</a>
			</li>
			<li>
			    <a href="<?= base_url('service-centers'); ?>">
				<img class="suIcon" src="<?= base_url(); ?>assets/front-end/images/supportIcon.png" alt="" />
				<h3 class="subtitle">Service & Support</h3>
				<p class="subPara">
					For any help with servicing your kitchen appliances, trust us to not disappoint you.
				</p>
				<span class="supPlus"><i class="fa fa-plus"></i></span>
				</a>
			</li>
		</ul>

		<div class="testimonialHome clearfix">
			<div class="teaMOncns clearfix">
				<h2>Our happy customers</h2>
				<div class="lineTest">
					<img class="lineTopTest" src="<?= base_url(); ?>assets/front-end/images/line-top.png">
					<img class="airTopTest" src="<?= base_url(); ?>assets/front-end/images/air-top.png">
					<div id="owl-demo4" class="owl-carousel cusTestmial">
							<?php if(!empty($testimonial)){
								foreach ($testimonial as $info) { ?>
						<div class="item">
							<div class="cusTest">
								<!-- <div class="custoImg">
								<img src="<?= base_url('uploads/testimonial/'.$info['image']); ?>" alt="" />
								</div> -->
								<div class="testCon">
									<p>
										<?= $info['content']; ?>
									</p>
									<h3 class="testcusName"><?= $info['name']; ?></h3>
									<p class="cusPlac"><?= $info['location']; ?></p>
								</div>
							</div>
						</div>
		               <?php } } ?>
					</div>
					<img class="linebotTest" src="<?= base_url(); ?>assets/front-end/images/line-bot.png">
					<img class="airbotTest" src="<?= base_url(); ?>assets/front-end/images/air-bot.png">
				</div>
			</div>
		</div>
<?php if(!empty($recipe_home)){ ?>
		<div class="recipeMenuHome clearfix">
			<div class="rcipeIner">
				<h2>Vidiem Kitchen Book</h2>
				<div id="owl-demo6" class="owl-carousel recipeMenuOwl clearfix">
					<?php foreach ($recipe_home as $info) { ?>
					<div class="item">
						<a href="<?= base_url('Recipe'); ?>" class="recipeSet">
							<div class="RecipeCon">
								<p><?= $info['name']; ?></p>
							</div>
							<div class="recipeImgSet">
								<img src="<?= base_url('uploads/recipe/'.$info['image']); ?>" alt="" />
							</div>
						</a>
					</div>

<?php } ?>
				</div>
			</div>
		</div>
<?php } ?>
		<div class="sponMani">
			<a target="_blank" href="http://www.superbikeschoolindia.com/" class="spimg">
				<img src="<?= base_url(); ?>assets/front-end/images/spon.png" alt="" />
			</a>
			<dir class="sponCon">
				<h3> Other Links</h3>
				<p>VIDIEM - Main Sponsor for California Superbike School , India</p>
				<a target="_blank" class="btn" href="http://www.superbikeschoolindia.com/">View our website</a>
			</dir>
		</div>
	</div>
</section>
<section class="bgPro abful clearfix hide">
	<div class="container">
		<div class="absetmaya">
			<ul class="mayaAbout clearfix">
			    <li><h2><p>Shop for the best Kitchen Appliances Online</p></h2></li>
				<li>
				<p>Everyone enjoys a perfectly good meal, and if it is healthy and homemade it’s absolutely perfect. To assist you, you require the best kind of kitchen appliances that are ergonomically designed, safe, reliable and of the latest technology to help you create a range of amazing dishes! Shop from the unique collection of kitchen appliances online at Vidiem and upgrade your kitchen’s style and features. Vidiem range of kitchen appliances have been engineered in the latest fashion to create a perfect synergy of style and functionality in your modern kitchen. Vidiem offers a range of mixer grinders, gas stoves, hobs, table top grinders, wet grinders and more being the largest brand marketplace for all your kitchen appliances and needs. Choose your favorite product and order now<span class="symbolFont">!</span></p>
				</li>
				<li><h2><p>Buy Stoves, Hobs Online at Best Price</p></h2></li>
				<li>
				<p>In addition to being sleek and well designed, Vidiem’s ranges of Gas Stoves and Hobs are also ergonomic and highly functional and easy to use. Vidiem’s 2 burner Gas stoves are perfect to cook for a small set of people. The burners are equipped with removable drip trays and hardened glass tops. The 3 Burner Gas Stoves have well spaced burners for various sized vessels. Vidiem’s 4 burner gas stoves are for commercial cooking, perfect for you to create a delicious meal for many! Vidiem’s branded gas stoves online are of the finest quality, designed for Indian cooking with the burner fashioned for even flame and heat distribution. The Hobs also are available in 3 burner and 4 burner style, with easy cleaning and 10mm toughened glass cooktops. Vidiem’s gas stoves come with a 5 year warranty on glass and 2 year warranty on the product. They are fitted with removable drip trays that make it easy to clean. The gas stoves and hobs have vitreous Enamel Coated pan supports and SS 304 fasteners for extra long life. Vidiem Glass Cooktops also have thermally treated 25% thicker metal backed toughened glass. Vidiem’s range of products also have aesthetic designer cooktops that perfectly fit to your stylish kitchen.  The gas stoves have high quality brass burners for continuous blue flame, heavy duty mixing tube and gas cock to improve thermal efficiency, powder coated pan supports, galvanizing iron powder coated front panel and rear leg to retain sturdiness and the amazing features and quality of these gas cook tops and hobs available online. Gas stove price are easily affordable and pocket friendly for everyone. Choose your favorite product and order now<span class="symbolFont">!</span> </p>
				</li>
				<li><h2><p>Online shopping for Home and Kitchen Appliances- Mixer Grinders</p></h2></li>
				<li>
				<p>It is essential for every kitchen to have a mixer grinder. Vidiem has a large range of mixer grinders that you can buy online at best prices in India! You can take your pick from among these based on various factors like the functions, types, capacities, number of jars, the various colors we offer and of course the multiple amazing features! With highly superior performance and energy efficient with a 1000 watts mixer grinder, and with best juicer mixer grinders you have come to the right place to shop online for Mixer grinders from a great selection at Home & Kitchen Store. If you want to extract purees, grind spices for your various yummy chutneys, make up a batch of delicious smoothies to beat the summer heat our mixer grinder online shopping offers are just for you! Vidiem’s range of juicer mixer grinders online has various numbers of jars, ranging from 3-5 jars. They have secure self locking jars, tri-mate couplers and dynamically balanced blades. They’re also equipped with advanced features with fully enclosed integrated dielectric motor casing, no water ingress. The mixer grinders are safe and shock proof and are highly efficient with 10% less current consumption. You will find small juicer mixer grinder online, at the lowest price online and with amazing features that is perfect for your kitchen. Juicer mixer grinder is one of the most versatile kitchen appliances found in almost every Indian household today. They achieve all your various types of grinding and juicing in one unit! We offer these Juicer Mixer Grinders online at the best price. They perform multiple functions such as chutney grinding, dry grinding, grating, juicing and come with different types of jars to lessen your time & effort in the kitchen<span class="symbolFont">!</span></p>
				</li>
				<li><h2><p>Grinders Online at the Best Price</p></h2></li>
				<li>
				<p>The convenience and handiness of the home appliances like wet grinders is unmatched to any kitchen luxury in the world. Replacing the traditional method of hand grinding, these highly efficient replacements have come in to make our work much easier! Wet Grinders perform the task of grinding and breaking down of the food ingredients effortlessly. If you are looking to buy wet grinder online at the best price, Vidiem’s range of grinders are the absolute perfect choice. Prepare meals quicker, by shopping online for Wet Grinders from our unique collection of Kitchen Appliances online<span class="symbolFont">!</span></p>
				</li>
				<li><p>Whether you need it to make delicious yummy chutneys, to grind the best batter for super soft idlies, crispy ghee filled dosas, or the perfect appams we have got them all covered under one virtual roof. Vidiem offers 2 year warranty on product and 5 year warranty on Motor for all of Vidiem’s table top grinders.</p> </li>

				<li><p>The Vidiem Jewel PC is half the size and weight of the traditional table top grinder but just as effective. It has powerful direct drive motor, with a long life and fine grinding. The Roller and blades allow for smooth and easy grinding with easy to clean twin telescopic wipers. The Jewel PC also uses only half the power consumption and is completely hygienic and safe. It is the perfect addition to your kitchen<span class="symbolFont">!</span></p></li>

				<li><p>If you prefer the conventional table top grinder and wet grinder then Vidiem offers Gem and Garnet models online at the best price. These models are built with a sturdy body that is both durable and has a long life. It is both vibration and noise free making your grinder very simple and easy. It comes with a coconut scraper with metal blades and an atta kneader with food grade plastic blades to give you the best results.</p></li>

				<li><p>Vidiem offers you best branded kitchen appliances at one virtual platform that you can easily access that also has the best online prices and is pocket friendly. So go ahead and buy your favorite kitchen appliance and add a lovely addition to your kitchen<span class="symbolFont">!</span></p>
				</li>
				<li>
				</li>
				<li></li>
			</ul>
		</div>
</div>
</section>



<?php require_once('container/footer.php'); ?>