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

//////////////////////////////////////
//Boonex Shop/Files
	//Erstelle Hidden Album wenn nicht vorhanden
	mysql_query("INSERT IGNORE INTO `sys_albums` (`Caption`,`Uri`,`Location`,`Type`,`Owner`,`Status`,`Date`,`ObjCount`,`LastObjId`,`AllowAlbumView`) VALUES ('Hidden','Hidden','undefiniert','bx_photos','".$realprofileID."','active','".addslashes(time())."','0','0','2')");
	$mquery = mysql_query("SELECT `ID` FROM `sys_albums` WHERE `Owner`='".$realprofileID."' AND `Uri`='Hidden' AND `Type`='bx_photos'");
	$m = mysql_fetch_row($mquery);
	//Erstelle Hidden Files wenn nicht vorhanden				
	mysql_query("INSERT IGNORE INTO `sys_albums` (`Caption`,`Uri`,`Location`,`Type`,`Owner`,`Status`,`Date`,`ObjCount`,`LastObjId`,`AllowAlbumView`) VALUES ('Hidden','Hidden','undefiniert','bx_files','".$realprofileID."','active','".addslashes(time())."','0','0','2')");
	$nquery = mysql_query("SELECT `ID` FROM `sys_albums` WHERE `Owner`='".$realprofileID."' AND `Uri`='Hidden' AND `Type`='bx_files'");
	$n = mysql_fetch_row($nquery);
	//
	
	
	mysql_query("INSERT IGNORE INTO `bx_photos_main` (
														`Categories`,
														`Owner`,
														`Ext`,
														`Size`,
														`Title`,
														`Uri`,
														`Desc`,
														`Tags`,
														`Date`,
														`Views`,
														`Rate`,
														`RateCount`,
														`CommentsCount`,
														`Featured`,
														`Status`,
														`Hash`
														) VALUES (
														'Store',
														'".addslashes($realprofileID)."',
														'jpg',
														'".addslashes($width).'x'.addslashes($height)."',
														'".addslashes($title)."',
														'".addslashes($urifilename)."',
														'".addslashes($_POST['albumDesc'])."',
														'".addslashes($_POST['albumKeywords'])."',
														'".addslashes(time())."',
														'0',
														'0',
														'0',
														'0',
														'0',
														'".addslashes($status2)."',
														'".addslashes(md5('store_'.$filename))."'
														)");
				//Neue ID Abfangen										
				$sto = mysql_query("SELECT `ID` FROM `bx_photos_main` WHERE `Categories`='Store' AND `Uri`='".$urifilename."' AND `Hash`='".md5('store_'.$filename)."' AND `Owner` = '".$realprofileID."'");
				$s = mysql_fetch_row($sto);
				$vorschaufotoID = $s['0'];
							
				mysql_query("INSERT INTO `sys_albums_objects` (`id_album`,`id_object`,`obj_order`) VALUES ('".$m['0']."','".$vorschaufotoID."','0')");
				mysql_query("UPDATE `sys_albums` SET `ObjCount`=ObjCount+1, `LastObjId`='".$vorschaufotoID."' WHERE `Owner`='".$realprofileID."' AND `Uri`='Hidden' AND `Type`='bx_photos'");
							
				resizejpeg($dir, basename($watermark_file), 640, 640, 128, 128);
				rename($dir.'i_'.basename($watermark_file), dirname($_SERVER['SCRIPT_FILENAME']).'/boonex/photos/data/files/'.$s['0'].'_m.jpg');
				rename($dir.'t_'.basename($watermark_file), dirname($_SERVER['SCRIPT_FILENAME']).'/boonex/photos/data/files/'.$s['0'].'_t.jpg');	
						
				resizejpeg($dir, basename($watermark_file), 64, 64, 32, 32);
				rename($watermark_file, dirname($_SERVER['SCRIPT_FILENAME']).'/boonex/photos/data/files/'.$s['0'].'.jpg');
				rename($dir.'i_'.basename($watermark_file), dirname($_SERVER['SCRIPT_FILENAME']).'/boonex/photos/data/files/'.$s['0'].'_rt.jpg');
				rename($dir.'t_'.basename($watermark_file), dirname($_SERVER['SCRIPT_FILENAME']).'/boonex/photos/data/files/'.$s['0'].'_ri.jpg');
				
				mysql_query("INSERT INTO `bx_store_products` (  `title`,
																`uri`,
																`desc`,
																`status`,
																`thumb`,
																`created`,
																`author_id`,
																`tags`,
																`categories`,
																`views`,
																`rate`,
																`rate_count`,
																`comments_count`,
																`featured`,
																`price_range`,
																`allow_view_product_to`,
																`allow_post_in_forum_to`
																) VALUES (
																'".addslashes($title)."',
																'".addslashes($urifilename)."',
																'".addslashes($_POST['albumDesc'])."',
																'".addslashes($status2)."',
																'".addslashes($vorschaufotoID)."',
																'".addslashes(time())."',
																'".addslashes($realprofileID)."',
																'".addslashes($_POST['albumKeywords'])."',
																'".addslashes($_POST['ShopCate'])."',
																'0',
																'0',
																'0',
																'0',
																'0',
																'%s".$_POST['PicPrice']."',
																'3',
																'c'
																)");
																
				$proquery = mysql_query("SELECT `ID` FROM `bx_store_products` WHERE thumb='".$vorschaufotoID."' AND `author_id`='".$realprofileID."'");												
				$pr = mysql_fetch_row($proquery);
				
				mysql_query("INSERT INTO `bx_store_product_images` (`entry_id`,`media_id`) VALUES ('".$pr['0']."','".$vorschaufotoID."')");
				
				$aFileInfo = array (
					'medTitle' => $title,
					'medDesc' => $_POST['albumDesc'],
					'medTags' => 'store',
					'Categories' => 'Store',
					'Type' => 'text/plain',
				);
	
				$iRet = BxDolService::call('files', 'perform_file_upload', array($filename, $aFileInfo), 'Uploader');
				$filquery = mysql_query("SELECT `ID` FROM `bx_files_main` WHERE `Owner`='".$realprofileID."' ORDER BY `ID` DESC LIMIT 1");
				$filID = mysql_fetch_row($filquery);
				
				mysql_query("UPDATE `bx_files_main` SET `Categories`='Store' WHERE `ID`=".$filID['0']."");
				mysql_query("INSERT INTO `bx_store_product_files` (`author_id`,`entry_id`,`media_id`,`price`,`allow_purchase_to`,`hidden`) VALUES('".addslashes($realprofileID)."','".$pr['0']."','".$filID['0']."','".$_POST['PicPrice']."','4','0')");
				unlink($filename);
				//rename($filename, dirname($_SERVER['SCRIPT_FILENAME']).'/boonex/files/data/files/'.$filID['0'].'_'.md5($filename));
				
				

?>