<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
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
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}
$Smarty->assign('xv_texts_step', 'editor');

if($XVwebEngine->Session->Session('xv_texts_title') == ''){
		header('Location: '.$URLS['Script'].'write/set_title/');
		exit;
}

include_once(dirname(__FILE__).'/../libs/editor.interface.php');

foreach (glob(dirname(__FILE__)."/../editors/*/*.editor.php") as $filename) {
   include_once($filename);
}

$class_name = "xv_texts_editor_".strtolower($XVwebEngine->GetFromURL($PathInfo, 3));

if (!class_exists($class_name)) {
		header('Location: '.$URLS['Script'].'write/select_editor/');
		exit;
}
$editor_class = new $class_name($XVwebEngine);
$xv_texts_editor_html = xvp()->get_editor($editor_class, $XVwebEngine->Session->Session('xv_texts_content'));

$Smarty->assignByRef('xv_texts_editor_html', $xv_texts_editor_html);


?>