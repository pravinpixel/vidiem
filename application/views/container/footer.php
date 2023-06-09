<!-- Newsletter -->
	  <!-- <section class="footer-locations">
		<div class="container position-relative">
		
			<img src="<?= base_url(); ?>assets/front-end/images/newsletter-image.webp" alt="" class="img-fluid newsletter-image"/>
			<div class="row align-items-center no-gutters">
				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-8">
				    <h1 class="text-red">Find us</h1>
					<h2>Vidiem Service Centres</h2>
					<h5 style="font-weight: 300; color:#323232; ">We Provide Service in These Locations</h5>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-6 col-xl-4">
					<div class="input-group-append">
						<a class="btn btn-link m-0 newsletter_btn" href="<?= base_url(); ?>service-centers" id="MaterialButton-addon2">Click Here</a>
					</div>
				
					<form action="" method="post" id="subForm" class="newsletter_form">
						<div class="md-form input-group">
							<input type="text" class="form-control newsletter_mail" id="newsletter_mail" name="newsletter_mail" placeholder="Enter Your Email ID Here" aria-label="Enter Your Email ID Here" aria-describedby="MaterialButton-addon2" required>
							
						</div>
					</form>
				</div>
			</div>
		</div>
	  </section> -->
	  <?php 
$dealer_session = $this->session->userdata('dealer_session');

