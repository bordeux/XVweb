<?php
/**************************************************************************
****************   Bordeux.NET Project            *************************
****************   File name :  CSSbinder.php     *************************
****************   Start     :   18.10.2009 r.    *************************
****************   License   :   GNU              *************************
***************************************************************************/
//JSbinder.php?Load=style:UsersList:EditArticle
if(empty($_GET['Load']))
exit("var NoLoad=true;");

	$JSFiles = explode(":", $_GET['Load']);
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
	$file =  md5(serialize($JSFiles)).'.js';
	$filegz = '../../../tmp/'.$file . '.gz';
	$makeNewGz = false;
	if (!file_exists ($filegz)) 
	$makeNewGz = true;
	
	if(!$makeNewGz){
		if((filemtime($filegz)) < filemtime($_SERVER['SCRIPT_FILENAME'])){
			$makeNewGz = true;
			unlink($filegz);
		}
	}
	

	if ($makeNewGz === true) {
		$BindFile = "";
		foreach ($JSFiles as $key=>$Value){
			$Value = preg_replace('/[^0-9a-zA-Z.-]/', '', $Value);
			if (file_exists($Value.'.js'))
			$BindFile .= ';'.file_get_contents($Value.'.js');
		}
		//include_once("class.JavaScriptPacker.php");
		//$BindFile = new JavaScriptPacker($BindFile, 0);
		//$BindFile = $BindFile->pack();
		
		$JSNoCompressFiles = array_reverse(explode(":", $_GET['NoCompress']));
		foreach ($JSNoCompressFiles as $key=>$Value){
			$Value = preg_replace('/[^0-9a-zA-Z.-]/', '', $Value);
			if (file_exists($Value.'.js'))
			$BindFile = ';'.file_get_contents($Value.'.js').';'.$BindFile;
		}
		$handle = gzopen ($filegz, 'w9');
		gzwrite ($handle, $BindFile);
		gzclose ($handle);
		chmod ($filegz, 0666);
	}


	ob_clean();
	
				$FileModification = filemtime($filegz);
				$expires =  1209600; //60*60*24*14
				if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $_SERVER['HTTP_IF_MODIFIED_SINCE'] == gmdate('D, d M Y H:i:s',$FileModification).' GMT') {
					header("HTTP/1.0 304 Not Modified");
					header('ETag: "'.$file.'"');
					header ("content-type: text/javascript; charset: UTF-8"); 
					header('XVwebMSG: "JSBinder: Not modified"');
					exit;
				}
				
	header("Pragma: public");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s", $FileModification)." GMT"); 
	header('ETag: "'.$file.'"');
	header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
	header ("content-type: text/javascript; charset: UTF-8");   
	header ('Content-Encoding: gzip');
	header ('Vary: Accept-Encoding');
	readfile($filegz);
	exit;
}
exit("var NoQZip=true;");
?>