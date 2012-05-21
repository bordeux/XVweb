<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
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

class xv_admin_ip_ban {
	var $style = "width: 60%;";
	var $title = "IP Ban";
	var $URL = "IP_Ban/";
	var $content = "";
	var $id = "xv-ip-ban-main";
	public function __construct(&$XVweb){
	global $URLS;
		$this->icon = $GLOBALS['URLS']['Site'].'plugins/ip_ban/admin/icons/ban.png';
		
			$this->URL = "IP_Ban/".(empty($_SERVER['QUERY_STRING']) ? "" : "?".$XVweb->add_get_var(array(), true));

			$bans_list = $this->get_records($XVweb, ((int) ifsetor($_GET['page'], 0)), 30);
			include_once(ROOT_DIR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
			$pager = pager(30, (int) $bans_list->list_count,  "?".$XVweb->add_get_var(array("page"=>"-npage-id-"), true), $actual_page);
			
			$this->content =  '<div class="xv-ban-table-div xv-table">
				<div style="float:right;">
					<a href="'.$URLS['Script'].'Administration/IP_Ban/Add/" class="xv-get-window" ><img src="'.$GLOBALS['URLS']['Site'].'plugins/ip_ban/admin/icons/add_32.png" alt="Add Ban" title="Add Ban" /></a>
				</div>
			<table style="width : 100%; text-align: center;">
			<caption>'.$pager[0].'</caption>
				<thead> 
					<tr class="xv-pager">
						<th><a>ID</a></th>
						<th><a>Filter</a></th>
						<th><a>Filter type</a></th>
						<th><a>Message</a></th>
						<th><a>Admin</a></th>
					
					</tr>
				</thead> 
				<tbody>';
				foreach($bans_list->list as $ban_item){
					$this->content .= '<tr>
							<td><a href="'.$URLS['Script'].'Administration/IP_Ban/Edit/?id='.$ban_item['ID'].'" class="xv-get-window" >'.$ban_item['ID'].'</a></td>
							<td><a href="'.$URLS['Script'].'Administration/IP_Ban/Edit/?id='.$ban_item['ID'].'" class="xv-get-window" >'.$ban_item['IP'].'</a></td>
							<td>'.($ban_item['FilterType'] ? 'LIKE' : 'NOT LIKE').'</td>
							<td>'.substr(strip_tags($ban_item['Message']), 0, 50).'...</td>
							<td><a href="'.$URLS['Script'].'Administration/Users/Get/'.$ban_item['By'].'/" class="xv-get-window" >'.$ban_item['By'].'</a></td>
						</tr>';
				}
				$this->content .= '</tbody>
				</table>
				<div class="xv-table-pager">
				'.$pager[1].'
				</div>
		</div>';
		
		$this->content .=  '<div class="xv-ban-search">
				<a href="#" class="xv-toggle" data-xv-toggle=".xv-ban-search-form" action="?'.$XVweb->add_get_var(array(), true).'" > Search... </a>
					<form style="display:none" class="xv-ban-search-form xv-form" method="get" data-xv-result=".content" action="'.$GLOBALS['URLS']['Script'].'Administration/get/IP_Ban/?'.$XVweb->add_get_var(array(), true).'">
						<table>
						<tbody>';
				foreach($XVweb->DataBase->get_fields("Bans") as $keyf=>$field){		
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
			$table = "Bans";
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
	
			$select_bans_sql = $XVweb->DataBase->prepare($select_query);
			$select_bans_sql->execute($exec_vars);
			$result_list = $select_bans_sql->fetchAll();
			$result_count = $XVweb->DataBase->pquery('SELECT FOUND_ROWS() AS `count_list`;')->fetch(PDO::FETCH_OBJ)->count_list;
			return (object)  array('list'=>$result_list, 'list_count'=>$result_count );
	}
}


class xv_admin_ip_ban_add {
	var $style = "width: 30%;";
	var $title = 'IP Ban: Add';
	var $URL = 'IP_Ban/Add/';
	var $content = "";
	var $id = "xv-ip-ban-add-main";
	public function __construct(&$XVweb){
	global $URLS;
	if(isset($_POST['ip_ban'])){
		if($XVweb->Session->get_sid() != $_POST['xv_sid']){
			exit("<div class='failed'>Error: Bad SID!</div>");
		}
		$insert_ban = $XVweb->DataBase->prepare('INSERT INTO {Bans} ({Bans:IP}, {Bans:FilterType}, {Bans:Expire}, {Bans:Message}, {Bans:By}) VALUES (:ip, :filter_type, :expire, :message, :by)  ON DUPLICATE KEY UPDATE {Bans:FilterType} = {Bans:FilterType};');
		$insert_ban->execute(array(
			":ip"=> $_POST['ip_ban']['ip'],
			":filter_type"=> (int) $_POST['ip_ban']['filter'],
			":expire"=> $_POST['ip_ban']['expire'],
			":message"=> $_POST['ip_ban']['message'],
			":by"=> $XVweb->Session->Session("Logged_User"),
		));
		$delete_sessions = $XVweb->DataBase->prepare('DELETE FROM {Sessions} WHERE {Sessions:IP} '.((int) $_POST['ip_ban']['filter'] ? 'LIKE' :  'NOT LIKE').' :data');
		$delete_sessions->execute(array(
			":data" => $_POST['ip_ban']['ip']
		));
		exit("<div class='success'>Ban added!</div>");
	}
		$this->icon = $URLS['Site'].'plugins/ip_ban/admin/icons/ban.png';
		$this->content = '<div class="xv-ip-ban-add-div xv-table">
			<form action="'.$URLS['Script'].'Administration/get/IP_Ban/Add/" method="post" class="xv-form" data-xv-result=".xv-ip-ban-add-div">
			<input type="hidden" value="'.htmlspecialchars($XVweb->Session->get_sid()).'" name="xv_sid" />
			<table style="width : 100%; text-align: center;">
				<tr>
					<td>Filter type</td>
					<td>
					<select name="ip_ban[filter]" >
						<option value="1">LIKE</option>
						<option value="0">NOT LIKE</option>
					</select>
					</td>
				</tr>
				<tr>
					<td>IP</td>
					<td><input name="ip_ban[ip]" type="text" value="" /></td>
				</tr>			
				<tr>
					<td>Message</td>
					<td><textarea name="ip_ban[message]"></textarea></td>
				</tr>	
				<tr>
					<td>Expire</td>
					<td><input type="date" value="" name="ip_ban[expire]" class="xv-ip-ban-date" value=""></td>
				</tr>		
				<tr>
					<td></td>
					<td><input type="submit" value="Add ban"></td>
				</tr>
			</table>
			</form>
			<script>
				$( ".xv-ip-ban-date" ).datepicker({
				showOn: "button",
				buttonImage: "'.$URLS['Site'].'plugins/ip_ban/admin/icons/calendar_16.png",
				buttonImageOnly: true,
				dateFormat: "yy-mm-dd 00:00:00"
			});
			
			</script>
		</div>
		';
	}
}

class xv_admin_ip_ban_edit {
	var $style = "width: 30%;";
	var $title = 'IP Ban: Edit';
	var $URL = 'IP_Ban/Edit/';
	var $content = "";
	var $id = "xv-ip-ban-edit-main";
	public function __construct(&$XVweb){
	global $URLS;
	if(isset($_POST['ip_ban'])){
		if($XVweb->Session->get_sid() != $_POST['xv_sid']){
			exit("<div class='failed'>Error: Bad SID!</div>");
		}
		$update_ban = $XVweb->DataBase->prepare('UPDATE {Bans} SET {Bans:IP} = :ip, {Bans:FilterType} = :filter_type, {Bans:Expire} = :expire, {Bans:Message} = :message WHERE {Bans:ID} = :id');
		$update_ban->execute(array(
			":ip"=> $_POST['ip_ban']['ip'],
			":filter_type"=> (int) $_POST['ip_ban']['filter'],
			":expire"=> $_POST['ip_ban']['expire'],
			":message"=> $_POST['ip_ban']['message'],
			":id"=> (int) $_GET['id'],
		));
		$delete_sessions = $XVweb->DataBase->prepare('DELETE FROM {Sessions} WHERE {Sessions:IP} '.((int) $_POST['ip_ban']['filter'] ? 'LIKE' :  'NOT LIKE').' :data');
		$delete_sessions->execute(array(
			":data" => $_POST['ip_ban']['ip']
		));
		exit("<div class='success'>Ban edited!</div>");
	}
	if(isset($_POST['delete_ban'])){
		if($XVweb->Session->get_sid() != $_POST['xv_sid']){
			exit("<div class='failed'>Error: Bad SID!</div>");
		}
		$delete_ban = $XVweb->DataBase->prepare('DELETE FROM {Bans} WHERE {Bans:ID} = :id');
		$delete_ban->execute(array(
			":id" => $_POST['delete_ban']
		));
		exit("<div class='success'>Ban deleted</div>");
	}
		
		$this->URL = 'IP_Ban/Edit/?id='.((int) $_GET['id']);
		$this->icon = $URLS['Site'].'plugins/ip_ban/admin/icons/ban.png';
		$ban_info = $update_ban = $XVweb->DataBase->prepare('SELECT {Bans:*} FROM {Bans} WHERE {Bans:ID} = :id');
		$ban_info->execute(array(
			":id" => (int) $_GET['id']
		));
		$ban_info = $ban_info->fetch(PDO::FETCH_OBJ);
		if(empty($ban_info)){
			$this->content = '<div class="error">Ban not found</div>';
			return true;
		}
		$this->content = '<div class="xv-ip-ban-edit-div xv-table">
		<fieldset>
			<legend>Edit</legend>
			<form action="'.$URLS['Script'].'Administration/get/IP_Ban/Edit/?id='.((int) $_GET['id']).'" method="post" class="xv-form" data-xv-result=".xv-ip-ban-edit-div">
			<input type="hidden" value="'.htmlspecialchars($XVweb->Session->get_sid()).'" name="xv_sid" />
			<table style="width : 100%; text-align: center;">
				<tr>
					<td>Filter type</td>
					<td>
					<select name="ip_ban[filter]" >
						<option value="1">LIKE</option>
						<option value="0" '.($ban_info->FilterType ? '' : 'selected="selected"').'>NOT LIKE</option>
					</select>
					</td>
				</tr>
				<tr>
					<td>IP</td>
					<td><input name="ip_ban[ip]" type="text" value="'.$ban_info->IP.'" /></td>
				</tr>			
				<tr>
					<td>Message</td>
					<td><textarea name="ip_ban[message]">'.htmlspecialchars($ban_info->Message).'</textarea></td>
				</tr>	
				<tr>
					<td>Expire</td>
					<td><input type="date"  name="ip_ban[expire]" class="xv-ip-ban-date" value="'.$ban_info->Expire.'"></td>
				</tr>		
				<tr>
					<td></td>
					<td><input type="submit" value="Edit ban"></td>
				</tr>
			</table>
			</form>
			</fieldset>
			<fieldset>
				<legend>Delete ban</legend>
				<form action="'.$URLS['Script'].'Administration/get/IP_Ban/Edit/?id='.((int) $_GET['id']).'" method="post" class="xv-form" data-xv-result=".xv-ip-ban-edit-div" style="text-align:center;">
					<input type="hidden" value="'.htmlspecialchars($XVweb->Session->get_sid()).'" name="xv_sid" />
					<input type="hidden" value="'.((int) $_GET['id']).'" name="delete_ban" />
						
								<input type="submit" value="Delete ban" />
							
			
				</form>
			</fieldset>
			
			<script>
				$( ".xv-ip-ban-date" ).datepicker({
				showOn: "button",
				buttonImage: "'.$URLS['Site'].'plugins/ip_ban/admin/icons/calendar_16.png",
				buttonImageOnly: true,
				dateFormat: "yy-mm-dd 00:00:00"
			});
			
			</script>
		</div>
		';
	}
}

$CommandSecond = strtolower($XVwebEngine->GetFromURL($PathInfo, 4));
if (class_exists('xv_admin_ip_ban_'.$CommandSecond)) {
	$xv_admin_class_name = 'xv_admin_ip_ban_'.$CommandSecond;
}else{
	$xv_admin_class_name = "xv_admin_ip_ban";
}

?>