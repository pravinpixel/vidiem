<?php
// include config file
error_reporting(0);
include_once './includes/config.inc.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php echo $lang['STORE_FINDER']; ?> - Google Maps Store Locator with Google Street View, Google Direction, Admin Area, Category Icons, Store Thumbnail, Custom Markers, Google Maps API v3</title>
	 <meta name="keywords" content="street view, google direction, ajax, bootstrap, embed, geo ip, geolocation, gmap, google maps, jquery, json, map, responsive, store admin, store finder, store locator" />
     <meta name="description" content="Super Store Finder &amp;#8211; Easy to use Google Maps API Store Finder Super Store Finder is a multi-language fully featured PHP Application integrated with Google Maps API v3 that allows customers to..." />
	 <link rel="shortcut icon" href="img/favicon.ico" />
	 <script>

	function changeLang(v){
	document.location.href="?langset="+v;
	}
	</script>
	  <?php include ROOT."settings.php"; ?>
	  <?php include ROOT."themes/meta_mobile.php"; ?>

	<style>
	#clinic-finder .distance-units {
	top:524px;
	}
	
	#clinic-finder #results ol {
	height:465px;
	}
	.mapfilter{
	    float:left;
	    width: 25%;
	    background:#222;
	}
	.map{
	    float:right;
	    width: 72%;
	}
	.red-btn{
	margin-top: 15px !important;
	color:#FFF !important;
	border: none;
	background:#F7000A;
	padding:12px 15px;
	font-size: 16px;
	width: 100%;
	text-align: center;
	transition: 0.3s ease;
	box-shadow: 5px 5px 10px rgba(0,0,0,0.2);
}

.red-btn:hover{
    color:#FFF !important;
	background:#222;
	transition: 0.6s ease;
}


.black-btn{
	margin-top: 15px !important;
	color:#FFF !important;
	border: none;
	background:#222;
	padding:12px 15px;
	font-size: 16px;
	width: 100%;
	text-align: center;
	transition: 0.3s ease;
	box-shadow: 5px 5px 10px rgba(0,0,0,0.2);
}

.black-btn:hover{
    color:#FFF !important;
	background:#F7000A;
	transition: 0.6s ease;
}
@media(max-width:760px){
    
    .mapfilter{
	    width: 100%;
	}
	.map{
	    width: 100%;
	}
	#clinic-finder #results ol {
	height:500px;
	}
	#clinic-finder .distance-units{
	    top: 22px;
	}
}
	</style>