if( isset( $dealer_session['user']) ) { 
    if( $dealer_session['user']['user_type'] != 'sale_person' ) {
        // redirect();
    }
} else {
    ?>
	  <section>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-sm-12 col-md-12 col-lg-12">
				    <h1 class="text-red">Support</h1>
					<h2>Need Service Support?</h2>
				</div>
				<div class="col-sm-12 col-md-4 col-lg-4">
					<a href="<?= base_url(); ?>complaint-registration" class="footer-support">
						<i class="fa fa-chevron-right"></i>
						<span>
							<img src="<?= base_url(); ?>assets/front-end/images/register.png" alt="" class="img-fluid"/>
						</span>
						<h3>Register your complaint</h3>
						Submit your complaint online and our support team will get in touch with you
					</a>
				</div>
				<div class="col-sm-12 col-md-4 col-lg-4">
					<a href="https://api.whatsapp.com/send?phone=9600469600&text=Hello%20Vidiem,%20I%20have%20something%20to%20ask" target="_blank" class="footer-support">
						<i class="fa fa-chevron-right"></i>
						<span>
							<img src="<?= base_url(); ?>assets/front-end/images/whatsapp.png" alt="" class="img-fluid"/>
						</span>
						<h3>Whatsapp us your concerns</h3>
						Not able to register a complaint? No worries, just send us a message on Whatsapp
					</a>
				</div>				
				<div class="col-sm-12 col-md-4 col-lg-4">
					<a href="<?= base_url(); ?>service-centers" class="footer-support">
						<i class="fa fa-chevron-right"></i>
						<span>
							<img src="<?= base_url(); ?>assets/front-end/images/service-centers.png" alt="" class="img-fluid"/>
						</span>
						<h3>Visit our service centres</h3>
						Visit any of our nearest Service Centres or contact our Support Team
					</a>
				</div>
			</div>
		</div>
	  </section>
	  
	  <footer>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-9">
					<div class="row">
						<div class="col-6 col-sm-6 col-md-6 col-lg-3">
							<h4>Categories</h4>
							<ul>
								
								<?php if (!empty($cat_menu)) {
								  foreach ($cat_menu as $info) { ?>
									<li>
									<a href="<?= base_url('category/' . $info['slug']); ?>"><?= $info['name']; ?></a>
									</li>
								<?php }
								} ?>
								
							</ul>
						</div>
						<div class="col-6 col-sm-6 col-md-6 col-lg-3">
							<h4>Quick Links</h4>
							<ul>
								<li>
									<a href="<?= base_url('about-us'); ?>">About Us</a>
								</li>
								<li>
									<a href="<?= base_url('blog'); ?>">Read Our Blog</a> 
								</li>
								<li>
									<a href="<?= base_url('contact-us'); ?>">Contact Us</a>
								</li>
								<li>
									<a href="<?= base_url('service-centers'); ?>">Service Centers</a>
								</li>
							</ul>
						</div>
						<div class="col-6 col-sm-6 col-md-6 col-lg-3">
							<h4>Policy &amp; Terms</h4>
							<ul>
								<li>
									<a href="<?= base_url('privacy-policy'); ?>">Privacy Policy</a>
								</li>
								<li>
									<a href="<?= base_url('disclaimer'); ?>">Disclaimer</a>
								</li>
								<li>
									<a href="<?= base_url('terms-conditions');?>">Terms Of Use</a>
								</li>
								<li>
									<a href="<?= base_url('warranty');?>">Warranty Terms</a>
								</li>
							</ul>
						</div>
						<div class="col-6 col-sm-6 col-md-6 col-lg-3">
							<h4>Purchase &amp; Usage</h4>
							<ul>
								<li>
									<a href="<?= base_url('return-refund-policy'); ?>">Return &amp; Refund Policy</a>
								</li>
								<li>
									<a href="<?= base_url('shipping-delivery');?>">Shipping &amp; Delivery</a>
								</li>
								<li>
									<a href="<?= base_url('tracking'); ?>">Order Tracking</a>
								</li>
								<!--<li>
									<a href="#">Shipping</a>
								</li>-->
							</ul>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-3">
					<h4>Contact Us</h4>
					<p>No. 3/140, Old Mahabalipuram Road Oggiam, Thoraipakkam, Chennai - 600 097.</p>
					<p><a class="top-phone" href="tel:044-6635 6635" >044-6635 6635</a>  <span>&nbsp; / &nbsp;</span>
						<a class="top-phone" href="tel:7711006635" >77110 06635</a></p>
					<p><a href="mailto:care@vidiem.in" target="
					_blank">care@vidiem.in</a></p>
					<h4 class="mt-4">Payment Methods</h4>
					<img src="<?= base_url(); ?>assets/front-end/images/payment.png" width="250" class="img-fluid" alt=""/>
				</div>
			</div>
			<div class="divider"></div>
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-6">
					<p>&copy; <?= date('Y'); ?> Vidiem, All Rights Reserved. With Love by <a href="https://www.pixel-studios.com/" target="_blank" class="text-white">Pixel Studios</a></p>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-6">
					<p class="text-right"><span class="text-white">Follow Us On</span> - &nbsp; 
					<a target="_blank" href="https://www.facebook.com/VidiemTM/"><i class="fa fa-facebook" aria-hidden="true"></i></a> &nbsp; <a target="_blank" href="https://twitter.com/vidiemmaya"><i class="fa fa-twitter" aria-hidden="true"></i></a> &nbsp; <a target="_blank" href="https://www.instagram.com/vidiemtm/"><i class="fa fa-instagram" aria-hidden="true"></i></a> &nbsp; <a target="_blank" href="https://www.youtube.com/channel/UCLJE5AoP7y7ccfFrMFyAv8g"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></a></p>
				</div>
			</div>
		</div>
	  </footer>
<?php } ?>
	  
	  
      <a href="#header" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
      <!-- Vendor JS Files -->
      <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" ></script>-->
	  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" ></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" ></script>
	  <script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/sweetalert.min.js"></script>	 
		<script src="<?= base_url(); ?>assets/front-end/js/f5dfb8bff8.js" ></script>
		
		<script src="<?= base_url(); ?>assets/front-end/js/slick.min.js" ></script>
      <!-- MDB core JavaScript -->
	  <script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/mdb.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" ></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>	  
      <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	   <script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/developer.js"></script>
	   <script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/bootstrap-slider.js"></script>
	   <script src="<?= base_url(); ?>assets/front-end/js/jquery.scrolling-tabs.js"></script>
	  <script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/jquery.validate.min.js"></script>
	 <script src="<?= base_url(); ?>assets/front-end/js/jquery.waypoints.min.js" ></script>
	 
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" ></script>
	 
	 <script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/stickySidebar.js"></script>
	  
	  <!-- custom scrollbar plugin -->
		<script src="<?= base_url(); ?>assets/front-end/js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="<?= base_url(); ?>assets/front-end/js/main.js"></script>
	  
		<script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/additional-methods.js"></script>
		<script type="text/javascript" src="<?= base_url(); ?>assets/front-end/js/date-time-picker.min.js"></script>
		<!--<script async defer crossorigin="anonymous" src="<?= base_url(); ?>assets/front-end/js/sdk.js"></script>-->


		<!--<div id="VideoModal" class="modal fade" tabindex="-1" role="dialog"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <i class="lni lni-close"></i>
					</button>
         <div class="modal-dialog opacity-animate3">			
            <div class="modal-content">	
               <div class="modal-body">
                  <iframe src="https://www.youtube.com/embed/8biVjAqkHg4" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
               </div>
            </div>
         </div>
      </div> -->
	  
	  <div id="AddToCompareModal" class="modal fade" tabindex="-1" role="dialog"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <i class="lni lni-close"></i>
					</button>
         <div class="modal-dialog opacity-animate3">			
            <div class="modal-content">	
               <div class="modal-body">
				  <div class="row">
					<div class="col-sm-12 col-md-6 col-lg-6">
						<h2>Compare Products</h2>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
						<a class="model-add-to-cart mt-0 mb-3" href="<?= base_url('compare'); ?>"><i class="lni lni-reload"></i> &nbsp; See Comparison</a>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
						<a class="model-add-to-cart mt-0 mb-3 remove_compare_all" href="javascript:void(0);"><i class="lni lni-close"></i> &nbsp; Remove All</a>
						
					</div>
					
				  </div>
                  <div class="row mt-3 comproList_section">
				  
				          <?php 
							$compare=$this->session->userdata('c_products'); 
						   if(!empty($compare)){
							foreach ($compare as $info) { 
							$tmp=$this->FunctionModel->Select_Fields_Row('id,name,image,slug,price,old_price,outofstock','vidiem_products',array('id'=>$info));
							?>
				  
					<div class="col-sm-12 col-md-4">
						<div class="model-border light-gray-bg">
							<h3><strong>Vidiem</strong> <?= $tmp['name']; ?></h3>
							<p class="model-price">₹ <?= @number_format($tmp['price']); ?> <span class="strike"> <?php if(isset($tmp['old_price'])){ ?> ₹ <?= @number_format($tmp['old_price']); } ?></span></p>
							
							<img src="<?= base_url('uploads/images/'.$tmp['image']); ?>" alt="" class="img-fluid" />
							<div class="row">
								<div class="col-sm-6 col-md-6">
									<?php if($tmp['outofstock']==0){ ?>
									<a href="javascript:void(0);" class="model-add-to-cart add_to_cart" data-id="<?= @$tmp['id'];?>"><i class="lni lni-cart"></i> &nbsp; Add to Cart</a>
									<?php } else{ ?>
									<a class="model-add-to-cart" href="<?= base_url('contact-us'); ?>"><i class="lni lni-cart"></i> &nbsp; Out of Stock</a>
									<?php } ?>
									
									
								</div>
								<div class="col-sm-6 col-md-6">
									<a href="javascript:void(0);" class="model-remove remove_compare_products" data-id="<?= $tmp['id']; ?>"><i class="lni lni-close"></i> &nbsp; Remove</a>
								</div>
							</div>
						</div>
					</div>
					
					<?php }} else{ ?>
            <li>Compare List Empty</li>
          <?php } ?> 
					
					<!--<div class="col-sm-12 col-md-4">
						<div class="model-border light-gray-bg">
							<h3><strong>Vidiem</strong> MG 580A Vision 650 Watts Mixer Grinder</h3>
							<p class="model-price">₹ 2,890.00 <span class="strike">₹ 3,290.00</span></p>
							<img src="<?= base_url(); ?>assets/front-end/images/product-images/product-image2.png" alt="" class="img-fluid" />
							<div class="row">
								<div class="col-sm-6 col-md-6">
									<a class="model-add-to-cart" href="#"><i class="lni lni-cart"></i> &nbsp; Add to Cart</a>
								</div>
								<div class="col-sm-6 col-md-6">
									<a href="#" class="model-remove"><i class="lni lni-close"></i> &nbsp; Remove</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-4">
						<div class="model-border light-gray-bg">
							<h3><strong>Vidiem</strong> MG 519A VSTAR Chrome 750 Watts Mixer Grinder</h3>
							<p class="model-price">₹ 4,090.00 <span class="strike">₹ 4,790.00</span></p>
							<img src="<?= base_url(); ?>assets/front-end/images/product-images/product-image3.png" alt="" class="img-fluid" />
							<div class="row">
								<div class="col-sm-6 col-md-6">
									<a class="model-add-to-cart" href="#"><i class="lni lni-cart"></i> &nbsp; Add to Cart</a>
								</div>
								<div class="col-sm-6 col-md-6">
									<a href="#" class="model-remove"><i class="lni lni-close"></i> &nbsp; Remove</a>
								</div>
							</div>
						</div>
					</div>-->
					
				  </div>
				  
               </div>
            </div>
         </div>
      </div>

