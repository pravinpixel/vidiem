		 <!-- Mobile viewport optimized: j.mp/bplateviewport -->
     <meta name="viewport" content="width=device-width,initial-scale=1">
	 <meta name="description" content="">
	 
	
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT_URL; ?>css/superstorefinder-mobile.css" media="all" />
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT_URL; ?>css/bootstrap.css" media="all" />
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT_URL; ?>css/bootstrap-responsive.css" media="all"  />

	
	<script src="<?php echo ROOT_URL; ?>includes/geoip.php" type="text/javascript"><!--mce:1--></script>
	<?php if(MEGA_GOOGLE_API!=''){
	$google_api_key='key='.MEGA_GOOGLE_API.'&';	
	}else{
	$google_api_key='';	
	} ?>
	<script src="https://maps.googleapis.com/maps/api/js?<?php echo $google_api_key; ?>libraries=geometry,places"></script>
	<script type="text/javascript" src="<?php echo ROOT_URL; ?>js/jquery-1.9.0.min.js"></script>
	<script type="text/javascript" src="<?php echo ROOT_URL; ?>js/bootstrap.js"></script>

	<script type="text/javascript" src="<?php echo ROOT_URL; ?>js/super-store-finder-mobile.js" charset="utf-8"></script>
	<script type="text/javascript" src="<?php echo ROOT_URL; ?>js/jquery.sort.js" charset="utf-8"></script>
	<script type="text/javascript" src="<?php echo ROOT_URL; ?>js/jquery.geocomplete.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT_URL; ?>css/typography.css" media="all" />
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<link rel="stylesheet" href="style.css">
	 <link rel="stylesheet" href="css/responsive.css">
	 <link href='http://fonts.googleapis.com/css?family=PT+Sans:700|Open+Sans:600' rel='stylesheet' type='text/css'><!-- Custom Google Fonts -->

	 <script src="js/libs/modernizr-2.0.6.min.js"></script>
	
	<!-- ########## CSS Files ########## -->

	<link rel="stylesheet" href="landing_mobile/css/reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="landing_mobile/css/text.css" type="text/css" media="screen" />

	<!-- Cufon Font Replacement -->

	
	<!-- To customise any of the above, please use this file -->
	