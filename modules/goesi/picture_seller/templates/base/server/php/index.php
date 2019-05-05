<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

error_reporting(E_ALL | E_STRICT);

//Read User Daten und erstelle neue Verzeichnisse
@$user_id = $_POST['user_id'];
@$AlbumID = $_POST['newalbumID'];
$img_folder = dirname($_SERVER['SCRIPT_FILENAME']).'/files/'.$user_id.'/'.$AlbumID.'/';

	if (is_dir($img_folder) == false ) { 
		if (!mkdir($img_folder, 0777, true)) {
		die('Failed to write file to disk.');
		}
	}

//

require('upload.class.php');
$upload_handler = new UploadHandler();
