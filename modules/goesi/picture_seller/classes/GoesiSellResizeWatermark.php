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

//Wasserzeichen bearbeiten:
	   function resize_png_image($img,$newWidth,$newHeight,$target){
		$srcImage=imagecreatefrompng($img);
		if($srcImage==''){
			return FALSE;
		}
		$srcWidth=imagesx($srcImage);
		$srcHeight=imagesy($srcImage);
		$percentage=(double)$newWidth/$srcWidth;
		$destHeight=round($srcHeight*$percentage)+1;
		$destWidth=round($srcWidth*$percentage)+1;
		if($destHeight > $newHeight){
			// if the width produces a height bigger than we want, calculate based on height
			$percentage=(double)$newHeight/$srcHeight;
			$destHeight=round($srcHeight*$percentage)+1;
			$destWidth=round($srcWidth*$percentage)+1;
		}
		$destImage=imagecreatetruecolor($destWidth-1,$destHeight-1);
		if(!imagealphablending($destImage,FALSE)){
			return FALSE;
		}
		if(!imagesavealpha($destImage,TRUE)){
			return FALSE;
		}
		if(!imagecopyresampled($destImage,$srcImage,0,0,0,0,$destWidth,$destHeight,$srcWidth,$srcHeight)){
			return FALSE;
		}
		if(!imagepng($destImage,$target)){
			return FALSE;
		}
		imagedestroy($destImage);
		imagedestroy($srcImage);
		return TRUE;
		}	
	   
	   //
?>