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

***************************************************************************
 * function resizejpeg:
 *
 *  = creates a resized image based on the max width
 *    specified as well as generates a thumbnail from
 *    a rectangle cut from the middle of the image.
 *
 *    @dir   = directory image is stored in
 *    @img   = the image name
 *    @max_w = the max width of the resized image
 *    @max_h = the max height of the resized image
 *    @th_w  = the width of the thumbnail
 *    @th_h  = the height of the thumbnail
 *
 **********************************************************/

function resizejpeg($dir, $img, $max_w, $max_h, $max_th_w, $max_th_h)
{
    // get original images width and height
    list($or_w, $or_h, $or_t) = getimagesize($dir.$img);

    // make sure image is a jpeg
    if ($or_t == 2) {
   
        // obtain the image's ratio
        $ratio = ($or_h / $or_w);

        // original image
        $or_image = imagecreatefromjpeg($dir.$img);

        // resize image
        if ($or_w > $max_w || $or_h > $max_h) {

            // first resize by width (less than $max_w)
            if ($or_w > $max_w) {
                $rs_w = $max_w;
				$th_w = $max_th_w;
                $rs_h = $ratio * $max_h;
				$th_h = $ratio * $max_th_h;
            } else {
                $rs_w = $or_w;
				$th_w = $or_w;
                $rs_h = $or_h;
				$th_h = $or_h;
            }

            // then resize by height (less than $max_h)
            if ($rs_h > $max_h) {
                $rs_w = $max_w / $ratio;
				$th_w = $max_th_w / $ratio;
                $rs_h = $max_h;
				$th_h = $max_th_h;
            }

            // copy old image to new image
            $rs_image = imagecreatetruecolor($rs_w, $rs_h);
            imagecopyresampled($rs_image, $or_image, 0, 0, 0, 0, $rs_w, $rs_h, $or_w, $or_h);
        } else {
            $th_w = $rs_w = $or_w;
            $th_h = $rs_h = $or_h;
			

            $rs_image = $or_image;
        }
   
        // generate resized image
        imagejpeg($rs_image, $dir.'i_'.$img, 100);
		
        $th_image = imagecreatetruecolor($th_w, $th_h);

        // cut out a rectangle from the resized image and store in thumbnail
        //$new_w = (($rs_w / 6));
        //$new_h = (($rs_h / 6));

        imagecopyresampled($th_image, $or_image, 0, 0, 0, 0, $th_w, $th_h, $or_w, $or_h);

        // generate thumbnail
        imagejpeg($th_image, $dir.'t_'.$img, 100);
		imagedestroy($th_image);
		imagedestroy($rs_image);
        return true;
    }
   
    // Image type was not jpeg!
    else {
        return false;
    }
}
?>