<script type="text/javascript">
try{
var addCartButton = document.querySelector('a.add_to_cart');
addCartButton.addEventListener("click", () => {
    fbq('track', 'AddCartButton');
});
}
catch(e)
{
	
}
</script>

<?php $reload=$this->session->flashdata('reload'); 
    if(!empty($reload)){ ?>
      <script>
      window.close();
      window.opener.location.reload();
      </script>
<?php } ?>

<?php $fb_issue=$this->session->flashdata('fb_issue'); 
    if(!empty($fb_issue)){ ?>
      <script>
      setTimeout(
    function() {
       window.close();
    }, 3000);
      </script>
<?php } ?>

<?php $title=$this->session->flashdata('title'); 
if(!empty($title)){ 
  $msg=$this->session->flashdata('msg');
  $type=$this->session->flashdata('type');
  ?>
<script>
  $(document).ready(function(){
      swal("<?= $title; ?>", "<?= $msg; ?>", "<?= $type; ?>");
  })
</script>
<?php   
     $this->session->unset_userdata('title');
     $this->session->unset_userdata('msg');
     $this->session->unset_userdata('type');
} ?>

<script>
function subcatfunction(id,slug){
	$('<form action="<?php echo base_url(); ?>category/'+slug+'" method="POST"><input type="hidden" name="subcatid" value="'+id+'"></form>').appendTo('body').submit();

}

</script>	  
	  
	  
   </body>
</html>