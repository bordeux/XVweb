<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   register.php      *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :   1.0               *************************
****************   Authors   :   XVweb team        *************************
*************************XVweb Team*****************************************
				Krzyszof Bednarczyk, meybe you
/////////////////////////////////////////////////////////////////////////////
 Klasa XVweb jest na licencji LGPL v3.0 ( GNU LESSER GENERAL PUBLIC LICENSE)
****************http://www.gnu.org/licenses/lgpl-3.0.txt********************
		Pe³na dokumentacja znajduje siê na stronie domowej projektu: 
*********************http://www.bordeux.NET/Xvweb***************************
***************************************************************************/
header("Cache-Control: no-cache, must-revalidate");
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}
function generate_image($Word, $height=30, $width=90){
	$pic=ImageCreate($width,$height);
	$white=ImageColorAllocate($pic,255,255,255);
	$colors[] = ImageColorAllocate($pic,150,150,150);
	//$colors[] = ImageColorAllocate($pic,83,191, 0);
	//$colors[] = ImageColorAllocate($pic,255, 0, 0);
	//$colors[] = ImageColorAllocate($pic,0,34, 255);
	//$colors[] = ImageColorAllocate($pic,25,45,47);

	ImageFill($pic,1,1,$white);
	for($i=0;$i<300;++$i){
		$rand1=rand(0,$width);
		$rand2=rand(0,$height);
		ImageLine($pic,$rand1,$rand2,$rand1,$rand2,$colors[rand(0, sizeof($colors)-1)]);
		}
		for($i=0;$i<strlen($Word) ;++$i){
		$size=rand(5,20);
			ImageString($pic,$size,$i*10+7,3,trim($Word[$i]), ImageColorAllocate($pic,0,0,0));
		}
		ob_clean();
		header("Content-type: image/gif");
	ImageGIF($pic);
}

function generate_key($LengthPassword = 5){
		$CharPack = "abcdefghijklmnpqrstuvwxyz123456789";
		srand((double)microtime() * 1000000);

		while(strlen($haslo) < $LengthPassword)
		{
			$znak = $CharPack[rand(0, strlen($CharPack) - 1)];
			if(!is_integer(strpos($haslo, $znak))) $haslo .= $znak;
		}
		return $haslo;
}  

$XVwebEngine->Session->Session('captcha_key', generate_key());
generate_image($XVwebEngine->Session->Session('captcha_key'), 30, 90);
exit;

?>