<?php
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}
if ($XVwebEngine->Config("config")->find("config dropbox backup enable")->html() == "true"){
	require dirname(__FILE__).DIRECTORY_SEPARATOR.'DropboxUploader.php';
	$uploader = new DropboxUploader($XVwebEngine->Config("config")->find("config dropbox mail")->html(), $XVwebEngine->Config("config")->find("config dropbox password")->html());
	$uploader->setCaCertificateFile(dirname(__FILE__).DIRECTORY_SEPARATOR.'certificate.cer');
	$uploader->upload($SQLFile.'.gz' , '/backups');
}