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

$TMPFileDir = ROOT_DIR.'tmp'.DIRECTORY_SEPARATOR;
$XVwebEngine->FilesClass()->Date['FilesDir'] = $UploadDir;
$IDFile = $XVwebEngine->GetFromURL($PathInfo, 2);
if(!empty($IDFile)){
	if(!is_numeric($IDFile)){
		header("location: ".$URLS['Script'].'System/BadIDFile/');
		exit;
	}
	
	
	if(isset($_GET['Delete']) && $_GET['SIDCheck'] == $GLOBALS['XVwebEngine']->Session->GetSID()){
		try {
			$XVwebEngine->FilesClass()->DeleteFile($IDFile);
		} catch (XVwebException $e) {
			if($e->getCode() == 1) 
			header("location: ".$URLS['Script'].'System/AccessDenied/'); else
			header("location: ".$URLS['Script'].'System/Error/');
			exit;
		}
		header("location: ".$URLS['Script'].'System/FileDeleted/');
		exit;
	}
	function DetectType(){
	global $FileInfo, $ctype, $IsImage, $viewFileHeader;
			switch ($FileInfo['Extension']) {
				case "pdf": $ctype="application/pdf"; break;
				case "exe": $ctype="application/octet-stream"; break;
				case "zip": $ctype="application/zip"; break;
				case "doc": $ctype="application/msword"; break;
				case "xls": $ctype="application/vnd.ms-excel"; break;
				case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
				case "gif": $ctype="image/gif"; $IsImage= true; $viewFileHeader= ""; break; 
				case "png": $ctype="image/png"; $IsImage= true; $viewFileHeader= ""; break;
				case "bmp": $ctype="image/bmp"; $IsImage= true; $viewFileHeader= ""; break;
				case "jpeg":$ctype="image/jpg"; $IsImage= true; $viewFileHeader= ""; break;
				case "jpg": $ctype="image/jpg"; $IsImage= true; $viewFileHeader= "";break;
				case "swf": $ctype="application/x-shockwave-flash"; $IsImage= true; $viewFileHeader= "";break;
				default: $ctype="application/force-download";
			}
	}
	if(($XVwebEngine->GetFromURL($PathInfo, 3))){
	if(!xv_perm("DownloadFile")){
		header("location: ".$URLS['Script'].'System/AccessDenied/?flag=DownloadFile');
		exit;
	}
		$FileInfo = $XVwebEngine->FilesClass()->GetFile($IDFile, true);
		if($XVwebEngine->Plugins()->Menager()->event("onPreDownload")) eval($XVwebEngine->Plugins()->Menager()->event("onPreDownload"));
		
		$viewFileHeader=" attachment;";
		$IsImage = false;
		if(isset($_GET['Download'])) $ctype="application/force-download"; else{
				 DetectType();
		}
		$NameClassFile = 'xv_files_'.$FileInfo['Server'];
		if(!class_exists($NameClassFile)){
			exit("Server not found: ".$FileInfo['Server']. ' . Please add in config.php '.$NameClassFile.' class');
		}
		$ClassFile = new $NameClassFile;
		
		$FileLocation = $ClassFile->download($FileInfo['MD5File'].$FileInfo['SHA1File']);
		
		@set_time_limit(0);
		if($viewFileHeader=="" && $IsImage && ((isset($_GET['width']) && is_numeric($_GET['width'])) or (isset($_GET['height']) && is_numeric($_GET['height'])))){
		$Old = $FileLocation;
		$FileLocation = Cache_dir.$FileInfo['MD5File'].$FileInfo['SHA1File'].(isset($_GET['width']) ? $_GET['width'] :"").'x'.(isset($_GET['height']) ? $_GET['height'] :"").'.'.$FileInfo['Extension'];
		if(!file_exists($FileLocation)){
					include_once($LocationXVWeb.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'ResizeImage.class.php');
						$image = new SimpleImage();
						$image->load($Old);
						if(isset($_GET['height']))
						$image->resizeToHeight($_GET['height']);
						if(isset($_GET['width']))
						$image->resizeToWidth($_GET['width']);
						$image->save($FileLocation);					
			}
					
		}
		if($ctype == "application/zip"){
		$Zip = $XVwebEngine->GetFromURL($PathInfo, 4);
			if(!empty($Zip)){
			$FileInZip = substr($PathInfo, strlen('/File/'.$XVwebEngine->GetFromURL($PathInfo, 2).'/'.$XVwebEngine->GetFromURL($PathInfo, 3).'/'), -1);
			$ZipFileLoc = $FileLocation;
			$FileInfo['MD5File'] = md5(('zip://' .$FileLocation. '#'.$FileInZip));
			$FileLocation = (Cache_dir.$FileInfo['MD5File']);
			if(!file_exists($FileLocation)){
				if(!@file_put_contents($FileLocation , file_get_contents('zip://' .$ZipFileLoc. '#'.$FileInZip))){
					header("location: ".$URLS['Script'].'System/BadIDFile/');
					exit;
					}
				}

			$FileInfo['Extension'] = pathinfo($FileInZip, PATHINFO_EXTENSION);
			$FileInfo['FileName'] = pathinfo($FileInZip, PATHINFO_FILENAME );
			
				DetectType();
			}
		}
		ob_clean();
		header("Pragma: public");
		header("Expires: Sat, 26 Jul 2012 05:00:00 GMT");
		header("Etag: ".$FileInfo['MD5File']); 
		header("Cache-Control: maxage=50000, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: ".$ctype);
		header("Content-Disposition:".$viewFileHeader." filename=\"".$FileInfo['FileName'].'.'.$FileInfo['Extension']."\";");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($FileLocation));
		$DownloadRate = $XVwebEngine->Config("config")->find('config downloadlimit')->text();
		if(!empty($DownloadRate) && $DownloadRate != 0){
		flush();
		$file = fopen($FileLocation , "r");    
				while(!feof($file)) {
					print fread($file, round($DownloadRate * 1024));    
					flush();
					sleep(1);    
				}    
		fclose($file);
	}else {
			@readfile($FileLocation ) or die($Language['Error']);
		}
		exit;

	}
	$FileInfo = $XVwebEngine->FilesClass()->GetFile($IDFile);
	if(is_null($FileInfo["ID"])){
			header("location: ".$URLS['Script'].'System/BadIDFile/');
			exit;
	}
	
	$FileInfo['FileSize'] = $XVwebEngine->FilesClass()->size_comp($FileInfo['FileSize']);
	$Smarty->assign('File', $FileInfo);
	$Smarty->assign('FileInfo', true);
	$Smarty->assign('IntervalTime', sprintf($Language['IntervalTime'], ($XVwebEngine->FilesClass()->Date['CacheTime'] / 60) ));
	$Smarty->display('file_show.tpl');
	exit;
}

if(isset($_GET['SendFile']) && is_array($_FILES['UploadForm'])){
		if(!(xv_perm('AddFile'))){
			header("location: ".$URLS['Script'].'System/AccessDenied/');
			exit;
		}
	$SaveFiles = array();
	foreach ($_FILES['UploadForm']['tmp_name'] as $Key=>$TMPLocation){
		$strUploadDir = $TMPFileDir . $_FILES['UploadForm']['name'][$Key];
		if(move_uploaded_file($TMPLocation, $strUploadDir ) )
			$SaveFiles[] = $XVwebEngine->FilesClass()->AddFile($strUploadDir); else
			$SaveFiles[] =  array("Result"=>"Failed");
		if($XVwebEngine->Plugins()->Menager()->event("onUploadFile")) eval($XVwebEngine->Plugins()->Menager()->event("onUploadFile"));
	}
	unset($TMPLocation);
	$Smarty->assign('ViewCode', true);
	$Smarty->assign('FileList', $SaveFiles);
	$Smarty->display('file_show.tpl');
	exit;
}
$Smarty->assign('UploadForm', true);
$Smarty->display('file_show.tpl');
?>