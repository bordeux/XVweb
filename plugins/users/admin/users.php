<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   default.php       *************************
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
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}


	class XV_Admin_users{
		var $style = "height: 400px; width: 40%;";
		var $title = "testWindow";
		var $URL = "Test/";
		var $content = "test";
		var $id = "testWindow";
		var $contentAddClass = " xv-terminal";
		public function __construct(&$XVweb){
		
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/ban.png';
		}
	}
	class XV_Admin_users_groups{
		var $style = "width: 500px;";
		var $title = "Groups";
		var $URL = "Users/Groups/";
		var $content = "";
		var $id = "xv-users-groups";
		var $contentAddClass = "";
		public function __construct(&$XVweb){
		
		$groups_list = $XVweb->DataBase->pquery('SELECT {Groups:Name} AS `Name` FROM {Groups} GROUP BY {Groups:Name};')->fetchAll(PDO::FETCH_ASSOC);
		
			$this->content = "
<div>
	<div style='text-align:center;'>
		<select class='xv-users-groups-select' style='width: 300px; text-align:center;'>
		<option value='none'>----</option>";
		foreach($groups_list as $group_name)
			$this->content .= "<option>".$group_name['Name']."</option>";
		$this->content .= "</select>
	</div>
	<div class='xv-users-groups-content'></div>
</div>
<script>
$(function(){
	$('#xv-users-groups .xv-users-groups-select').change(function(){
		if($(this).val() == 'none')
			return true;
			$('.xv-users-groups-content').load('{$GLOBALS['URLS']['Script']}Administration/Get/Users/get_permissions/?group='+$(this).val());
	
	});
});
</script>
<style>
.xv-users-groups-perms .column { width: 200px; float: left; padding-bottom: 100px; }
.xv-users-groups-perms .portlet { margin: 0 1em 1em 0; }
.xv-users-groups-perms .portlet-header { margin: 0.3em; padding-bottom: 4px; padding-left: 0.2em; }
.xv-users-groups-perms .portlet-header .ui-icon { float: right; }
.xv-users-groups-perms .portlet-content { padding: 0.4em; display:none; }
.xv-users-groups-perms .ui-sortable-placeholder { border: 1px dotted black; visibility: visible !important; height: 50px !important; }
.xv-users-groups-perms .ui-sortable-placeholder * { visibility: hidden; }
</style>
";
			
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/users.png';
		}
	}
	class XV_Admin_users_get_permissions{
		var $XVweb;
		public function __construct(&$XVweb){
		$this->XVweb = &$XVweb;
		
		$groups_perms = $XVweb->DataBase->pquery('SELECT {Groups:*} FROM {Groups} WHERE {Groups:Name} = '.$XVweb->DataBase->quote($_GET['group']).';')->fetchAll(PDO::FETCH_ASSOC);
		$perms = $this->get_perms();
		$perms_all = array();
		
		$perms_group = array();
		
		foreach($groups_perms as $perm_item){
			$perms_group[] = array(
				"name"=> $perm_item['Permission'],
				"desc"=> ifsetor( $perms['descriptions'][($perm_item['Permission'])] , "No data")
			);
			if(isset($perms['names'][($perm_item['Permission'])]))
				unset($perms['names'][($perm_item['Permission'])]);
		}
		
		foreach($perms['names'] as $perm){
			$perms_all[] = array(
				"name"=> $perm,
				"desc"=> ifsetor( $perms['descriptions'][$perm] , "No data")
			);
		
		}
		
		
		echo '
<div class="xv-users-groups-perms" style="max-height: 500px; overflow-y: scroll; padding-top: 15px;">
<div class="xv-users-groups-result"></div>
<form method="post" action="'.$GLOBALS['URLS']['Script'].'Administration/get/Users/Groups_Save/" class="xv-form" data-xv-result=".xv-users-groups-result" style="padding: 10px;">
<input type="hidden" value="'.htmlspecialchars($XVweb->Session->GetSID()).'" name="xv-sid" />
	<div><label for="group">Group: </label> <input type="text" name="group" value="'.$_GET['group'].'" /> <input type="submit" value="Save" /></div>
	<div class="xv-users-groups-form-fields" style="display:none;"></div>
</form>
	<div class="column">
		<h2>Disabled premissions</h2>
		';
		foreach($perms_all as $perm_show){
			echo '
			<div class="portlet">
				<div class="portlet-header">'.$perm_show['name'].'</div>
				<div class="portlet-content">'.$perm_show['desc'].'</div>
			</div>';
		}
		echo '
	</div>
	<div class="column xv-users-groups-group-perms" style="background: rgba(245,184,0, 0.2); padding-left:3px;">		
	<h2>Enabled premissions</h2>';
		
		foreach($perms_group as $perm_show){
			echo '
			<div class="portlet">
				<div class="portlet-header">'.$perm_show['name'].'</div>
				<div class="portlet-content">'.$perm_show['desc'].'</div>
			</div>';
		}
		
	echo '</div>
</div>
<div style="clear:both";> </div>
<script>
$(function() {
var onUpdatePerms = function(){
	$(".xv-users-groups-form-fields *").remove();
					$(".xv-users-groups-group-perms .portlet-header").each(function(){
						$("<input>").attr({
							"type":"hidden",
							"name":"perms[]",
							"value":$(this).text()
						}).appendTo(".xv-users-groups-form-fields");
	});
}
		$( ".xv-users-groups-perms .column" ).sortable({
			connectWith: ".column",
			update: onUpdatePerms
		});
onUpdatePerms();
		$( ".xv-users-groups-perms .portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
			.find( ".portlet-header" )
				.addClass( "ui-widget-header ui-corner-all" )
				.prepend( "<span class=\'ui-icon ui-icon-plusthick\'></span>")
				.end()
			.find( ".portlet-content" );

		$( ".xv-users-groups-perms .portlet-header .ui-icon" ).click(function() {
			$( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
			$( this ).parents( ".portlet:first" ).find( ".portlet-content" ).toggle();
		});

		$( ".xv-users-groups-perms .column" ).disableSelection();
	});
</script>
';
		exit;
		}
	public function get_perms(){
	$perms_names = array();
	$perms_descriptions = array();
	$plugins_config = new xv_plugins_config();

		foreach($plugins_config->get_all() as $val){

			include_once(ROOT_DIR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'phpQuery'.DIRECTORY_SEPARATOR.'phpQuery.php');
			$plugin_xml = phpQuery::newDocumentFile(ROOT_DIR.'plugins'.DIRECTORY_SEPARATOR.$val['name'].'/'.$val['name'].'.xml');
			foreach($plugin_xml->find("ranks rank") as $perm){
				$name_perm = pq($perm)->find("name")->html();
				$desc_perm = pq($perm)->find("description")->html();
				$perms_names[$name_perm] = $name_perm;
				$perms_descriptions[$name_perm] = $desc_perm;
			}
		};
		
	return array("names"=>$perms_names , "descriptions"=>$perms_descriptions);
	}
}
class XV_Admin_users_groups_save{
	var $XVweb;
	public function __construct(&$XVweb){
		if($XVweb->Session->GetSID() != $_POST['xv-sid']){
			exit("<div class='failed'>Error: Bad SID!</div>");
		}
	if(!isset($_POST['group']) || strlen($_POST['group']) < 2){
		exit("<div class='failed'>Error: Group name is short!</div>");
	}
	$delete_group = $XVweb->DataBase->pquery('DELETE FROM 
		{Groups} 
	WHERE 
		{Groups:Name} = '.$XVweb->DataBase->quote($_POST['group']).';');
	
	$add_perm = $XVweb->DataBase->prepare("INSERT INTO 
		{Groups} 
		({Groups:Name}, {Groups:Permission})
	VALUES
		(:name, :perm);
	");
	
	foreach($_POST['perms'] as $perm_add){
			$add_perm->execute(array(
				":name" => $_POST['group'],
				":perm" => $perm_add
			));
		}
	exit("<div class='success'>Done</div>");
	}
}
	
	//Groups_Save
	$CommandSecond = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
	if (class_exists('XV_Admin_users_'.$CommandSecond)) {
		$XVClassName = 'XV_Admin_users_'.$CommandSecond;
	}else
		$XVClassName = "XV_Admin_users";

?>