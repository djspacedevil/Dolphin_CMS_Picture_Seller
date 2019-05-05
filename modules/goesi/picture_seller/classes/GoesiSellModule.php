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

bx_import('BxDolModule');

class GoesiSellModule extends BxDolModule {

    function GoesiSellModule(&$aModule) {        
        parent::BxDolModule($aModule);
    }
///////////////////////////////////////////////
    //Admin Bereich
    function actionAdministration () {

        if (!$GLOBALS['logged']['admin']) {
            $this->_oTemplate->displayAccessDenied ();
            return;
        }

        $this->_oTemplate->pageStart();
	
	$cId = $this->_oDb->getSettingsCategory(); 
	if(empty($cId)) { // if category is not found display page not found
            echo MsgBox(_t('_sys_request_page_not_found_cpt'));
            $this->_oTemplate->pageCodeAdmin (_t('_goesi_pic_seller'));
            return;
        }
        
// POSTS
   require_once('GoesiSellOptions.php');
   if ($_POST['create_watermark'] == 'beginn_works') {
   require_once('GoesiSellWatermarks.php');
   }
//
   //User Gruppen
  $query = mysql_query("SELECT `id`,`Name` FROM `sys_acl_levels` WHERE `Active`='yes' AND `id`>1");
  while ($q = mysql_fetch_row($query)) {
    $group = mysql_query("SELECT * FROM `goesi_pic_seller_config` WHERE `option`='upload_group' AND `value`='".$q['0']."'");
    $g = mysql_fetch_row($group);
    if ($g['0']) {$checked = 'checked="checked"';} else {$checked = '';}
  $allow_group .= '<input type="checkbox" class="gruppe" name="'.$q['1'].'" value="'.$q['0'].'" '.@$checked.'>'.$q['1'].'<br>';
  }
  //
  
  // Auto_ Accept
    $query = mysql_query("SELECT `value` FROM `goesi_pic_seller_config` WHERE `option`='auto_accept'");
    $q = mysql_fetch_row($query);
    if ($q['0'] == 'true') {
      $select_accept_yes = 'selected="selected"';
    } else if ($q['0'] == 'false') {
      $select_accept_no = 'selected="selected"';
    } else {
    mysql_query("INSERT INTO `goesi_pic_seller_config` (`option`,`value`) VALUES ('auto_accept','false')");
      $select_accept_no = 'selected="selected"';
    }
    
    $auto_accept = '<tr><td>'._t('_goesi_pic_seller_auto_accept').'</td><td><select id="selector" name="auto_accept"><option value="true" '.@$select_accept_yes.'>'._t('_goesi_pic_seller_yes').'</option><option value="false" '.@$select_accept_no.'>'._t('_goesi_pic_seller_no').'</option></select></td></tr>';
  //
  
  // Galleries / Boonex Photos (Photos) and Art Gallerie (Art albums)  sys_options_cats // Shop (Store)

    $opt[] = 'accept_photos';
    $opt[] = 'accept_art';
    $opt[] = 'accept_store';

    foreach ($opt as $op) {
        if ($op == 'accept_photos') $ops = 'Photos';
        if ($op == 'accept_art') $ops = 'Art albums';
        if ($op == 'accept_store') $ops = 'Store';
    $querya = mysql_query("SELECT `id` FROM `sys_options_cats` WHERE `name`='".$ops."'"); 
     $qa = mysql_fetch_row($querya);
     if ($qa['0']) {
     
    $select_accept_yes = '';
    $select_accept_no = '';
    $query = mysql_query("SELECT `value` FROM `goesi_pic_seller_config` WHERE `option`='".$op."'");
    $q = mysql_fetch_row($query);
    if ($q['0'] == 'true') {
      $select_accept_yes = 'selected="selected"';
    } else if ($q['0'] == 'false') {
      $select_accept_no = 'selected="selected"';
    } else {
    mysql_query("INSERT INTO `goesi_pic_seller_config` (`option`,`value`) VALUES ('".$op."','false')");
      $select_accept_no = 'selected="selected"';
    }
    if ($op == 'accept_photos') {
    $accept_photos = '<tr><td> '._t('_goesi_pic_seller_accept_photos').' </td><td><select id="selector" name="'.$op.'"><option value="true" '.@$select_accept_yes.'>'._t('_goesi_pic_seller_yes').'</option><option value="false" '.@$select_accept_no.'>'._t('_goesi_pic_seller_no').'</option></select></td></tr>';
    } else if ($op == 'accept_art') {
    $accept_art = '<tr><td> '._t('_goesi_pic_seller_accept_art').' </td><td><select id="selector" name="'.$op.'"><option value="true" '.@$select_accept_yes.'>'._t('_goesi_pic_seller_yes').'</option><option value="false" '.@$select_accept_no.'>'._t('_goesi_pic_seller_no').'</option></select></td></tr>';
    } else if ($op == 'accept_store') {
    $accept_store = '<tr><td> '._t('_goesi_pic_seller_accept_store').' </td><td><select id="selector" name="'.$op.'"><option value="true" '.@$select_accept_yes.'>'._t('_goesi_pic_seller_yes').'</option><option value="false" '.@$select_accept_no.'>'._t('_goesi_pic_seller_no').'</option></select></td></tr>';
    }
    }
    }
    
  //
  
  //Watermark
  if ($_FILES) {
  //BX_DOL_URL_MODULES.'goesi/youtube_auto-import/templates/base/images/icons/
  $target_path = __DIR__."/../templates/base/images/";
  if ($_FILES['uploadedfile']['type'] == 'image/png') {
      rename ($_FILES['uploadedfile']['tmp_name'], $target_path.'watermark.png');
  } else {
  $error = 'Watermark is not a PNG File';}
  }
  if (file_exists(__DIR__."/../templates/base/images/watermark.png")) {
  $watermark = '<a href="'.BX_DOL_URL_ROOT .'modules/goesi/picture_seller/templates/base/images/watermark.png" target="_blank" title="original size"><img width="100px" src="'.BX_DOL_URL_ROOT .'modules/goesi/picture_seller/templates/base/images/watermark.png?'.time().'"></a>';
  } else {
  $watermark = '<a href="'.BX_DOL_URL_ROOT .'modules/goesi/picture_seller/templates/base/images/empty_watermark.png" target="_blank" title="original size"><img width="100px" src="'.BX_DOL_URL_ROOT .'modules/goesi/picture_seller/templates/base/images/empty_watermark.png?'.time().'"></a>';
  }
  //
  
  // Wasserzeichen Position bestimmen
  $waterposition[] = array('name' => 'none_water',
                            'file' => 'demo_file.jpg',
                            'language' => '_goesi_pic_seller_no_watermark');
  $waterposition[] = array('name' => 'buttom_right',
                            'file' => 'demo_file_buttom_right.jpg',
                            'language' => '_goesi_pic_seller_buttom_right');
  $waterposition[] = array('name' => 'buttom_left',
                            'file' => 'demo_file_buttom_left.jpg',
                            'language' => '_goesi_pic_seller_buttom_left');                          
  $waterposition[] = array('name' => 'header_left',
                            'file' => 'demo_file_header_left.jpg',
                            'language' => '_goesi_pic_seller_header_left');
  $waterposition[] = array('name' => 'header_right',
                            'file' => 'demo_file_header_right.jpg',
                            'language' => '_goesi_pic_seller_header_right');
  $waterposition[] = array('name' => 'center_small',
                            'file' => 'demo_file_center.jpg',
                            'language' => '_goesi_pic_seller_center_small');
  $waterposition[] = array('name' => 'center_full',
                            'file' => 'demo_file_all-over_center.jpg',
                            'language' => '_goesi_pic_seller_center_full');
  $waterposition[] = array('name' => 'center_all_over',
                            'file' => 'demo_file_all-over.jpg',
                            'language' => '_goesi_pic_seller_complete');                                                                              
  
  foreach($waterposition as $watermarks) {
    $query = mysql_query("SELECT `value` FROM `goesi_pic_seller_config` WHERE `option`='".$watermarks['name']."'"); //$watermark['name']  $watermark['language'] $watermark['file']
    $q = mysql_fetch_row($query);
    $checked = '';
    if ($q['0'] == 'true') {
    $checked = 'checked="checked"';
    } else if ($q['0'] == 'false') {
    $checked = '';
    } else {
    $checked = '';
    mysql_query("INSERT INTO `goesi_pic_seller_config` (`option`,`value`) VALUES ('".$watermarks['name']."','false')");
    }
    $all_watermark_option .= '<tr><td><input type="checkbox" class="watermarks" name="'.$watermarks['name'].'" value="'.$watermarks['name'].'" '.$checked.'><bx_text:'.$watermarks['language'].' /></td><td><img width="100px" src="<bx_image_url:'.$watermarks['file'].' />"></td></tr>';
  }

  //
  //Transparenz
  $query = mysql_query("SELECT `value` FROM `goesi_pic_seller_config` WHERE `option`='quality'");
  $q = mysql_fetch_row($query);
  $i = '100';
  if ($q['0'] != '') {
	
		while ($i >= '0') {
			if ($i == $q['0'])
			{
				$select = 'selected="selected"';
			} else {
				$select = '';
			}
	
			$quali .= '<option value="'.$i.'" '.@$select.'>'.$i.'</option>';
			$i--;
		}
	} else {
		mysql_query("INSERT INTO `goesi_pic_seller_config` (`option`,`value`) VALUES ('quality','95')");
		while ($i >= '0') {
			if ($i == '95')
			{
				$select = 'selected="selected"';
			} else {
				$select = '';
			}
	
		$quali .= '<option value="'.$i.'" '.@$select.'>'.$i.'</option>';
		$i--;
		}
	}
  
  
  //
  
	$aVars = array (
       'module_url' 	=> BX_DOL_URL_ROOT . $this->_oConfig->getBaseUri(),
	     'allow_group'	=> @$allow_group,
	     'auto_accept' => @$auto_accept,
	     'accept_photos' => @$accept_photos,
	     'accept_art' => @$accept_art,
	     'accept_store' => @$accept_store,
	     'all_watermark_option' => $all_watermark_option,
	     'quality'	=> $quali,
	     'newurls'	=> '2',
	     'lastcron'	=> '3',
	     'error' => $error,	
	     'watermark' => $watermark,
        );
        bx_import('BxDolAdminSettings'); // import class
        
        $mixedResult = '';
        if(isset($_POST['save']) && isset($_POST['cat'])) { 
            $oSettings = new BxDolAdminSettings($cId);
            $mixedResult = $oSettings->saveChanges($_POST);
        }

        $oSettings = new BxDolAdminSettings($cId); 
        $sResult = $oSettings->getForm();
                   
        if($mixedResult !== true && !empty($mixedResult)) 
            $sResult = $mixedResult . $sResult . header("Location: " . BX_DOL_URL_ROOT . $this->_oConfig->getBaseUri() .'administration/');
  $sContent .= '<script type="text/javascript"> 
			var Bilderpfad = "'.BX_DOL_URL_MODULES.'goesi/picture_seller/templates/base/images/icons/";
			var PostDir = "'.BX_DOL_URL_ROOT . $this->_oConfig->getBaseUri().'administration/";
			</script>';      
	$sContent .= '<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.js"></script>';
	$sContent .= $this -> _oTemplate  -> addJs('goesi_pic_actions.js', true);
	$sContent .= $this->_oTemplate->parseHtmlByName ('admin', $aVars);


        echo $this->_oTemplate->adminBlock ($sContent, _t('_goesi_pic_seller'));

        echo DesignBoxAdmin (_t('_goesi_pic_seller'), $sResult);
        
        $this->_oTemplate->pageCodeAdmin (_t('_goesi_pic_seller'));
    }

///////////////////////////////////////////////


///////////////////////////////////////////////
//User Bereich
    function actionHome () {
        $this->_oTemplate->pageStart();
	
		include_once ('GoesiSellUser.php');
	
		if ( $arr_Professional ) { 
		// Ist Pic-Seller
			echo $this->_oTemplate->parseHtmlByName('pic-seller', $aVars);
			$this->_oTemplate->pageCode(_t('_goesi_pic_seller'), true);
		} else {
		// Ist kein Pic-Seller
			echo $this->_oTemplate->parseHtmlByName('no-seller', $aVars);
			$this->_oTemplate->pageCode(_t('_goesi_pic_seller'), true);
		}

    }

///////////////////////////////////////////////
}

?>
