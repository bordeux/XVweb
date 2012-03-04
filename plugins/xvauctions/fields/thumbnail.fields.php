<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xvauction_fields_thumbnail extends xvauction_fields {
	var $Type = "integer";
	var $XVweb = null;

	public function __construct(&$Xvweb) {
		$this->XVweb = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	
	
	function options(){
		$array = array(
		"caption" => "Miniaturka : ",
		"input_desc" => "Gragika w rozdzielczosci 64x48",
		"caption_desc" => "Change",
		"error" => "Zly format pliku!",
		"resize_width" => "64",
		"resize_height" => "48",
		"required" => "1",
		


		);
		return ($array);

	}
	
	function quick(&$field){
		return '';
	}

	function advanced(&$field){
		return '';
	}

	function query(&$field){
		return null;
	}
	
	function add_form(&$field, $fail= false){
	if(isset($_FILES['upload']['tmp_name'][$field['Name']]) && file_exists($_FILES['upload']['tmp_name'][$field['Name']])){
	include_once($GLOBALS['LocationXVWeb'].DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'ResizeImage.class.php');
	$UniqID = uniqid().'.jpg';
	if($_POST['add'][$field['Name']] != ""){
		@unlink(ROOT_DIR.'plugins/xvauctions/th-tmp/'.str_replace(array("..", "/", "\\"), '', $_POST['add'][$field['Name']]));
	}
	
	$_POST['add'][$field['Name']] = $UniqID;
						$image = new SimpleImage();
						$image->load($_FILES['upload']['tmp_name'][$field['Name']]);
						$image->resize($field['FieldOptions']['resize_width'], $field['FieldOptions']['resize_height']);
						$image->save(ROOT_DIR.'plugins/xvauctions/th-tmp/'.$UniqID);	
						$image = new SimpleImage();
						$image->load($_FILES['upload']['tmp_name'][$field['Name']]);
						$image->resize(300, 200);
						$image->save(ROOT_DIR.'plugins/xvauctions/th-tmp/300x200_'.$UniqID);	
	}
	if(isset($_POST['delete'][$field['Name']])){
		@unlink(ROOT_DIR.'plugins/xvauctions/th-tmp/'.str_replace(array("..", "/", "\\"), '', $_POST['add'][$field['Name']]));
		@unlink(ROOT_DIR.'plugins/xvauctions/th-tmp/300x200_'.str_replace(array("..", "/", "\\"), '', $_POST['add'][$field['Name']]));
		$_POST['add'][$field['Name']] = '';
	}
	
	$Result =	'<div class="xvauction-add-item'.($fail ? ' xvauction-add-item-error' : '' ).'">
					<div class="xvauction-add-name">
					'.$field['FieldOptions']['caption'].'
					'.($field['FieldOptions']['caption_desc'] == "" ? "" : '<div class="xvauction-add-name-desc">'.$field['FieldOptions']['caption_desc'].'</div>').'
					</div>
					<div class="xvauction-add-input"> 
						<input type="hidden" name="add['.$field['Name'].']" value="'.$_POST['add'][$field['Name']].'" />
						'.($_POST['add'][$field['Name']] == "" ? "" : '<img src="'.$GLOBALS['URLS']['Site'].'plugins/xvauctions/th-tmp/'.$_POST['add'][$field['Name']].'" style="width: '.$field['FieldOptions']['resize_width'].'px; height: '.$field['FieldOptions']['resize_height'].'px;" alt="Miniatura" /> <input type="submit" value="Usuń miniature" name="delete['.$field['Name'].']"  /> ').'
						
						<input name="upload['.$field['Name'].']" type="file"  onchange="$(this).parents(\'.xvauction-add-form\').submit();"/>
						
						'.($fail ? '<div class="xvauction-add-input-error">'.$field['FieldOptions']['error'].'</div>'  : '' ).'
						
						'.($field['FieldOptions']['input_desc'] == "" ? "" : '<div class="xvauction-add-input-desc">'.$field['FieldOptions']['input_desc'].'</div>' ).'
					</div>
					<div class="clear"></div>
				</div>	';
	return $Result;
	}
	public function valid(&$field){
		if((int) $field['FieldOptions']['required']){
			if($_POST['add'][$field['Name']] == "")
				return false;
		}
	return true;
	}
	public function insert($field, $auction_id){
	$FileName = str_replace(array("..", "/", "\\"), '', $_POST['add'][$field['Name']]);
	@rename(ROOT_DIR.'plugins/xvauctions/th-tmp/'.$FileName, ROOT_DIR.'plugins/xvauctions/th/'.$FileName);
	@rename(ROOT_DIR.'plugins/xvauctions/th-tmp/300x200_'.$FileName, ROOT_DIR.'plugins/xvauctions/th/300x200_'.$FileName);
		$insert_query = $this->XVweb->DataBase->prepare('INSERT INTO {AuctionValues} ({AuctionValues:IDS}, {AuctionValues:Val}, {AuctionValues:Auction}) VALUES (:fieldID, :value, :auctionID );');
		$insert_query->execute(array(
				":auctionID" => $auction_id,
				":value" =>  $FileName,
				":fieldID" => $field['ID']
			));	
		$update_auction = $this->XVweb->DataBase->prepare('UPDATE {AuctionAuctions} SET {AuctionAuctions:Thumbnail} = :thumbnail WHERE {AuctionAuctions:ID} = :auctionID;');
		$update_auction->execute(array(
				":auctionID" => $auction_id,
				":thumbnail" =>  $FileName
			));
	return true;
	}
	public function remove_filter(&$field){
		return null;
	}
	public function detail($field){
		
		return null;
	}
	public function edit_trigger($field, $auction_id, $auction_info){
		$FileName = $auction_info['Thumbnail'];
		if (file_exists(ROOT_DIR.'plugins/xvauctions/th/'.$FileName) && !file_exists(ROOT_DIR.'plugins/xvauctions/th-tmp/'.$FileName)) 
			@copy(ROOT_DIR.'plugins/xvauctions/th/'.$FileName, ROOT_DIR.'plugins/xvauctions/th-tmp/'.$FileName);
		
		if (file_exists(ROOT_DIR.'plugins/xvauctions/th/300x200_'.$FileName) && !file_exists(ROOT_DIR.'plugins/xvauctions/th-tmp/300x200_'.$FileName)) 
			@copy(ROOT_DIR.'plugins/xvauctions/th/300x200_'.$FileName, ROOT_DIR.'plugins/xvauctions/th-tmp/300x200_'.$FileName);
		return null;
	}
}

?>