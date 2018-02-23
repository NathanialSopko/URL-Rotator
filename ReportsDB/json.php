<?php
    $json = $_POST['json'];
	$fh = fopen('ReportsList.json', 'r+') or die("can't open file");
	$stat = fstat($fh);
	if(filesize('ReportsList.json') > 4){
		//this is normal
		ftruncate($fh, $stat['size']-1);
		fclose($fh);
		$file = fopen('ReportsList.json','a');
		fwrite($file, ",");
		fwrite($file, $json);
		fwrite($file, "]");
		fclose($file);
	}
	else{
		//this means the file is empty or had less than 4 characters left (from deleting entries possibly)
		$fh = fopen( 'filelist.txt', 'w' );
		fclose($fh);
		$file = fopen('ReportsList.json','a');
		fwrite($file, "[");
		fwrite($file, $json);
		fwrite($file, "]");
		fclose($file);
	}
?>