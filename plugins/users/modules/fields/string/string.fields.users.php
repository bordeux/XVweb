<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xv-userss.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xv_users_fields_string extends xv_users_fields {
	var $Type = "string";
	var $XVweb = null;

	public function __construct(&$Xvweb) {
		$this->XVweb = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	
	
	function options(){
		$array = array(
			"caption" => "Szukaj przez",
			"maxlength" => "250",
			"input_desc" => "Tytul moze zawierac od 3 do 50 znaków.",
			"caption_desc" => "Change",
			"error" => "Zle dane podales!",
			"filter" => "/(.*?)/",
			"HTML5_pattern" => "",
			"input_type" => "text",
		);
		return ($array);

	}

	function add_form(&$field, $fail= false){
	$Result =	'<div class="xv-users-add-item'.($fail ? ' xv-users-add-item-error' : '' ).'">
					<div class="xv-users-add-name">
					'.$field['FieldOptions']['caption'].'
					'.($field['FieldOptions']['caption_desc'] == "" ? "" : '<div class="xv-users-add-name-desc">'.$field['FieldOptions']['caption_desc'].'</div>').'
					</div>
					<div class="xv-users-add-input"> 		
						<input type="'.$field['FieldOptions']['input_type'].'" name="add['.$field['Name'].']" value="'.htmlspecialchars($_POST['add'][$field['Name']]).'" maxlength="'.$field['FieldOptions']['maxlength'].'"  '.($field['FieldOptions']['HTML5_pattern'] =="" ? "" : ' pattern="'.$field['FieldOptions']['HTML5_pattern'].'"').' />
						
						'.($fail ? '<div class="xv-users-add-input-error">'.$field['FieldOptions']['error'].'</div>'  : '' ).'
						
						'.($field['FieldOptions']['input_desc'] == "" ? "" : '<div class="xv-users-add-input-desc">'.$field['FieldOptions']['input_desc'].'</div>' ).'
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
			"link"=> $this->XVweb->AddGet(array(
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