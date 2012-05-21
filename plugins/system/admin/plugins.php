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


class xv_admin_plugins {
		var $style = "height: 600px; width: 90%;";
		var $contentStyle = "overflow-y:scroll; overflow-x: hidden; padding-bottom:10px;";
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
					"xv-sid" : "'.htmlspecialchars($XVweb->Session->get_sid()).'"
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
		<li><a href="#xv-plg-enabled-id">Plugiins</a></li>
		<li><a href="#xv-plg-install-id">Install</a></li>
	</ul>
	<div id="xv-plg-enabled-id">
		<div class="xv-table">
			<table style="width : 100%; text-align: center;">
				<caption>Enabled</caption> 
				<tbody>';
				foreach($plugins_status['all'] as $plugin){
				$plugin_info= $this->get_info_plugin($plugin);
				if($plugin_info->find("name")->html() == "System"){
					continue;
				}
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
	<style type="text/css" media="all">
		.xv-plugin-uploader {
			height: 50px;
			background: #C0FFBD;
			border: 1px solid #0AC900;
			-webkit-border-radius: 10px;
			-moz-border-radius: 10px;
			border-radius: 10px;
			text-align:center;
			line-height: 50px;
			font-size: 20px;
			color: #7D7D7D;
		}
		.xv-plugin-uploader-hover{
			background: #FFF7A3;
			border: 1px solid #D9C700;
		}
		.xv-plugin-uploader-result {
			max-height: 400px;
		}
	</style>
	<div id="xv-plg-install-id">
	<script type="text/javascript" src="'.$GLOBALS['URLS']['Theme'].'js/html5_uploader.jquery.js" charset="UTF-8"> </script> 
	<script type="text/javascript" src="'.$GLOBALS['URLS']['Site'].'plugins/system/admin/js/plugins.uploader.js" charset="UTF-8"> </script> 

		<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" style="margin-bottom: 20px;">
				<div class="portlet-header ui-widget-header ui-corner-all" style="padding: 5px;">Upload plugin</div>
				<div class="portlet-content" style="display: block; padding: 10px; ">
					<div class="xv-plugin-uploader-result"></div>
					<div class="xv-plugin-uploader">Drag here your *.xvweb file</div>
				</div>
		</div>
		<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" style="">
				<div class="portlet-header ui-widget-header ui-corner-all" style="padding: 5px;">Upload plugin by URL</div>
				<div class="portlet-content" style="display: block; padding: 10px; ">
					<div class="xv-plugin-upload-url-result">
						<form method="post" action="'.$GLOBALS['URLS']['Site'].'Administration/get/Plugins/UURL/?xv-sid='.$XVweb->Session->get_sid().'" class="xv-form" data-xv-result=".xv-plugin-upload-url-result">
							<label for="xv-plugin-upload">URL to *.xvweb file:<label><input type="url" placeholder="http://" style="width: 200px; margin-left: 10px;" id="xv-plugin-upload" name="xv_plugin_upload_url" /> <input type="submit" value="Install" />
						</form>
					</div>
				</div>
			</div>
		

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
		include_once(ROOT_DIR.'core/libraries/phpQuery/phpQuery.php');
		$plg_info = phpQuery::newDocumentFile($file_name);
				return $plg_info->find("info:first");
	}
	
	
	}

	class xv_admin_plugins_set {
		public function __construct(&$XVweb){
		if($XVweb->Session->get_sid() != ifsetor($_GET['xv-sid'], "")){
			exit(json_encode( array(
				"result" => true,
				"msg"=> "<div class='failed'>Error: Wrong SID key</div>"
			)));
		}
		$_GET['plugin'] = trim($_GET['plugin']);
		$plugins_config = new xv_plugins_config();
		
		if($_GET['enabled'] == "false"){ //wylaczenie	
			
				$Result = array(
					"result" => true,
					"msg"=> "<div class='failed'>Plugin disabled </div>"
				);
				unset($plugins_config->{$_GET['plugin']});
		
		}else{
				$plugin_info = xv_admin_plugins::get_info_plugin($_GET['plugin']);
				if(empty($plugin_info)){
					$Result = array(
					"result" => true,
					"msg"=> "<div class='failed'>Error: problem with read plugin</div>"
					);
				}else{
				$plugins_config->{$_GET['plugin']} = array(
					"name" => $_GET['plugin'],
					"version"=> $plugin_info->find("version")->html(),
					"title"=> $plugin_info->find("name")->html(),
				);
				$Result = array(
					"result" => true,
					"msg"=> "<div class='success'>Plugin enabled</div>"
				);
			}
		}
		
		$XVweb->Cache->clear();
		@unlink(ROOT_DIR."config/pluginscompiled.xml");
		exit(json_encode($Result));
		}
	}	
	class xv_admin_plugins_upload {
		public function __construct(&$XVweb){
			if($XVweb->Session->get_sid() != ifsetor($_GET['xv-sid'], "")){
				exit("<div class='error'>Error: Wrong SID</div>");
			}
			$zip = new ZipArchive;
			if ($zip->open($_FILES['upload']['tmp_name'][0]) === TRUE) {
				$zip->extractTo(ROOT_DIR);
				$zip->close();
				echo "<div class='success'>Plugin ".$_FILES['upload']['name'][0]." installed</div>";
			} else {
				echo "<div class='error'>Error with plugin ".$_FILES['upload']['name'][0]."</div>";
			}
			exit;
		}
	}	
	class xv_admin_plugins_uurl {
		public function __construct(&$XVweb){
			if($XVweb->Session->get_sid() != ifsetor($_GET['xv-sid'], "")){
				exit("<div class='error'>Error: Wrong SID</div>");
			}
				$uniq_id = uniqid();
				$fp = fopen (ROOT_DIR.'tmp/'.$uniq_id.'.tmp', 'w+');//This is the file where we save the information
				$ch = curl_init($_POST['xv_plugin_upload_url']);//Here is the file we are downloading
				curl_setopt($ch, CURLOPT_TIMEOUT, 50);
				curl_setopt($ch, CURLOPT_FILE, $fp);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_exec($ch);
				curl_close($ch);
				fclose($fp);


			$zip = new ZipArchive;
			if ($zip->open(ROOT_DIR.'tmp/'.$uniq_id.'.tmp') === TRUE) {
				$zip->extractTo(ROOT_DIR);
				$zip->close();
				echo "<div class='success'>Plugin ".basename($_POST['xv_plugin_upload_url'])." installed</div>";
			} else {
				echo "<div class='error'>Error with plugin ".basename($_POST['xv_plugin_upload_url'])."</div>";
			}
			@unlink(ROOT_DIR.'tmp/'.$uniq_id.'.tmp');
			exit;
		}
	}
	
	
$CommandSecond = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
if (class_exists('xv_admin_plugins_'.$CommandSecond)) {
	$xv_admin_class_name = 'xv_admin_plugins_'.$CommandSecond;
}else
$xv_admin_class_name = "xv_admin_plugins";


?>