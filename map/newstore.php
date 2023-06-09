<?php
// include config file
include_once './includes/config.inc.php';
include './includes/validate.php';

validate_request_add_store();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php echo $lang['STORE_FINDER']; ?> - Google Maps Store Locator with Google Street View, Google Direction, Admin Area, Category Icons, Store Thumbnail, Custom Markers, Google Maps API v3</title>
	 <meta name="keywords" content="street view, google direction, ajax, bootstrap, embed, geo ip, geolocation, gmap, google maps, jquery, json, map, responsive, store admin, store finder, store locator" />
     <meta name="description" content="Super Store Finder &amp;#8211; Easy to use Google Maps API Store Finder Super Store Finder is a multi-language fully featured PHP Application integrated with Google Maps API v3 that allows customers to..." />
	 <link rel="shortcut icon" href="img/favicon.ico" />
	 <?php include ROOT."settings.php"; ?>
	  <?php include ROOT."themes/meta_others.php"; ?>
	  

	

	
	<script>
	function changeLang(v){
	document.location.href="?langset="+v;
	}
	</script>

</head>
<body id="add_edit_body">

         <h1 class="grid_4 logo"><a href="http://superstorefinder.net/products/superstorefinder/skins/compact/" class='ie6fix'>Super Store Finder</a></h1>



		
		
		<div class="clear"></div><!-- CLEAR -->
		
		<!-- Start Header Break Line -->
		<div class="container_12">
			<hr class="grid_12"></hr>
		</div>
		<!-- Header Break Line END -->
		
		<div class="clear"></div><!-- CLEAR -->
	
		<!-- Start Teaser -->
		<div class="container_12 ">
			
			<!-- Start Centered Text -->
			<div class="grid_12 middle">
				
				<!-- Heading -->	
				<center>
					<div style="padding:10px;">Language: 
				<select onChange="changeLang(this.value)">
				<option value="en_US" <?php if(!isset($_SESSION['language']) || $_SESSION['language']=="en_US") { ?>selected<?php } ?>>English</option>
				<option value="sv_SE" <?php if(isset($_SESSION['language']) && $_SESSION['language']=="sv_SE") { ?>selected<?php } ?>>Swedish</option>
				<option value="es_ES" <?php if(isset($_SESSION['language']) && $_SESSION['language']=="es_ES") { ?>selected<?php } ?>>Spanish</option>
				<option value="fr_FR" <?php if(isset($_SESSION['language']) && $_SESSION['language']=="fr_FR") { ?>selected<?php } ?>>French</option>
				<option value="de_DE" <?php if(isset($_SESSION['language']) && $_SESSION['language']=="de_DE") { ?>selected<?php } ?>>German</option>
				<option value="cn_CN" <?php if(isset($_SESSION['language']) && $_SESSION['language']=="cn_CN") { ?>selected<?php } ?>>Chinese</option>
				<option value="kr_KR" <?php if(isset($_SESSION['language']) && $_SESSION['language']=="kr_KR") { ?>selected<?php } ?>>Korean</option>
				<option value="jp_JP" <?php if(isset($_SESSION['language']) && $_SESSION['language']=="jp_JP") { ?>selected<?php } ?>>Japanese</option>
				<option value="ar_AR" <?php if(isset($_SESSION['language']) && $_SESSION['language']=="ar_AR") { ?>selected<?php } ?>>Arabic</option>
				</select>
				</div>
				</center>
				
			</div><!-- Centered Text END -->
	
		</div>
		<!-- Teaser END -->
	
	<div class="clear"></div>
		
	<!-- Start Container 12 -->
	<div id="main_content" class="container_12">
	
		<div id="main">
		<div class="width-container">
			<?php echo notification(); ?>
							
			<?php if(!empty($errors)): ?>
			<div class="alert alert-block alert-error fade in">
			<ul>
				<?php foreach($errors as $k=>$v): ?>
				<li><?php echo $v; ?></li>
				<?php endforeach; ?>
			</ul>
			</div>
			<?php endif; ?>
			<div id="container-sidebar">
				<div class="content-boxed">
					<div id="map-container">

						<div id="clinic-finder" class="clear-block">
						<div class="links"></div>
			
					

                            

                            <div id="map_canvas" class="newstore_map"></div>
							<div id="ajax_msg"></div>
                            <div id="results">        
							
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

                              <div style="display:block; clear:both; overflow: auto;">
			<form name="f" method='post' id='form_new_store' enctype="multipart/form-data" onSubmit="valForm(); return false;">
				<fieldset>

						<div id="val-name" class="control-group">
						<label><?php echo $lang['ADMIN_NAME']; ?>: <span class='required'>*</span></label>
						<div class="controls">
						<input type='text' name='name' id='name' value='<?php echo $fields['name']['value']; ?>' />
						<span id="text-name" class="help-inline"></span>
						
						 </div>
						</div>
						
						<?php 
							$db = db_connect();
							mysqli_query($GLOBALS["___mysqli_ston"], "SET NAMES utf8");
							$cats = $db->get_rows("SELECT categories.* FROM categories WHERE categories.id!='' ORDER BY categories.cat_name ASC");

						?>
						
						<label>Category: <span class='required'>*</span></label>
						<select name="cat_id" class="form-select" id="cat_id"><option value="0">No Category</option>
						 <?php if(!empty($cats)): ?>
							<?php foreach($cats as $k=>$v): ?>
							<option value="<?php echo $v['id']; ?>"><?php echo $v['cat_name']; ?></option>
							<?php endforeach; ?>
							<?php endif; ?>
						 </select>
					
						<div id="val-address" class="control-group">
						<label><?php echo $lang['ADMIN_ADDRESS']; ?>: <span class='required'>*</span></label>
						<div class="controls">
						<input type='text' name='address' id='address' value='<?php echo $fields['address']['value']; ?>' />
						<span id="text-address" class="help-inline"></span>
						
						 </div>
						</div>
						<span class="help-block"><?php echo $lang['ADMIN_LAT_LANG_AUTO']; ?></span>
					
					<div id="val-telephone" class="control-group">
						<label><?php echo $lang['ADMIN_TELEPHONE']; ?>:</label>
						<div class="controls">
						<input type='text' name='telephone' id='telephone' value='<?php echo $fields['telephone']['value']; ?>' />
						<span id="text-telephone" class="help-inline"></span>
						
						 </div>
						</div>
					
					
					<div id="val-email" class="control-group">
						<label><?php echo $lang['ADMINISTRATOR_EMAIL']; ?>:</label>
						<div class="controls">
						<input type='text' name='email' id='email' value='<?php echo $fields['email']['value']; ?>' />
						<span id="text-email" class="help-inline"></span>
						
						 </div>
						</div>
					
					
						<label><?php echo $lang['ADMIN_WEBSITE']; ?>:</label>
						<input type='text' name='website' id='website' value='<?php echo $fields['website']['value']; ?>' />
					
						<label><?php echo $lang['ADMIN_DESCRIPTION']; ?>:</label>
						<textarea name='description' id='description' rows="4" cols="40"><?php echo $fields['description']['value']; ?></textarea>
					
						<label><?php echo $lang['ADMIN_STORE_IMAGE']; ?>:</label>
						<input type="file" name="file" id="file" class="File" />
						<span class="help-block"><?php echo $lang['ADMIN_THUMB_AUTO']; ?> </span>
					
					<label>Embed Video:</label>
						<input type='text' name='embed_video' id='embed_video' value='<?php echo $fields['embed_video']['value']; ?>' />
					
					
					<?php if(!empty($images)): ?>
					<div class="input">
						<?php foreach($images as $k=>$v): ?>
						<div class="image">
							<img src="<?php echo $v; ?>" alt="Image" />
							<button type="submit" name="delete_image[<?php echo basename($v); ?>]" id="delete_image" class="btn btn-danger" value="<?php echo basename($v); ?>"><?php echo $lang['ADMIN_DELETE']; ?></button>
						</div>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>

					<br /><br />
					<label>Default Media:</label>
						<input type='radio' name='default_media' id='default_media' value='image' <?php if($fields['default_media']['value']=='image' || $fields['default_media']['value']=='') { echo "checked"; } ?>/> Image <br />
						<input type='radio' name='default_media' id='default_media' value='video' <?php if($fields['default_media']['value']=='video') { echo "checked"; } ?>/> Video <br /><br />
					
					
					<div class='input first'>
					<div id="val-latitude" class="control-group">
						<label><?php echo $lang['ADMIN_LATITUDE']; ?>:</label>
						<div class="controls">
						<input type='text' name='latitude' id='latitude' value='<?php echo $fields['latitude']['value']; ?>' style="width:206px !important;" />
						<span id="text-latitude" class="help-inline"></span>
						
						 </div>
						</div>
					</div>
					<div class='input second'>
					<div id="val-longitude" class="control-group">
						<label><?php echo $lang['ADMIN_LONGITUDE']; ?>:</label>
						<div class="controls">
						<input type='text' name='longitude' id='longitude' value='<?php echo $fields['longitude']['value']; ?>' style="width:206px !important;" />
						<span id="text-longitude" class="help-inline"></span>
						
						 </div>
						</div>
					</div>
					
					<?php echo $ssf_accept_privacy; ?>
					<div class='input first'><div><br><br></div></div>
					<div class='input buttons'>
					<button type="button" name="op" onclick="document.location.href='index.php'" value="Cancel" class="btn btn-Finder"><?php echo $lang['ADMIN_CANCEL']; ?></button>&nbsp;
						<button type='submit' name='save' class="btn btn-Finder" id='save'><?php echo $lang['ADMIN_SAVE']; ?></button>
					</div>
				</fieldset>
			</form>
			</div>
                            </div>

				
						
					  
					 
					  
	</div>


	
					</div>
					
						
						<div class="clearfix"></div>

					</div>
					

			</div><!-- close #container-sidebar -->
			

			
		<div class="clearfix"></div>
		</div><!-- close .width-container -->
	</div><!-- close #main -->
  
  
  <script>

