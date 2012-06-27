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
$Smarty->assign('xv_texts_step', 'select_editor');

if(isset($_POST['texts']['title'])){
	if($XVwebEngine->Session->get_sid() != $_POST['xv-sid']){
		header('Location: '.$URLS['Script'].'write/');
		exit;
	}
	if(strlen($_POST['texts']['title']) < 1){
		header('Location: '.$URLS['Script'].'Page/Texts/Wrong_title/');
		exit;
	}
	$XVwebEngine->Session->Session('xv_texts_title', $_POST['texts']['title']);
	header('Location: '.$URLS['Script'].'write/select_editor/');
	exit;
}
if($XVwebEngine->Session->Session('xv_texts_title') == ''){
		header('Location: '.$URLS['Script'].'write/set_title/');
		exit;
}

include_once(dirname(__FILE__).'/../libs/editor.interface.php');

foreach (glob(dirname(__FILE__)."/../editors/*/*.editor.php") as $filename) {
   include_once($filename);
}
$xv_texts_class_prefix = "xv_texts_editor_";
$xv_texts_editors_classes = $XVwebEngine->get_classes_by_prefix("xv_texts_editor_");
$xv_texts_buttons = array();
foreach($xv_texts_editors_classes as $class_name){
	$editor_class = new $class_name($XVwebEngine);
	$xv_texts_buttons[] = array(
		"html"  => $editor_class->get_button(),
		"class" => substr($class_name, strlen($xv_texts_class_prefix)),
		"name" => $editor_class->editor_name
	);
}
$Smarty->assignByRef('xv_texts_buttons', $xv_texts_buttons);


?>