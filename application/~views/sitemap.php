<?php include('container/header.php'); ?>

<section class="ban-next">
	<div class="container clearfix">
		<h2>Sitemap</h2>
	</div>
</section>

<div class="bgPro useMan clearfix">
	<div class="container">
		<ul class="siteMapCon clearfix">
			<h2>Vidiem sitemap</h2>
			<li>
				<h3>Categories</h3>
				<div class="sitemapLocationSet clearfix">
					<ul class="setOfsitemap clearfix">
						<li>
							<a href="javascript:void(0);" class="boldConSiteM">Gas Cooktops</a>
							<ul class="subCataDe clearfix">
								<li>
									<a href="<?= base_url('category/gas-cooktops'); ?>">AIR Series</a>
								</li>
								<li>
									<a href="<?= base_url('category/gas-cooktops'); ?>">VIVA Series</a>
								</li>
								<li>
									<a href="<?= base_url('category/gas-cooktops'); ?>">EDGE Series</a>
								</li>
								<li>
									<a href="<?= base_url('category/gas-cooktops'); ?>">VITA Series</a>
								</li>
								<li>
									<a href="<?= base_url('category/gas-cooktops'); ?>">MIRAGE Series</a>
								</li>
								<li>
									<a href="<?= base_url('category/gas-cooktops'); ?>">TIRO Series</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:void(0);" class="boldConSiteM">HOBS</a>
							<ul class="subCataDe clearfix">
								<li>
									<a href="<?= base_url('category/hobs'); ?>">INDHOB 3B</a>
								</li>
								<li>
									<a href="<?= base_url('category/hobs'); ?>">INDHOB 4B</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:void(0);" class="boldConSiteM">Mixer Grinder</a>
							<ul class="subCataDe clearfix">
								<li>
									<a href="<?= base_url('category/mixer-grinders'); ?>">Vtron Series</a>
								</li>
								<li>
									<a href="<?= base_url('category/mixer-grinders'); ?>">Vstar Series</a>
								</li>
								<li>
									<a href="<?= base_url('category/mixer-grinders'); ?>">Versa Series</a>
								</li>
								<li>
									<a href="<?= base_url('category/mixer-grinders'); ?>">Eva Series</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:void(0);" class="boldConSiteM">Table Top Grinder</a>
							<ul class="subCataDe clearfix">
								<li>
									<a href="<?= base_url('category/table-top-grinder'); ?>">Jewel Series</a>
								</li>
								<li>
									<a href="<?= base_url('category/table-top-grinder'); ?>">Gem Series</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:void(0);" class="boldConSiteM">Salad Makers</a>
						</li>
					</ul>
				</div>
			</li>
			<li>
				<h3>Pages</h3>
				<div class="sitemapLocationSet clearfix">
					<ul class="setOfsitemap clearfix">
						<li>
							<a href="javascript:void(0);" class="">Home</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="">About Us</a>
							<ul class="subCataDe clearfix">
								<li>
									<a href="<?= base_url('about-us'); ?>">About Maya Appliances</a>
								</li>
								<li>
									<a href="<?= base_url('about-us'); ?>">Our Team</a>
								</li>
								<li>
									<a href="<?= base_url('about-us'); ?>">What sets us apart</a>
								</li>
								<li>
									<a href="<?= base_url('about-us'); ?>">Awards and Recognition</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:void(0);" class="">Support</a>
							<ul class="subCataDe clearfix">
								<li>
									<a href="<?= base_url('product-registration'); ?>">Product Registration</a>
								</li>
								<li>
									<a href="<?= base_url('user-manual'); ?>">User Manual</a>
								</li>
								<li>
									<a href="<?= base_url('faqs'); ?>">FAQS</a>
								</li>
								<li>
									<a href="<?= base_url('demo-videos'); ?>">Demo Videos</a>
								</li>
								<li>
									<a href="<?= base_url('dealer-locator'); ?>">Dealer Locator</a>
								</li>
								<li>
									<a href="<?= base_url('service-centers'); ?>">Service Centers</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:void(0);" class="">Media</a>
							<ul class="subCataDe clearfix">
								<li>
									<a href="<?= base_url('events'); ?>">Events</a>
								</li>
								<li>
									<a href="<?= base_url('videos'); ?>">Videos</a>
								</li>
								<li>
									<a href="<?= base_url('press-release'); ?>">Press Release</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:void(0);" class="">Recipe</a>
							<ul class="subCataDe clearfix">
								<li>
									<a href="<?= base_url('Recipe'); ?>">Recipe</a>
								</li>
								<li>
									<a href="javascript:void(0);">Contest</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="<?= base_url('contact-us'); ?>" class="">Contact Us</a>
						</li>
						<li>
							<a href="<?= base_url('blog'); ?>" class="">Blog</a>
						</li>
					</ul>
				</div>
			</li>
			<li>
				<h3>Your Account</h3>
				<div class="sitemapLocationSet clearfix">
					<ul class="setOfsitemap clearfix">
						<li>
						     <?php if($this->session->userdata('client_id')){?>
							<a href="<?= base_url('user/dashboard'); ?>" class="">Your Account</a>
							<?php }else{?>
							<a href="<?= base_url('sign-in'); ?>" class="">Your Account</a>
							 <?php } ?>
						</li>
						<li>
						     <?php if($this->session->userdata('client_id')){?>
							<a href="<?= base_url('user/dashboard'); ?>" class="">Personal Information</a>
							<?php }else{?>
							<a href="<?= base_url('sign-in'); ?>" class="">Personal Information</a>
							<?php } ?>
						</li>
						<li>
						    <?php if($this->session->userdata('client_id')){?>
							<a href="<?= base_url('user/dashboard'); ?>" class="">Addresses</a>
							<?php }else{?>
							<a href="<?= base_url('sign-in'); ?>" class="">Addresses</a>
								<?php } ?>
						</li>
						<li>
						    <?php if($this->session->userdata('client_id')){?>
							<a href="<?= base_url('user/dashboard'); ?>" class="">Order Histroy</a>
							<?php }else{?>
							<a href="<?= base_url('sign-in'); ?>" class="">Order Histroy</a>
							<?php } ?>
						</li>
					</ul>
				</div>
			</li>
		</ul>
	</div>
</div>



<?php require_once('container/footer.php')?>