function valForm(){
error = 0;
resetForm();

	if($('#name').val()==""){
		$('#val-name').addClass("error");
		$('#text-name').html('<?php echo $lang['ADMIN_STORE_NAME_VALIDATE']; ?>');
		error = 1;
	}
	
	if($('#address').val()==""){
		$('#val-address').addClass("error");
		$('#text-address').html('<?php echo $lang['ADMIN_STORE_ADDRESS_VALIDATE']; ?>');
		error = 1;
	}
	
	if($('#latitude').val()==""){
		$('#val-latitude').addClass("error");
		$('#text-latitude').html('<?php echo $lang['ADMIN_STORE_LATITUDE_VALIDATE']; ?>');
		error = 1;
	}
	
	if($('#longitude').val()==""){
		$('#val-longitude').addClass("error");
		$('#text-longitude').html('<?php echo $lang['ADMIN_STORE_LONGITUDE_VALIDATE']; ?>');
		error = 1;
	}
	
	if($('#email').val()!=""){
	if(!validateEmail($('#email').val())){
		$('#val-email').addClass("error");
		$('#text-email').html('<?php echo $lang['ADMIN_STORE_EMAIL_VALIDATE']; ?>');
		error = 1;
	}
	}
	
	
	tel = $('#telephone').val();
	if(tel!=""){
	if((!tel.match(/^\d+/))){
		$('#val-telephone').addClass("error");
		$('#text-telephone').html('<?php echo $lang['ADMIN_STORE_TELEPHONE_VALIDATE']; ?>');
		error = 1;
	}
	}
	
	if (jQuery('#ssf_gdpr_check').length>0) {
			if(jQuery('input#ssf_gdpr_check').is(':checked')){
				//continue
			}else{
				jQuery('input#ssf_gdpr_check').addClass('ssf_invalid');
				error = 1;
			}
		}
	
	if(error==0){
	   document.f.submit();
	}


}

function resetForm(){
	$('#text-name').html('');
	$('#text-address').html('');
	$('#text-latitude').html('');
	$('#text-longitude').html('');
	$('#text-telephone').html('');
	$('#text-email').html('');

	$('#val-name').removeClass("error");
	$('#val-address').removeClass("error");
	$('#val-latitude').removeClass("error");
	$('#val-longitude').removeClass("error");
	$('#val-telephone').removeClass('');
	$('#val-email').removeClass('');

}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 

jQuery(document).ready(function() {
        jQuery("input#ssf_gdpr_check").click(function() {
            var s_checked = jQuery(this).is(':checked');
            if (s_checked) {
                jQuery('input#ssf_gdpr_check').removeClass('ssf_invalid');
            } 
        });
    });

</script>
  
  
  <style>
  .control-group {
  margin-bottom:0px !important;
  }

form fieldset .input{
  padding:0px !important;
}
</style>

   <center>
 
 



<?php include ROOT."themes/footer.inc.php"; ?>
</body>
</html>