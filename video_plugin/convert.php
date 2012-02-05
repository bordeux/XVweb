<?php
$file_format = $XVwebEngine->GetFromURL($PathInfo, 2);
$file_name = $XVwebEngine->GetFromURL($PathInfo, 3);
$file_id =(int) $file_name ;
$file_formats = array("webm", "mp4", "mp3", "ogg", "jpg");
$supported_extensions = array("mp4", "ogg", "avi", "flv");
$ffmpeg_parameters = array(
	"mp4" => "-b 1500k -vcodec libx264 -vpre slow -vpre baseline -g 30",
	"jpg" => "-an -ss 00:00:13 -an -r 1 -vframes 1 -y",
);
if(!in_array($file_format, $file_formats)){
	exit("Invalid format");
}

$file_info = $XVwebEngine->FilesClass()->GetFile($file_id);
if(empty($file_info)){
 exit("File not found");
}

$file_info['Extension'] = strtolower($file_info['Extension']);

if(!in_array($file_info['Extension'], $supported_extensions)){
 exit("This file can't be converted - invalid file type");
}

include_once(ROOT_DIR.'config'.DIRECTORY_SEPARATOR.'files.config.php');

$server_class_name = 'XV_Files_'.$file_info['Server'];
if(!class_exists($server_class_name)){
	exit("Server not found: ".$file_info['Server']. ' . Please add in config.php '.$server_class_name.' class');
}
$file_class = new $server_class_name;
$file_location = $file_class->download($file_info['MD5File'].$file_info['SHA1File']);
$file_tmp_loc = dirname(__FILE__)."/tmp/".$file_info['ID'].'.'.$file_info['Extension'];
copy($file_location, $file_tmp_loc);
$file_converterd_directory = dirname(__FILE__).'/'.$file_format.'/';

$file_converterd_name = dirname(__FILE__).'/'.$file_format.'/'.$file_info['ID'].'.'.$file_format;

$ffmpeg_loc = "/usr/local/bin/ffmpeg";
if(!file_exists($ffmpeg_loc)){
	$ffmpeg_loc = "ffmpeg";
}

if(!is_dir($file_converterd_directory))
	mkdir($file_converterd_directory);
	
	header('Location: ?converting=true');
if(PHP_OS == "WINNT"){
	$ffmpeg_loc = "ffmpeg.exe"; 
	echo exec($ffmpeg_loc.' -i '.escapeshellarg($$file_tmp_loc).' '.ifsetor($ffmpeg_parameters[$file_format], '').' '.escapeshellarg($$file_converterd_name));
}else{
	echo shell_exec($ffmpeg_loc.' -i '.escapeshellarg($file_tmp_loc).' '.ifsetor($ffmpeg_parameters[$file_format], '').' '.escapeshellarg($file_converterd_name));
}
?>