<?php
if ($XVwebEngine->Config("config")->find("facebook fanpage enable")->text() == "true"){
xv_appendFooter('<div style="position: fixed; right:0px; top:20%;">
	<div style="float:left"><a href="http://www.facebook.com/apps/application.php?id='.trim($XVwebEngine->Config("config")->find("config facebook appid")->text()).'#FacebookFan" id="FacebookFan"><img src="'.$GLOBALS['URLS']['Site'].'plugins/data/facebook/facebookbn.png" alt="Facebook" /></a></div>
	<div id="FBFrame" style="float:left; display:none; background:#FFF;"></div></div>
	<script type="text/javascript">
	$(function(){
	 $("#FacebookFan").click(function () {
	 if($("#FBFrame").html() == "")
	  $("#FBFrame").html(\'<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D'.trim($XVwebEngine->Config("config")->find("config facebook appid")->text()).'&amp;width=292&amp;colorscheme=light&amp;connections=10&amp;stream=false&amp;header=true&amp;height=300" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:300px;" allowTransparency="true"></iframe>\');
		  $("#FBFrame").animate({width: "toggle"});
		  return false;
		});
	});
	</script>');
}
?>