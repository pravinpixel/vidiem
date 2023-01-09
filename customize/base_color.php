<?php
session_start();
error_reporting(0);
$rgb=hexToRgb($_REQUEST['ccode']);

$imgname = "eva1.gif";
$im = imagecreatefromgif ($imgname);
$index = imagecolorexact ($im,255,0,0);
imagecolorset($im,$index,$rgb['r'],$rgb['g'],$rgb['b']);
foreach (glob("base_".session_id()."_*.gif") as $filename) {
    unlink($filename);
}

$imgname = "base_".session_id()."_".time().".gif";
imagegif($im,$imgname);

$html= ' <img id="basetemp" src="'.$imgname.'" width="600" height="620"    > ';

echo json_encode(array("imgsrc"=>$imgname,"rslt"=>"1"));

 
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