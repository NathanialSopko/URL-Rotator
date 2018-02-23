<?php
    $json = $_POST['json'];
	
	$log = fopen('log.txt','a');
	
	$fh = fopen('ReportsList.json', 'r+') or die("can't open file");
	$stat = fstat($fh);
	if(filesize('ReportsList.json') > 4){
		//this is normal
		fclose($fh);
		$file = file_get_contents('ReportsList.json', FILE_USE_INCLUDE_PATH);
		$chars = str_split($file);
		$length = sizeof($chars);
		$search = strpos($file, $json);
		$start = 0;
		$end = 0;
		if ($search !== false) {
			$start = $search;
			if($chars[$search-2]== ','){
				//comma, go two back
				$start = $start - 2;
				$end = $start;
				for ($x = $search; $x <= $length; $x++) {
					if($chars[$x] == '}'){
						$end = $x;
						break;
					}
				}
			}
			else{
				if($chars[$search-2] == '['){
					//bracket, go one back
					$start = $start - 1;
					$end = $start;
					for ($x = $search; $x <= $length; $x++) {
						if($chars[$x] == '}'){
							if($chars[$x + 1] == ']'){
								$end = $x;
							}
							else{
								$end = $x+1;
							}
							break;
						}
					}
				}
				//error
			}
		}
		$end = ($end - $length) + 1;
		$newFile = substr_replace($file, '', $start, $end);
		$fh = fopen('ReportsList.json', 'w');
		fclose($fh);
		$file = fopen('ReportsList.json','a');
		fwrite($file, $newFile);
		fclose($file);
	}
	else{
		fclose($fh);
		//this means the file is empty or had less than 4 characters left (from deleting entries possibly)
		$fh = fopen( 'ReportsList.json', 'w' );
		fclose($fh);
	}
	
	fclose($log);
?>