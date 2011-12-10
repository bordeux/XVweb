<?php
/**************************************************************************
****************   Bordeux.NET Project            *************************
****************   File name :  CSSbinder.php     *************************
****************   Start     :   18.10.2009 r.    *************************
****************   License   :   GNU              *************************
***************************************************************************/
//CSSbinder.php?Load=style:UsersList:EditArticle
if(empty($_GET['Load']))
exit;	
	$CSSFiles = explode(":", $_GET['Load']);
if (substr_count ($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
	$file =  md5(serialize($CSSFiles)).'.css';
	$filegz = '../compile/'.$file . '.gz';
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
		foreach ($CSSFiles as $key=>$Value){
			$Value = preg_replace('/[^0-9a-zA-Z]/', '', $Value);
			if (file_exists($Value.'.css'))
			$BindFile .= ' '.file_get_contents($Value.'.css');
		}
		$BindFile = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $BindFile);
		$BindFile = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $BindFile);
		$handle = gzopen ($filegz, 'w9');
		gzwrite ($handle, $BindFile);
		gzclose ($handle);
		chmod ($filegz, 0666);
	}


	ob_clean();
	header ("content-type: text/css; charset: UTF-8");  
	header ("cache-control: must-revalidate");  
	header ('Content-Encoding: gzip');
	header ('Vary: Accept-Encoding');
	readfile($filegz);
	exit;
}
		$BindFile = "";
		foreach ($CSSFiles as $key=>$Value){
			$Value = preg_replace('/[^0-9a-zA-Z]/', '', $Value);
			if (file_exists($Value.'.css'))
			$BindFile .= ' '.file_get_contents($Value.'.css');
		}
		$BindFile = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $BindFile);
		$BindFile = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $BindFile);
echo $BindFile;
?>