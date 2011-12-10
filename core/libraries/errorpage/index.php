<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
if(isset($_POST['ajax']) || isset($_GET['ajax'])){
?>
<b>Error</b><br />
<textarea style="color: black; border:none; background-color: transparent; width:90%; height:100px;"><?php echo $ErrorPage['Message3']; ?></textarea>
<?php
exit;
}?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> <?php echo $ErrorPage['Title']; ?> </title>
<link rel="stylesheet" type="text/css" href="<?php echo $ErrorPage['URLS']['Site']; ?>core/libraries/errorpage/style.css" media="screen" />
<!--[if lte IE 7]>
<link rel="stylesheet" type="text/css" href="<?php echo $ErrorPage['URLS']['Site']; ?>core/libraries/errorpage/styleie7.css" media="screen" />
<![endif]-->
</head>
<body>
<div id="cjsp-wrapper">
<div id="cjsp-logo">
	<a href="<?php echo $ErrorPage['URLS']['Site']; ?>" title="xdfcgvhk jn">
		<img class="cjsp-pngfix" src="<?php echo $ErrorPage['URLS']['Site']; ?>core/libraries/errorpage/images/logo.png" alt="<?php echo $ErrorPage['SiteName']; ?>" />
	</a>
</div><!-- /logo -->
<div id="cjsp-content" class="cjsp-pngfix">
    <div class="cjsp-topsection">
	<h1 class="cjsp-heading"><?php echo $ErrorPage['Title']; ?></h1><!-- /heading -->
	<p class="cjsp-msg"><?php echo $ErrorPage['Message']; ?></p><!-- /message -->
    </div>
	
	<p id="cjsp-smessage" class="cjsp-spammsg">You can contact us <a href="mailto:<?php echo $ErrorPage['Mail']; ?>"><?php echo $ErrorPage['Mail']; ?></a>.</p>
	<p class="cjsp-connect">
		<?php echo $ErrorPage['Message2']; ?>
		<?php if( isset($ErrorPage['Message3'])) { ?>
	<b>Error info</b><br />
		<textarea style="color: black; border:none; background-color: transparent; width:90%; height:90px;"><?php echo $ErrorPage['Message3']; ?></textarea>
	</p>
	<?php } ?>
</div><!-- /content -->

</div><!-- /wrapper -->
</body>
</html>