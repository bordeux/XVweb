<?php
set_time_limit(0);
header('Content-type: text/html;');
if (ob_get_level() == 0) ob_start();

?><!doctype html>
<html>
  <head>
    <title>XVweb Installer</title>
	</head>
	<body style="padding-bottom: 100px;">
<?php
function send_message($x){
        echo $x;
        echo str_pad('',4096)."<br /><script>window.scrollBy(100,100);</script>";
        ob_flush();
        flush();
}
$last_percent = 0;
function progress_bar($download_size, $downloaded, $upload_size, $uploaded){
	global $last_percent;
	
	if($download_size)
    $percent=round(($downloaded/$download_size)*100);
	else $percent = 0;
	if($percent > $last_percent){
		send_message(str_repeat("#", $percent).' '.$percent."%");
		$last_percent = $percent;
	}
}
function download_file($file, $local_path, $newfilename) 
{ 
    $err_msg = ''; 
	send_message("Downloading file ".$file);
    $out = fopen($newfilename, 'wb'); 
    if ($out == FALSE){ 
      print "File not opened<br>"; 
      exit; 
    } 
    $ch = curl_init();    
    curl_setopt($ch, CURLOPT_FILE, $out); 
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_URL, $file); 
	curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, 'progress_bar');
	curl_setopt($ch, CURLOPT_NOPROGRESS,false);
	curl_setopt($ch, CURLOPT_BUFFERSIZE,64000);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_exec($ch); 
    curl_close($ch); 

}
download_file('https://nodeload.github.com/bordeux/XVweb/zipball/master',dirname(__FILE__).'/', 'xvweb.zip');
send_message("<span style='color: #00A305;'>File downloaded</span>");
send_message("Unziping file xvweb.zip");

    $zip = new ZipArchive;
     $res = $zip->open(dirname(__FILE__).'/xvweb.zip');
     if ($res === TRUE) {
		 
		$dirname_extract = $zip->statIndex(0);
		$dirname_extract = dirname(__FILE__).'/'.$dirname_extract['name'];
		send_message("Extract to ".$dirname_extract);
        $zip->extractTo(dirname(__FILE__).'/');
        $zip->close();
         send_message("<span style='color: #00A305;'>Unzip done</span>");
     } else {
        send_message("<span style='color: #D90000;'>Unzip failed</span>");
		exit;
     }
 send_message("Deleting xvweb.zip");
if(unlink(dirname(__FILE__).'/xvweb.zip')){
 send_message("<span style='color: #00A305;'>Deleted xvweb.zip</span>");
}else{
 send_message("<span style='color: #D90000;'>Delete problem with xvweb.zip</span>");
}

 send_message("Deleting ".basename(__FILE__));
if(unlink(__FILE__)){
 send_message("<span style='color: #00A305;'>Deleted ".basename(__FILE__).'</span>');
}else{
 send_message("<span style='color: #D90000;'>Delete problem with ".basename(__FILE__).'</span>');
}

send_message("Moving system files to root dir");

foreach(scandir($dirname_extract) as $file){
	if($file == "." || $file == ".."){
		
	}else{
		send_message("Moving ".$file);
		if(rename($dirname_extract.$file, dirname(__FILE__).'/'.$file)){
			send_message("<span style='color: #00A305;'>Moved done ".$file.'</span>');
		}else{
			send_message("<span style='color: #D90000;'>Moved error ".$file.'</span>');
		}
	}
}

send_message("Moving done");
send_message("Now refresh the page");
send_message("<script>location.href='install/'; </script>");

ob_end_flush();

?>