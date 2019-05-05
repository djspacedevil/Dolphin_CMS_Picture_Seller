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

  if ($_POST['gruppe_checked'] == 'yes' && $_POST['group_value']) {
    //checked gruppe
    $query = mysql_query("SELECT * FROM `goesi_pic_seller_config` WHERE `option`='upload_group' AND `value`='".addslashes($_POST['group_value'])."'");
    $q = mysql_fetch_row($query);
    if (!$q['0']) {
      mysql_query("INSERT INTO `goesi_pic_seller_config` (`option`,`value`) VALUES ('upload_group','".addslashes($_POST['group_value'])."')");
      ob_end_clean();
      echo 'checked';
      exit;
    }
  } else if ($_POST['gruppe_checked'] == 'no' && $_POST['group_value']) {
    //unchecked gruppe
    $query = mysql_query("SELECT * FROM `goesi_pic_seller_config` WHERE `option`='upload_group' AND `value`='".addslashes($_POST['group_value'])."'");
    $q = mysql_fetch_row($query);
    if ($q['0']) {
      mysql_query("DELETE FROM `goesi_pic_seller_config` WHERE `option`='upload_group' AND `value`='".addslashes($_POST['group_value'])."'");
      ob_end_clean();
      echo 'unchecked';
      exit;
     }
    }
    
    if ($_POST['action_selector'] && $_POST['value']) {
    // SELECTOR
    mysql_query("UPDATE `goesi_pic_seller_config` SET `value`='".$_POST['value']."' WHERE `option`='".addslashes($_POST['action_selector'])."'");
      ob_end_clean();
      echo 'selected';
      exit;
    }
    
    if ($_POST['water_checked'] == 'yes' && $_POST['water_value']) {
    //checked watermarks
        mysql_query("UPDATE `goesi_pic_seller_config` SET value='false' WHERE (`option`='none_water' OR `option`='buttom_right' OR `option`='buttom_left' OR `option`='header_left' OR `option`='header_right' OR `option`='center_small' OR `option`='center_full' OR `option`='center_all_over')");
        
        mysql_query("UPDATE `goesi_pic_seller_config` SET value='true' WHERE `option`='".addslashes($_POST['water_value'])."'");
          
        ob_end_clean();
        echo 'water_checked';
        exit;
    }
   else if ($_POST['water_checked'] == 'no' && $_POST['water_value']) {
    //unchecked watermarks
    mysql_query("UPDATE `goesi_pic_seller_config` SET value='false' WHERE `option`='".addslashes($_POST['water_value'])."'");
        ob_end_clean();
        echo 'water_unchecked';
        exit;
     
    }
	
	if ($_POST['quality_selector'] == 'changes' && $_POST['value']) {
	//transparenz
	mysql_query("UPDATE `goesi_pic_seller_config` SET `value`='".addslashes($_POST['value'])."' WHERE `option`='quality'");
	ob_end_clean();
    echo 'changed';
    exit;
	}
?>