</head>
<body id="super-store-finder"  style="background: none !important;">
		
	<!-- Start Container 12 -->
	<div id="main_content" class="container_12">
	
		<div class="width-container" style="width:100% !important;">

			<div id="container-sidebar">
			
				<div class="content-boxed">
				
					<div id="map-container">

						<div id="clinic-finder" class="clear-block">
						<div class="links"></div>
			
						<form method="post" action="./index.php" accept-charset="UTF-8" method="post" id="clinic-finder-form" class="clear-block">
						<div class="mapfilter">
						 <div id="results">        
						<h2 class="title-bg" style="padding-bottom:10px !important; "><input type="radio" id="distance" name="distance" value="50" onChange="cachesearch = ''; $('#clinic-finder-form').submit();"> 50 <div class="radius-distance" style="display:inline;"><?php echo DEFAULT_DISTANCE; ?></div> <input type="radio" id="distance" name="distance" value="100" checked  onChange="cachesearch = ''; $('#clinic-finder-form').submit();"> 100 <div class="radius-distance"  style="display:inline;"><?php echo DEFAULT_DISTANCE; ?></div></h2>
						<p class="distance-units">
						  <label class="km <?php if(DEFAULT_DISTANCE=="mi") {?>unchecked<?php } ?>" units="km" <?php if(DEFAULT_DISTANCE=="mi") {?> checked="unchecked"<?php } ?> >
							<input type="radio" name="distance-units" value="kms" /><?php echo $lang['KM']; ?>
						  </label>
						  <label class="miles <?php if(DEFAULT_DISTANCE=="km") {?>unchecked<?php } ?>" <?php if(DEFAULT_DISTANCE=="km") {?> checked="unchecked"<?php } ?>units="miles">
							<input type="radio" name="distance-units" value="miles" /><?php echo $lang['MILES']; ?>
						  </label>
						</p>
						<ol style="display: block; " id="list"></ol>
					  </div>
						</div>
						
						<div class="map">
													<table style="width:100%">
							<tr><td width="95%" style="padding-right:20px;">
							<div class="form-item" id="edit-gmap-address-wrapper">
							 <label for="edit-gmap-address"><?php echo $lang['PLEASE_ENTER_YOUR_LOCATION']; ?>: </label>
							 <input type="text" maxlength="128" name="address" id="address" size="60" value="" class="form-text" autocomplete="off" />
							</div>
							</td>
							</tr>
							<tr>
							
							<td  width="95%">
							<?php 
							if($_GET['locator']=='service'){
							   $cat=1; 
							}else{
							   $cat=2;   
							}
							// support unicode
							mysqli_query($GLOBALS["___mysqli_ston"], "SET NAMES utf8");
							$cats = $db->get_rows("SELECT categories.* FROM categories WHERE categories.id=".$cat." ORDER BY categories.cat_name ASC");
							$defaultCategory='';
							if(isset($_REQUEST['category']) && $_REQUEST['category']!=''){
								$defaultCategory = strtolower($_REQUEST['category']);
							}
							?>
							<div class="form-item" id="edit-products-wrapper">
							 
							 <select name="products" class="form-select" id="edit-products" >
							 <!--<option value=""><?php echo $lang['SSF_ALL_CATEGORY']; ?></option>-->
							 <?php if(!empty($cats)): ?>
								<?php foreach($cats as $k=>$v): ?>
								<?php $selected = ($defaultCategory==trim(strtolower($v['cat_name']))) ? 'selected' : ''; ?>
								<option value="<?php echo $v['id']; ?>" <?=$selected?>>
									<?php echo $v['cat_name']; ?>
								</option>
								<?php endforeach; ?>
								<?php endif; ?>
							 </select>
							</div>
							
							</tr>
							<tr><td align="center" nowrap><input type="submit" name="op" id="edit-submit" value="<?php echo $lang['FIND_STORE']; ?>" class="red-btn"/>
							<input type="hidden" name="form_build_id" id="form-0168068fce35cf80f346d6c1dbd7344e" value="form-0168068fce35cf80f346d6c1dbd7344e"  />
							<input type="hidden" name="form_id" id="edit-clinic-finder-form" value="clinic_finder_form"  />
							
							<input type="button" name="op" onclick="document.location.href='embed_newstore.php'" id="edit-submit" value="<?php echo $lang['REQUEST_ADD_STORE']; ?>" class="black-btn"/>
							
							</td></tr>
							</table>

					  <div id="map_canvas"><?php echo $lang['JAVASCRIPT_ENABLED']; ?></div>
						</div>
 
					  </form>
					  
					  <div id="direction">
					  <h2 class="title-bg" style="padding-bottom:10px !important; ">Directions</h2>
					  <form method="post" id="direction-form">
					  
					  <p>
					  <table><tr>
					  <td><?php echo $lang['STORE_ORIGIN']; ?>:</td><td><input id="origin-direction" name="origin-direction" class="orides-txt" type=text /></td>
					  </tr>
					  <tr>
					  <td><?php echo $lang['STORE_DESTINATION']; ?>:</td><td><input id="dest-direction" name="dest-direction" class="orides-txt" type=text readonly /></td>
					  </tr>
					  </table>
					  <div id="get-dir-button" class="get-dir-button"><input type=submit id="get-direction" class="btn" value="<?php echo $lang['STORE_GET_DIRECTION']; ?>"><input type="button" style="display:none; margin-left:5px;" class="btn btnPrint" value="<?php echo $lang['STORE_PRINT']; ?>"/> <a href="javascript:directionBack()"><?php echo $lang['STORE_BACK_BTN']; ?></a></div></p>
					  </form>
					  </div>
					  
	</div>
	<script>
		if(geo_settings==1){
				$('#address').val(geoip_city()+", "+geoip_country_name());
		} else {
				$('#address').val(default_location);
		}
	</script>
    </div>

    </div>

	</div><!-- close #container-sidebar -->

	</div><!-- close .width-container -->

		</div>
	
	</div><!-- Container 12 END-->
	
