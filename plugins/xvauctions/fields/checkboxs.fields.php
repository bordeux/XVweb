<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xvauction_fields_checkboxs extends xvauction_fields {
	var $Type = "string";
	var $XVweb = null;

	public function __construct(&$Xvweb) {
		$this->XVweb = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	
	
	function options(){
		$array = array(
			"caption" => "Caption",
			"input_description" => "Tytul moze zawierac od 3 do 50 znaków.",
			"caption_description" => "Caption descriptions",
			"error" => "Bad input, please fix problems",
			"methods" => 
"First
Second
Third",
	"detail_enable" => 1,
	"detail_caption" => "Detail description",
	"min_select" => 0,
	"max_select" => 0,
	"quick_caption" => "caption",
		);
		return ($array);

	}
	
	/*function quick(&$field){
		$fieldOptions = ($field['FieldOptions']);
		$Result = "
			<div class='auction-search-quick-item'>
				<div>".$fieldOptions['quick_caption']."</div>
				<table>";
$select_methods = explode("\n", $field['FieldOptions']['methods']);
						foreach($select_methods as $key=>$method){
							$Result .= '
							<tr>
								<td style="width: 20px; padding-right: 10px;"><input type="checkbox" value="'.$key.'" name="add['.$field['Name'].']['.$key.']" id="xvacheckboxs-'.$field['Name'].'-'.$key.'"  style="margin: 4px;" '.(ifsetor($_POST['add'][$field['Name']][$key], "false") == "true" ? ' checked="checked" ' : '').'/></td>
								<td><label for="xvacheckboxs-'.$field['Name'].'-'.$key.'">'.trim($method).'</label></td>
							</tr>
							';
						}
	
			$Result ."</table></div>
		";
		return $Result;
	}*/
	
	function quick(&$field){
		$fieldOptions = ($field['FieldOptions']);
		$Result = "
			<div class='auction-search-quick-item'>
				<fieldset>
					<legend>".$fieldOptions['quick_caption']."</legend>";
					
			$select_methods = explode("\n", $field['FieldOptions']['methods']);
			foreach($select_methods as $key=>$method){
			$Result .= '<div><input type="checkbox" value="true" name="'.$field['Name'].'['.$key.']" id="xvacheckboxs-'.$field['Name'].'-'.$key.'"  style="margin: 4px;" '.(ifsetor($_GET[$field['Name']][$key], "false") == "true" ? ' checked="checked" ' : '').'/> <label for="xvacheckboxs-'.$field['Name'].'-'.$key.'">'.trim($method).'</label></div>';
			}
			$Result .=	"</fieldset>
			</div>
		";
		return $Result;
	}

	function advanced(&$field){
		return '';
	}

	function query(&$field){
		$UniqID = uniqid();
		$fieldOptions = ($field['FieldOptions']);
		if(!isset($_GET[$field['Name']]) or empty($_GET[$field['Name']]) or !is_array($_GET[$field['Name']])){
			return null;
		}
		$db_execute= array(':'.$UniqID .'FieldName' =>$field['Name']);
		$queries = array();
		$actual = 0;
		foreach($_GET[$field['Name']] as $key=>$val){
			if(is_numeric($key) && $key < 500 && $val == "true"){
				$actual++;
				$queries[] = " v.{AuctionValues:Val} LIKE :".$UniqID .$actual."FieldVal ";
				$db_execute[":".$UniqID .$actual."FieldVal"] = "%i:".$key.";i:1;%";
			}
		}
		
		if($actual==0)
			return null;
			
		$Result = '( f.{AuctionFields:Name} = :'.$UniqID .'FieldName AND '.implode(" AND ", $queries).' )';
		return array($Result, $db_execute);
	}
	
	function add_form(&$field, $fail= false){
	$Result =	'<div class="xvauction-add-item'.($fail ? ' xvauction-add-item-error' : '' ).'">
					<div class="xvauction-add-name">
					'.$field['FieldOptions']['caption'].'
					'.($field['FieldOptions']['caption_description'] == "" ? "" : '<div class="xvauction-add-name-desc">'.$field['FieldOptions']['caption_description'].'</div>').'
					</div>
					<div class="xvauction-add-input"> 
					<table>
					
					';
					
					$select_methods = explode("\n", $field['FieldOptions']['methods']);
						foreach($select_methods as $key=>$method){
							$Result .= '
							<tr>
								<td style="width: 20px; padding-right: 10px;"><input type="checkbox" value="true" name="add['.$field['Name'].']['.$key.']" id="xvacheckboxs-'.$field['Name'].'-'.$key.'"  style="margin: 4px;" '.(ifsetor($_POST['add'][$field['Name']][$key], "false") == "true" ? ' checked="checked" ' : '').'/></td>
								<td><label for="xvacheckboxs-'.$field['Name'].'-'.$key.'">'.trim($method).'</label></td>
							</tr>
							';
						}
						
				$Result .=	'</table>
				
				'.($fail ? '<div class="xvauction-add-input-error">'.$field['FieldOptions']['error'].'</div>'  : '' ).'
				
				'.($field['FieldOptions']['input_description'] == "" ? "" : '<div class="xvauction-add-input-desc">'.$field['FieldOptions']['input_description'].'</div>' ).'
				</div>
					<div class="clear"></div>
				</div>	';
	return $Result;
	}
	public function valid(&$field){
		if(!isset($_POST['add'][$field['Name']])){
			if($field['FieldOptions']['min_select'] == 0){
				return true;
			}
			return false;
		}
		if(!is_array($_POST['add'][$field['Name']]))
			return false;
		$filed_selected = 0;
		foreach($_POST['add'][$field['Name']] as $key=>$val){
			if(!is_numeric($key))
				return false;
				
			if($val == "true"){
				$field_selected++;
			}
		
		}
		$field['FieldOptions']['max_select'] = (int) $field['FieldOptions']['max_select'];
		$field['FieldOptions']['min_select'] = (int) $field['FieldOptions']['min_select'];
		
		if($field['FieldOptions']['min_select'] > $filed_selected)
			return false;
		if($field['FieldOptions']['max_select'] && $field['FieldOptions']['max_select'] < $filed_selected)
			return false;
			
		return true;
		
	}
	public function insert(&$field, $auction_id){
		$insert_query = $this->XVweb->DataBase->prepare('INSERT INTO {AuctionValues} ({AuctionValues:IDS}, {AuctionValues:Val}, {AuctionValues:Auction}) VALUES (:fieldID, :value, :auctionID );');
		$array_add = array();
		
		foreach($_POST['add'][$field['Name']] as $key=>$val){
			if($val == "true"){
				$array_add[$key] = 1;
			}
		
		}
		
		$insert_query->execute(array(
				":auctionID" => $auction_id,
				":value" =>  serialize($array_add),
				":fieldID" => $field['ID']
			));
	return true;
	}
	public function remove_filter(&$field){
		if(!is_array($_GET[$field['Name']]))
			return null;

		$result = array();
		$select_methods = explode("\n", $field['FieldOptions']['methods']);
		
		foreach($_GET[$field['Name']] as $key=>$val){
			if(isset($select_methods[$key]) && $val == "true"){
				$result[] = 	array(
					"link"=>"test",
					"caption" => $select_methods[$key]
				);
			}
		}
		return $result;
	}
	public function detail($field, $val){
	if(!$field['FieldOptions']['detail_enable'])
		return null;
	if(empty($val))
		return null;
		$select_methods = explode("\n", $field['FieldOptions']['methods']);
		
		$options = unserialize($val['Val']);
		$details_val = array();
		foreach($options as $key=>$val){
			$details_val[] = "<span>".$select_methods[$key]."</span>";
		}
		return array(
		"caption" => ifsetor($field['FieldOptions']['detail_caption'], '') ,
		"val" =>  implode(", ", $details_val),
		);
	}
}

?>