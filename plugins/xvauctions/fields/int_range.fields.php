<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xvauction_fields_int_range extends xvauction_fields {
var $Type = "integer";
	var $XVweb = null;

	public function __construct(&$Xvweb) {
		$this->XVweb = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	function options(){
		$array = array(
		"Caption" => "Cost: ",
		"Before" => "from ",
		"Center" => "to ",
		"After" => " $",
		"AddDefault" => "",

		"QuickLabelFirstStyle" => "width: 64px;",
		"QuickLabelSecondStyle" => "width: 64px;",
		"QuickInputFirstStyle" => "width: 64px;",
		"QuickInputSecondStyle" => "width: 64px;",
		
		"AdvancedInputStyle" => "width: 64px;",
		"AdvancedAferText" => "",
		"AdvancedLabelStyle" => "width: 64px;",
		"maxlength" => "250",
		"InputDesc" => "Liczba może zawierać od 0 do 50 znaków.",
		"CaptionDesc" => "Change",
		"Error" => "Zle dane podales!",
		"Filter" => "/^([0-9]){0,}$/",
		
		"detail_enable" => "1",
		"detail_caption" => "Details",
		"detail_before" => "",
		"detail_after" => "",
		);
		return ($array);

	}
	
	function quick($field){
		$fieldOptions = ($field['FieldOptions']);
		$Result = "
			<div class='auction-search-quick-item'>
				<fieldset>
				<legend><label style='".$fieldOptions['QuickLabelFirstStyle']."' for='".$field['Name']."-id'>".$fieldOptions['Caption']."</label></legend>
				 ".$fieldOptions["Before"]."
				<input pattern='([0-9]){0,}' id='".$field['Name']."-id' type='text' value='".htmlspecialchars($_GET[$field['Name'].'_from'])."' name='".$field['Name']."_from' style='".$fieldOptions['QuickInputFirstStyle']."' /> 
				<label for='".$field['Name']."-two-id' style='".$fieldOptions['QuickLabelSecondStyle']."'>".$fieldOptions["Center"]."</label>
				<input pattern='([0-9]){0,}' id='".$field['Name']."-two-id' type='text' value='".htmlspecialchars($_GET[$field['Name'].'_to'])."' name='".$field['Name']."_to' style='".$fieldOptions['QuickInputSecondStyle']."' /> ".$fieldOptions["After"]."
				</fieldset>
			</div>
		";
		return $Result;
	}

	function advanced($field){
		$fieldOptions = ($field['FieldOptions']);
		$Result = "
			<div class='auction-search-advanced-item'>
				<label style='".$fieldOptions['AdvancedLabelStyle']."' for='".$field['Name']."-id'>".$fieldOptions['Caption']."</label><input id='".$field['Name']."-id' type='text' value='".htmlspecialchars($_GET[$field['Name']])."' name='".$field['Name']."' style='".$fieldOptions['AdvancedInputStyle']."' /> ".$fieldOptions["AdvancedAferText"]."
			</div>
		";
		return $Result;
	}

	function query($field){
		$UniqID = uniqid();
		$fieldOptions = ($field['FieldOptions']);
		if(!is_numeric($_GET[$field['Name'].'_from']) && !is_numeric($_GET[$field['Name'].'_to'])){
			unset($_GET[$field['Name'].'_from']);
			unset($_GET[$field['Name'].'_to']);
			
			return null;
		}
		$ExecuteArray = array();
		$Result = '(f.{AuctionFields:Name} = :'.$UniqID .'FieldName ';
							$ExecuteArray[':'.$UniqID .'FieldName'] = $field['Name'];
							
		if(is_numeric($_GET[$field['Name'].'_from'])){
			$Result .= ' AND CONVERT(v.{AuctionValues:Val}, signed) >=  :'.$UniqID .'FieldValFrom';
			$ExecuteArray[':'.$UniqID .'FieldValFrom'] = (int)$_GET[$field['Name'].'_from'];
		}else{
			unset($_GET[$field['Name'].'_from']);
		}
		if(is_numeric($_GET[$field['Name'].'_to'])){
			$Result .= ' AND CONVERT(v.{AuctionValues:Val}, signed) <=  :'.$UniqID .'FieldValTo';
			$ExecuteArray[':'.$UniqID .'FieldValTo'] = (int)$_GET[$field['Name'].'_to'];
		}else{
			unset($_GET[$field['Name'].'_to']);
		}
		
		$Result .= ')';
		
		return array($Result,$ExecuteArray);
	}
	function add_form($field, $fail= false){
	$Result =	'<div class="xvauction-add-item'.($fail ? ' xvauction-add-item-error' : '' ).'">
					<div class="xvauction-add-name">
					'.$field['FieldOptions']['Caption'].'
					'.($field['FieldOptions']['CaptionDesc'] == "" ? : '<div class="xvauction-add-name-desc">'.$field['FieldOptions']['CaptionDesc'].'</div>').'
					</div>
					<div class="xvauction-add-input"> 		
						<input name="add['.$field['Name'].']" value="'.htmlspecialchars(ifsetor($_POST['add'][$field['Name']] , $field['FieldOptions']['AddDefault'])).'" maxlength="'.$field['FieldOptions']['maxlength'].'" />
						'.($fail ? '<div class="xvauction-add-input-error">'.$field['FieldOptions']['Error'].'</div>'  : '' ).'
						
						'.($field['FieldOptions']['InputDesc'] == "" ? "" : '<div class="xvauction-add-input-desc">'.$field['FieldOptions']['InputDesc'].'</div>' ).'
					</div>
					<div class="clear"></div>
				</div>	';
	return $Result;
	}
	public function valid($field){
	if(isset($field['FieldOptions']['Filter']) && $field['FieldOptions']['Filter'] != ""){
			if (@preg_match($field['FieldOptions']['Filter'], $_POST['add'][$field['Name']])) {
				return true;
			} else {
				return false;
		}

		}else{
			return true;
		}
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
	$fieldOptions = ($field['FieldOptions']);
	$CaptionText = $fieldOptions['Caption']." ";
	$show = false;
			if(is_numeric($_GET[$field['Name'].'_from'])){
				$CaptionText .= $fieldOptions["Before"].' '.( (int) $_GET[$field['Name'].'_from']);
				$show = true;
			}
		if(is_numeric($_GET[$field['Name'].'_to'])){
			$CaptionText .= $fieldOptions["Center"].' '.((int)$_GET[$field['Name'].'_to']);
			$show = true;
		}
		if(!$show)
			return null;
		return array(
			"link"=> $this->XVweb->add_get_var(array(
				$field['Name'].'_from' => null,
				$field['Name'].'_to' => null	
			), true),
			"caption" => $CaptionText
		);
	}


	public function detail($field, $val){
	if(!$field['FieldOptions']['detail_enable'])
		return null;
		
		return array(
		"caption" => ifsetor($field['FieldOptions']['detail_caption'], '') ,
		"val" => ifsetor($field['FieldOptions']['etail_before'], '').$val['Val'].ifsetor($field['FieldOptions']['detail_after'], ''),
		);
	}
}

?>