<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

$auction_id =  strtolower($XVwebEngine->GetFromURL($PathInfo, 2));

$auction_info = xvp()->get_auction($XVauctions, $auction_id);
if(empty($auction_info)){
	$auction_archive = xvp()->get_from_archive($XVauctions, $auction_id);
	if($auction_archive == null){
		header("location: ".$URLS['Script'].'Page/xvAuctions/404/');
		exit;
	}else{
		$auction_info = &$auction_archive['auction'];
		$auction_offers = &$auction_archive['offers'];
		$fields_values = &$auction_archive['fields'];
		foreach($auction_archive['texts'] as $val){
			if($val['Name'] == "description")
				$auction_description = $val['Text'];
		}
	}
}

if(!isset($auction_description))
	$auction_description = xvp()->get_auction_description($XVauctions, $auction_info['ID'], "description");
	
if(is_null($auction_description)){
	exit("xvAuction: Error with description.");
}

$auction_selled = 0;
if(!isset($auction_offers))
	$auction_offers = xvp()->get_offers($XVauctions, $auction_info['ID']);
	
if(is_array($auction_offers)){
	foreach($auction_offers as $offer){
		$auction_selled += $offer['Pieces'];
	}
}

$fields = xvp()->get_fields($XVauctions, $auction_info['Category']);
if(!isset($fields_values))
	$fields_values = xvp()->get_fields_values($XVauctions, $auction_info['ID']);
$fields_classes = array();
$auction_details = array();
$auction_footer = array();
foreach($fields as $field){
	$class_field_name = $field['Class'];
	$field_name = $field['Name'];
	include_once(ROOT_DIR.'plugins/xvauctions/fields/fields.php');
	include_once(ROOT_DIR.'plugins/xvauctions/fields/'.substr($class_field_name, 17).'.fields.php');
	if (class_exists($class_field_name)) {
		$fields_classes[$class_field_name] = new $class_field_name($XVwebEngine);
		$detail = $fields_classes[$class_field_name]->detail($field, $fields_values[$field['ID']], $auction_info['ID']);
		$footer = $fields_classes[$class_field_name]->footer($field, $fields_values[$field['ID']], $auction_info['ID']);
		if(is_array($detail)){
			$auction_details[] = $detail;
		}		
		if(!is_null($footer)){
			$auction_footer[] = $footer;
		}
	}
}


$category_tree = xvp()->get_category_tree($XVauctions, $auction_info['Category']);
$category_info = end($category_tree);
$auction_category = $auction_info['Category'];
$xva_config = $category_info['Options'];

$Smarty->assignByRef('xva_config', $xva_config);
$Smarty->assignByRef('auction_details', $auction_details);
$Smarty->assignByRef('auction_offers', $auction_offers);
$Smarty->assignByRef('auction_selled', $auction_selled);
$Smarty->assignByRef('auction_footer', $auction_footer);

$Smarty->assign('auction_available_pieces', ($auction_info['Pieces'] - $auction_selled));

$Smarty->assign('Title', $auction_info['Title']);
$Smarty->assign('SiteTopic', $auction_info['Title']);

$Smarty->assignByRef('category_tree', $category_tree);
$Smarty->assignByRef('auction_info', $auction_info);
$Smarty->assignByRef('auction_description', $auction_description);


$Smarty->display('xvauctions_theme/auction_show.tpl');

?>