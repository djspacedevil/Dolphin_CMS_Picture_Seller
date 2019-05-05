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
////////////////////////////////
// Options for the Users - Frontend

$profileID = getID( $_GET['ID'] );
include_once("GoesiSellUserDB.php");
$is_seller = false;
////////////////////////////////

////////////////////////////////
// Uploader-Level 
	$query = mysql_query("SELECT `value` FROM `goesi_pic_seller_config` WHERE `option`='upload_group'");
	while ($result = mysql_fetch_row($query)) {
		$MemLevelProfessional = $result['0'];
		$arr_Professional = db_arr( "SELECT `ID`, `NickName` FROM `Profiles` LEFT JOIN `sys_acl_levels_members` ON 
		( `sys_acl_levels_members`.`IDLevel` = $MemLevelProfessional ) 
		WHERE `sys_acl_levels_members`.`IDMember` = $profileID " );
		if ( $arr_Professional ) {
		$is_seller = true;
		break;
		}
	}
////////////////////////////////

////////////////////////////////
// Table 1 - Schritt 1
$query = mysql_query("SELECT `ID` FROM `sys_options_cats` WHERE `name`='Art albums'");
$q = mysql_fetch_row($query);
$artalbum = '';
	if ($q['0'] != '') {
		$artalbum = '<option value="art">'._t('_goesi_pic_uploaded_in_art_own').'</option><option value="art-shop">'._t('_goesi_pic_uploaded_in_art').'</option>';
	}
$table1 = '<table id="table">
	<tr>
		<td>'._t('_goesi_pic_uploaded_in').':<br>
			<font size="1">'._t('_goesi_pic_uploaded_in_1').'</font>
		</td>
		<td>
			<select id="albums">
					<option selected="selected" value="">'._t('_goesi_pic_choose').'</option>
					<option value="own">'._t('_goesi_pic_choose_own').'</option>
					<option value="own-shop">'._t('_goesi_pic_uploaded_in_own').'</option>
					'.$artalbum.'
					<option value="shop">'._t('_goesi_pic_uploaded_in_shop').'</option>
			</select>
		</td>
	</tr>
</table>';

////////////////////////////////

////////////////////////////////
// Check if Paypal Adress is set
  //bx_pmt_user_values  user_id "$profileID"	option_id "3"	value "emailadresse"
	$query = mysql_query("SELECT `value` FROM `bx_pmt_user_values` WHERE `user_id`='".$profileID."' AND `option_id`='3'");
	$qu = mysql_fetch_row($query);
	$paypal_email ='';
	$paypal = '';
	$paypal_script = '';
	if ($qu['0'] != "") {
	$paypal_email = $qu['0'];
	$paypal = _t('_goesi_pic_yes-paypal');
	$paypal_script = 'yespaypal';
	} else {
	$paypal = _t('_goesi_pic_no-paypal');
	$paypal_script = 'nopaypal';
	$table1 = '';
	}
////////////////////////////////

////////////////////////////////
// Album Optionen
	$albcatoptions ='';
	if ($artalbum != '') {
		$query = mysql_query("SELECT `Category` FROM `sys_categories` WHERE `Type`='ayphotos' AND Status='active' ORDER BY `Date` DESC");
		while ($a = mysql_fetch_row($query)) {
			$albcatoptions .= '<option value="'.$a['0'].'" >'.$a['0'].'</option>';
		}
	}
	
	$albLandoptions = '';
	$query = mysql_query("SELECT `Value`,`LKey` FROM `sys_pre_values` WHERE `Key`='Country' ORDER BY `Order`");
	$query2 = mysql_query("SELECT `VALUE` FROM `sys_options` WHERE `Name`='default_country'");
	$qu = mysql_fetch_row($query2);
	while($b = mysql_fetch_row($query)) {
		if ($b['0'] == $qu['0']) {$sele = 'selected="selected"';} else {$sele = '';}
		$albLandoptions .= '<option value="'.$b['0'].'" '.$sele.'>'._t($b['1']).'</option>';	
	}
////////////////////////////////

////////////////////////////////
//Shop Kategorien
$shopcategories = '';
$query = mysql_query("SELECT `Category` FROM `sys_categories` WHERE `Type`='bx_store' AND `Status`='active'");
	while ($q = mysql_fetch_row($query)) {
		$shopcategories .= '<option value="'.$q['0'].'">'.$q['0'].'</option>';
	}
////////////////////////////////

////////////////////////////////
// Output
$aVars = array (
       'module_url' 	=> BX_DOL_URL_ROOT . $this->_oConfig->getBaseUri(),
	   'module_base'		=> BX_DOL_URL_MODULES.'goesi/picture_seller/templates/base',
	     'AlbumOptions'	=> $AlbumOptions,	
	     'all'		=> $sResult,
	     'newurls'	=> $URLList,
	     'lastcron'	=> $LastCron,
		 'userid' => $profileID+10000,
		 'albumid' => '10000',
		 'paypal_email' => $paypal_email,
		 'paypal' => $paypal,
		 'table1' => $table1,
		 'albcatoptions' => $albcatoptions,
		 'albLandoptions' => $albLandoptions,
		 'shopcategories' => $shopcategories,
		 
        );
//

	echo '<script type="text/javascript"> 
			var Bilderpfad = "'.BX_DOL_URL_MODULES.'goesi/picture_seller/templates/base/images/icons/";
			var PostDir = "'.BX_DOL_URL_ROOT . $this->_oConfig->getBaseUri().'";
			var Paypal = "'.$paypal_script.'";
			var missingfields = "'._t('_goesi_pic_missing_fields').'";
			</script>';
	echo '<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.js"></script>';
	echo $this -> _oTemplate  -> addJs('goesi_pic_user_ac.js', true);
	echo $this -> _oTemplate  -> addCss('uploader_bootstrap.min.css', true);
////////////////////////////////	
?>