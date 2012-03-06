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
		
		$plugins_status = $this->get_plugins_status();
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
				foreach($plugins_status['all'] as $plugin){
				$plugin_info= $this->get_info_plugin($plugin);
					$this->content .= ' <tr>
						<td style="width:80%; text-align:left;"><div class="xv-plg-header"> <span class="xv-plg-title" style="font-size:14px; font-weight:bold;">'.$plugin_info->find("name")->html().'</span> <span style="font-size:9px"> <a href="'.$plugin_info->find("url")->html().'" target="_blank"> '.$plugin_info->find("author")->html().' </a></span></div>
						<div class="xv-plg-description" style="padding-top:10px;">'.$plugin_info->find("description")->html().'</div>
						</td>
						<td>v. '.$plugin_info->find("version")->html().'</td>
						<td><input type="checkbox" '.( in_array($plugin, $plugins_status['enabled'])? "checked='checked'": "").' class="xv-plg-checkbox" name="'.$plugin.'" /> </td>
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

	public function get_plugins_status(){
		$all_plugins = array();	
		$enabled_plugins = array();	
		$disabled_plugins = array();
		$plugins_config = new xv_plugins_config();
		//GLOB_ONLYDIR
	
		foreach (glob(ROOT_DIR."plugins/*", GLOB_ONLYDIR) as $dirname) {
			$plg_name = basename($dirname);
			if(file_exists($dirname.'/'.$plg_name.'.xml')){
				$all_plugins[] =  $plg_name;
			}
		}
		
		foreach($plugins_config->get_all() as $key=>$plugin){
			$plugin_name = $plugin['name'];
		
		if($plugin_name != "system"){
				if(in_array($plugin_name, $all_plugins)){
					$enabled_plugins[] = $plugin_name;
				}
			}
		}
		
		foreach($all_plugins as $plg_name){
			if(!in_array($plg_name, $enabled_plugins)){
				$disabled_plugins[] = $plg_name;
			}
		
		}
		return array("all"=>$all_plugins, "enabled"=>$enabled_plugins, "disabled" => $disabled_plugins);
	}
	
	public function get_info_plugin($plugin){
		$file_name = ROOT_DIR."plugins/".$plugin.'/'.$plugin.'.xml';
		if(!file_exists($file_name)){
			return null;
		}
		$plg_info = phpQuery::newDocumentFile($file_name);
				return $plg_info->find("info:first");
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
		$_GET['plugin'] = trim($_GET['plugin']);
		$plugins_config = new xv_plugins_config();
		
		if($_GET['enabled'] == "false"){ //wylaczenie
			$XVweb->Config("plugins")->find("plugin[file='".trim($_GET['plugin'])."']")->remove();
				$Result = array(
					"result" => true,
					"msg"=> "<div class='failed'>Wyłączono plugin</div>"
				);
		
		}else{
				$plugin_info = XV_Admin_plugins::get_info_plugin($_GET['plugin']);
				if(empty($plugin_info)){
					$Result = array(
					"result" => true,
					"msg"=> "<div class='failed'>Nie można wczytać pluginu</div>"
					);
				}else{
				$plugins_config->{$_GET['plugin']} = array(
					"name" => $_GET['plugin'],
					"version"=> $plugin_info->find("version")->html(),
					"title"=> $plugin_info->find("name")->html(),
				);
				$Result = array(
					"result" => true,
					"msg"=> "<div class='success'>Włączono plugin</div>"
				);
			}
		}
		
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