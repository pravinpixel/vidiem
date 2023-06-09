<?php include('container/header.php'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front-end/css/vidiem-by-you.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div id="loader"></div>  
<div class="by-you-header">
    <a href="<?= base_url(); ?>"><img src="<?= base_url(); ?>assets/front-end/images/logo.png" alt="" /></a>
    <div class="by-you-cart"><img src="<?= base_url(); ?>assets/front-end/images/cart-icon.svg" atl="" /> <span class="count cart_total_product"><?= @$cart_count; ?></span></div>
    <a href="<?= base_url(); ?>" class="red-btn back-to-home"><i class="fa fa-home" aria-hidden="true"></i></a>
</div>
<section class="pt-0 pb-0 vidiem-for-you">
   <div class="container">
      <div class="row align-items-center justify-content-center">
         <div class="col-sm-12 col-md-12 col-lg-6">
            <div class="product-image">			
			<div class="show-message"></div>
			<?php 
			if($cartitems['bodyinfo'][0]['bm_color_id']!="" && !empty($cartitems['bodyinfo'][0]['bm_color_id']))
			   { 
		  // print_r($cartitems['bodyinfo'][0]); die();
				   ?>
				      <img id="fullbaseimg" src="<?php echo base_url('uploads/customizeimg/basecolor/'.$cartitems['bodyinfo'][0]['bodycolorimg']) ?>" id="product-image" alt="" class="img-fluid"/>  
					<?php 		
					   } else {
						 ?>
               <img id="fullbaseimg" src="<?= base_url(); ?>assets/front-end/images/vidiem-by-you/silhouette.jpg" id="product-image" alt="" class="img-fluid"/>  
			<?php } ?>  
               <a href="#" class="red-btn view-selected-items" data-toggle="modal" data-target="#SelectedItemsModal">Selected Items</a>			   
			   <div class="product-selected-items">
			   <p class="text-center">Selected Items</p>
			   <div class="selected-items-scroll">
			   <?php   if($cartitems['bodyinfo'][0]['base_id']!="" && !empty($cartitems['bodyinfo'][0]['base_id']))
				   { 
			         echo $selecteditem;
				   }		
			   ?>
			   </div>
			   </div>
            </div>
		<?php   if($cartitems['bodyinfo'][0]['base_id']!="" && !empty($cartitems['bodyinfo'][0]['base_id']))
				   { ?>
            <div class="selected-price" style="display:block;">Rs. <strong><?php echo $totprice; ?></strong></div>
        
				   <?php } else { ?>
				    <div class="selected-price">Rs. <strong>0.00</strong></div>
            <button type="button" class="red-btn" id="customize-button">Customize this Product</button>
				   <?php } ?>			
		 <?php 
			//  } 
		//	}
		// }
		  ?>	
         </div>
         <div class="col-sm-12 col-md-12 col-lg-6 pb-5">
             
            <div class="accordion mt-5" id="by-you-accordion">
               <div class="card">
			   <?php 
			  //print_r($cartitems);
			  
			   $clsgreenck="";
			    if($cartitems['bodyinfo'][0]['base_id']!="" && !empty($cartitems['bodyinfo'][0]['base_id']))
				   {
						$clsgreenck=" greenCheck ";
				   }
				?>
			   
			   
                  <div class="card-header <?php echo $clsgreenck; ?> " id="heading1">
                     <a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#accordion1"
                        aria-expanded="true" aria-controls="accordion1">
						<i class="fa fa-check-circle" aria-hidden="true"></i> 
						<span class="pc-text">Choose Body Design</span></a>
                  </div>
                  <div id="accordion1" class="collapse show" aria-labelledby="heading1" data-parent="#by-you-accordion">
                     <div class="card-body">
                     <div class="text-center position-relative"><span class="mobile-text">Choose Body</span></div>
                        <div class="body-type">
						<?php 
						 if(count($customizebase)>0){ 
						   foreach($customizebase as $base) {
							   $clsactive="";
							   if($cartitems['bodyinfo'][0]['base_id']==$base['base_id'])
							   {
								    $clsactive=" active ";
							   }
							   
						 ?>
                           <div>
                               <a class="select-body <?php echo $clsactive ?>" href="javascript:void(0);" onclick="fnbaseclick(this,'<?php echo $base['base_id']?>','<?= base_url()."uploads/customizeimg/".$base['basepath']; ?>','<?= @number_format($base['price']);?>');" >
                              <img src="<?= base_url()."uploads/customizeimg/".$base['basepath']; ?>" alt="<?= $base['basetitle']?>" class="img-fluid"/>
                              <span class="basetitle"><?= $base['basetitle']?></span>
							  <span class="baseprice"> ₹ <?= @number_format($base['price']);?></span>
                              <i class="fa fa-check-circle" aria-hidden="true"></i>
                              </a>
                           </div>
						   <?php 
						   }
						 } ?>	 
                           
                     </div>
					 
                        <div class="next-btn">
						<?php
							$butdisabled=" disabled ";
						  if($cartitems['bodyinfo'][0]['base_id']!="" && !empty($cartitems['bodyinfo'][0]['base_id']))
						   {
								$butdisabled="  ";
						   }
						
						?>
						
                           <button type="button" <?php echo $butdisabled; ?> class="red-btn" id="body-design-next">Next &nbsp; <i class="lni lni-arrow-right"></i></button>
                        </div>
                  </div>
               </div>
               </div>
               <div class="card">
			   
			   <?php 
				   $clsgreenck="";
					if($cartitems['bodyinfo'][0]['bm_color_id']!="" && !empty($cartitems['bodyinfo'][0]['bm_color_id']))
					   {
							$clsgreenck=" greenCheck ";
					   }
				?>
			   
                  <div class="card-header <?php echo $clsgreenck; ?>  " id="heading2">
                     <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#accordion2"
                        aria-expanded="true" aria-controls="accordion1"><i class="fa fa-check-circle" aria-hidden="true"></i> <span class="pc-text">Choose Color</span></a>
                  </div>
                  <div id="accordion2" class="collapse" aria-labelledby="heading2" data-parent="#by-you-accordion">
                     <div class="card-body">
                        <div class="text-center position-relative"><span class="mobile-text">Choose Color</span></div>
						 <div id="divbasecolor">
						 
							<div class="body-color">	
						<?php	
							if(count($basecolorlist)>0){

			 
						   foreach($basecolorlist as $base_col) {
							   $clsactive="";
							   if($cartitems['bodyinfo'][0]['bm_color_id']==$base_col['bm_color_id'])
							   {
								    $clsactive=" active ";
							   }
							?>
								 <div>
							 <a class="select-color <?php echo $clsactive; ?>" href="javascript:void(0);" onclick="fnbasecolorclick(this,'<?php echo $base_col['bm_color_id']; ?>','<?php echo base_url('uploads/customizeimg/basecolor/'.$base_col['basepath']) ?>','<?php echo@number_format($base_col['price'])?>');" >	
							 
                             
                              <img src="<?php echo base_url('uploads/customizeimg/basecolor/'.$base_col['basepath'])?>" alt="" class="img-fluid"/>
                              <span><?php echo $base_col['title'] ?></span>
						<?php 
						if(	$base_col['price']!=0)
						{ ?>
							<span><?php echo $base_col['price'] ?></span> 
					  <?php 		
						}		
						?>  
                       <i class="fa fa-check-circle" aria-hidden="true"></i>
                              </a>
                           </div>
					<?php 		   
					   }
					 } 
					  ?> 
						</div>  
						<div class="next-btn">
						
						<?php
							$butdisabled=" disabled ";
						
						  if($cartitems['bodyinfo'][0]['bm_color_id']!="" && !empty($cartitems['bodyinfo'][0]['bm_color_id']))
						   {
							  
								$butdisabled="  ";
						   }
						
						?>
						
                           <button type="button" class="black-btn" id="body-color-prev"><i class="lni lni-arrow-left"></i> &nbsp; Previous</button>
                           <button <?php echo $butdisabled; ?> type="button" class="red-btn" id="body-color-next">Next &nbsp; <i class="lni lni-arrow-right"></i></button>
                        </div>

							
						</div>
						
                      
						</div>
                     </div>
                  </div>              
               <div class="card">
			   
			   <?php 
				   $clsgreenck="";
					if(count($cartitems['jarinfo'])>0)
					   {
							$clsgreenck=" greenCheck ";
					   }
				?>
			   
			   
                  <div class="card-header <?php echo $clsgreenck; ?>" id="heading3">
                     <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#accordion3"
                        aria-expanded="true" aria-controls="accordion3"><i class="fa fa-check-circle" aria-hidden="true"></i>  <span class="pc-text">Choose Jars</span></a>
                  </div>
                  <div id="accordion3" class="collapse" aria-labelledby="heading3" data-parent="#by-you-accordion">
                     <div class="card-body">
                     <div class="text-center position-relative"><span class="mobile-text">Choose Jars</span></div>
					 <div id="divbasejar">
					  <div class="jar-scroll">
					<?php  
					 if(count($cartitems['jarinfo'])>0)
					   {
						   $existjarids=array();
						  
						   foreach($cartitems['jarinfo'] as $j)
						   {
							    $existjarids[]=$j['jar_id'];
							   
						   }
						
					 	   foreach($jarlist as $jar) {
							   $bflag=0;
							   if(in_array($jar['jar_id'],$existjarids))
							   {
								    $bflag=1;
							   }
							   $jarkey = array_search ($jar['jar_id'], $existjarids);
							   
							  					 
					 ?>
					
					 
					 <div>
                              <div class="select-jar selectedjar-<?php echo $jar['jar_id']?> <?php echo $bflag==1?" active ":"";?> ">
                                 <a href="<?php echo base_url("uploads/customizeimg/jar/".$jar['basepath']); ?>" data-fancybox data-caption="Jar1">
                                     <img src="<?php echo base_url("uploads/customizeimg/jar/".$jar['basepath']); ?>" alt="" class="img-fluid"/>
                                 </a>
                                 <span class="jar-name"><?php echo $jar['name']?></span>
                                 <span>Rs. <?php echo number_format($jar['price']) ?></span>                                            
                                 <div class="plus-minus">
                                    <div class="input-group">
                                       <span class="input-group-prepend">
                                       <button type="button" class="btn btn-number" <?php echo $bflag==1?"  disabled='disabled' ":"";?> data-type="minus" data-field="quant[<?php echo $jar['jar_id']?>]">
                                       <span class="fa fa-minus"></span>
                                       </button>
                                       </span>
                                       <input type="text" id="qtyinp_<?php echo $jar['jar_id'] ?>" name="quant[<?php echo $jar['jar_id'] ?>]" class="form-control input-number" value="<?php echo $bflag==1?$cartitems['jarinfo'][$jarkey]['qty']:"0";?>" min="0" max="10">
                                       <span class="input-group-append">
                                       <button type="button" class="btn btn-number jar-plus" data-type="plus" data-field="quant[<?php echo $jar['jar_id'] ?>]">
                                       <span class="fa fa-plus"></span>
                                       </button>
                                       </span>
                                    </div>
                                 </div>
                                 <i class="fa fa-check-circle" aria-hidden="true"></i>
                              </div>
                            </div>
					 
					 
				
					 
					 <?php 
						   }
						?>
						
						<div>
                              <div class="select-jar-last"><p class="jar-options">Choose from other <br/><a href="#" data-toggle="modal" data-target="#JarsModal">Jar Options</a></p>
                              <p class="jar-options-selected"><strong>0 Jar Selected</strong><p>
                              </div>
                           </div>

					<?php		
						   
					   }   
					?>	   
                       
					   
					</div>   
					</div>	
					
					<?php 
				  $butdisabled=" disabled ";
					if(count($cartitems['jarinfo'])>0)
					   {
							$butdisabled="  ";
					   }
				?>
			   
					
                        <div class="next-btn">
                           <button type="button" class="black-btn" id="jar-prev"><i class="lni lni-arrow-left"></i> &nbsp; Previous</button>
                           <button type="button" <?php echo $butdisabled; ?> class="red-btn"  id="jar-next">Next &nbsp; <i class="lni lni-arrow-right"></i></button>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="card">
			   
			   <?php 
   $clsgreenck="";
	if($cartitems['bodyinfo'][0]['motor_id']!="" && !empty($cartitems['bodyinfo'][0]['motor_id']))
	   {
			$clsgreenck=" greenCheck ";
	   }
?>
			   
                  <div class="card-header <?php echo $clsgreenck; ?>" id="heading4">
                     <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#accordion4"
                        aria-expanded="true" aria-controls="accordion4"><i class="fa fa-check-circle" aria-hidden="true"></i>  <span class="pc-text">Select Motor Power</span></a>
                  </div>
                  <div id="accordion4" class="collapse" aria-labelledby="heading4" data-parent="#by-you-accordion">
                     <div class="card-body">
                     <div class="text-center position-relative"><span class="mobile-text">Choose Motor</span></div>
                        <div id="divbasemotor" class="row align-items-center justify-content-center no-gutters">
						 <div class="col-12 col-sm-8 col-md-8 col-lg-9">
						 <div class="motor-select-scroll">
						<?php 
						  if(count($basemotorlist)>0){
						$flag=0;
					
						
						   foreach($basemotorlist as $motor) {
							   $clsactive="";
							   if($flag==0)
							   {
								   // $clsactive=" active ";
								   $motorimg=base_url('uploads/customizeimg/basemotor/'.$motor['basepath']);
								   $flag=1;
							   }
							   
							   $clsactive="";
							   $chkmotor="";
							   if($cartitems['bodyinfo'][0]['motor_id']==$motor['motor_id'])
							   {
								    $clsactive=" active ";
									  $chkmotor=" checked='checked' ";
							   }
							   
						 ?>
						 <div>
							 <div class="custom-control custom-radio motor-select <?php echo $clsactive;?>" href="javascript:void(0);" >	
							 
							  <input onchange="fnbasemotorclick(this,'<?php echo $motor['motor_id']?>','<?php echo base_url('uploads/customizeimg/basemotor/'.$motor['basepath'])?>,'<?php echo @number_format($motor['price'])?>');" <?php echo  $chkmotor; ?>  class="custom-control-input" type="radio" name="motorSelect" id="motorSelect<?php echo $motor['motor_id']?>" />
                                            <label class="custom-control-label" for="motorSelect<?php echo $motor['motor_id']?>"> <?php echo $motor['motorname']?> <small><?php echo $motor['description']?></small> </label>                             
                       <?php     
						if(	$motor['motorprice']!=0)
						{ ?>
							<span>Rs. <?php echo number_format($motor['motorprice'])?></span>
					<?php	}	?>	 
							  
                           
                              </div>
                           </div>
					<?php		   
					   }
				 } 
					   ?>
				</div> </div> 
                        <div class="col-12"> <div class="next-btn">
					
					<?php
							$butdisabled=" disabled ";
						
						  if($cartitems['bodyinfo'][0]['motor_id']!="" && !empty($cartitems['bodyinfo'][0]['motor_id']))
						   {
							  
								$butdisabled="  ";
						   }
						
						?>	
						
						
                            <button type="button" class="black-btn" id="motor-prev"><i class="lni lni-arrow-left"></i> &nbsp; Previous</button>
                           <button <?php echo $butdisabled; ?> type="button" class="red-btn"   href="#" id="motor-next">Next &nbsp; <i class="lni lni-arrow-right"></i></button>
                        </div></div>
                   
                     </div>
                  </div>
               </div>
               </div>
               <div class="card">
			   
			     
			   <?php 
				   $clsgreenck="";
					if($cartitems['bodyinfo'][0]['canvas_text']!="" && !empty($cartitems['bodyinfo'][0]['package_id']))
					   {
							$clsgreenck=" greenCheck ";
					   }
				?>
			   
                  <div class="card-header <?php echo $clsgreenck; ?>" id="heading5">
                     <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#accordion5"
                        aria-expanded="true" aria-controls="accordion5"><i class="fa fa-check-circle" aria-hidden="true"></i>  <span class="pc-text">Get Your Name / Message Imprinted</span></a>
                  </div>
                  <div id="accordion5" class="collapse" aria-labelledby="heading5" data-parent="#by-you-accordion">
                     <div class="card-body">
                     <div class="text-center position-relative"><span class="mobile-text">Message Imprinted</span></div>
                        <div class="row justify-content-center">
                            <div class="col-12 col-sm-12 col-md-8">
                                <input type="text" maxlength="20" class="form-control" onblur="funsaveimportedtext(this.value);" value="<?php echo $cartitems['bodyinfo'][0]['canvas_text']; ?>" id="type-message" />
                                <small class="text-red">Maximum 20 Characters</small>
                            </div> 
                        </div>
                            <div class="next-btn">
                              <button type="button" class="black-btn" id="imprinted-prev"><i class="lni lni-arrow-left"></i> &nbsp; Previous</button>
                              <button type="button"  class="red-btn" href="#" id="imprinted-next">Next &nbsp; <i class="lni lni-arrow-right"></i></button>
                           </div>
                     </div>
                  </div>
               </div>
               <div class="card">
			   
			     
			   <?php 
				   $clsgreenck="";
					if($cartitems['bodyinfo'][0]['package_id']!="" && !empty($cartitems['bodyinfo'][0]['package_id']))
					   {
							$clsgreenck=" greenCheck ";
					   }
				?>
			   
                  <div class="card-header <?php echo $clsgreenck; ?>" id="heading6">
                     <a href="#" class="btn btn-header-link collapsed" id="pack-pref" data-toggle="collapse" data-target="#accordion6"
                        aria-expanded="true" aria-controls="accordion6"><i class="fa fa-check-circle" aria-hidden="true"></i>  <span class="pc-text">Your Packaging Preference</span></a>
                  </div>
                  <div id="accordion6" class="collapse" aria-labelledby="heading6" data-parent="#by-you-accordion">
                     <div class="card-body">
                     <div class="text-center position-relative"><span class="mobile-text">Your Packaging Preference</span></div>
                        <div class="package-list">
						<?php 
						 if(count($customizepackage)>0){ 
						   foreach($customizepackage as $package) {
							   $clsactive="";
							   $chkpack="";
							   if($cartitems['bodyinfo'][0]['bm_color_id']==$base_col['bm_color_id'])
							   {
								    $clsactive=" active ";
									  $chkpack=" checked='checked' ";
							   }
							   
						 ?>
						
							
							 <a class="custom-control custom-radio package-select <?php echo $clsactive ?>" href="javascript:void(0);" onclick="fnpackageclick(this,'<?php echo $package['package_id']?>','<?= base_url()."uploads/customizeimg/".$package['basepath']; ?>','<?= @number_format($package['price']);?>');" >
                                
                                    <input class="custom-control-input" type="radio" name="packageSelect" id="packageSelect<?php echo $package['package_id']; ?>" <?php echo $chkpack; ?> />
                                    <label class="custom-control-label" for="packageSelect<?php echo $package['package_id']; ?>"> <?php echo $package['packagename']; ?> <small><?php echo $package['description']; ?></small>
									<span class="baseprice"> ₹ <?= @number_format($package['price']);?></span>
									</label>
                               
							</a>	
						  <?php 
						   }
						 } ?>		
                           
                        </div>                        
                        <div class="next-btn">
                              <button type="button" class="black-btn" id="package-prev"><i class="lni lni-arrow-left"></i> &nbsp; Previous</button>
                              <button type="button" disabled class="red-btn" id="package-next">Confirm &amp; Proceed &nbsp; <i class="lni lni-arrow-right"></i></button>
                           </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<div id="JarsModal" class="modal fade" tabindex="-1" role="dialog">
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
   <i class="lni lni-close"></i>
   </button>
   <div class="modal-dialog opacity-animate3">
      <div class="modal-content">
         <div class="modal-body">
            <div class="row">
               <div class="col-sm-12 col-md-12 col-lg-12">
                  <h2>Other Jar Options</h2>
                  <button type="button" class="red-btn" id="for-you-filters"><i class="fa fa-filter"></i></button>
                  <div id="divjarfilter" class="light-gray-bg mb-3 for-you-show-filters">
				<form id="frmjarfilter" name="frmjarfilter" >  
				<input type="hidden" id="hidbid" name="hidbid" value="" >
		 
			<?php if(count($typeofjar)>0) { 
			  ?>
				  
                     <div class="filter-checkbox2 m-3">
                        <h4 class="color-dark text-uppercase">Type of Jars</h4>
			<?php			
				 foreach($typeofjar as $jar) {
			?>		 		
                        <div class="custom-checkbox">
                           <label>
                           <input onchange="fnjarfilter();" type="checkbox" id="typeofjarid <?= $jar['typeofjar_id'] ?>" name="typeofjar[]" value=" <?= $jar['typeofjar_id'] ?>">
                           <span class="box"></span>
                           <?= $jar['typeofjarname'] ?>	</label>
                        </div>                       
			  <?php  
			   }
			?>			   
                     </div>
			 <?php
			} 
			?>			 
			
			
				<?php if(count($typeofhandle)>0) { 
			  ?>
				  
                     <div class="filter-checkbox2 m-3">
                        <h4 class="color-dark text-uppercase">Type of Handle</h4>
			<?php			
				 foreach($typeofhandle as $han) {
			?>		 		
                        <div class="custom-checkbox">
                           <label>
                           <input onchange="fnjarfilter();" type="checkbox" id="typeofhandleid <?= $han['typeofhandle_id'] ?>" name="typeofhandle[]" value=" <?= $han['typeofhandle_id'] ?>">
                           <span class="box"></span>
                           <?= $han['typeofhandlename'] ?>	</label>
                        </div>                       
			  <?php  
			   }
			?>			   
                     </div>
			 <?php
			} 
			?>	
			
			
			
				<?php if(count($typeoflid)>0) { 
			  ?>
				  
                     <div class="filter-checkbox2 m-3">
                        <h4 class="color-dark text-uppercase">Type of LID</h4>
			<?php			
				 foreach($typeoflid as $lid) {
			?>		 		
                        <div class="custom-checkbox">
                           <label>
                           <input onchange="fnjarfilter();" type="checkbox" id="typeoflidid <?= $lid['typeoflid_id'] ?>" name="typeoflid[]" value=" <?= $lid['typeoflid_id'] ?>">
                           <span class="box"></span>
                           <?= $lid['typeoflidname'] ?>	</label>
                        </div>                       
			  <?php  
			   }
			?>			   
                     </div>
			 <?php
			} 
			?>	
			
               </form>    
                    
                  </div>
               </div>
               <div id="divotherjar" class="col-12 col-sm-12 col-md-12 col-lg-12">
			   
			   <?php  
			   
			    if(count($cartitems['jarinfo'])>0)
					   {
						   $existjarids=array();
						  
						   foreach($cartitems['jarinfo'] as $j)
						   {
							    $existjarids[]=$j['jar_id'];
							   
						   }
						
					 	   foreach($alljarlist as $jar) {
							   $bflag=0;
							   if(in_array($jar['jar_id'],$existjarids))
							   {
								    $bflag=1;
							   }
							   $jarkey = array_search ($jar['jar_id'], $existjarids);
					 
					 ?>
			   
						 <div>
                              <div class="select-jar selectedjar-<?php echo $jar['jar_id']?> <?php echo $bflag==1?" active ":"";?> ">
                                 <a href="<?php echo base_url("uploads/customizeimg/jar/".$jar['basepath']); ?>" data-fancybox data-caption="Jar1">
                                     <img src="<?php echo base_url("uploads/customizeimg/jar/".$jar['basepath']); ?>" alt="" class="img-fluid"/>
                                 </a>
                                 <span class="jar-name"><?php echo $jar['name']?></span>
                                 <span>Rs. <?php echo number_format($jar['price']) ?></span>                                            
                                 <div class="plus-minus">
                                    <div class="input-group">
                                       <span class="input-group-prepend">
                                       <button type="button" class="btn btn-number"  <?php echo $bflag==1?"  disabled='disabled' ":"";?> data-type="minus" data-field="quant[<?php echo $jar['jar_id']?>]">
                                       <span class="fa fa-minus"></span>
                                       </button>
                                       </span>
                                       <input type="text" id="qtyinp_<?php echo $jar['jar_id'] ?>" name="quant[<?php echo $jar['jar_id'] ?>]" class="form-control input-number" value="<?php echo $bflag==1?$cartitems['jarinfo'][$jarkey]['qty']:"0";?>" min="0" max="10">
                                       <span class="input-group-append">
                                       <button type="button" class="btn btn-number jar-plus" data-type="plus" data-field="quant[<?php echo $jar['jar_id'] ?>]">
                                       <span class="fa fa-plus"></span>
                                       </button>
                                       </span>
                                    </div>
                                 </div>
                                 <i class="fa fa-check-circle" aria-hidden="true"></i>
                              </div>
                            </div>
						   <?php }  
					   } ?>		
                  
               </div>
            </div>
            <div id="divotherjarbutton" class="buttons mt-5">
              <?php  
					 if(count($cartitems['jarinfo'])>0)
					   { ?> 
			  
			  <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-6">
                     &nbsp;
                  </div>
                  <div class="col-sm-6 col-md-4 col-lg-3">
                     <a class="black-btn" href="javascript:void(0);"  onclick="funremoveotherjars(\''.$id.'\');"><i class="lni lni-close"></i> &nbsp;Removed selected jars</a>
                  </div>
                  <div class="col-sm-6 col-md-4 col-lg-3">
                     <a class="red-btn" href="javascript:void(0);" onclick="funmodalclose(\''.$id.'\');"><i class="lni lni-checkmark-circle"></i> &nbsp; Submit Jars</a>
                  </div>
               </div>
					   <?php } ?> 
			  
            </div>
         </div>
      </div>
   </div>
</div>


<div id="SelectedItemsModal" class="modal fade" tabindex="-1" role="dialog">
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
   <i class="lni lni-close"></i>
   </button>
   <div class="modal-dialog opacity-animate3">
      <div class="modal-content">
         <div class="modal-body">
             <div class="row">
                 <div class="col-sm-6 col-6 text-center">
                     <h4 class="text-center">Vitiron</h4>
                     <img src="<?= base_url(); ?>assets/front-end/images/vidiem-by-you/body-design.png" alt="" class="img-fluid"/>
                 </div>
                 <div class="col-sm-6 col-6 text-center">
                     <h4 class="text-center">Pink IVY</h4>
                     <img src="<?= base_url(); ?>assets/front-end/images/vidiem-by-you/body-color.png" alt="" class="img-fluid"/>
                 </div>
                 <div class="col-sm-6 col-6 text-center">
                     <h4 class="text-center">Master Jar</h4>
                     <img src="<?= base_url(); ?>assets/front-end/images/vidiem-by-you/jar1.jpg" alt="" class="img-fluid"/>
                 </div>
                 <div class="col-sm-6 col-6 text-center">
                     <h4 class="text-center">Multi Jar</h4>
                     <img src="<?= base_url(); ?>assets/front-end/images/vidiem-by-you/jar2.jpg" alt="" class="img-fluid"/>
                 </div>
                 <div class="col-sm-6 col-6 text-center">
                     <h4 class="text-center">Marval Jar</h4>
                     <img src="<?= base_url(); ?>assets/front-end/images/vidiem-by-you/jar3.jpg" alt="" class="img-fluid"/>
                 </div>
                 <div class="col-sm-6 col-6 text-center">
                     <h4 class="text-center">Motor 750 Watt</h4>
                     <img src="<?= base_url(); ?>assets/front-end/images/vidiem-by-you/motor.jpg" alt="" class="img-fluid"/>
                 </div>
             </div>
         </div>
      </div>
   </div>
</div>

<?php require_once('container/footer-customize.php')?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script>
function funmodalclose(bid)
{
	$('#JarsModal').modal('hide');
	
}

function funremoveotherjars(bid)
{
	
		$.ajax({
			url:'<?php echo base_url("home/removeotherjars"); ?>',
			dataType: 'json',
			type:'POST',
			data:'bid='+bid,
			success:function(data){
			//$("#shippingaddressupdatediv").html(data.addressformhtml);	
			if(data.status==200)
			{
				 $(".selected-price strong").html(data.totprice);
				 $(".selected-items-scroll").html(data.selecteditem);
				 $("#divotherjar .input-number").val('0');
				 $("#divotherjar .select-jar ").removeClass('active');
				 $('#JarsModal').modal('hide');
				 				 
			}
			else{
				swal("Error", "", "error");
			}
				
			}
		});
	
	
	
}

   $(document).ready(function() {   	
   
    
        $('[data-toggle=collapse]').prop('disabled',true);
   
   
   $('.collapse').on('shown.bs.collapse', function () {
      // $(this).prev().addClass('active-acc');
   });
   
   $('.collapse').on('hidden.bs.collapse', function () {
      // $(this).prev().removeClass('active-acc');
   });
   
   $(".next-btn button").attr("disabled");
   
   
   });
   
   function fnbaseclick(ele,bid,baseimg,price){
  
     $(".select-body").removeClass("active");
     $(".product-selected-items").show();
     $(ele).addClass("active");
	 $("#fullbaseimg").attr("src",baseimg);
	 $("#hidbid").val(bid);	
	 $(".selected-price").show();
	$("#heading1").addClass("greenCheck");
	$("#body-design-next").removeAttr("disabled");
	
	$.ajax({
			url:'<?php echo base_url("home/getbasecolor"); ?>',
			dataType: 'json',
			type:'POST',
			data:'bid='+bid,
			success:function(data){
			//$("#shippingaddressupdatediv").html(data.addressformhtml);	
			if(data.status==200)
			{
				$(".show-message").css("left",data.showmsgleft+"%"); 
				$(".show-message").css("top",data.showmsgtop+"%"); 
				 $(".selected-price strong").html(data.totprice);
				 $(".selected-items-scroll").html(data.selecteditem);
				  
				/* Base Color Script */
				$("#divbasecolor").html(data.color_html);
				  $('.body-color').slick({
					   slidesToShow: 2,
					   dots:false,
					   centerMode: false,
					   autoplay: false,
					   infinite: false,
					   slidesToScroll: 1,
					   variableWidth: true,
					 });
					 
					 $("#body-color-next").on("click", function() {
						   $("#accordion3").collapse('show');
					   });

					   $("#body-color-prev").on("click", function() {
						   $("#accordion1").collapse('show');
					   }); 
					   
					/* Base Motor Script */   
					
					$("#divbasemotor").html(data.motor_html);
				  $('.motor-select-scroll').slick({
				   slidesToShow: 2,
				   dots:false,
				   centerMode: false,
				   autoplay: false,
				   infinite: false,
				   slidesToScroll: 1,
				   variableWidth: true,
				 });
					 
				$("#motor-next").on("click", function() {
				   $("#accordion5").collapse('show');
			   });

			   $("#motor-prev").on("click", function() {
				   $("#accordion3").collapse('show');
			   });
					
				
			  /* Base Jar Script */   
					
				$("#divbasejar").html(data.jar_html);
				  $('.jar-scroll').slick({
					   slidesToShow: 2,
					   dots:false,
					   centerMode: false,
					   autoplay: false,
					   infinite: false,
					   slidesToScroll: 1,
					   variableWidth: true,
					 });
				$("#divotherjar").html(data.other_jar_html);				
				$("#divotherjarbutton").html(data.otherjar_button);
				 $(".model-jars").mCustomScrollbar({
					theme:"dark-thin",
					setHeight:250,
					scrollButtons:{enable:true},
				   });
   
					 
				
				$('.btn-number').click(function(e){
							e.preventDefault();
						   
						   fieldName = $(this).attr('data-field');
						   type      = $(this).attr('data-type');
						   var input = $("input[name='"+fieldName+"']");
						   var currentVal = parseInt(input.val());
						   if (!isNaN(currentVal)) {
							   if(type == 'minus') {
								   
								   if(currentVal > input.attr('min')) {
									   input.val(currentVal - 1).change();
								   } 
								   if(parseInt(input.val()) == input.attr('min')) {
									   $(this).attr('disabled', true);
								   }
					   
							   } else if(type == 'plus') {
					   
								   if(currentVal < input.attr('max')) {
									   input.val(currentVal + 1).change();
								   }
								   if(parseInt(input.val()) == input.attr('max')) {
									   $(this).attr('disabled', true);
								   }
					   
							   }
						   } else {
							   input.val(0);
						   }
					   });		
				
				 $('.input-number').focusin(function(){
					  $(this).data('oldValue', $(this).val());
				   });
				   $('.input-number').change(function() {
					   
					   minValue =  parseInt($(this).attr('min'));
					   maxValue =  parseInt($(this).attr('max'));
					   valueCurrent = parseInt($(this).val());
					   var inid=$(this).attr('id');
					   var jid=(inid.split("_"))[1];
					
					   name = $(this).attr('name');
					   if(valueCurrent >= minValue) {
						  
						   $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled');
						   if(valueCurrent=='0'){
							 
								$(".selectedjar-"+jid).removeClass("active");
								swal("Removed", "Selected jar removed from your cart", "info");
						   }
							else{
								
								$(".selectedjar-"+jid).addClass("active");
							}
					   } else {
						    $(".selectedjar-"+jid).removeClass("active");
							swal("Check your quantity", "Sorry, the minimum value was reached", "info");
						   $(this).val($(this).data('oldValue'));
					   }
					   if(valueCurrent <= maxValue) {
						   $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled');
						   	   if(valueCurrent=='0'){
								   $(".selectedjar-"+jid).removeClass("active");
							   }
							   else{
						    $(".selectedjar-"+jid).addClass("active");
							   }
					   } else {
						   swal("Check your quantity", "Sorry, the maximum value was reached", "info");
						   $(this).val($(this).data('oldValue'));
					   }
					   
					   /* save jar */
					   
					   $.ajax({
								url:'<?php echo base_url("home/savejar"); ?>',
								dataType: 'json',
								type:'POST',
								data:'jid='+jid+"&qty="+valueCurrent,
								success:function(data){
								//$("#shippingaddressupdatediv").html(data.addressformhtml);	
								if(data.status==200)
								{
									 $(".selected-price strong").html(data.totprice);
									  $(".selected-items-scroll").html(data.selecteditem);
													  
									 if(data.jarcount>0)
									 {
										
									 $("#heading3").addClass("greenCheck");
									 $("#jar-next").removeAttr("disabled");
									 }
									 else{
										 $("#jar-next").prop('disabled', true);
										
										  $("#heading3").removeClass("greenCheck");
										   
									 }
									
								}
								else{
									swal("Error", "", "error");
								}
									
								}
							});
					   
					   
				   });
				   
				   $(".input-number").keydown(function (e) {
					   // Allow: backspace, delete, tab, escape, enter and .
					   if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
							// Allow: Ctrl+A
						   (e.keyCode == 65 && e.ctrlKey === true) || 
							// Allow: home, end, left, right
						   (e.keyCode >= 35 && e.keyCode <= 39)) {
								// let it happen, don't do anything
								return;
					   }
					   // Ensure that it is a number and stop the keypress
					   if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
						   e.preventDefault();
					   }
				   });
				
				 /*  $(".jar-plus").click(function(){
						
						 $(".selected-jar").show();
						 $(".jar-options-selected").show();  
						 $(".view-selected-items").addClass('show');       
					   });
				*/
					
					$("#heading2").removeClass("greenCheck");
					$("#heading3").removeClass("greenCheck");
					$("#heading4").removeClass("greenCheck");
					$("#heading5").removeClass("greenCheck");
					$("#heading6").removeClass("greenCheck");
					
			}
			else{
				swal("Error", "", "error");
				
			}
				
			}
		});
	
   }
  
   
   
  /* $(".select-body").click(function(){
     $(".select-body").removeClass("active");
     $(".selected-body").show();
     $(this).addClass("active");
     $(".selected-price").show(); 
     $('#product-image').attr('src', '<?= base_url(); ?>assets/front-end/images/vidiem-by-you/body-design.png');
   }); */
   
   $("#for-you-filters").on("click", function() {
       $(".for-you-show-filters").toggleClass('show');
   });
   
   $("#customize-button").on("click", function() {
       $(".accordion").show();
       $(this).hide();
   });
   
     
   
    function fnbasecolorclick(ele,bcid,baseimg,price){
  
     $(".select-color").removeClass("active");
     $(".select-color").show();
	 $(".selected-color").show();
     $(ele).addClass("active");
	 $("#fullbaseimg").attr("src",baseimg);	
	 
	 $(".selected-price").show();
	$("#heading2").addClass("greenCheck");
	$("#body-color-next").removeAttr("disabled");
	
	$.ajax({
			url:'<?php echo base_url("home/savebasecolor"); ?>',
			dataType: 'json',
			type:'POST',
			data:'bcid='+bcid,
			success:function(data){
			//$("#shippingaddressupdatediv").html(data.addressformhtml);	
			if(data.status==200)
			{
				 $(".selected-price strong").html(data.totprice);
				 $(".selected-items-scroll").html(data.selecteditem);
				 				 
			}
			else{
				swal("Error", "", "error");
			}
				
			}
		});
	
   }
   
   
    function fnbasemotorclick(ele,bcid,baseimg,price){ 
    
     $(ele).addClass("active");
	 $("#motorimg").attr("src",baseimg);
	$("#heading4").addClass("greenCheck");
	$("#motor-next").removeAttr("disabled");
	
	$.ajax({
			url:'<?php echo base_url("home/savebasemotor"); ?>',
			dataType: 'json',
			type:'POST',
			data:'bcid='+bcid,
			success:function(data){			
			if(data.status==200)
			{
				 $(".selected-price strong").html(data.totprice);
				  $(".selected-items-scroll").html(data.selecteditem);
				  				  
			}
			else{
				swal("Error", "", "error");
			}
				
			}
		});
	
   }
   
   
   
   
    function fnpackageclick(ele,bcid,baseimg,price){
  
     $(".select-color").removeClass("active");
     $(".select-color").show();
     $(ele).addClass("active");

	
	 
	 $(".selected-price").show();
	$("#heading2").addClass("greenCheck");
	$(".next-btn button").removeAttr("disabled");
	
	$.ajax({
			url:'<?php echo base_url("home/savepackage"); ?>',
			dataType: 'json',
			type:'POST',
			data:'bcid='+bcid,
			success:function(data){
			//$("#shippingaddressupdatediv").html(data.addressformhtml);	
			if(data.status==200)
			{
				 $(".selected-price strong").html(data.totprice);
			}
			else{
				swal("Error", "", "error");
			}
				
			}
		});
	
   }
   

   $("#body-design-next").on("click", function() {
	 
       $("#accordion2").collapse('show');
	   //$("#heading1").addClass('greenCheck');
   });
   
   $("#body-color-next").on("click", function() {
       $("#accordion3").collapse('show');
	  
   });

   $("#body-color-prev").on("click", function() {
       $("#accordion1").collapse('show');
   });
   
   $("#jar-next").on("click", function() {
       $("#accordion4").collapse('show');
	   
   });

   $("#jar-prev").on("click", function() {
       $("#accordion2").collapse('show');
   });


   $("#imprinted-next").on("click", function() {
	   var txt=$("#type-message").val();
	   if(txt!="")
	   {
		  	$("#heading5").addClass("greenCheck"); 
	   }
	   else{
		   $("#heading5").removeClass("greenCheck"); 
	   }
	   
	    $.ajax({
								url:'<?php echo base_url("home/chkcondition"); ?>',
								dataType: 'json',
								type:'POST',
								data:'headid=5',
								success:function(data){
								//$("#shippingaddressupdatediv").html(data.addressformhtml);	
								console.log(data);
								if(data.status==0)
								{
									$('[data-target=accordion'+data.ind+']').prop('disabled',false);
																		  
								}
								else{
									$("#package-next").prop('disabled',false);
									
								}
								
									
								}
							});
	   
       $("#accordion6").collapse('show');
   });

   $("#imprinted-prev").on("click", function() {
       $("#accordion4").collapse('show');
   });

   $("#package-prev").on("click", function() {
       $("#accordion5").collapse('show');
   });  

    $("#package-next").on("click", function() {
		
		$.ajax({
								url:'<?php echo base_url("home/chkcondition"); ?>',
								dataType: 'json',
								type:'POST',
								data:'headid=6',
								success:function(data){
								
								if(data.status==0)
								{
									 $("#accordion"+data.ind).collapse('show');
								}
								else{
									location.href='<?php echo base_url(""); ?>customize-cart';
								}
								}
							});
		
      
   }); 	

   $(".remove-jar").on("click", function() {
        $(this).closest('.selected-jars').hide();
   });   

   $(".remove-motor").on("click", function() {
        $(this).closest('.selected-motor').hide();
   });

   $('input:radio[name="motorSelect"]').change(
    function(){
        if ($(this).is(':checked') && $(this).val() == 'Yes') {
            $(".selected-motor").show();
        }
    });

    $('#motorSelect1').click(function() {
    if($('#motorSelect1').is(':checked')) {
        $(".selected-motor").show();
     }
    });

   
   $(".product-selected-items").mCustomScrollbar({
   	theme:"dark-thin",
   	setHeight:200,
   	scrollButtons:{enable:true},
   });
	 
	 
   
    $(".card-header").click(function() {
	  // e.preventDefault();
      var strheader=$(this).attr("id");
	  var strid=strheader.replace("heading","");
	   //$('[data-target=accordion'+strid+']').prop('disabled',true);
	     $.ajax({
								url:'<?php echo base_url("home/chkcondition"); ?>',
								dataType: 'json',
								type:'POST',
								data:'headid='+strid,
								success:function(data){
								//$("#shippingaddressupdatediv").html(data.addressformhtml);	
								console.log(data);
								if(data.status==0)
								{
									$('[data-target=accordion'+data.ind+']').prop('disabled',false);
																		  
								}
								
									
								}
							});
	  
	  
    }); 
   
   function fnjarfilter()
   {
	    
	   $.ajax({
			url:'<?php echo base_url("home/jarfillterlist"); ?>',
			dataType: 'json',
			type:'POST',
			data: $("#frmjarfilter").serializeArray(),
			success:function(data){
			//$("#shippingaddressupdatediv").html(data.addressformhtml);	
			if(data.status==200)
			{
				
				$("#divotherjar").html(data.other_jar_html);
				 $(".model-jars").mCustomScrollbar({
					theme:"dark-thin",
					setHeight:250,
					scrollButtons:{enable:true},
				   });
   
					 
				
				$('.btn-number').click(function(e){
							e.preventDefault();
						   
						   fieldName = $(this).attr('data-field');
						   type      = $(this).attr('data-type');
						   var input = $("input[name='"+fieldName+"']");
						   var currentVal = parseInt(input.val());
						   if (!isNaN(currentVal)) {
							   if(type == 'minus') {
								   
								   if(currentVal > input.attr('min')) {
									   input.val(currentVal - 1).change();
								   } 
								   if(parseInt(input.val()) == input.attr('min')) {
									   $(this).attr('disabled', true);
								   }
					   
							   } else if(type == 'plus') {
					   
								   if(currentVal < input.attr('max')) {
									   input.val(currentVal + 1).change();
								   }
								   if(parseInt(input.val()) == input.attr('max')) {
									   $(this).attr('disabled', true);
								   }
					   
							   }
						   } else {
							   input.val(0);
						   }
					   });		
				
				 $('.input-number').focusin(function(){
					  $(this).data('oldValue', $(this).val());
				   });
				   $('.input-number').change(function() {
					   
					   minValue =  parseInt($(this).attr('min'));
					   maxValue =  parseInt($(this).attr('max'));
					   valueCurrent = parseInt($(this).val());
					   var inid=$(this).attr('id');
					   var jid=(inid.split("_"))[1];
					
					   name = $(this).attr('name');
					   if(valueCurrent >= minValue) {
						  
						   $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled');
						   if(valueCurrent=='0'){
							 
								$(".selectedjar-"+jid).removeClass("active");
								swal("Removed", "Selected jar removed from your cart", "info");
						   }
							else{
								
								$(".selectedjar-"+jid).addClass("active");
							}
					   } else {
						    $(".selectedjar-"+jid).removeClass("active");
							swal("Check your quantity", "Sorry, the minimum value was reached", "info");
						   $(this).val($(this).data('oldValue'));
					   }
					   if(valueCurrent <= maxValue) {
						   $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled');
						   	   if(valueCurrent=='0'){
								   $(".selectedjar-"+jid).removeClass("active");
							   }
							   else{
						    $(".selectedjar-"+jid).addClass("active");
							   }
					   } else {
						   swal("Check your quantity", "Sorry, the maximum value was reached", "info");
						   $(this).val($(this).data('oldValue'));
					   }
					   
					   /* save jar */
					   
					   $.ajax({
								url:'<?php echo base_url("home/savejar"); ?>',
								dataType: 'json',
								type:'POST',
								data:'jid='+jid+"&qty="+valueCurrent,
								success:function(data){
								//$("#shippingaddressupdatediv").html(data.addressformhtml);	
								if(data.status==200)
								{
									 $(".selected-price strong").html(data.totprice);
									  $(".selected-items-scroll").html(data.selecteditem);
									  				  
									  if(data.jarcount>0)
									 {
									 $("#heading3").addClass("greenCheck");
									 $("#jar-next").removeAttr("disabled");
									 }
									 else{
										  $("#heading3").removeClass("greenCheck");
										   $("#jar-next").addAttr("disabled");
									 }
								}
								else{
									swal("Error", "", "error");
								}
									
								}
							});
					   
					   
				   });
				   
				   $(".input-number").keydown(function (e) {
					   // Allow: backspace, delete, tab, escape, enter and .
					   if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
							// Allow: Ctrl+A
						   (e.keyCode == 65 && e.ctrlKey === true) || 
							// Allow: home, end, left, right
						   (e.keyCode >= 35 && e.keyCode <= 39)) {
								// let it happen, don't do anything
								return;
					   }
					   // Ensure that it is a number and stop the keypress
					   if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
						   e.preventDefault();
					   }
				   });
				
				 $(".selected-price strong").html(data.totprice);
				 $(".selected-items-scroll").html(data.selecteditem);
				 
			}
			else{
				swal("Error", "", "error");
			}
				
			}
		});
	   
	   
   }
   
  function funsaveimportedtext(val)
  {
	  $.ajax({
			url:'<?php echo base_url("home/saveimportedtext"); ?>',
			dataType: 'json',
			type:'POST',
			data:'txt='+val,
			success:function(data){		
			if(data.status==200)
			{
				 $(".selected-price strong").html(data.totprice);
				  $(".selected-items-scroll").html(data.selecteditem);
			}
			else{
				swal("Error", "", "error");
			}
				
			}
		});
	  
  }
  
  
  function fnjardelete(val,jid)
  {
	  $.ajax({
			url:'<?php echo base_url("home/deletecartjar"); ?>',
			dataType: 'json',
			type:'POST',
			data:'cjid='+val,
			success:function(data){		
			if(data.status==200)
			{
				 $(".selected-price strong").html(data.totprice);
				 $(".selected-items-scroll").html(data.selecteditem);
				  
				   $("#qtyinp_"+jid).val('0');
				   $(".selectedjar-"+jid).removeClass("active");
				   if(data.jarcount>0)
						 {
							
						 $("#heading3").addClass("greenCheck");
						 $("#jar-next").removeAttr("disabled");
						 }
						 else{
							 $("#jar-next").prop('disabled', true);
							
							  $("#heading3").removeClass("greenCheck");
							   
						 }
				}
			else{
				swal("Error", "", "error");
			}
				
			}
		});
	  
  }
  
       
       
       
   
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
   $(window).on('load', function(){
     $('.body-type').slick({
       slidesToShow: 2,
       dots:false,
       centerMode: false,
       autoplay: false,
       infinite: false,
       slidesToScroll: 1,
       variableWidth: true,
     });
   
     $('.body-color').slick({
       slidesToShow: 2,
       dots:false,
       centerMode: false,
       autoplay: false,
       infinite: false,
       slidesToScroll: 1,
       variableWidth: true,
     });
     
     
     $('.motor-select-scroll').slick({
       slidesToShow: 2,
       dots:false,
       centerMode: false,
       autoplay: false,
       infinite: false,
       slidesToScroll: 1,
       variableWidth: true,
     });
     
     $('.jar-scroll').slick({
       slidesToShow: 2,
       dots:false,
       centerMode: false,
       autoplay: false,
       infinite: false,
       slidesToScroll: 1,
       variableWidth: true,
     });


	
				$('.btn-number').click(function(e){
							e.preventDefault();
						   
						   fieldName = $(this).attr('data-field');
						   type      = $(this).attr('data-type');
						   var input = $("input[name='"+fieldName+"']");
						   var currentVal = parseInt(input.val());
						   if (!isNaN(currentVal)) {
							   if(type == 'minus') {
								   
								   if(currentVal > input.attr('min')) {
									   input.val(currentVal - 1).change();
								   } 
								   if(parseInt(input.val()) == input.attr('min')) {
									   $(this).attr('disabled', true);
								   }
					   
							   } else if(type == 'plus') {
					   
								   if(currentVal < input.attr('max')) {
									   input.val(currentVal + 1).change();
								   }
								   if(parseInt(input.val()) == input.attr('max')) {
									   $(this).attr('disabled', true);
								   }
					   
							   }
						   } else {
							   input.val(0);
						   }
					   });		
				
				 $('.input-number').focusin(function(){
					  $(this).data('oldValue', $(this).val());
				   });
				   $('.input-number').change(function() {
					   
					   minValue =  parseInt($(this).attr('min'));
					   maxValue =  parseInt($(this).attr('max'));
					   valueCurrent = parseInt($(this).val());
					   var inid=$(this).attr('id');
					   var jid=(inid.split("_"))[1];
					
					   name = $(this).attr('name');
					   if(valueCurrent >= minValue) {
						  
						   $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled');
						   if(valueCurrent=='0'){
							 
								$(".selectedjar-"+jid).removeClass("active");
								swal("Removed", "Selected jar removed from your cart", "info");
						   }
							else{
								
								$(".selectedjar-"+jid).addClass("active");
							}
					   } else {
						    $(".selectedjar-"+jid).removeClass("active");
							swal("Check your quantity", "Sorry, the minimum value was reached", "info");
						   $(this).val($(this).data('oldValue'));
					   }
					   if(valueCurrent <= maxValue) {
						   $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled');
						   	   if(valueCurrent=='0'){
								   $(".selectedjar-"+jid).removeClass("active");
							   }
							   else{
						    $(".selectedjar-"+jid).addClass("active");
							   }
					   } else {
						   swal("Check your quantity", "Sorry, the maximum value was reached", "info");
						   $(this).val($(this).data('oldValue'));
					   }
					   
					   /* save jar */
					   
					   $.ajax({
								url:'<?php echo base_url("home/savejar"); ?>',
								dataType: 'json',
								type:'POST',
								data:'jid='+jid+"&qty="+valueCurrent,
								success:function(data){
								//$("#shippingaddressupdatediv").html(data.addressformhtml);	
								if(data.status==200)
								{
									 $(".selected-price strong").html(data.totprice);
									  $(".selected-items-scroll").html(data.selecteditem);
													  
									 if(data.jarcount>0)
									 {
										
									 $("#heading3").addClass("greenCheck");
									 $("#jar-next").removeAttr("disabled");
									 }
									 else{
										 $("#jar-next").prop('disabled', true);
										
										  $("#heading3").removeClass("greenCheck");
										   
									 }
									
								}
								else{
									swal("Error", "", "error");
								}
									
								}
							});
					   
					   
				   });
				   
				   $(".input-number").keydown(function (e) {
					   // Allow: backspace, delete, tab, escape, enter and .
					   if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
							// Allow: Ctrl+A
						   (e.keyCode == 65 && e.ctrlKey === true) || 
							// Allow: home, end, left, right
						   (e.keyCode >= 35 && e.keyCode <= 39)) {
								// let it happen, don't do anything
								return;
					   }
					   // Ensure that it is a number and stop the keypress
					   if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
						   e.preventDefault();
					   }
				   });
				   
				   $("#motor-next").on("click", function() {
				   $("#accordion5").collapse('show');
			   });

			   $("#motor-prev").on("click", function() {
				   $("#accordion3").collapse('show');
			   });

     
   });
</script>

<script>  
   $(window).load(function() {  
      $("#loader").fadeOut(1000);  
   });
   
   $('input[type="text"]').on('keydown, keyup', function () {
	  var texInputValue = $('#type-message').val();
	  $('.show-message').html(texInputValue);
   });
</script> 