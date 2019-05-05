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
//Art Gallerie

$query = mysql_query("SELECT `ID` FROM `ayphotos_units` WHERE `Filename`='".$mdfilename."'  AND `AlbumID`='".$_POST['AlbumID']."'");
$q = mysql_fetch_row($query);
	if ($q['0']) {
		mysql_query("UPDATE `ayphotos_units` SET AlbumID = '".addslashes($_POST['AlbumID'])."',
												 Title = '".addslashes($title)."', 
												 Uri = '".addslashes($urifilename)."',
												 When = '".addslashes(time())."',
												 Size = '".addslashes($width).'x'.addslashes($height)."'
												 WHERE `Filename`='".addslashes($mdfilename)."'");
	} else {
		mysql_query("INSERT INTO `ayphotos_units` ( `AlbumID`,
													`Title`,
													`Uri`,
													`When`,
													`Size`,
													`Filename`,
													`License`,
													`Adult`,
													`Views`,
													`CommentsCount`,
													`Rate`,
													`RateCount`
													) VALUES (
													'".addslashes($_POST['AlbumID'])."',
													'".addslashes($title)."',
													'".addslashes($urifilename)."',
													'".addslashes(time())."',
													'".addslashes($width).'x'.addslashes($height)."',
													'".addslashes($mdfilename)."',
													'',
													'0',
													'0',
													'0',
													'0',
													'0'
													)");		
																   
		$alb = mysql_query("SELECT `ID`,`AlbumID` FROM `ayphotos_units` WHERE `Uri`='".$urifilename."' AND `AlbumID`='".$_POST['AlbumID']."'");
		$a = mysql_fetch_row($alb);
		mysql_query("UPDATE `ayphotos_albums` SET `Thumb`='".$a['0']."' WHERE `ID`='".$a['1']."'");
		}
						
	resizejpeg($dir, basename($watermark_file), 800, 800, 128, 128);
	copy($watermark_file, dirname($_SERVER['SCRIPT_FILENAME']).'/aramis/art/data/files/'.$mdfilename);
	rename($dir.'i_'.basename($watermark_file), dirname($_SERVER['SCRIPT_FILENAME']).'/aramis/art/data/files/i_'.$mdfilename);
	rename($dir.'t_'.basename($watermark_file), dirname($_SERVER['SCRIPT_FILENAME']).'/aramis/art/data/files/t_'.$mdfilename);

//////////////////////////////////////
?>