<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xvauction_fields_string extends xvauction_fields {
	var $Type = "string";
	var $XVweb = null;

	public function __construct(&$Xvweb) {
		$this->XVweb = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	
	
	function options(){
		$array = array(
		"caption" => "Szukaj przez",
		"quick_input_style" => "width: 64px;",
		"quick_afer_text" => "",
		"quick_label_style" => "width: 64px;",
		"advanced_input_style" => "width: 64px;",
		"advanced_afer_text" => "",
		"advanced_label_style" => "width: 64px;",
		"maxlength" => "250",
		"input_desc" => "Tytul moze zawierac od 3 do 50 znaków.",
		"caption_desc" => "Change",
		"error" => "Zle dane podales!",
		"filter" => "/(.*?)/",
		"HTML5_pattern" => "",
		"input_type" => "text",
		

		"detail_enable" => "1",
		"detail_caption" => "Details",
		"detail_before" => "",
		"detail_after" => "",
		);
		return ($array);

	}
	
	function quick(&$field){
		$fieldOptions = ($field['FieldOptions']);
		$Result = "
			<div class='auction-search-quick-item'>
				<label style='".$fieldOptions['quick_label_style']."' for='".$field['Name']."-id'>".$fieldOptions['caption']."</label><input id='".$field['Name']."-id' type='text' value='".htmlspecialchars($_GET[$field['Name']])."' name='".$field['Name']."' style='".$fieldOptions['quick_input_style']."' /> ".$fieldOptions["quick_afer_text"]."
			</div>
		";
		return $Result;
	}

	function advanced(&$field){
		$fieldOptions = ($field['FieldOptions']);
		$Result = "
			<div class='auction-search-advanced-item'>
				<label style='".$fieldOptions['advanced_label_style']."' for='".$field['Name']."-id'>".$fieldOptions['caption']."</label><input id='".$field['Name']."-id' type='text' value='".htmlspecialchars($_GET[$field['Name']])."' name='".$field['Name']."' style='".$fieldOptions['advanced_input_style']."' /> ".$fieldOptions["advanced_afer_text"]."
			</div>
		";
		return $Result;
	}

	function query(&$field){
		$UniqID = uniqid();
		$fieldOptions = ($field['FieldOptions']);
		if(!isset($_GET[$field['Name']]) or empty($_GET[$field['Name']]) or strlen($_GET[$field['Name']]) < 3){
			return null;
		}
		
		$Result = '( f.{AuctionFields:Name} = :'.$UniqID .'FieldName AND v.{AuctionValues:Val} = :'.$UniqID .'FieldVal )';
		return array($Result, array(
		':'.$UniqID .'FieldName' =>$field['Name'],
		':'.$UniqID .'FieldVal' => $_GET[$field['Name']],
		));
	}
	
	function add_form(&$field, $fail= false){
	$Result =	'<div class="xvauction-add-item'.($fail ? ' xvauction-add-item-error' : '' ).'">
					<div class="xvauction-add-name">
					'.$field['FieldOptions']['caption'].'
					'.($field['FieldOptions']['caption_desc'] == "" ? "" : '<div class="xvauction-add-name-desc">'.$field['FieldOptions']['caption_desc'].'</div>').'
					</div>
					<div class="xvauction-add-input"> 		
						<input type="'.$field['FieldOptions']['input_type'].'" name="add['.$field['Name'].']" value="'.htmlspecialchars($_POST['add'][$field['Name']]).'" maxlength="'.$field['FieldOptions']['maxlength'].'"  '.($field['FieldOptions']['HTML5_pattern'] =="" ? "" : ' pattern="'.$field['FieldOptions']['HTML5_pattern'].'"').' />
						
						'.($fail ? '<div class="xvauction-add-input-error">'.$field['FieldOptions']['error'].'</div>'  : '' ).'
						
						'.($field['FieldOptions']['input_desc'] == "" ? "" : '<div class="xvauction-add-input-desc">'.$field['FieldOptions']['input_desc'].'</div>' ).'
					</div>
					<div class="clear"></div>
				</div>	';
	return $Result;
	}
	public function valid(&$field){
	if(isset($field['FieldOptions']['filter']) && $field['FieldOptions']['filter'] != ""){
			if (@preg_match($field['FieldOptions']['filter'], $_POST['add'][$field['Name']])) {
				return true;
			} else {
				return false;
		}

		}else{
			return true;
		}
	}
	public function insert(&$field, $auction_id){
		$insert_query = $this->XVweb->DataBase->prepare('INSERT INTO {AuctionValues} ({AuctionValues:IDS}, {AuctionValues:Val}, {AuctionValues:Auction}) VALUES (:fieldID, :value, :auctionID );');
		$insert_query->execute(array(
				":auctionID" => $auction_id,
				":value" =>  $_POST['add'][$field['Name']],
				":fieldID" => $field['ID']
			));
	return true;
	}
	public function remove_filter(&$field){
	if(strlen($_GET[$field['Name']]) == 0)
		return null;
		
		return array(
			"link"=> $this->XVweb->add_get_var(array(
				($field['Name']) => ''	
			), true),
			"caption" => $fieldOptions['caption'].'  '.htmlspecialchars(ifsetor($_GET[$field['Name']], ''))
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