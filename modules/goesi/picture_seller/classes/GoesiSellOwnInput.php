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
//Boonex Photos - Fertig
$query = mysql_query("SELECT `ID` FROM `bx_photos_main` WHERE `Uri`='".$urifilename."' AND `Hash`='".md5($filename)."' AND `Owner`='".$realprofileID."'");
					$q = mysql_fetch_row($query);
					
						if ($q['0']) {
								mysql_query("UPDATE `bx_photos_main` SET 
																		 `Owner` = '".addslashes($realprofileID)."',
																		 `Ext` = 'jpg',
																		 `Size` = '".addslashes($width).'x'.addslashes($height)."',
																		 `Title` = '".addslashes($title)."',
																		 `Desc` = '".$_POST['albumDesc']."',
																		 `Tags` = '".$_POST['albumKeywords']."',
																		 `Date` = '".addslashes(time())."',
																		 `Views` = '0',
																		 `Rate` = '0',
																		 `RateCount` = '0',
																		 `CommentsCount` = '0',
																		 `Featured` = '0',
																		 `Status` = '".addslashes($status2)."',
																		 `Hash` = '".addslashes(md5($filename))."'
																   WHERE `Uri`='".$urifilename."'
																		 ");
								$alb = mysql_query("SELECT `ID` FROM `bx_photos_main` WHERE `Uri`='".$urifilename."' `Hash`='".md5($filename)."' AND `Owner`='".$realprofileID."'");
								$a = mysql_fetch_row($alb);
						} else {
							
								mysql_query("INSERT INTO `bx_photos_main` (
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
																			'Profile photos',
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
																			'".addslashes(md5($filename))."'
																			)");
							//echo "SELECT `ID` FROM `bx_photos_main` WHERE `Uri`='".$urifilename."' AND `Hash`='".md5($filename)."' AND `Owner`='".$realprofileID."'";												
							$alb = mysql_query("SELECT `ID` FROM `bx_photos_main` WHERE `Uri`='".$urifilename."' AND `Hash`='".md5($filename)."' AND `Owner`='".$realprofileID."'");
							$a = mysql_fetch_row($alb);
							mysql_query("INSERT INTO `sys_albums_objects`(`id_album`,`id_object`,`obj_order`) 
																  VALUES ('".addslashes($_POST['AlbumID'])."','".$a['0']."','0')");
							mysql_query("UPDATE `sys_albums` SET `LastObjId`='".$a['0']."',`ObjCount`=ObjCount+1 WHERE `ID`='".addslashes($_POST['AlbumID'])."'");												
						}
						
						resizejpeg($dir, basename($watermark_file), 640, 640, 128, 128);
						rename($dir.'i_'.basename($watermark_file), dirname($_SERVER['SCRIPT_FILENAME']).'/boonex/photos/data/files/'.$a['0'].'_m.jpg');
						rename($dir.'t_'.basename($watermark_file), dirname($_SERVER['SCRIPT_FILENAME']).'/boonex/photos/data/files/'.$a['0'].'_t.jpg');	
						
						resizejpeg($dir, basename($watermark_file), 64, 64, 32, 32);
						copy($watermark_file, dirname($_SERVER['SCRIPT_FILENAME']).'/boonex/photos/data/files/'.$a['0'].'.jpg');
						rename($dir.'i_'.basename($watermark_file), dirname($_SERVER['SCRIPT_FILENAME']).'/boonex/photos/data/files/'.$a['0'].'_rt.jpg');
						rename($dir.'t_'.basename($watermark_file), dirname($_SERVER['SCRIPT_FILENAME']).'/boonex/photos/data/files/'.$a['0'].'_ri.jpg');
//////////////////////////////////////
?>