 
<?php
$imgname = "eva1.gif";
$im = imagecreatefromgif ($imgname);
$index = imagecolorexact ($im,255,0,0);
imagecolorset($im,$index,102,102,102);
$imgname = "result.gif";
imagegif($im,$imgname);
?>



 <?php
$imgname2 = "eva1_bottom.gif";
$im2 = imagecreatefromgif ($imgname2);
$index2 = imagecolorexact ($im2,255,255,255);
imagecolorset($im2,$index2,188,32,188);
$imgname2 = "result2.gif";
imagegif($im2,$imgname2);
?>
 
