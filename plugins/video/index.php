<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   file.php          *************************
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
	exit;
}

include_once(ROOT_DIR.'config'.DIRECTORY_SEPARATOR.'files.config.php');
$XVwebEngine->FilesClass()->Date['FilesDir'] = $UploadDir;

$id_file = $XVwebEngine->GetFromURL($PathInfo, 2);


if(empty($id_file) || !is_numeric($id_file)){
		$Smarty->assign('error', "bad_id_file");
}else{

	$file_info = $XVwebEngine->FilesClass()->GetFile($id_file);
		if(empty($file_info["ID"])){
				$Smarty->assign('error', "bad_id_file");
	}else{
		$file_info['FileSize'] = $XVwebEngine->FilesClass()->size_comp($file_info['FileSize']);
		$Smarty->assign('file_info', $file_info);
	}
}
	
$Smarty->display(dirname(__FILE__).'/video_show.tpl');

?>