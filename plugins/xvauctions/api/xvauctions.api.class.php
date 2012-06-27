<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE application!   *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

class xv_api_xvauctions {

     var $counter = 1;
	 
	/**
	 * List of category: category_list, by LIKE %pattern%
	 * Usage : get_auctions("/aaa/bb/?key1=val1")
	 * 
	 * @param string $url
	 * @return array
	 */	
	function get_auctions($url){
		global $XVwebEngine, $URLS;
		$url = str_replace($URLS['Script'].'auctions', '', $url);
		$URL_info = parse_url($url);
		$copy_get = $_GET;
		
		include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvauctions.php');
		$XVauctions = &$XVwebEngine->load_class("xvauctions");
		$category_tree = xvp()->get_category_tree($XVauctions, $URL_info['path']);
		
		if(empty($category_tree) &&  $auction_category != '/'){
			$auction_category = "/";
		}
		parse_str($URL_info['query'], $_GET);
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
	$display_options = array(
			"sort"=>$_GET['sort'],
			"sortby"=>$_GET['sortby'],
			
		);
	$record_limit = 30;
		if(isset($_GET['auction_type'])&& strlen($_GET['auction_type']) != 0  && $_GET['auction_type'] != "all" ){
			$display_options['type'] = $_GET['auction_type'];
		}
		if(isset($_GET['auction_seller'])&& strlen($_GET['auction_seller']) != 0){
			$display_options['seller'] = $_GET['auction_seller'];
		}
		if(isset($_GET['auction_cost_from'])&& strlen($_GET['auction_cost_from']) != 0){
			$display_options['cost_from'] = $_GET['auction_cost_from'];
		}
		if(isset($_GET['auction_cost_to']) && strlen($_GET['auction_cost_to']) != 0){
			$display_options['cost_to'] = $_GET['auction_cost_to'];
		}
		if(isset($_GET['auction_search']) && !empty($_GET['auction_search'])){
			$display_options['search'] = $_GET['auction_search'];
		}
	$auctions_list = xvp()->get_auctions($XVauctions, $auction_category, $queries_search, $display_options, (int) $_GET['page'], $record_limit);
		$result = array();
		$allowed_keys = array("ID", "Category", "Enabled", "Views", "Title", "Type", "AuctionsCount", "Thumbnail", "Start", "End", "Seller", "Pieces", "NowTime");
		foreach($auctions_list[0] as $auction){
			$item = array();

			foreach($allowed_keys as $key)
				$item[$key] = $auction[$key];
			if(isset($item['Thumbnail'])){
				if(empty($item['Thumbnail'])){
					$item['Thumbnail'] = $URLS['Theme'].'xvauctions/img/no_picture.png';
					$item['Thumbnail2'] = $URLS['Theme'].'xvauctions/img/no_picture.png';
				}else{
					$item['Thumbnail2'] = $URLS['Site'].'plugins/xvauctions/th/300x200_'.$item['Thumbnail'];
					$item['Thumbnail'] = $URLS['Site'].'plugins/xvauctions/th/'.$item['Thumbnail'];
				}
				if($item['Type'] == "buynow"){
					$item['Cost'] = $auction['BuyNow'];
				}elseif($item['Type'] == "auction"){
					$item['Cost'] = $auction['Auction'];
				}elseif($item['Type'] == "dutch"){
					$item['Cost'] = $auction['BuyNow'];
					$item['Cost2'] = $auction['AuctionMin'];
				}else{
					$item['Cost'] = $auction['BuyNow'];				
					$item['Cost2'] = $auction['Auction'];				
				}
			}
			$result[] = $item;
		}
		return array("list"=>$result, "count_all"=>$auctions_list[1]);
	}

	
	/**
	 * Get auction information
	 * Usage : get_auction(4440404)
	 * 
	 * @param int $id
	 * @return array
	 */	
	function get_auction($id){
		global $XVwebEngine, $URLS;
			include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvauctions.php');
			$XVauctions = &$XVwebEngine->load_class("xvauctions");
			$auction_data = xvp()->get_auction($XVauctions, $id, true);
			if(empty($auction_data))
				return array();
			$auction_info = array(
				"id" => $auction_data['ID'],
				"category" => $auction_data['Category'],
				"enabled" => $auction_data['Enabled'],
				"views" => $auction_data['Views'],
				"type" => $auction_data['Type'],
				"thumbnail" =>$auction_data['Thumbnail'],
				"start" => $auction_data['Start'],
				"end" => $auction_data['End'],
				"premium" => $auction_data['Premium'],
				"seller" => $auction_data['Seller'],
				"pieces" => $auction_data['Pieces'],
			);
			return $auction_info;
	}	
	
	/**
	 * Get auction information
	 * Usage : get_auction(4440404)
	 * 
	 * @param int $id
	 * @return array
	 */	
	function get_auction_full($id){
		global $XVwebEngine, $URLS;
			include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvauctions.php');
			$XVauctions = &$XVwebEngine->load_class("xvauctions");
			$auction_data = xvp()->get_auction($XVauctions, $id, true);
			if(empty($auction_data))
				return array();
			$auction_info = array(
				"id" => $auction_data['ID'],
				"category" => $auction_data['Category'],
				"enabled" => $auction_data['Enabled'],
				"views" => $auction_data['Views'],
				"type" => $auction_data['Type'],
				"thumbnail" =>$auction_data['Thumbnail'],
				"start" => $auction_data['Start'],
				"end" => $auction_data['End'],
				"premium" => $auction_data['Premium'],
				"seller" => $auction_data['Seller'],
				"pieces" => $auction_data['Pieces'],
			);
			$fields = xvp()->get_fields($XVauctions, $auction_data['Category']);
			if(!isset($fields_values))
				$fields_values = xvp()->get_fields_values($XVauctions, $auction_data['ID']);
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
					$detail = $fields_classes[$class_field_name]->detail($field, $fields_values[$field['ID']], $auction_data['ID']);
					$footer = $fields_classes[$class_field_name]->footer($field, $fields_values[$field['ID']], $auction_data['ID']);
					if(is_array($detail)){
						$auction_details[$field['Name']] = $detail;
					}		
					if(!is_null($footer)){
						$auction_footer[$field['Name']] = $footer;
					}
				}
			}
			$auction_info['details'] = $auction_details;
			$auction_info['footer'] = $auction_footer;
			$auction_info['description'] = xvp()->get_auction_description($XVauctions, $auction_data['ID'], "description");
			return $auction_info;
	}
	/**
	 * Get stats for user
	 * Usage : get_user_stats("user")
	 * 
	 * @param string $user
	 * @return array
	 */	
	function get_user_stats($user){
		global $XVwebEngine, $URLS;
			include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvauctions.php');
			$XVauctions = &$XVwebEngine->load_class("xvauctions");
		return xvp()->get_user_stats($XVauctions, $user);
	}
	
    public function __wakeup(){
       
    }

	
}
