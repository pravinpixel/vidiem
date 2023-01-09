<?php session_start();

// define the root path to the admin folder
define('ROOT', $_SERVER['DOCUMENT_ROOT'].'/map1/admin/');
// define the root URL to the admin section
define('ROOT_URL', 'https://www.vidiem.in/map1/admin/');
// Authentication SALT
define('SALT', 'Ku23ao+(f%bxh|k?4ee4<+?%B$-<2_#%IpwU4]+o2l+xmXGHL0_h}+1m$QnL.pIu');
// define default language. Note: session will have to be deleted before it will reflect the site upon refresh
$default_language = "en_US";

if(isset($_REQUEST['langset'])){
   $_SESSION['language']=$_REQUEST['langset'];
}

// default language file
if(isset($_SESSION['language'])){
	include_once '../language/'.$_SESSION['language'].'.php';
} else {
	include_once '../language/'.$default_language.'.php';
	$_SESSION['language'] = $default_language;
}

// include common file
include_once ROOT.'includes/library.php';
// include database class
include_once ROOT.'includes/class.database.php';
// include image class
include_once ROOT.'includes/class.img.php';



// define database settings
define('HOSTNAME','localhost');
define('DB_USERNAME','vidiem_dealer');
define('DB_PASSWORD','zpii0_KHr');
define('DB_NAME','vidiem_dealer');
// admin email address
define('ADMINISTRATOR_EMAIL','your@email.com');

