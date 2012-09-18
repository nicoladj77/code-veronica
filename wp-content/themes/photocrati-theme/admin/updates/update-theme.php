<?php
	
   	$newdirectory = dirname(dirname(dirname(dirname(__FILE__)))).'/photocrati-theme/';
	$zipfile = 'http://www.photocrati.com/theme-update-files/photocrati-theme-v'.$_POST['theme-version'].'.zip';
   	$newzipfile = dirname(dirname(dirname(dirname(__FILE__)))).'/photocrati-theme.zip';
	
	$data = file_get_contents($zipfile);
	$file = fopen($newzipfile, "w+");
	
	if (fputs($file, $data)) {
	
		$zip = new ZipArchive;
		$res = $zip->open($newzipfile);
		if ($res === TRUE) {
			$zip->extractTo($newdirectory);
			$zip->close();
			unlink($newzipfile);
			echo 'UPDATE SUCCESSFUL!';
		} else {
			echo 'UPDATE FAILED';
		}
		
	}
	
	fclose($file);
				
?>