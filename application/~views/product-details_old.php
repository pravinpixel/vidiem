<?php 
//echo "<pre>"; print_r($cat_slug); exit;
include('container/header.php'); ?>

	  <!-- Products Listing Banner -->
	  <section class="dark_bg pb-0">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<h2 class="text-white ml-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000"><small><?= @$product['name']; ?></small></h2>
					<nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
						<ol class="breadcrumb product-details-breadcrumb">
							<li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
							<li class="breadcrumb-item"><a href="<?= base_url('category/'.$cat_slug[0]['slug']); ?>"><?=$cat_slug[0]['name']; ?></a></li>
							<!--<li class="breadcrumb-item"><a href="<?= base_url('category/'.$subcat_slug[0]['slug']); ?>"><?=$subcat_slug[0]['name']; ?></a></li>-->
							<li class="breadcrumb-item"><?= @$product['name']; ?></li>
						</ol>
					</nav>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-12">
					<div id="product-details-carousel" class="carousel slide vert" data-ride="carousel" data-interval="false">
						<div class="row no-gutters">
						  <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
							<div class="carousel-indicators">
							  <div data-target="#product-details-carousel" data-slide-to="0" class="item active"><img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image1.png" src="" class="img-fluid" /></div>
							  <div data-target="#product-details-carousel" data-slide-to="1" class="item"><img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image2.png" src="" class="img-fluid" /></div>
							  <div data-target="#product-details-carousel" data-slide-to="2" class="item"><img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image3.png" src="" class="img-fluid" /></div>
							  <div data-target="#product-details-carousel" data-slide-to="3" class="item"><img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image4.png" src="" class="img-fluid" /></div>
							  <div data-target="#product-details-carousel" data-slide-to="4" class="item"><img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image5.png" src="" class="img-fluid" /></div>
							  <div data-target="#product-details-carousel" data-slide-to="5" class="item"><img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image6.png" src="" class="img-fluid" /></div>
							</div>
						  </div><!-- col-sm-4 Indicators -->


						  <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10">
							<div class="carousel-inner">
							  <div class="carousel-item active">
								<img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image1.png" src="" class="img-fluid" />
							  </div>
							  <div class="carousel-item">
								<iframe src="https://www.youtube.com/embed/D0n-Vb6syFM" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							  </div>
							  <div class="carousel-item">
								<img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image3.png" src="" class="img-fluid" />
							  </div>
							  <div class="carousel-item">
								<img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image4.png" src="" class="img-fluid" />
							  </div>
							  <div class="carousel-item">
								<img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image5.png" src="" class="img-fluid" />
							  </div>
							  <div class="carousel-item">
								<img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image6.png" src="" class="img-fluid" />
							  </div>
							</div>
							<a class="carousel-control-prev" href="#product-details-carousel" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					  </a>
					  <a class="carousel-control-next" href="#product-details-carousel" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					  </a>
						  </div>
						</div>
					  </div>
					  
				</div>
			</div>
		</div>
	  </section>
	  <section class="red-bg pt-5 pb-5">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-5">
					<h3 class="text-white" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
						About the Product
					</h3>
					<p class="text-white" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Ut enim ad minima veniam, nostum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur</p>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-7">
				<h3 class="text-white" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
						Product Description
					</h3>
					<ul class="product-description-details" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
							<li class="w-50 mr-0">
								Product Dimensions
								<span>54.5 x 29 x 25.5 CM / 4.33 Kilograms</span>
						</li>
						<li class="w-50 mr-0">
							Manufacturer
							<span>Vidiem</span>
												</li>
												<li class="w-50 mr-0">
													Voltage
													<span>220V - 240V AC 50Hz</span>
												</li>
												<li class="w-50 mr-0">
													Date First Available
													<span>26 January 2020</span>
												</li>
											</ul>
				</div>
			</div>
		</div>
	  </section>
	  <section class="product-details-colors">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-4">
					<h4 class="color-dark"><?= @$product['name']; ?></h4>
					<h3 class="price text-red">₹ 3,190 <span class="strike">  ₹ 5,190</span></h3>
					<!--<p>Master Jar With Round Dome</p>-->
				</div>
				
				<div class="col-sm-12 col-md-6 col-lg-4">
					<!--<h6>Availability <span>In Stock (22 Nos)</span></h6>
					<h6>Select Color</h6>
					<ul class="colors" data-aos="fade-up" data-aos-delay="50" data-aos-duration="500">
						<li>
							<a href="#" class="dark-blue"></a>
						</li>
						<li>
							<a href="#" class="red"></a>
						</li>
						<li>
							<a href="#" class="yellow"></a>
						</li>
						<li>
							<a href="#" class="orange"></a>
						</li>
						<li class="active">
							<a href="#" class="light-pink"></a>
						</li>
					</ul>-->
				</div>
				
				<div class="col-sm-12 col-md-12 col-lg-4">
					<div class="row">
						<div class="col-6">
							<a href="#" class="buy-now">Buy Now</a>
						</div>
						<div class="col-6">
							<a href="#" class="add-to-cart">Add to Cart</a>
						</div>
						<div class="col-12">
							<p>You Can <a href="#" class="text-red">Customise</a> Your Own Vidiem Product</p>
						</div>
					</div>
				</div>
			</div>
		<div>
	  </section>
	  
	  <nav class="navigation" id="mainNav">
			<a class="navigation__link active" id="s1" href="#tab1">About the Product</a>
			<a class="navigation__link" id="s2" href="#tab2">Product Details</a>
			<a class="navigation__link" id="s3" href="#tab3">Product Description</a>
			<a class="navigation__link" id="s4" href="#tab4">Customer Review</a>
	  </nav> 
	  <section class="p-0">
		<div class="container-fluid pl-0 pr-0">
			<div class="row">
				<div class="col-sm-12 col-md-12" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
				    <div class="page-section" id="tab1">
							<h1 class="pt-5 mt-5 text-red text-center" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">About The Product</h1>
							<h2 class="pb-4 text-center" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Vidiem synonymous<br/>with innovation</h2>
							<div class="gray-bg p-5">
								<div class="container">
									<div class="row align-items-center">
										<div class="col-sm-12 col-md-6" data-aos="zoom-out" data-aos-delay="50" data-aos-duration="1000">
											<img src="<?= base_url(); ?>assets/front-end/images/product-details/details-image4-large.png" src="" class="img-fluid" />
										</div>
										<div class="col-sm-12 col-md-6" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
											<h3 class="pb-4" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Today the Vidiem brand has become synonymous with innovation in both design and functionality</h3>
											<h4 class="pb-4" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Nam tempus turpis at metus scelerisque placerat nulla deumantos sollicitudin delos cosmo milancelos.</h4>
											<p class="pb-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="500">Ut enim ad minima veniam, nostum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur</p>
										</div>
									</div>
								</div>
							</div>
							<div class="light-gray-bg p-5">
								<div class="container">
									<div class="row align-items-center">
										<div class="col-sm-12 col-md-6" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
											<h3 class="pb-4" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit nisi laboriosam</h3>
											<h4 class="pb-4" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur</h4>
											<p class="pb-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="500">Ut enim ad minima veniam, nostum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur</p>
										</div>									
										<div class="col-sm-12 col-md-6" data-aos="zoom-out" data-aos-delay="50" data-aos-duration="1000">
											<img src="<?= base_url(); ?>assets/front-end/images/product-details/details-image3-large.png" src="" class="img-fluid" />
										</div>
									</div>
								</div>
							</div>
							<div class="bg-white p-5">
								<div class="container">
									<div class="row align-items-center">
										<div class="col-sm-12 col-md-6" data-aos="zoom-out" data-aos-delay="50" data-aos-duration="1000">
											<img src="<?= base_url(); ?>assets/front-end/images/product-details/details-image5-large.png" src="" class="img-fluid" />
										</div>
										<div class="col-sm-12 col-md-6" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
											<h3 class="pb-4 color-dark" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit fugit</h3>
											<div class="row">
												<div class="col-sm-12 col-md-6">
													<h4 class="text-dark" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Nam tempus turpis</h4>
													<p class="pb-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="500">Ut enim ad minima veniam, nostum exercitanem ullam corporis suscipit nisi laboriosam</p>
												</div>
												<div class="col-sm-12 col-md-6">
													<h4 class="text-dark" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">at metus scelerisque</h4>
													<p class="pb-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="500">Ut enim ad minima veniam, nostum exercitanem ullam corporis suscipit nisi laboriosam</p>
												</div>
												<div class="col-sm-12 col-md-6">
													<h4 class="text-dark" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Nam tempus turpis</h4>
													<p class="pb-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="500">Ut enim ad minima veniam, nostum exercitanem ullam corporis suscipit nisi laboriosam</p>
												</div>
												<div class="col-sm-12 col-md-6">
													<h4 class="text-dark" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">at metus scelerisque</h4>
													<p class="pb-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="500">Ut enim ad minima veniam, nostum exercitanem ullam corporis suscipit nisi laboriosam</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="light-gray-bg p-5">
								<div class="container">
									<div class="row align-items-center">
										<div class="col-sm-12 col-md-6" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
											<h3 class="pb-4" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">enim ad minima veniam, odit aspernatur exercitationem ullam corporis suscipit</h3>
											<h4 class="pb-4" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">qui in ea voluptate velsse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat nulla pariatur</h4>
											<p class="pb-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="500">Ut enim ad minima veniam, nostum exercitation lam corporis suscipit laboriosam, aliquid ex ea commodi consequatur. Quis autem vel eum iure reprehenderit qui in evoluptate velit esse quam molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas.<br/><br/>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
										</div>									
										<div class="col-sm-12 col-md-6" data-aos="zoom-out" data-aos-delay="50" data-aos-duration="1000">
											<img src="<?= base_url(); ?>assets/front-end/images/product-details/details-image6-large.png" src="" class="img-fluid" />
										</div>
									</div>
								</div>
							</div>
							</div>
							<div class="page-section" id="tab2">
							<h1 class="pt-5 mt-5 text-red text-center" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Product Details</h1>
							<h2 class="pb-4 text-center" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Vidiem Mixer<br/>design and functionality</h2>
							<div class="text-center"><img src="<?= base_url(); ?>assets/front-end/images/product-details/details-image6-large.png" src="" class="img-fluid" />
							</div>
							<div class="light-gray-bg p-5">
								<div class="container">
									<div class="row align-items-center">
										<div class="col-sm-12 col-md-6" data-aos="zoom-out" data-aos-delay="50" data-aos-duration="1000">
											<img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image7.png" src="" class="img-fluid" />
										</div>
										<div class="col-sm-12 col-md-6" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
											<h3 class="pb-4" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Sedcus faucibus ansull amcorper mattis drostique</h3>
											<h4 class="pb-4" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Nam tempus turpis at metus scelerisque placerat nulla deumantos sollicitudin delos cosmo milancelos.</h4>
											<p class="pb-3" data-aos="fade-up" data-aos-delay="50" data-aos-duration="500">Ut enim ad minima veniam, nostum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur</p>
										</div>
										<div class="col-sm-12 col-md-12 pt-5">
											<div class="owl-carousel product-details-carousel">
												<div class="item">
													<a href="#">
														<img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image11.png" alt="" class="img-fluid" />
														<h4 class="mt-4">1.5 Litre Master Jar</h4>
														<h6 class="text-red">Deliciousness on your Plate</h6>
														<p>Ut mnima veniam, nostum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid quam commodi consequatur.</p>
													</a>
												</div>
												<div class="item">
													<a href="#">
														<img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image8.png" alt="" class="img-fluid" />
														<h4 class="mt-4">1.0 Litre Multi Jar</h4>
														<h6 class="text-red">Scrumptious Spices</h6>
														<p>Ut mnima veniam, nostum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid quam commodi consequatur.</p>
													</a>
												</div>
												<div class="item">
													<a href="#">
														<img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image9.png" alt="" class="img-fluid" />
														<h4 class="mt-4">0.4 Litre Marvel Jar</h4>
														<h6 class="text-red">Flavourful Chutneys</h6>
														<p>Ut mnima veniam, nostum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid quam commodi consequatur.</p>
													</a>
												</div>
												<div class="item">
													<a href="#">
														<img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image10.png" alt="" class="img-fluid" />
														<h4 class="mt-4">1.5 Litre Blender</h4>
														<h6 class="text-red"> Super Juicer</h6>
														<p>Ut mnima veniam, nostum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid quam commodi consequatur.</p>
													</a>
												</div>
												<div class="item">
													<a href="#">
														<img src="<?= base_url(); ?>assets/front-end/images/product-details/product-details-image11.png" alt="" class="img-fluid" />
														<h4 class="mt-4">1.5 Litre Master Jar</h4>
														<h6 class="text-red">Deliciousness on your Plate</h6>
														<p>Ut mnima veniam, nostum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid quam commodi consequatur.</p>
													</a>
												</div>
											  </div>
										</div>
									</div>
								</div>
							</div>
							</div>
							<section class="page-section dark_bg" id="tab3">
								<div class="container">
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<h1 class="text-white text-center" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Product Description</h1>
											<h2 class="text-white pb-4 text-center" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Vidiem Mixer<br/>design and functionality</h2>
											<ul class="product-description-details" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
												<li class="border-right">
													Product Dimensions
													<span>54.5 x 29 x 25.5 CM / 4.33 Kilograms</span>
												</li>
												<li class="border-right">
													Manufacturer
													<span>Vidiem</span>
												</li>
												<li>
													Voltage
													<span>220V - 240V AC 50Hz</span>
												</li>
												<li class="border-right">
													Date First Available
													<span>26 January 2020</span>
												</li>
												<li class="border-right">
													Item Weight
													<span>4 KG 330</span>
												</li>
												<li>
													Number Of Jars
													<span>4 Jars + 1 Multi Chef</span>
												</li>
												<li class="border-right">
													 ASIN
													<span>B08CR7W3C6</span>
												</li>
												<li class="border-right">
													Item Dimensions (L x W x H)
													<span>54.5 x 29 x 25.5 In Centimeters</span>
												</li>
												<li>
													Juicer Jar
													<span>Yes</span>
												</li>												
												<li class="border-right">
													 Item Model Number
													<span>MG 581 A</span>
												</li>
												<li class="border-right">
													Net Quantity
													<span>1.00 Unit</span>
												</li>
												<li>
													Power
													<span>750W</span>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</section>
							<section class="page-section" id="tab4">
								<div class="container">
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<h1 class="text-center" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Customer Review</h1>
											<h2 class="pb-4 text-center" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Top reviews from Our<br/>Valuable Customers</h2>	
										</div>
										<div class="col-sm-12 col-md-12 col-lg-6" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
											<div class="customer-reviews">
												<img src="<?= base_url(); ?>assets/front-end/images/product-details/reviews-image1.png" alt="" />
												<h3 class="text-red">Larry E White</h3>
												<h6>Business Women</h6>
												<p>Neque porro quisquam est, qui dolorem ipsum qiamet, consectetur, adipisci velit, sed quia non numquam eius teimpora incidunt labore et dolore magnam aliquam quaerat voluptatem.</p>
												<h6>Must Buy! Worth The Price</h6>
												<p>23 August 2020</p>
											</div>
										</div>
										<div class="col-sm-12 col-md-12 col-lg-6" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
											<div class="customer-reviews">
												<img src="<?= base_url(); ?>assets/front-end/images/product-details/reviews-image2.png" alt="" />
												<h3 class="text-red">Scott Martin</h3>
												<h6>Employee</h6>
												<p>Neque porro quisquam est, qui dolorem ipsum qiamet, consectetur, adipisci velit, sed quia non numquam eius teimpora incidunt labore et dolore magnam aliquam quaerat voluptatem.</p>
												<h6>Sturdy Motor & Strong Blades</h6>
												<p>05 September 2020</p>
											</div>
										</div>
										<div class="col-sm-12 col-md-12 col-lg-6" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
											<div class="customer-reviews">
												<img src="<?= base_url(); ?>assets/front-end/images/product-details/reviews-image3.png" alt="" />
												<h3 class="text-red">Larry E White</h3>
												<h6>Business Women</h6>
												<p>Neque porro quisquam est, qui dolorem ipsum qiamet, consectetur, adipisci velit, sed quia non numquam eius teimpora incidunt labore et dolore magnam aliquam quaerat voluptatem.</p>
												<h6>Must Buy! Worth The Price</h6>
												<p>23 August 2020</p>
											</div>
										</div>
										<div class="col-sm-12 col-md-12 col-lg-6" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
											<div class="customer-reviews">
												<img src="<?= base_url(); ?>assets/front-end/images/product-details/reviews-image4.png" alt="" />
												<h3 class="text-red">Scott Martin</h3>
												<h6>Employee</h6>
												<p>Neque porro quisquam est, qui dolorem ipsum qiamet, consectetur, adipisci velit, sed quia non numquam eius teimpora incidunt labore et dolore magnam aliquam quaerat voluptatem.</p>
												<h6>Sturdy Motor & Strong Blades</h6>
												<p>05 September 2020</p>
											</div>
										</div>
										<div class="col-sm-12 col-md-12 col-lg-6" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
											<div class="customer-reviews">
												<img src="<?= base_url(); ?>assets/front-end/images/product-details/reviews-image5.png" alt="" />
												<h3 class="text-red">Larry E White</h3>
												<h6>Business Women</h6>
												<p>Neque porro quisquam est, qui dolorem ipsum qiamet, consectetur, adipisci velit, sed quia non numquam eius teimpora incidunt labore et dolore magnam aliquam quaerat voluptatem.</p>
												<h6>Must Buy! Worth The Price</h6>
												<p>23 August 2020</p>
											</div>
										</div>
										<div class="col-sm-12 col-md-12 col-lg-6" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
											<div class="customer-reviews">
												<img src="<?= base_url(); ?>assets/front-end/images/product-details/reviews-image6.png" alt="" />
												<h3 class="text-red">Scott Martin</h3>
												<h6>Employee</h6>
												<p>Neque porro quisquam est, qui dolorem ipsum qiamet, consectetur, adipisci velit, sed quia non numquam eius teimpora incidunt labore et dolore magnam aliquam quaerat voluptatem.</p>
												<h6>Sturdy Motor & Strong Blades</h6>
												<p>05 September 2020</p>
											</div>
										</div>
									</div>
								</div>
							</section>
                </div>
			</div>
		</div>
	  </section>
	  
