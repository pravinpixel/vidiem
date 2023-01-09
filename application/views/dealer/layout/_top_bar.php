<div class="dealer-header">
    <div class="container">
		<div class="row align-items-center">
			<div class="col-6 col-sm-6 col-md-6">
				<a href="<?= base_url(); ?>" class="mx-2">
					<img src="<?= base_url(); ?>assets/front-end/images/logo.png" alt="" /></a>
				<a href="<?= base_url(); ?>vidiem-dealer" class="dealer-logo">
					<?php 
					if( isset( $this->session->userdata('dealer_session')['dealer']['image'] ) && !empty( $this->session->userdata('dealer_session')['dealer']['image'] ) ) {

					
					?>
					<img src="<?= base_url(); ?>uploads/dealer/<?= $this->session->userdata('dealer_session')['dealer']['image'] ?>" alt="Dealer logo" class="img-fluid" style="max-width: 200px;" width="100" />
					<?php } else {  ?>
					
					<img src="<?= base_url(); ?>assets/front-end/images/dealer.png" alt="Dealer logo" class="img-fluid" style="max-width: 200px;"  />
					<?php  } ?>
					<?= $this->session->userdata('dealer_session')['location']['location_name'] ?> &nbsp;
					<?= $this->session->userdata('dealer_session')['location']['location_address'] ?? '' ?>
				</a>
			</div>
			<div class="col-6 col-sm-6 col-md-6 text-right">
				<img src="<?= base_url(); ?>assets/front-end/images/vidiem-by-you/vidiem-by-you-logo.png" alt="logo" class="img-fluid mr-2" style="max-width: 130px;" />
				 <?php 
					if( $this->session->has_userdata('dealer_session') ) { 
					   ?>
					   <a href="<?= base_url()?>dealer/logout" class="red-btn w-auto d-inline" title="Logout" data-toggle="tooltip" data-placement="bottom"><i class="lni lni-exit"></i></a>
				<?php }
				?>
			</div>
		</div>
	</div>
</div>