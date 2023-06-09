<?php session_start();

// define the root path to the frontend folder
define('ROOT', $_SERVER['DOCUMENT_ROOT'].'/maya-21/map1/');
// define the root URL to the frontend section
define('ROOT_URL', 'http://miketesting123.com/maya-21/map1/');
// define default language. Note: session will have to be deleted before it will reflect the site upon refresh
define('DEFAULT_LANGUAGE', 'en_US');

if(isset($_REQUEST['langset'])){
   $_SESSION['language']=$_REQUEST['langset'];
}


// default language file
if(isset($_SESSION['language'])){
	include_once ROOT.'language/'.htmlspecialchars($_SESSION['language']).'.php';
} else {
	include_once ROOT.'language/'.DEFAULT_LANGUAGE.'.php';
	$_SESSION['language'] = DEFAULT_LANGUAGE;
}

// include library file
include_once ROOT.'includes/library.php';
// include database class
include_once ROOT.'includes/class.database.php';
// include image class
include_once ROOT.'includes/class.img.php';

// define database settings
define('HOSTNAME','localhost');
define('DB_USERNAME','miketlqu_ma14');
define('DB_PASSWORD','Y(1@qUpJeNmN');
define('DB_NAME','miketlqu_maya-14');
// admin email address
define('ADMINISTRATOR_EMAIL','kali@in1947.com');

// new db instance
$db = new DB(array(
	'hostname'=>HOSTNAME,
	'username'=>DB_USERNAME,
	'password'=>DB_PASSWORD,
	'db_name'=>DB_NAME
));

// stop on db fail
if($db===FALSE) {
	$db_errors = $db->errors;
}

?>


