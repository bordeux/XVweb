<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

$URLS['Auctions'] = $URLS['Script'].$auction_prefix;

$auction_category =  substr($PathInfo, strlen($auction_prefix)+1);

$category_tree = xvp()->get_category_tree($XVauctions, $auction_category);

if(empty($category_tree) &&  $auction_category != '/'){
	header("location: ".$URLS['Script'].'Page/xvAuctions/Category_404/');
	exit;
}
	include_once(ROOT_DIR.'plugins/xvauctions/fields/fields.php');
	foreach (glob(ROOT_DIR.'plugins/xvauctions/fields/*.fields.php') as $filename) {
			include_once($filename);
	}
		
if(empty($category_tree)){
	$auction_category = "/";
	include(ROOT_DIR.'plugins/xvauctions/config/default.php');
}else{
	$auction_info = end($category_tree);
	$auction_category = $auction_info['Category'];
	$xva_config = $auction_info['Options'];
}

$Smarty->assignByRef('xva_config', $xva_config);
$fields = xvp()->get_fields($XVauctions, $auction_category);
$fields_classes = array();
$quick_search_fields = array();
$search_filters_remove = array();
$queries_search = array();

foreach($fields as $field){
$class_field_name = $field['Class'];
$field_name = $field['Name'];
if (class_exists($class_field_name)) {
		$fields_classes[$class_field_name] = new $class_field_name($XVwebEngine);
		
		if($field['Search'] == "quick" || $field['Search'] == "both"){
			$quick_search_fields_result = $fields_classes[$class_field_name]->quick($field);
			if(!empty($quick_search_fields_result))
				$quick_search_fields[] = $quick_search_fields_result;
			$remove_filter = $fields_classes[$class_field_name]->remove_filter($field);
			if(is_array($remove_filter)){
				if(isset($remove_filter['caption'])){
					$search_filters_remove[] = $remove_filter;
				}else{
					foreach($remove_filter as $remove_filter_item){
						$search_filters_remove[] =  $remove_filter_item;
					}
				}
			}
		}
		if($field['Search'] != "none"){
			$query_search = $fields_classes[$class_field_name]->query($field);
			if(!is_null($query_search) or empty($query_search))
				$queries_search[] = $query_search;
		}
		
	}
}
$categories = xvp()->get_categories($XVauctions, $auction_category, $queries_search);

$display_options = array(
		"sort"=>$_GET['sort'],
		"sortby"=>$_GET['sortby'],
		
	);
	
$record_limit = 30;
	if(isset($_GET['auction_type'])&& strlen($_GET['auction_type']) != 0  && $_GET['auction_type'] != "all" ){
		$display_options['type'] = $_GET['auction_type'];
		$auction_type_c = "";
		
		if($_GET['auction_type']== "dutch")
			$auction_type_c =  xv_lang("xca_dutch_auction1");
		elseif($_GET['auction_type']== "auction")	
			$auction_type_c = xv_lang("xca_action1");	
		elseif($_GET['auction_type']== "buynow")	
			$auction_type_c = xv_lang("xca_buynow");
		$search_filters_remove[] = array(
				"link"=> xvp()->add_get_var($XVwebEngine, array("auction_type" => ""), true),
				"caption"=> xv_lang("xca_auction_type")." : ".$auction_type_c
			);
	}
	if(isset($_GET['auction_seller'])&& strlen($_GET['auction_seller']) != 0){
		$display_options['seller'] = $_GET['auction_seller'];
		$search_filters_remove[] = array(
					"link"=> xvp()->add_get_var($XVwebEngine, array("auction_seller" => ''), true),
					"caption"=> xv_lang("xca_seller")." : ".htmlspecialchars($_GET['auction_seller'])
				);
	}
	if(isset($_GET['auction_cost_from'])&& strlen($_GET['auction_cost_from']) != 0){
		$display_options['cost_from'] = $_GET['auction_cost_from'];
		$search_filters_remove[] = array(
				"link"=> xvp()->add_get_var($XVwebEngine, array("auction_cost_from" => ''), true),
				"caption"=> xv_lang("xca_cost_from")." : ".htmlspecialchars($_GET['auction_cost_from']).' '.xv_lang("xca_coin_type")
			);
	}
	if(isset($_GET['auction_cost_to']) && strlen($_GET['auction_cost_to']) != 0){
		$display_options['cost_to'] = $_GET['auction_cost_to'];
		$search_filters_remove[] = array(
				"link"=> xvp()->add_get_var($XVwebEngine, array("auction_cost_to" =>''), true),
				"caption"=> xv_lang("xca_cost_to")." : ".htmlspecialchars($_GET['auction_cost_to']).' '.xv_lang("xca_coin_type")
			);
	}	
	if(isset($_GET['auction_search']) && !empty($_GET['auction_search'])){
		$display_options['search'] = $_GET['auction_search'];
		$search_filters_remove[] = array(
				"link"=> xvp()->add_get_var($XVwebEngine, array("auction_search" =>''), true),
				"caption"=> xv_lang("xca_search")." : ".htmlspecialchars($_GET['auction_search'])
			);
	}
$auctions_list = xvp()->get_auctions($XVauctions, $auction_category, $queries_search, $display_options, (int) $_GET['page'], $record_limit);
$_GET = array_filter($_GET);

include_once(ROOT_DIR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
$pager = pager($record_limit, (int) $auctions_list[1],  "?".$XVwebEngine->add_get_var(array("page"=>"-npage-id-"), true), (int) $_GET['page']);

$Smarty->assignByRef('pager', $pager);
$Smarty->assignByRef('quick_search_fields', $quick_search_fields);
$Smarty->assignByRef('search_filters_remove', $search_filters_remove);
$Smarty->assignByRef('auctions_list', $auctions_list[0] );
$Smarty->assignByRef('auctions_category_tree', $category_tree);
$Smarty->assignByRef('auctions_categories', $categories);
$Smarty->assignByRef('auctions_category', $auction_category);



$Smarty->display('xvauctions_theme/items_show.tpl');

?>