<?php                
if(GDPR=='true'){
	$ssf_gdpr_txt = "";

	if(!empty(GDPR_PRIVACY)){
		$ssf_gdpr_txt .=" <a target='new' href='".GDPR_PRIVACY."'>".$lang['GDPR_PRIVACY']."</a>";
	}
	
$ssf_accept_privacy="<div class='ssf_option_input' style='border-bottom:none;'>
	<label for='shortname_logo'>".$lang['GDPR_AGREEMENT'].": </label>
	<div class='ssfgdpr'>
	<div class='ssf_gdpr_check'><input type='checkbox' id='ssf_gdpr_check'></div><div class='ssf_gdpr_text'>".$lang['GDPR_CONSENT']." $ssf_gdpr_txt</div>
	</div>
</div>";
}else{
	$ssf_accept_privacy="";
}
?>

     <!-- Contact us form data-model code --> 
  <div class="modal fade" id="myModal"  style="display:none;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" style="margin-top:10px;" aria-hidden="true">×</button>
                          <h4 class="modal-title" id="myModalLabel" align='center' style="margin-top:10px;"><?php echo $lang['CONTACT_THIS_STORE']; ?></h4>
                      </div> <!-- /.modal-header -->
                      <div class="modal-body">
                        <div class="col-lg-12" align='center'>
						<form id='ssf-contact-form' action='#' method='post' name='form' role='form'>
						<div><h4 id='ssf-msg-status'></h4></div>
						<div>
						<label>
						<span><?php echo $lang['ADMIN_NAME']; ?>: (<div class='ssf-red-star'>*</div>)</span>
						<input placeholder='Please enter your name' name='ssf_cont_name' type='text' tabindex='1' required autofocus>
						</label>
						</div>
						<div>
						<label>
						<span><?php echo $lang['EMAIL']; ?>: (<div class='ssf-red-star'>*</div>)</span>
						<input placeholder='Please enter your email address' name='ssf_cont_email' type='email' tabindex='2' required>
						</label>
						</div>
						<div>
						<label>
						<span><?php echo $lang['TELEPHONE']; ?></span>
						<input placeholder='Please enter your number' name='ssf_cont_phone' type='tel' tabindex='3'>
						</label>
						</div>
						<div>
						<label>
						<span><?php echo $lang['POPUP_MESSAGE']; ?>: (<div class='ssf-red-star'>*</div>)</span>
						<textarea placeholder='Include all the details you can' name='ssf_cont_msg' tabindex='4' required></textarea>
						</label>
						</div>
						<?php echo $ssf_accept_privacy; ?>
						<div>
						<button name='submit' type='button' onclick='ssfEmailSubmit();'><?php echo $lang['POPUP_SEND_BTN']; ?></button>
						</div>
                        </form>
                    </div>
                    </div> 
                  <div class="modal-footer">
                  <div id="loginMsg" style="color:#900; font-size:12px; font-weight:600; text-align:center;"></div>
                  <div id="signupMsg" style="color:#090; font-size:12px; font-weight:600; text-align:center;"></div>
                  </div> 
                  </div>
                  </div>
          </div>
<!-- Contact us form data-model code end here -->   

</body>
</html>