<?php include 'container/footer.php';?>

<script>
 jQuery('iframe[src*="https://www.youtube.com/embed/"]').addClass("youtube-iframe");

    jQuery(".carousel-control-next").click(function() {
      // changes the iframe src to prevent playback or stop the video playback in our case
      $('.youtube-iframe').each(function(index) {
        $(this).attr('src', $(this).attr('src'));
        return false;
      });
      
//click function
    });
	
/*
Smooth scrolling
*/
$("#s1").click(function() {
     $('html, body').animate({
         scrollTop: $("#tab1").offset().top-130
     });
	 $("nav.navigation a").removeClass("active");
	 $(this).addClass("active");
  return false;
 });

$("#s2").click(function() {
     $('html, body').animate({
         scrollTop: $("#tab2").offset().top-150
     });
	 $("nav.navigation a").removeClass("active");
	 $(this).addClass("active");
  return false;
 });

$("#s3").click(function() {
     $('html, body').animate({
         scrollTop: $("#tab3").offset().top-100
     });
	 $("nav.navigation a").removeClass("active");
	 $(this).addClass("active");
  return false;
 });

$("#s4").click(function() {
  $(this).addClass("active");
     $('html, body').animate({
         scrollTop: $("#tab4").offset().top-100
     });
	 $("nav.navigation a").removeClass("active");
	 $(this).addClass("active");
  return false;
 });

$('#tab1').waypoint(function() {
  $("nav.navigation a").removeClass("active");
  $("#s1").addClass("active");
});

$('#tab2').waypoint(function() {
  $("nav.navigation a").removeClass("active");
  $("#s2").addClass("active");
});

$('#tab3').waypoint(function() {
  $("nav.navigation a").removeClass("active");
  $("#s3").addClass("active");
});

$('#tab4').waypoint(function() {
  $("nav.navigation a").removeClass("active");
  $("#s4").addClass("active");
});	
</script>