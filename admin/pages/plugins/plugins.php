<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   config.php        *************************
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


class XV_Admin_plugins {
		var $style = "height: 600px; width: 90%;";
		var $contentStyle = "overflow-y:scroll; padding-bottom:10px;";
		var $URL = "Plugins/";
		var $content = "";
		var $id = "plugins-window";
		private $Data;
		public function __construct(&$XVweb){
		$this->Data['XVweb'] = &$XVweb;
		//$this->content = ''.print_r($this->GetPluginStatus(), true);
		$PluginsStatus = $this->GetPluginStatus();
		$this->content = "
		<script type='text/javascript' src='{$GLOBALS['URLS']['Theme']}js/jquery.tzCheckbox/jquery.tzCheckbox.js' charset='UTF-8'> </script> 
			<style type='text/css' media='all'>
				@import url('{$GLOBALS['URLS']['Theme']}js/jquery.tzCheckbox/jquery.tzCheckbox.css');
			</style>
		";
		$this->content .= '
		<script>
	$(function() {
		$( "#xv-plg-tabs-id" ).tabs();
		$(".xv-plg-checkbox").tzCheckbox({
			labels: [ "Enable", "Disable" ],
			change : function(org){
				$.getJSON(URLS.Script+"Administration/Get/Plugins/Set/", {
					"plugin" : org.attr("name"),
					"enabled" : org.is(":checked"),
					"xv-sid" : "'.htmlspecialchars($XVweb->Session->GetSID()).'"
				},  function(data) {
					$(".xv-plg-result").html(data.msg);
				});
			}
		});
	});
	</script>
<div class="xv-plg-result"></div>
<div class="xv-plg-main">
<div id="xv-plg-tabs-id">
	<ul>
		<li><a href="#xv-plg-enabled-id">Enabled</a></li>
		<li><a href="#xv-plg-install-id">Install</a></li>
	</ul>
	<div id="xv-plg-enabled-id">
		<div class="xv-table">
			<table style="width : 100%; text-align: center;">
				<caption>Enabled</caption> 
				<tbody>';
				foreach($PluginsStatus['All'] as $Plg){
				$PlgInfo = $this->GetInfoPlugin($Plg);
					$this->content .= ' <tr>
						<td style="width:80%; text-align:left;"><div class="xv-plg-header"> <span class="xv-plg-title" style="font-size:14px; font-weight:bold;">'.$PlgInfo->find("name")->html().'</span> <span style="font-size:9px"> <a href="'.$PlgInfo->find("url")->html().'" target="_blank"> '.$PlgInfo->find("author")->html().' </a></span></div>
						<div class="xv-plg-description" style="padding-top:10px;">'.$PlgInfo->find("description")->html().'</div>
						</td>
						<td>v. '.$PlgInfo->find("version")->html().'</td>
						<td><input type="checkbox" '.( in_array($Plg, $PluginsStatus['Enabled'])? "checked='checked'": "").' class="xv-plg-checkbox" name="'.$Plg.'" /> </td>
					</tr>';
				}
			$this->content .=	'</tbody> 
				</table>
			</div>
	</div>
	<div id="xv-plg-install-id">
		<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
		<p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
	</div>
</div>

</div><!-- End demo -->';;
				
		
			$this->title = ifsetor($GLOBALS['Language']['Plugins'], "Plugins");
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/plugins.png';
			
		}
		
		
	public function GetPluginStatus(){
		$AllPlugins = array();	
		$EnabledPlugins = array();	
		$DisabledPlugins = array();	
			foreach (glob(ROOT_DIR."plugins/*.xml") as $filename) {
				if(basename($filename) != "system.xml")
					$AllPlugins[] = basename($filename);
			}	
		foreach($this->Data['XVweb']->Config("plugins")->find("plugin") as $valPlugin){
		$PlgName = pq($valPlugin)->attr("file");
		
		if($PlgName != "system.xml")
			if(in_array($PlgName, $AllPlugins))
				$EnabledPlugins[] = pq($valPlugin)->attr("file");
		}
		
		foreach($AllPlugins as $EnPlg){
			if(!in_array($EnPlg, $EnabledPlugins))
				$DisabledPlugins[] = $EnPlg;
		
		}
		return array("All"=>$AllPlugins, "Enabled"=>$EnabledPlugins, "Disabled" => $DisabledPlugins);
	}
	public function GetInfoPlugin($plug){
		$PluginsInfo = array();
			foreach (glob(ROOT_DIR."plugins/".$plug) as $filename) {
			$PlgInfo = phpQuery::newDocumentFile($filename);
				return $PlgInfo->find("info:first");
			}
	}
	
	
	}

	class XV_Admin_plugins_set {
		public function __construct(&$XVweb){
		if($XVweb->Session->GetSID() != ifsetor($_GET['xv-sid'], "")){
			exit(json_encode( array(
				"result" => true,
				"msg"=> "<div class='failed'>Błąd: Zły SID</div>"
			)));
		}
		
		if($_GET['enabled'] == "false"){ //wylaczenie
			$XVweb->Config("plugins")->find("plugin[file='".trim($_GET['plugin'])."']")->remove();
				$Result = array(
					"result" => true,
					"msg"=> "<div class='failed'>Wyłączono plugin</div>"
				);
		
		}else{
			$XVweb->Config("plugins")->find("plugin[file='".trim($_GET['plugin'])."']")->remove();
			$XVweb->Config("plugins")->find("enabled")->append('<plugin file="'.trim($_GET['plugin']).'" ></plugin>');
			$Result = array(
				"result" => true,
				"msg"=> "<div class='success'>Włączono plugin</div>"
			);
		}
		
			include_once(ROOT_DIR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'BeautyXML.class.php');
			$bc = new BeautyXML();
			file_put_contents(ROOT_DIR."config/plugins.xml", '<?xml version="1.0" encoding="utf-8"?>'.chr(13).$bc->format($XVweb->Config("plugins")));
			
		$XVweb->Cache->clear();
		@unlink(ROOT_DIR."config/pluginscompiled.xml");
		exit(json_encode($Result));
		}
	}
	
	
$CommandSecond = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
if (class_exists('XV_Admin_plugins_'.$CommandSecond)) {
	$XVClassName = 'XV_Admin_plugins_'.$CommandSecond;
}else
$XVClassName = "XV_Admin_plugins";


?>