                  
<?= $this->load->view('tracking/_tracking_user_section', null, true) ?>
<?php 
if( isset( $trackingDetails ) && !empty( $trackingDetails ) ) {
?>
<?= $this->load->view('tracking/_tracking_section', null, true) ?>
<?php } ?>