<script type="text/javascript">
$(document).ready(function(){
		$('.dropdown-toggle').dropdown()						
	});	
</script>
<div style="float:right; padding:10px;"><?php echo $lang['ADMIN_LOGGED_IN_AS']; ?>: 
<div class="btn-group">
                <button class="btn" onclick="document.location.href='stores.php'"><?php echo $_SESSION['User']['username']; ?></button>
				<button class="btn" onclick="document.location.href='settings.php'"><i class="icon-cog"></i>							
				</button>
				<?php 
				if(MEGA_GOOGLE_API_ADMIN==''){ $google_api_check=false; } else{ $google_api_check=true; }
                if (strpos($_SERVER['PHP_SELF'],'settings.php') !== false && isset($_POST['mega_google_api'])){
				   if($_POST['mega_google_api']!=''){
				       $google_api_check=true;
				   }else{
					   $google_api_check=false;
				   }				
				}								
				if($google_api_check==false) { ?>
				<div class="warnings btn" id="notification-panel">
				<a href="#" data-toggle="dropdown" class="notification-btn">
				<i class="icon-warning-sign"></i> 				
				<span class="notify">1</span>			
				</a>
				  <div class="warn-menu dropdown-menu" role="menu" aria-labelledby="dLabel">
                    	<div class="title"><span>You have 1 new notifications</span></div>
                        <ul>
                            <li>
                            	<div>Since 22 June 2016, Google Maps API key<br> is required (
						<a href="http://superstorefinder.net/support/knowledgebase/new-google-maps-after-22-june-2016-will-require-google-api-key/" target="new">Read Article</a>
						) -
						<a href="https://superstorefinder.net/support/knowledgebase/how-to-use-google-api-keys-for-super-store-finder/" target="new">Learn More</a></div>
                            </li>
                        </ul>
                    </div>     
				</div>
				<?php } ?>	
				<button class="btn btn-info" onclick="document.location.href='change_password.php'"><?php echo $lang['ADMIN_CHANGE_PASSWORD']; ?></button>
                <button class="btn btn-danger" onclick="document.location.href='logout.php'"><?php echo $lang['ADMIN_LOGOUT']; ?></button>
		  </div>
</div>

<div id="logo"></div>
<div class="clearfix"></div>
<div class="navbar">
<div class="navbar-inner">

<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
	  
<a class="brand" href="../index.php"><?php echo $lang['MENU_STORE_FINDER']; ?></a>
 
<div class="nav-collapse collapse">   
<ul class="nav">

	<li class="divider-vertical"></li>
	<li id="store-list" <?php if (strpos($_SERVER['PHP_SELF'],'stores.php') !== false) { ?>class="active"<?php } ?>><a href="./stores.php"><?php echo $lang['ADMIN_STORE_LIST']; ?></a></li>
	<li class="divider-vertical"></li>
	<li id="add-store" <?php if (strpos($_SERVER['PHP_SELF'],'stores_add.php') !== false) { ?>class="active"<?php } ?>><a href="./stores_add.php"><?php echo $lang['ADMIN_ADD_STORE']; ?></a></li>
	<li class="divider-vertical"></li>
	<li id="import" <?php if (strpos($_SERVER['PHP_SELF'],'import.php') !== false) { ?>class="active"<?php } ?>><a href="./import.php">Import/Export Stores</a></li>
	<li class="divider-vertical"></li>
	<li id="add-store" <?php if (strpos($_SERVER['PHP_SELF'],'categories.php') !== false) { ?>class="active"<?php } ?>><a href="./categories.php"><?php echo $lang['SSF_CATEGORY_LIST']; ?></a></li>
	<li class="divider-vertical"></li>
	<li id="add-store" <?php if (strpos($_SERVER['PHP_SELF'],'category_add.php') !== false) { ?>class="active"<?php } ?>><a href="./category_add.php"><?php echo $lang['SSF_ADD_CATEGORY']; ?></a></li>
	<li class="divider-vertical"></li>
	<li id="user-list" <?php if (strpos($_SERVER['PHP_SELF'],'users.php') !== false) { ?>class="active"<?php } ?>><a href="./users.php"><?php echo $lang['ADMIN_USER_LIST']; ?></a></li>
	<li class="divider-vertical"></li>
	<li id="add-user" <?php if (strpos($_SERVER['PHP_SELF'],'users_add.php') !== false) { ?>class="active"<?php } ?>><a href="./users_add.php"><?php echo $lang['ADMIN_ADD_USER']; ?></a></li>
	
	<li class="divider-vertical"></li>
</ul>
  </div>
  </div>
</div>	