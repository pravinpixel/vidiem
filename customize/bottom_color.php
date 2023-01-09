<?php
session_start();
error_reporting(0);
$rgb=hexToRgb($_REQUEST['ccode']);

$imgname2 = "eva1_bottom.gif";
$im2 = imagecreatefromgif ($imgname2);
$index2 = imagecolorexact ($im2,255,255,255);
imagecolorset($im2,$index2,$rgb['r'],$rgb['g'],$rgb['b']);
foreach (glob("bottom_".session_id()."_*.gif") as $filename) {
    unlink($filename);
}

$imgname2 = "bottom_".session_id()."_".time().".gif";
imagegif($im2,$imgname2);

echo json_encode(array("imgsrc"=>$imgname2,"rslt"=>"1"));

 
function hexToRgb($hex, $alpha = false) {
   $hex      = str_replace('#', '', $hex);
   $length   = strlen($hex);
   $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
   $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
   $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
   if ( $alpha ) {
      $rgb['a'] = $alpha;
   }
   return $rgb;
}

?>