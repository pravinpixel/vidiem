<?php 
// include common file
include_once '../includes/config.inc.php';
// new db instance
$db = new DB(array(
	'hostname'=>HOSTNAME,
	'username'=>DB_USERNAME,
	'password'=>DB_PASSWORD,
	'db_name'=>DB_NAME
));

$lat = $_POST['latitude'];
$long = $_POST['longitude'];

if(!$db->insert('stores',$_POST)) {
  //echo "error inserting";
  echo '0';
} else {
  //echo "inserting: ".$lat.", ".$long;
  echo '1';
}
?>