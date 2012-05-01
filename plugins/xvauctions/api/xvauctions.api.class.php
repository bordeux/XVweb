<?php
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
		$XVauctions = &$XVwebEngine->InitClass("xvauctions");
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
					$item['Thumbnail'] = $URLS['Theme'].'xvauctions_theme/img/no_picture.png';
					$item['Thumbnail2'] = $URLS['Theme'].'xvauctions_theme/img/no_picture.png';
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
	 * List of category: category_list, by LIKE %pattern%
	 * Usage : get_auctions("BASE64URL")
	 * 
	 * @param string $b64_url
	 * @return array
	 */	
	function get_auctions_b64($b64_url){
		return $this->get_auctions(base64_decode($b64_url));
	}
    public function __wakeup(){
       
    }

	
}
