<?php
   $img = imagecreate(550, 400);
   imagecolorallocate($img, 0, 0, 0);
   $bgcolor = imagecolorat($img, 255, 255);
   imagecolorset($img, $bgcolor, 111, 110, 150);
   header('Content-Type: image/png');
   imagepng($img);
   imagedestroy($img);
?>