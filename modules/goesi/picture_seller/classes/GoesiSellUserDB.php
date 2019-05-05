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
	//Time Limit hochsetzen
	
	set_time_limit(9000);
	//////////////////////////////////////
	//Album erstellen
	if ($_POST['createalbum'] != '' && $_POST['albumTitle'] != '' && $_POST['albumDesc'] != '' && $_POST['albumLand'] != '' && $_POST['albumKeywords'] != '') {
		$uri = preg_replace('#\W#', '-', $_POST['albumTitle']);
		$profileID;
		//approved | pending
		$query = mysql_query("SELECT `value` FROM `goesi_pic_seller_config` WHERE `option`='auto_accept'");
		$q = mysql_fetch_row($query);
		if ($q['0'] == 'true') {
			$status1 = 'active';
			$status2 = 'approved';
		} else {
			$status1 = 'active';
			$status2 = 'pending';
			
		}
		//
		
		if ($_POST['createalbum'] == 'own-shop' || $_POST['createalbum'] == 'own') {
		//Boonex Album
		//ID 	Caption 	Uri 	Location 	Description 	Type 	Owner 	Status 	Date 	ObjCount 	LastObjId 	AllowAlbumView
		$query = mysql_query("SELECT `ID` FROM `sys_albums` WHERE `Caption`='".addslashes($_POST['albumTitle'])."' AND `Owner`='".$profileID."'");
		$a = mysql_fetch_row($query);
		
		if (!$a['0']) {
			mysql_query("INSERT INTO `sys_albums` (
												 `Caption`,
												 `Uri`,
												 `Location`,
												 `Description`,
												 `Type`,
												 `Owner`,
												 `Status`,
												 `Date`,
												 `ObjCount`,
												 `LastObjId`,
												 `AllowAlbumView`
												 ) VALUES (
												 '".addslashes($_POST['albumTitle'])."',
												 '".$uri."',
												 '".addslashes($_POST['albumLand'])."',
												 '".addslashes($_POST['albumDesc'])."',
												 'bx_photos',
												 '".addslashes($profileID)."',
												 '".addslashes($status1)."',
												 '".addslashes(time())."',
												 '0',
												 '0',
												 '".addslashes($_POST['seenby'])."'
												 )");
			$query = mysql_query("SELECT `ID` FROM `sys_albums` WHERE `Caption`='".addslashes($_POST['albumTitle'])."'  AND `Owner`='".$profileID."'");
			$b = mysql_fetch_row($query);
			$AlbumID = $b['0'];
		} else {
			$AlbumID = $a['0'];
		}
			ob_end_clean();
			echo $AlbumID;
			exit;
			
		} else if ($_POST['createalbum'] == 'art-shop' || $_POST['createalbum'] == 'art') {
		//Art Gallerie
		$query1 = mysql_query("SELECT `ID` FROM `ayphotos_albums` WHERE `Title`='".addslashes($_POST['albumTitle'])."' AND `Owner`='".$profileID."'");
		$a = mysql_fetch_row($query1);
		if (!$a['0']) {
			mysql_query("INSERT INTO `ayphotos_albums` (`Owner`,
														`parent`,
														`Categories`,
														`Title`,
														`Uri`,
														`Desc`,
														`Country`,
														`Tags`,
														`When`,
														`Thumb`,
														`Views`,
														`CommentsCount`,
														`Rate`,
														`RateCount`,
														`AllowAlbumView`,
														`Status`) 
														VALUES (
														'".addslashes($profileID)."',
														'0',
														'".addslashes($_POST['albumCat'])."',
														'".addslashes($_POST['albumTitle'])."',
														'".addslashes($uri)."',
														'".addslashes($_POST['albumDesc'])."',
														'".addslashes($_POST['albumLand'])."',
														'".addslashes($_POST['albumKeywords'])."',
														'".addslashes(time())."',
														'0',
														'1',
														'0',
														'5',
														'1',
														'".addslashes($_POST['seenby'])."',
														'".addslashes($status2)."'
														)");
		$query2 = mysql_query("SELECT `ID` FROM `ayphotos_albums` WHERE `Title`='".addslashes($_POST['albumTitle'])."'  AND `Owner`='".$profileID."'");
		$b = mysql_fetch_row($query2);
		$AlbumID = $b['0'];
		} else {
		$AlbumID = $a['0'];
		}
		ob_end_clean();
		echo $AlbumID;
		exit;
		} else if ($_POST['createalbum'] == 'shop') {
		ob_end_clean();
		echo '1';
		exit;
		}		
	}
	//////////////////////////////////////
	
	//////////////////////////////////////
	//Delete old Files
	
	if ($_POST['delfolder'] == 'DELALL') {
	$profileID +=10000;
	$dir = dirname($_SERVER['SCRIPT_FILENAME']).'/goesi/picture_seller/templates/base/server/php/files/'.$profileID.'/';
	
	function deleteDirectory($dir) {
    if (!file_exists($dir)) return true;
    if (!is_dir($dir) || is_link($dir)) return unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!deleteDirectory($dir . "/" . $item)) {
                chmod($dir . "/" . $item, 0777);
                if (!deleteDirectory($dir . "/" . $item)) return false;
            };
        }
        return rmdir($dir);
    } 
	deleteDirectory($dir);
	ob_end_clean();
	echo 'del-true';
	exit;
	}
	
	//////////////////////////////////////
	//  Speichern der Bilder
	if ($_POST['Saveall'] == 'SaveALL' &&
		$_POST['whoAlbum'] != '' && 
		$_POST['AlbumID'] != '' && 
		$_POST['PicPrice'] != '' && 
		$_POST['ShopCate'] != '' &&
		$_POST['albumTitle'] != '' &&
		$_POST['albumDesc'] != '' &&
		$_POST['seenby'] != '' &&
		$_POST['singleImage'] != '') {
		$realprofileID = $profileID;
		$profileID +=10000;
		$uri = '';
		
		//approved | pending
		$query = mysql_query("SELECT `value` FROM `goesi_pic_seller_config` WHERE `option`='auto_accept'");
		$q = mysql_fetch_row($query);
		if ($q['0'] == 'true') {
			$status1 = 'active';
			$status2 = 'approved';
		} else {
			$status1 = 'active';
			$status2 = 'pending';
			
		}
		//
		//accept store 
		$query = mysql_query("SELECT `value` FROM `goesi_pic_seller_config` WHERE `option`='accept_store'");
		$q = mysql_fetch_row($query);
		if ($q['0'] == 'true') {
			$accept_store = 'true';
		} else {
			$accept_store = 'false';	
		}
		//
		
		
		if ($_POST['whoAlbum'] == 'art-shop' || $_POST['whoAlbum'] == 'art') {
			$query = mysql_query("SELECT `Uri` FROM `ayphotos_albums` WHERE `ID`='".$_POST['AlbumID']."'");
			$q = mysql_fetch_row($query);
			$uri = '/m/art/album/'.$q['0'].'/';
		} else if ($_POST['whoAlbum'] == 'own-shop' || $_POST['whoAlbum'] == 'own') {
			$query = mysql_query("SELECT `Uri` FROM `sys_albums` WHERE `ID`='".$_POST['AlbumID']."' AND `Type`='bx_photos'");
			$q = mysql_fetch_row($query);
			$uri = '/m/photos/browse/album/'.$q['0'].'/';
		}
		 $dir = dirname($_SERVER['SCRIPT_FILENAME']).'/goesi/picture_seller/templates/base/server/php/files/'.$profileID.'/'.$_POST['AlbumID'].'/';		
			
			$filename = $dir.$_POST['singleImage'];
			$files = glob($dir.'*.[jJ][pP][gG]');
			include_once("GoesiSellResize.php");
			
			if (file_exists($filename)) {
			//foreach ($files as $filename) {
					
					$watermark_file = $dir.'watermark_'.strtolower(basename($filename));
					$mdfilename = md5($filename).'.jpg';
					list($width, $height, $type, $attr)= getimagesize($filename);
					$urifilename = preg_replace('#\W#', '_', basename($filename));
					$title = str_replace(".jpg", "", basename($filename));
					include('GoesiSellWatermarks.php');
				
				
				
				if ($_POST['whoAlbum'] == 'art-shop' || $_POST['whoAlbum'] == 'art') {
					//Artgallerie - fertig 
					include("GoesiSellArtInput.php");
					
				} else if ($_POST['whoAlbum'] == 'own-shop' || $_POST['whoAlbum'] == 'own') {
				//Boonex - Photos
				
					include("GoesiSellOwnInput.php");
				}	
				
				if ($accept_store == 'true' && ( $_POST['whoAlbum'] == 'art-shop' || $_POST['whoAlbum'] == 'own-shop' || $_POST['whoAlbum'] == 'shop') ) {
				
				// In den Shop einfügen
				include("GoesiSellShopInput.php");	
				}
			}
				
				ob_end_clean();
				echo 'check';
				exit;
	}
	//////////////////////////////////////
	
	//////////////////////////////////////
	// Komplette Liste der Dateien ausgeben
	if ($_POST['ListALL'] == 'ListALL' && $_POST['AlbumID'] != '') {
	$profileID += 10000;
		$dir = dirname($_SERVER['SCRIPT_FILENAME']).'/goesi/picture_seller/templates/base/server/php/files/'.$profileID.'/'.$_POST['AlbumID'].'/';
		ob_end_clean();
		$files = glob($dir.'*.[jJ][pP][gG]');
		$PicList = '<table id="table">';
		foreach ($files as $filename) {
			$PicList .= '<tr>
							<td><img id="image_list" src="'.substr($_SERVER['SCRIPT_NAME'], 0 ,-9).'goesi/picture_seller/templates/base/images/img_liste.png" title="Image">'.basename($filename).'</td>
							<td text-align="left" width="100px"><img src="'.substr($_SERVER['SCRIPT_NAME'], 0 ,-9).'goesi/picture_seller/templates/base/images/wait_for_progress.gif"  title="Wait for accept" id="piclist_wait_loading" class="'.basename($filename).'"></td>
						</tr>';
		}
		$PicList .= '</table><img src="" title="Wait" id="piclist_wait_loading" class="finish">';
		
		echo $PicList;
		exit;
	}
	
	//////////////////////////////////////
?>