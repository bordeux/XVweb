<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   messages.php      *************************
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
if(!xv_perm("texts_create_page")){
	header("location: ".$URLS['Script'].'Page/System/Permissions/texts_create_page/');
	exit;
}
include_once(dirname(__FILE__)."/libs/texts.class.php");
$xv_texts = &$XVwebEngine->load_class("xv_texts");
$xv_step = strtolower($XVwebEngine->GetFromURL($PathInfo, 2));

switch ($xv_step) {
    case "select_editor":
        include_once(dirname(__FILE__)."/write_steps/select_editor.step.php");
        break;
    case "set_title":
        include_once(dirname(__FILE__)."/write_steps/set_title.step.php");
        break;    
	case "editor":
        include_once(dirname(__FILE__)."/write_steps/editor.step.php");
        break;	
	case "preview":
        include_once(dirname(__FILE__)."/write_steps/preview.step.php");
        break;
	case "save":
        include_once(dirname(__FILE__)."/write_steps/save.step.php");
        break;
    default:
        include_once(dirname(__FILE__)."/write_steps/select_category.step.php");
        break;
}

$Smarty->display('texts/write_index.tpl');
?>