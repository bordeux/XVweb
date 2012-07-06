<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE application!   *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}




class xv_admin_xvauctions_editfields{
	var $style = "min-height: 400px; width: 100%;";
	var $title = "Auctions - Edit fields";
	var $URL = "";
	var $id = "";
	var $content = "";
	public function __construct(&$XVweb){
	global $xva_wiki_page;
		$CatUNIQ = substr(md5($_GET['cat']), 28);
		$this->id = "xv-xvauctions-editfields-".$CatUNIQ;
		$this->URL = "XVauctions/EditFields/?cat=".urlencode($_GET['cat']);
		$this->icon = $GLOBALS['URLS']['Site'].'plugins/xvauctions/admin/xvauctions/icons/main.png';
		include_once(ROOT_DIR.'plugins/xvauctions/fields/fields.php');
		foreach (glob(ROOT_DIR.'plugins/xvauctions/fields/*.fields.php') as $filename) {
			include_once($filename);
		}
		$PrefixLength = strlen("xvauction_fields_");
		$fieldsList = (getClassesByPrefix("xvauction_fields_"));
		$FieldsTypes = "";
		
		foreach($fieldsList as $fieldT){
			$FieldsTypes .= '<option>'.substr($fieldT,$PrefixLength).'</option>';
		}
		
		
		
		$CategoryFields = $XVweb->DataBase->prepare('
			SELECT
					{AuctionFields:*}
			FROM 
				{AuctionFields}
			WHERE
				{AuctionFields:Category} = :category
		');
		
		$CategoryFields->execute(array(
		":category" => $_GET['cat']
		));
		$FieldEditContent = "
		<script>
		$(function() {
			$('.auction-editfield-list-".$CatUNIQ."' ).accordion();
		});
		</script>
	<div class='auction-editfield-list-".$CatUNIQ."'>";
		$CategoryFields = $CategoryFields->fetchAll(PDO::FETCH_ASSOC);
		$filed_classes = array();
		foreach($CategoryFields as $fieldItem){
			$FieldOptions = unserialize($fieldItem['FieldOptions']);
			$class_tmp_name = $fieldItem['Class'];
			if(!isset($filed_classes[$class_tmp_name])){
				$class_tmp_name = $fieldItem['Class'];
				$filed_classes[$class_tmp_name] = new $class_tmp_name($XVweb);
			}
			

			$FieldOptions = array_merge($filed_classes[$class_tmp_name]->options(), $FieldOptions);

			$FieldEditContent .= "
				<h3><a href='#'>{$fieldItem['Name']}</a></h3>
				<div class='auction-deletefield-{$fieldItem['Name']}-{$CatUNIQ}'>
					<div class='auction-editfield-{$fieldItem['Name']}-{$CatUNIQ}'></div>
					<form method='post'	action='{$GLOBALS['URLS']['Script']}Administration/get/XVauctions/SaveField/' class='xv-form' data-xv-result='.auction-editfield-{$fieldItem['Name']}-{$CatUNIQ}'>
					<input type='hidden' value='".htmlspecialchars($XVweb->Session->get_sid())."' name='xv-sid' />
					<input type='hidden' value='{$fieldItem['ID']}' name='field-id' />
					
					";
			foreach($FieldOptions as $FieldKey=> $FieldOption){
				$FieldEditContent .= "
					<div>
						<div style='float:left; width: 150px;'><label style='width: 300px;' for='auction-{$FieldKey}-{$CatUNIQ}'> {$FieldKey} <a href='".$xva_wiki_page.substr($class_tmp_name, 17)."#{$FieldKey}' target='_blank'>[?]</a>:</label> </div> <div style='float:left; margin-right: 30px;'><textarea id='auction-{$FieldKey}-{$CatUNIQ}' name='field[{$FieldKey}]' style='height:14px;'>".htmlspecialchars($FieldOption)."</textarea></div>
						
					</div>
					";
			}
			$FieldEditContent .= "
						<div style='clear:both'>
							<input type='submit' value='Save' /> 
						</div>
					</form>
					
					<form method='post'	action='{$GLOBALS['URLS']['Script']}Administration/get/XVauctions/DeleteField/' class='xv-form' data-xv-result='.auction-deletefield-{$fieldItem['Name']}-{$CatUNIQ}'>
						<input type='hidden' value='".htmlspecialchars($XVweb->Session->get_sid())."' name='xv-sid' />
						<input type='hidden' value='{$fieldItem['ID']}' name='field-id' />
						<input type='submit' onclick='return confirm(\"Do you want to delete this field?\");' value='Delete field' />
					</form>	
					<fieldset>
						<legend>Main field options</legend>
					<form method='post'	action='{$GLOBALS['URLS']['Script']}Administration/get/XVauctions/EditMainField/' class='xv-form' data-xv-result='.auction-editfield2-{$fieldItem['Name']}-{$CatUNIQ}'>
						<div class='auction-editfield2-{$fieldItem['Name']}-{$CatUNIQ}'></div>
						<table>
						<tr>
							<td>
								Field add priority : 
							</td>
							<td><input type='number' value='{$fieldItem['AddPriority']}' name='edit[AddPriority]' /></td>
						</tr>
						
						<tr>
							<td>Field priority :</td> 
							<td><input type='number' value='{$fieldItem['Priority']}' name='edit[Priority]' /></td>
						</tr>
						<tr>
							<td>Search mode :</td> 
							<td><select name='edit[Search]'>";
			foreach(array('none', 'quick', 'advanced', 'both') as $val){
				$FieldEditContent .= "<option ".($val == $fieldItem['Search'] ? "selected='selected'" : "" ).">{$val}</option>";
			}
			$FieldEditContent .= "</select></td>
							</tr>
						</table>
						<input type='hidden' value='{$fieldItem['ID']}' name='edit[ID]' />
						<input type='hidden' value='".htmlspecialchars($XVweb->Session->get_sid())."' name='xv-sid' />
						
						<input type='submit' value='Save' />
						
					</form>
					</fieldset>
				</div> 
			
			
			";
			
			
			
		}
		$FieldEditContent .= "</div>";
		
		$this->content = "
		<div  style='overflow-y:scroll; max-height: 600px;'>
			<div style='text-align:center; font-size: 16px;'> Now edit: <b>{$_GET['cat']}</b></div>
				<fieldset>
					<legend>Fields</legend>
						{$FieldEditContent}
					</legend>
				</fieldset>
				<fieldset>
					<legend>Add new field</legend>
						<div class='auction-newfield-result'></div>
					<form method='post'	action='{$GLOBALS['URLS']['Script']}Administration/get/XVauctions/NewField/' class='xv-form' data-xv-result='.auction-newfield-result'>
					<input type='hidden' value='".htmlspecialchars($XVweb->Session->get_sid())."' name='xv-sid' />
					<input type='hidden' value='".htmlspecialchars($_GET['cat'])."' name='newfield[category]' />
						<div>
							<label for='auction-newfield-name'>Field name (ascii chart) [<a href='http://xvauctions.pl/wiki/Category:Fields' target='blank'>?</a>]: </label><input type='text' name='newfield[name]' id='auction-newfield-name' />
						</div>
						<div>
							<label for='auction-newfield-type'>Field type: </label>
							<select name='newfield[type]' id='auction-newfield-type'>{$FieldsTypes}</select>
						</div>
						<div>
						<input type='submit' value='Add field' />
					</legend>
				</fieldset>
				<div style='clear:both;'>
			</div>
			";
	}
}

?>