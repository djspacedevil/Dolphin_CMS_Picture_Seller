<?php
/***************************************************************************
*
*                            Picture - Seller
*                      
*     copyright            : (C) 2012 Sven Goessling / SmileAndGo.de
*     website              : http://www.sven-goessling.de
*
*     IMPORTANT: This is a commercial product made by Sven Goessling and cannot be modified for other than personal usage. 
*     This product cannot be redistributed for free or redistribute it and/or modify without written permission from Sven Goessling. 
*     This notice may not be removed from the source code.
*     See license.txt file; if not, write to info@emsland-party.de 
*

***************************************************************************/
// Optionen umsetzen der Wasserzeichen finish_picture.jpg demo_file.jpg
	
	
	if ($_POST['demo_files'] == 'demo-test') {
	//admin Test
		$images_path = __DIR__.'/../templates/base/images/';
		$demo = $images_path.'demo_file.jpg';
		$fin_demo = $images_path.'finish_picture.jpg';
	} else {
	//Normaler ablauf
	$images_path = $dir;
	$file = $filename;
	$fin_filename = $images_path.'watermark_'.strtolower(basename($filename));
		}
	
	
	if (file_exists(__DIR__."/../templates/base/images/watermark.png")) {
	$watermark = __DIR__.'/../templates/base/images/watermark.png';
		} else {
    $watermark = __DIR__.'/../templates/base/images/empty_watermark.png';
	}
  
  $query = mysql_query("SELECT `value` FROM `goesi_pic_seller_config` WHERE `option`='none_water'");
  $q = mysql_fetch_row($query);
  if ($q['0'] == 'true') { 
	ob_end_clean();
	echo 'none_watermark';
	break;
  } else {
  
  $quali = mysql_query("SELECT `value` FROM `goesi_pic_seller_config` WHERE `option`='quality'");
  $qu = mysql_fetch_row($quali);
  $quality = $qu['0'];
  
  
  $querys = mysql_query("SELECT `option`,`value` FROM `goesi_pic_seller_config` WHERE (`option`='buttom_right' OR `option`='buttom_left' OR `option`='header_left' OR `option`='header_right' OR `option`='center_small' OR `option`='center_full' OR `option`='center_all_over')");
	include_once('GoesiSellResizeWatermark.php');
	
	
	
	while($wa = mysql_fetch_assoc($querys)) {
		// Bild mit Wasserzeichen versehen
		
		if ($wa['option'] == 'buttom_right' && $wa['value'] == 'true') {
			//set watermark on buttom right
			$save_as = 'jpeg';  
			$h_position = 'right'; 
			$v_position = 'bottom';
			$wm_size = '.3'; 
			
			include 'GoesiSellSetWatermark.php';
		}
		if ($wa['option'] == 'buttom_left' && $wa['value'] == 'true') {
			//set watermark on buttom_left
			$save_as = 'jpeg';  
			$h_position = 'left'; 
			$v_position = 'bottom';
			$wm_size = '.3'; 

			include 'GoesiSellSetWatermark.php';
		}
		if ($wa['option'] == 'header_left' && $wa['value'] == 'true') {
			//set watermark on header_left
			$save_as = 'jpeg';  
			$h_position = 'left'; 
			$v_position = 'top';
			$wm_size = '.3'; 

			include 'GoesiSellSetWatermark.php';			
		}
		if ($wa['option'] == 'header_right' && $wa['value'] == 'true') {
			//set watermark on header_right
			$save_as = 'jpeg';  
			$h_position = 'right'; 
			$v_position = 'top';
			$wm_size = '.3'; 

			include 'GoesiSellSetWatermark.php';
		}
		if ($wa['option'] == 'center_small' && $wa['value'] == 'true') {
			//set watermark on center_small
			$save_as = 'jpeg';  
			$h_position = 'center'; 
			$v_position = 'center';
			$wm_size = '.5'; 

			include 'GoesiSellSetWatermark.php';
		}
		if ($wa['option'] == 'center_full' && $wa['value'] == 'true') {
			//set watermark on center_full
			$save_as = 'jpeg';  
			$h_position = 'center'; 
			$v_position = 'center';
			$wm_size = '1'; 

			include 'GoesiSellSetWatermark.php';
		}
		if ($wa['option'] == 'center_all_over' && $wa['value'] == 'true') {
			//set watermark on center_all_over
			$save_as = 'jpeg';  
			$h_position = 'center'; 
			$v_position = 'center';
			$wm_size = 'larger'; 

			include 'GoesiSellSetWatermark.php';
		}

	}
	
	//File speichern
	
	
  
  if ($_POST['demo_files'] == 'demo-test') {
  ob_end_clean();
  echo 'watermark_set';
  exit;
  }
  
  
  }
		


?>