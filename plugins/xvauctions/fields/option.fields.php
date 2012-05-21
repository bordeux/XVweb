<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xvauction_fields_option extends xvauction_fields {
	var $Type = "integer";
	var $XVweb = null;

	public function __construct(&$Xvweb) {
		$this->XVweb = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	function options(){
		$array = array(
			"caption" => "Styl: ",
			"quick_select_style" => "width: 64px;",
			"advanced_select_style" => "width: 64px;",
			"quick_label_style" => "width: 64px;",
			"advanced_label_style" => "width: 64px;",
			"options" => "First\nSecond",
			"quick_option_empty" => "&nbsp;",
			"advanced_option_empty" => "&nbsp;",
			"input_desc" => "Tytuł może zawierać od 3 do 50 znaków.",
			"caption_desc" => "Change",
			"error" => "Zle dane podales!",
			"required" => "0",

		);
		return ($array);

	}
	
	function quick($field){
		$fieldOptions = ($field['FieldOptions']);
		$Result = "
			<div class='auction-search-quick-item'>
				<label style='".$fieldOptions['quick_label_style']."' for='".$field['Name']."-id'>".$fieldOptions['caption']."</label> 
				<select name='".$field['Name']."' id='".$field['Name']."-id'  style='".$fieldOptions['quick_select_style']."'>
					<option value='none'>".$fieldOptions['quick_option_empty']."</option>
					";
				$options = explode("\n", $field['FieldOptions']['options']);
				
				foreach($options as $key=>$val){
					$Result .= '<option value="'.$key.'" '.((isset($_GET[$field['Name']]) && $_GET[$field['Name']] == $key) ? 'selected="selected" ': ' ').'>'.$val.'</option>';
				}
				$Result .= "</select>
				</div>";
		return $Result;
	}

	function advanced($field){
		$fieldOptions = ($field['FieldOptions']);
		$Result = "
			<div class='auction-search-advanced-item'>
				<label style='".$fieldOptions['advanced_label_style']."' for='".$field['Name']."-id'>".$fieldOptions['caption']."</label> 
				<select name='".$field['Name']."' id='".$field['Name']."-id'  style='".$fieldOptions['advanced_select_style']."'>
					<option value=''>".$fieldOptions['advanced_option_empty']."</option>
					";
				$options = explode("\n", $field['FieldOptions']['options']);
				
				foreach($options as $key=>$val){
					$Result .= '<option value="'.$key.'" '.($_GET[$field['Name']] == $key ? 'selected="selected" ': ' ').'>'.$val.'</option>';
				}
				$Result .= "</select>
		</div>";
				
		return $Result;
	}

	function query($field){
		$UniqID = uniqid();
		$fieldOptions = ($field['FieldOptions']);
		if(!isset($_GET[$field['Name']]) or empty($_GET[$field['Name']]) or !is_numeric($_GET[$field['Name']])){
			unset($_GET[$field['Name']]);
			return null;
		}
		
		$Result = '( f.{AuctionFields:Name} = :'.$UniqID .'FieldName AND v.{AuctionValues:Val} = :'.$UniqID .'FieldVal )';
		return array($Result, array(
		':'.$UniqID .'FieldName' =>$field['Name'],
		':'.$UniqID .'FieldVal' => $_GET[$field['Name']],
		));
	}
	
	function add_form($field, $fail=false){
	$options = explode("\n", $field['FieldOptions']['options']);
	
	$Result =	'<div class="xvauction-add-item'.($fail ? ' xvauction-add-item-error' : '' ).'">
					<div class="xvauction-add-name">
					'.$field['FieldOptions']['caption'].'
					'.($field['FieldOptions']['caption_desc'] == "" ? : '<div class="xvauction-add-name-desc">'.$field['FieldOptions']['caption_desc'].'</div>').'
					</div>
					<div class="xvauction-add-input"> ';		
				$Result .= "<select name='add[".$field['Name']."]'  >";

				if($field['FieldOptions']['required'] == 0){
					$Result .= "<option value='none'>Wybierz</option>";	
				}
				foreach($options as $key=>$val){
					$Result .= '<option value="'.$key.'" '.($_POST['add'][$field['Name']] == $key ? 'selected="selected" ': ' ').'>'.$val.'</option>';
				}
				
			$Result .= '</select>
			'.($fail ? '<div class="xvauction-add-input-error">'.$field['FieldOptions']['error'].'</div>'  : '' ).'
			
						'.($field['FieldOptions']['input_desc'] == "" ? "" : '<div class="xvauction-add-input-desc">'.$field['FieldOptions']['input_desc'].'</div>' ).'
					</div>
					<div class="clear"></div>
				</div>	';
	return $Result;
	}
	
	public function valid($field){
	if($field['FieldOptions']['required'] == 0){
		return true;
	}
		$options = explode("\n", $field['FieldOptions']['options']);
		if(isset($options[$_POST['add'][$field['Name']]]))
			return true;
			
		return false;
	}
	public function insert($field, $auction_id){
		$insert_query = $this->XVweb->DataBase->prepare('INSERT INTO {AuctionValues} ({AuctionValues:IDS}, {AuctionValues:Val}, {AuctionValues:Auction}) VALUES (:fieldID, :value, :auctionID );');
		$insert_query->execute(array(
				":auctionID" => $auction_id,
				":value" =>  $_POST['add'][$field['Name']],
				":fieldID" => $field['ID']
			));
	return true;
	}

	public function remove_filter(&$field){
	if(!isset($_GET[$field['Name']]))
		return null;
	if(strlen($_GET[$field['Name']]) == 0)
		return null;
	if(!is_numeric($_GET[$field['Name']]))
		return null;
		
	$options = explode("\n", $field['FieldOptions']['options']);
		return array(
			"link"=> $this->XVweb->add_get_var(array(
				($field['Name']) => ''	
			), true),
			"caption" => $fieldOptions['caption'].'  '.htmlspecialchars(ifsetor($options[$_GET[$field['Name']]], ''))
		);
	}
	public function detail($field){
		
		return null;
	}
}

?>