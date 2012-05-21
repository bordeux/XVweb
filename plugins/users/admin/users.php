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


	class xv_admin_users{
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
	class xv_admin_users_groups{
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
	class xv_admin_users_get_permissions{
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
<input type="hidden" value="'.htmlspecialchars($XVweb->Session->get_sid()).'" name="xv-sid" />
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
class xv_admin_users_groups_save{
	var $XVweb;
	public function __construct(&$XVweb){
		if($XVweb->Session->get_sid() != $_POST['xv-sid']){
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
class xv_admin_users_list {
	var $style = "width: 60%; height: 500px; ";
	var $title = "Users List";
	var $contentStyle = "overflow-y:scroll; overflow-x: hidden; padding-bottom:10px;";
	var $URL = "Users/List/";
	var $content = "";
	var $id = "xv-users-list-main";
	public function __construct(&$XVweb){
	global $URLS;
		$this->icon = $GLOBALS['URLS']['Site'].'plugins/users/admin/icons/users.png';
		
			$this->URL = "Users/List/".(empty($_SERVER['QUERY_STRING']) ? "" : "?".$XVweb->add_get_var(array(), true));

			$users_list = $this->get_records($XVweb, ((int) ifsetor($_GET['page'], 0)), 30);
			include_once(ROOT_DIR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
			$pager = pager(30, (int) $users_list->list_count,  "?".$XVweb->add_get_var(array("page"=>"-npage-id-"), true), $actual_page);
			
			$this->content =  '<div class="xv-users-list-table-div xv-table">
			<table style="width : 100%; text-align: center;">
			<caption>'.$pager[0].'</caption>
				<thead> 
					<tr class="xv-pager">
						<th><a>ID</a></th>
						<th><a>Username</a></th>
						<th><a>Mail</a></th>
						<th><a>Creation</a></th>
						<th><a>Group</a></th>
					</tr>
				</thead> 
				<tbody>';
				foreach($users_list->list as $user_item){
					$this->content .= '<tr>
							<td><a href="'.$URLS['Script'].'Administration/Users/Get/'.$user_item['User'].'/" class="xv-get-window" >'.$user_item['ID'].'</a></td>
							<td><a href="'.$URLS['Script'].'Administration/Users/Get/'.$user_item['User'].'/" class="xv-get-window" >'.$user_item['User'].'</a> [<a href="'.$URLS['Script'].'Users/'.$user_item['User'].'" target="_blank" >preview</a>]</td>
							<td><a href="mailto:'.$user_item['Mail'].'" target="_blank">'.$user_item['Mail'].'</a></td>
							<td>'.$user_item['Creation'].'</td>
							<td>'.$user_item['Group'].'</td>
						</tr>';
				}
				$this->content .= '</tbody>
				</table>
				<div class="xv-table-pager">
				'.$pager[1].'
				</div>
		</div>';
		
		$this->content .=  '<div class="xv-users-list-search">
				<a href="#" class="xv-toggle" data-xv-toggle=".xv-users-list-search-form" action="?'.$XVweb->add_get_var(array(), true).'" > Search... </a>
					<form style="display:none" class="xv-users-list-search-form xv-form" method="get" data-xv-result=".content" action="'.$GLOBALS['URLS']['Script'].'Administration/get/Users/List/?'.$XVweb->add_get_var(array(), true).'">
						<table>
						<tbody>';
				foreach($XVweb->DataBase->get_fields("Users") as $keyf=>$field){		
					$this->content .=	'
						<tr>
							<td style="font-weight:bold;">'.$keyf.'</td>
							<td>
								<select name="xv-func['.$keyf.']">
									<option value="none">----</option>
									<option value="LIKE">LIKE</option>
									<option value="NOT LIKE">NOT LIKE</option>
									<option value="=">=</option>
									<option value="!=">!=</option>
									<option value="REGEXP">REGEXP</option>
									<option value="NOT REGEXP">NOT REGEXP</option>
									<option value="&lt;">&lt;</option>
									<option value="&gt;">&gt;</option>
								</select>
							</td>
							<td><input type="text" name="xv-value['.$keyf.']" /></td>
						</tr>';
						}
						$this->content .= '<tr>
						<td><input type="hidden" value="true" name="search_mode" /> <input type="submit" value="Search..." /></td>
							</tr>
							</tbody>
						</table>
					</form>
					
			</div>';
		if(isset($_GET['search_mode']))
				exit($this->content);
	}
	public function get_records(&$XVweb, $actual_page = 0, $every_page =30){
			$table = "Users";
			$l_limit = ($actual_page*$every_page);
			$r_limit = $every_page;

			$search_add_query = array();
			$exec_vars = array();
			if(isset($_GET["xv-value"]) && isset($_GET["xv-func"]) && is_array($_GET["xv-func"]) && is_array($_GET["xv-value"])){
				foreach($_GET["xv-func"] as $funckey=>$funcN){
					if($funcN !="none"){
					$UniqVar = ':'.uniqid();
						$search_add_query[] = ' {'.$table.':'.$funckey.'} '.$funcN.' '.$UniqVar.' ';
						$exec_vars[$UniqVar] = ifsetor($_GET["xv-value"][$funckey], "");
					}
				}
			
			}
			$select_query = 'SELECT SQL_CALC_FOUND_ROWS
			{'.$table.':*}
				FROM {'.$table.'} '.(empty($search_add_query) ? '' : 'WHERE '.implode(" AND ", $search_add_query)).' ORDER BY {'.$table.':ID} DESC LIMIT '.$l_limit.', '.$r_limit.';
	';
	
			$select_users_sql = $XVweb->DataBase->prepare($select_query);
			$select_users_sql->execute($exec_vars);
			$result_list = $select_users_sql->fetchAll();
			$result_count = $XVweb->DataBase->pquery('SELECT FOUND_ROWS() AS `count_list`;')->fetch(PDO::FETCH_OBJ)->count_list;
			return (object)  array('list'=>$result_list, 'list_count'=>$result_count );
	}
}

	class xv_admin_users_get{
		var $style = "height: 400px; width: 30%;";
		var $title = "";
		var $URL = "";
		var $content = "";
		var $id = "";
		public function __construct(&$XVweb){
		global $PathInfo;
			$user_from_url = $XVweb->GetFromURL($PathInfo, 5);
			$this->URL = "Users/Get/".$user_from_url.'/';
			$this->id = "xv-users-get-".$user_from_url;
			$this->title = "User edit: ".$user_from_url;
			$this->content = '
				<div class="success">ToDo</div>
				<fieldset>
					<legend>Change password</legend>
					<form method="post" action="?">
						<input type="hidden" name="user" value="'.$user_from_url.'" />
						<input type="text" value="" placeholder="New password..." />
						<input type="submit" value="Change password" />
					</form>
				</fieldset>		
				<fieldset>
					<legend>Change activation key</legend>
					IF you want disable this account, please fill this value other than "1"
					<form method="post" action="?">
						<input type="hidden" name="user" value="'.$user_from_url.'" />
						<input type="text" value="" placeholder="New key..." />
						<input type="submit" value="Change key" />
					</form>
				</fieldset>
			';
			$this->icon = $GLOBALS['URLS']['Site'].'plugins/users/admin/icons/user.png';
		}
	}
	
	//Groups_Save
	$CommandSecond = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
	if (class_exists('xv_admin_users_'.$CommandSecond)) {
		$xv_admin_class_name = 'xv_admin_users_'.$CommandSecond;
	}else
		$xv_admin_class_name = "xv_admin_users";

?>