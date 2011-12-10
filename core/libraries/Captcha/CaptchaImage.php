<?php
function GetCaptchaImage($Word, $height=30, $width=90){
$pic=ImageCreate($width,$height);
$white=ImageColorAllocate($pic,255,255,255);
$black=ImageColorAllocate($pic,0,0,0);
$gray=ImageColorAllocate($pic,150,150,150);

ImageFill($pic,1,1,$white);
for($i=0;$i<200;++$i){
    $rand1=rand(0,$width);
    $rand2=rand(0,$height);
    ImageLine($pic,$rand1,$rand2,$rand1,$rand2,$gray);
    }
    for($i=0;$i<strlen($Word) ;++$i){
    $size=rand(5,20);
    ImageString($pic,$size,$i*10+7,3,trim($Word[$i]),$black);
    }
	ob_clean();
    Header("Content-type: image/gif");
ImageGIF($pic);
}
?>