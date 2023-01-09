<?php include('container/header.php'); ?>

<section class="ban-next inner-page-bg pb-5">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-8">
				<h1 class="text-red" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Frequently Asked Questions</h1>
				<h2 class="pb-5 mb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Download User Manual</h2>
			</div>
			<div class="col-sm-12 col-md-4">
				<img src="<?= base_url(); ?>assets/front-end/images/user-manual.svg" alt="" class="img-fluid d-none d-md-block"  data-aos="fade-left" data-aos-delay="50" data-aos-duration="1000"/>
				<div class="text-right overlay-title pb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Download</div>
			</div>
		</div>
	</div>
<div class="bgPro contactUs useMan clearfix">
	<div class="container">
	<div class="row">
		<div class="col" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
			<!--<ul class="nav nav-tabs" id="user-manual-tab" role="tablist">
			
				<?php if (!empty($feature_category)) {
				 $i=0;	
				 $j=1;
				  foreach ($feature_category as $info) { ?>
				  <li class="nav-item">
					
					<a class="nav-link <?php if($i=='0'){ echo "active" ;}?>" href="#tab<?= $j; ?>" role="tab" data-toggle="tab"><?= $info['name']; ?></a>
					</li>
				<?php $i++; $j++; }
				} 
				?>	

			  </ul>
			  <div class="tab-content mb-5">
				 <?php if(!empty($feature_category)){ 
					   $i = 0;
					   $j=1;
					foreach($feature_category as $info){ ?> 
                <div role="tabpanel" class="tab-pane <?php echo $i == 0 ? ' in active ' : '' ?> animated fadeInUp" id="tab<?= $j; ?>">
					<div class="row">
						<div class="col">
							<div class="userManual light-gray-bg p-5">
								<div class="clearfix userManSet row">
									<?php 
									$usermanual = $this->FunctionModel->Select_Fields('id,cat_id,title,content,image,file', 'vidiem_user_manual', array('cat_id'=>$info['id'],'status' => 1), 'order_no', 'ASC'); 
									
									if(!empty($usermanual)){
											foreach ($usermanual as $info) { ?>
									<div class="col-sm-12 col-md-6 clearfix animatable zoomIn">
										<div class="row mt-3 mb-4 pb-3">
										<div class="userManImg col-sm-12 col-md-6 col-lg-4">
											<img src="<?= base_url('uploads/usermanual/'.$info['image']); ?>" class="img-fluid" alt="" />
										</div>
										<div class="userManCon col-sm-12 col-md-6 col-lg-8">
											<h4 class="text-dark"><?= $info['title']; ?></h4>
											<p class="mb-4"><?= $info['content']; ?></p>
											
											<a class="text-red" href="<?= (!empty($info['file'])?base_url('uploads/usermanualpdf/'.$info['file']):'javascript:void(0);')?>" target="_blank">
											Download</a>
										</div>
										</div>
										<div class="divider"></div>
									</div>
									 <?php } } else { ?>
									 
									 <div class="col-sm-12 col-md-6 clearfix animatable zoomIn">
										<div class="row mt-3 mb-4 pb-3">
										
										<div class="userManCon col-sm-12 col-md-6 col-lg-8">
											<h4 class="text-dark">No User Manual Found.</h4>
											
										</div>
										</div>
										
									</div>
									 
									 <?php } ?>
								</div>
							</div>
							</div>
						</div>
				</div>
				<?php $i++; $j++; } 
					    } ?>

			  </div>-->
			  
			  <ul id="responsive-tabs1" class="nav nav-tabs" role="tablist">
					<?php if (!empty($feature_category)) {
					 $i=0;	
					 $j=1;
					  foreach ($feature_category as $info) { ?>
						<li class="nav-item">
						<a id="tab-<?= $j; ?>" href="#pane-<?= $j; ?>" class="nav-link <?php if($i=='0'){ echo "active" ;}?>" data-toggle="tab" role="tab"><?= $info['name']; ?></a>
						</li>
					<?php $i++; $j++; }
					} 
					?>		

				</ul>


				<div id="responsive-accordion" class="tab-content" role="tablist">
				
					<?php if(!empty($feature_category)){ 
					   $i = 0;
					   $j=1;

					foreach($feature_category as $info){ 
					
					    if($j==1){
							$activecls ='active-acc';
							$ariaexpanded ='true';
							$collapse ='show';
						}else{
							$activecls ='';
							$ariaexpanded ='false';
							$collapse ='';
						}
					?> 
				
					<div id="pane-<?= $j; ?>" class="card tab-pane fade <?php echo $i == 0 ? ' show active ' : '' ?>" role="tabpanel" aria-labelledby="tab-<?= $j; ?>">
						<div class="card-header <?= $activecls; ?>" role="tab" id="heading-<?= $j; ?>">
							<h5 class="mb-0">
								<a data-toggle="collapse" href="#collapse-<?= $j; ?>" aria-expanded="<?= $ariaexpanded; ?>" aria-controls="collapse-<?= $j; ?>"> <?= $info['name']; ?>
								</a>
							</h5>
						</div>
						<div id="collapse-<?= $j; ?>" class="collapse <?= $collapse; ?> animated fadeInUp" data-parent="#responsive-accordion" role="tabpanel" aria-labelledby="heading-<?= $j; ?>">
							<div class="card-body">
								<div class="row">
									<div class="col">
										<div class="userManual light-gray-bg p-5">
											<div class="clearfix userManSet row">
												<?php 
												$usermanual = $this->FunctionModel->Select_Fields('id,cat_id,title,content,image,file', 'vidiem_user_manual', array('cat_id'=>$info['id'],'status' => 1), 'order_no', 'ASC'); 
									
												if(!empty($usermanual)){
												foreach ($usermanual as $info) { ?>
												<div class="col-sm-12 col-md-6 clearfix animatable zoomIn">
													<div class="row mt-3 mb-4 pb-3">
													<div class="userManImg col-sm-12 col-md-6 col-lg-4">
														<img src="<?= base_url('uploads/usermanual/'.$info['image']); ?>" class="img-fluid" alt="" />
													</div>
													<div class="userManCon col-sm-12 col-md-6 col-lg-8">
														<h4 class="text-dark"><?= $info['title']; ?></h4>
														<p class="mb-4"><?= $info['content']; ?></p>
														<a class="text-red" href="<?= (!empty($info['file'])?base_url('uploads/usermanualpdf/'.$info['file']):'javascript:void(0);')?>" target="_blank">Download</a>
													</div>
													</div>
													<div class="divider"></div>
												</div>
												<?php } } else { ?>
												<div class="col-sm-12 col-md-6 clearfix animatable zoomIn">
													<div class="row mt-3 mb-4 pb-3">
													
													<div class="userManCon col-sm-12 col-md-6 col-lg-8">
														<h4 class="text-dark">No User Manual Found.</h4>
														
													</div>
													</div>
										
												</div>
									 
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php $i++; $j++; } 
					    } ?>

				</div>
				</div>
			</div>
		</div>
	</div>

	</div>
</div>
</section>
<?php require_once('container/footer.php'); ?>