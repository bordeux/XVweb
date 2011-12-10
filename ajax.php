<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   receiver.php      *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :   1.0               *************************
****************   Authors   :   XVweb team        *************************
*************************XVweb Team*****************************************
				Krzyszof Bednarczyk, meybe you
/////////////////////////////////////////////////////////////////////////////
 Klasa XVweb jest na licencji LGPL v3.0 ( GNU LESSER GENERAL PUBLIC LICENSE)
****************http://www.gnu.org/licenses/lgpl-3.0.txt********************
		Pełna dokumentacja znajduje się na stronie domowej projektu: 
*********************http://www.bordeux.NET/Xvweb***************************
***************************************************************************/
header("Cache-Control: no-cache, must-revalidate");
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit();
}
if($XVwebEngine->Plugins()->Menager()->event("pre.ajax")) eval($XVwebEngine->Plugins()->Menager()->event("pre.ajax"));

$Command = strtolower($XVwebEngine->GetFromURL($PathInfo, 2));


if(empty($Command)){
		header("location: ".$URLS['Script'].'System/Error/?line='.(__LINE__).'&file='.urlencode(__FILE__).'&msg=Command+field+is+empty');
	exit;
}
$ClassName = 'XV_Ajax_'.$Command;
if(file_exists(($RootDir.'plugins'.DIRECTORY_SEPARATOR.'ajax'.DIRECTORY_SEPARATOR.$Command.'.php'))){ // zabezpieczenie przed ..
	include_once(($RootDir.'plugins'.DIRECTORY_SEPARATOR.'ajax'.DIRECTORY_SEPARATOR.$Command.'.php'));
}

if (class_exists($ClassName)) {
    $AjaxClass = new $ClassName($XVwebEngine);
	if(method_exists($AjaxClass, 'run'))
		 $AjaxClass->run();
}else{
	header("location: ".$URLS['Script'].'System/Error/?line='.(__LINE__).'&file='.urlencode(__FILE__).'&msg=Command+not+found');
	exit;
}



?>