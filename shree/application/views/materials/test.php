<?php
#error_reporting(0);
$path=FCPATH.'uploads/sops_wi/aaaaaa.pdf';
$im = new Imagick(); 
$im->setResolution( 300, 300 ); 
$im->readImage( $path);


?>

