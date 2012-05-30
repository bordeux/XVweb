<!DOCTYPE html>
<html>
<head>
<title>Captcha</title>
<style>
* {
border: none;
}
</style>
</head>

<body style='width: 200px;'>
<div style='float:left;'><img src='<?=$URLS['Script'];?>Captcha/image/captcha.gif?rand=<?=uniqid();?>' /></div>
<div style='float:left;'>		
<a tabIndex='-1' href='<?=$URLS['Script'];?>Captcha/Audio/?rand=<?=uniqid();?>' rel='nofollow'><img src='<?= $URLS['Theme']; ?>img/audio_icon.png' alt='Audio Captcha' /></a> <br />
<a tabIndex='-1' href='?rand=<?=uniqid();?>' >
	<img src='<?= $URLS['Theme']; ?>img/refresh_icon.png'/>
</a>
</div>

			
</body>

</html>