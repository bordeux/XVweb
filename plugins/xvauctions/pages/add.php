<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

if(!xv_perm("xva_sell")){
	header("location: ".$URLS['Script'].'Page/xvAuctions/Permission/Sell/');
	exit;
}

if(isset($_GET['cat'])){
	$get_cats = xvp()->get_api_categories($XVauctions, $_GET['cat']);
	echo json_encode($get_cats);
	exit;
}
$user_data = xvp()->get_user_data($XVauctions, $XVwebEngine->Session->Session('user_name'));
if(empty($user_data)){
	header("location: ".$URLS['Script'].'Users/'.$XVwebEngine->Session->Session('user_name').'/edit/?xva_set_data=true#xvauction-user-data');
	exit;
}


$URLS['AuctionsAdd'] = $URLS['Script'].$auction_prefix;
$add_class = new xva_add_class();
switch(strtolower($_GET['step'])){
case "descriptions":
	xvp()->xvauctin_step_descriptions($add_class);
	break;
case "preview":
	xvp()->xvauctin_step_preview($add_class);
	break;
case "templates":
	xvp()->xvauctin_step_templates($add_class);
	break;
case "get_template":
	xvp()->xvauctin_step_get_template($add_class);
	break;
case "clear":
	xvp()->xvauctin_step_clear($add_class);
	break;
case "save":
	xvp()->xvauctin_step_save($add_class);
	break;	
case "restore":
	xvp()->xvauctin_step_restore($add_class);
	break;
case "edit":
	xvp()->xvauctin_step_edit($add_class);
	break;
case "worker":
	xvp()->xvauctin_step_worker($add_class);
	break;
default:
	xvp()->xvauctin_step_category($add_class);
}
class xva_add_class {
	function xvauctin_step_category(){
		extract($GLOBALS);
		if((int) $XVwebEngine->Session->Session('xvauctions_edit_mode') > 0){
			header('Location: ?step=descriptions&try_edit_category=true');
			exit;
		}
		$Smarty->assign('xvauctions_mode', "category");
		if(isset($_GET['category'])){
			$CategorySelected = $_GET['category'];
		}else{
			$CategorySelected = $XVwebEngine->Session->Session('xvauctions_add_category');
		}
		if(empty($CategorySelected) || is_null($CategorySelected) || strlen($CategorySelected) < 1){
			$CategorySelected = "/";
		}
		$Smarty->assign('xvauctions_category', $CategorySelected);
		$XVwebEngine->Session->Session('xvauctions_edit_mode', false);
	}

	function xvauctin_step_descriptions(){
		extract($GLOBALS);
		$edit_auction_id = $XVwebEngine->Session->Session('xvauctions_edit_mode');
		$edit_mode = $edit_auction_id > 0 ? true : false;
		if($edit_mode){
			$auction_info = xvp()->get_auction($XVauctions, $edit_auction_id, true);
		}
		if(isset($_POST['category']) && $edit_mode == false){
			if($XVwebEngine->Session->get_sid() != $_POST['xv-sid']){
				header('Location: ?step=category');
				exit;
			}
			
			$category_add = $XVauctions->get_category($_POST['category']);
			if(empty($category_add) || $category_add['Use'] != 1){
				header('Location: ?step=category');
				exit;
			}else{
				$XVwebEngine->Session->Session('xvauctions_add_category', $category_add['Category']);
				$XVwebEngine->Session->Session('xvauctions_valid_form', false);
			}
		}
		
		$category_add = $XVwebEngine->Session->Session('xvauctions_add_category');

		if(empty($category_add) || is_null($category_add) || $category_add == ""){
			header('Location: ?step=category');
			exit;
		}
		
		if(isset($_POST['add']) && !empty($_POST['add'])){
			//$XVwebEngine->Session->Session('xvauctions_add_fields', $_POST['add']);
		}else{
			$_POST['add'] = $XVwebEngine->Session->Session('xvauctions_add_fields');
		}
		include_once(ROOT_DIR.'plugins/xvauctions/fields/fields.php');
		foreach (glob(ROOT_DIR.'plugins/xvauctions/fields/*.fields.php') as $filename) {
			include_once($filename);
		}
		
		$category_tree = $XVauctions->get_category_tree($category_add);
		
		$tmpvar = end($category_tree);
		if($category_tree == false || !$tmpvar['Use']){
			header('Location: ?step=category');
			exit;
		} // tutaj sprawdz
		$user_amount = (int) $XVwebEngine->Session->Session('xv_payments_amount');
		if($user_amount < $tmpvar['Options']['allowed_debt']*100){
		//echo $XVwebEngine->Session->Session('xv_payments_amount');
		//exit("toDo");
			header("location: ".$URLS['Script'].'Page/xvAuctions/Buy_credit/');
			exit;
		}
		
		$allowed_auctions = array(
			0 => ($tmpvar['Options']['buynow_enabled'] ? true : false),//kup teraz
			1 => ($tmpvar['Options']['auction_enabled'] ? true : false),//aukcja
			2 => ($tmpvar['Options']['buynow_auction_enabled'] ? true : false),// aukcja+kup teraz
			3 => ($tmpvar['Options']['dutch_enabled'] ? true : false),//aukcja holenderska
			4 => ($tmpvar['Options']['advert_enabled'] ? true : false),//og³oszenie
			5 => ($tmpvar['Options']['errand_enabled'] ? true : false),//zlecenie
		
		);
		xv_append_header("
			<script>
				var allowed_auctions = ".json_encode($allowed_auctions).";
			</script>
		");
		unset($tmpvar);
		
		
		$Smarty->assignByRef('auctions_category_tree', $category_tree);
		
		$fields = $XVauctions->get_fields($category_add, true);
		$fields_classes = array();
		$fields_form = array();
		$check_inputs = (isset($_POST['check']) ? true : false);

		if($check_inputs && $XVwebEngine->Session->get_sid() != $_POST['xv-sid']){
			header('Location: ?step=descriptions');
			exit;
		}
		$valid_forms = true;
		$price_list = array();
		foreach($fields as $field){
			$class_field_name = $field['Class'];
			$field_name = $field['Name'];
			
			if (class_exists($class_field_name)) {
				if(!isset($fields_classes[$class_field_name]))
				$fields_classes[$class_field_name] = new $class_field_name($XVwebEngine);	
				$valided = false;
				if($check_inputs){
					$valided = $fields_classes[$class_field_name]->valid($field);
					if(!$valided){
						$valid_forms = false;
						
					}
				}
				$form_add_result = $fields_classes[$class_field_name]->add_form($field, ($check_inputs ? !$valided : false));
				$form_add_price = $fields_classes[$class_field_name]->get_price($field);
				if(!empty($form_add_price)){
					$price_list[] = $form_add_price;
				}
				if($edit_mode == true)
					$fields_classes[$class_field_name]->edit_trigger($field, $edit_auction_id, $auction_info);
					
				if(!empty($form_add_result))
				$fields_form[] = $form_add_result;
			}
		}

		if(isset($_POST['add']) && !empty($_POST['add'])){
			$XVwebEngine->Session->Session('xvauctions_add_fields', $_POST['add']);
		}

		if($check_inputs && $valid_forms){
			$XVwebEngine->Session->Session('xvauctions_add_fields', $_POST['add']);
			$XVwebEngine->Session->Session('xvauctions_valid_form', true);
			$XVwebEngine->Session->Session('xvauctions_fields_price_list', $price_list);
			header('Location: ?step=preview');
			exit;
			
		}elseif($check_inputs){
			$XVwebEngine->Session->Session('xvauctions_valid_form', false);
		}


		$Smarty->assign('xvauctions_mode', "descriptions");
		$Smarty->assign('xvauctions_edit_mode', $edit_mode);
		$Smarty->assignByRef('xvauctions_fields', $fields_form);
	}

	function xvauctin_step_preview(){
		extract($GLOBALS);
		if($XVwebEngine->Session->Session('xvauctions_valid_form') !== true){
			header('Location: ?step=descriptions');
			exit;
		}
		$edit_auction_id = $XVwebEngine->Session->Session('xvauctions_edit_mode');
		$edit_mode = $edit_auction_id > 0 ? true : false;
		
		include_once(ROOT_DIR.'plugins/xvauctions/fields/fields.php');
		include_once(ROOT_DIR.'plugins/xvauctions/fields/wysiwyg.fields.php');
		$_POST['add'] = $XVwebEngine->Session->Session('xvauctions_add_fields');
		$category_add = $XVwebEngine->Session->Session('xvauctions_add_category');
		$category_tree = $XVauctions->get_category_tree($category_add);
		$category_info = end($category_tree);
		$price_list = array();
		$_POST['add']['description'] = xvauction_fields_wysiwyg::convert_html($_POST['add']['description']);
		
		$price_list["add"] = array(
				"caption" => xv_lang("xca_adv_add"),
				"cost" => $category_info['Options']['auction_add_cost'], 
			);
		
		if(ifsetor($_POST['add']['premium'][0], "false") == "true"){ //adv on top of list
			$price_list['on_top'] = array(
				"caption" => xv_lang("xca_adv_on_the_top"),
				"cost" => $category_info['Options']['auction_on_top_cost'], 
			);
		}
		if(ifsetor($_POST['add']['premium'][1], "false") == "true"){ //adv bold
			$price_list['bold'] = array(
				"caption" => xv_lang("xca_adv_bold"),
				"cost" => $category_info['Options']['auction_bold_cost'], 
			);
		}		
		if(ifsetor($_POST['add']['premium'][2], "false") == "true"){ //adv highlight
			$price_list['highlight'] = array(
				"caption" => xv_lang("xca_adv_highlight"),
				"cost" => $category_info['Options']['auction_highlight_cost'], 
			);
		}		
		if(ifsetor($_POST['add']['premium'][3], "false") == "true"){ //adv on main page
			$price_list['main_page'] = array(
				"caption" => xv_lang("xca_adv_on_main_page"),
				"cost" => $category_info['Options']['auction_main_page_cost'], 
			);
		}
		$price_field_list = $XVwebEngine->Session->Session('xvauctions_fields_price_list');
		
		if(is_array($price_field_list)){
			foreach($price_field_list as $price){
				$price_list[$price['key']] = array(
					"caption" => $price['caption'],
					"cost" => $price['cost'], 
				);
			}
		
		}
		$price_sum = 0;
		foreach($price_list as $key)
			$price_sum += $key['cost'];
		
		$XVwebEngine->Session->Session('xvauctions_price_list', $price_list);
		
		$Smarty->assign('xvauctions_price_list', $price_list);
		$Smarty->assign('xvauctions_price_sum', $price_sum);
		$Smarty->assign('xvauctions_mode', "preview");
	}

	function xvauctin_step_templates(){
		foreach (glob(ROOT_DIR.'plugins/xvauctions/templates/*/screen.*') as $filename) {
			echo "<a href='#' data-xva-theme='".basename(dirname($filename))."' ><img style='width: 200px; height: 80px; margin:3px;' src='".$GLOBALS['URLS']['Site'].'plugins/xvauctions/templates/'.basename(dirname($filename)).'/'.basename($filename)."' /></a>";
		}
		exit;
	}
	function xvauctin_step_get_template(){
		$_GET['theme'] = str_replace(array(".", "/", "\\"), "", $_GET['theme']);
		if (file_exists(ROOT_DIR.'plugins/xvauctions/templates/'.$_GET['theme'].'/index.html')) {
			$theme =  file_get_contents(ROOT_DIR.'plugins/xvauctions/templates/'.$_GET['theme'].'/index.html');
			$theme = str_replace("url(", "url(".$GLOBALS['URLS']['Site']."plugins/xvauctions/templates/".$_GET['theme'].'/', $theme);
			echo $theme;
		}else{
			echo "Theme no exsist";
		}
		exit();
	}

	function xvauctin_step_clear($redirect = true){
		extract($GLOBALS);
		$XVwebEngine->Session->Session('xvauctions_add_category', "/");
		$XVwebEngine->Session->Session('xvauctions_valid_form', false);
		$XVwebEngine->Session->Session('xvauctions_add_fields', array());
		$XVwebEngine->Session->Session('xvauctions_edit_mode', false);
		$XVwebEngine->Session->Session('xvauctions_gallery', array());
		$XVwebEngine->Session->Session('xvauctions_fields_price_list', array());
		if($redirect){
			header('Location: ?step=category');
			exit;
		}
		return true;
	}
	function xvauctin_step_save(){
		extract($GLOBALS);
		if($XVwebEngine->Session->get_sid() != $_GET['xv-sid']){
			header('Location: ?step=category');
			exit;
		}
		if($XVwebEngine->Session->Session('xvauctions_valid_form') !== true){
			header('Location: ?step=descriptions');
			exit;
		}
		$edit_auction_id = $XVwebEngine->Session->Session('xvauctions_edit_mode');
		$edit_mode = $edit_auction_id > 0 ? true : false;
		
		$price_list = $XVwebEngine->Session->Session('xvauctions_price_list');
		
		$_POST['add'] = $XVwebEngine->Session->Session('xvauctions_add_fields');
	
		
		$add_category = $XVwebEngine->Session->Session('xvauctions_add_category');
		
		$category_tree = $XVauctions->get_category_tree($add_category);
		$category_info = end($category_tree);
		$category_config = $category_info['Options'];
		
		$allowed_auctions = array(
			0 => ($category_config['buynow_enabled'] ? true : false),//kup teraz
			1 => ($category_config['auction_enabled'] ? true : false),//aukcja
			2 => ($category_config['buynow_auction_enabled'] ? true : false),// aukcja+kup teraz
			3 => ($category_config['dutch_enabled'] ? true : false),//aukcja holenderska
			4 => ($category_config['advert_enabled'] ? true : false),//og³oszenie
			5 => ($category_config['errand_enabled'] ? true : false),//zlecenie
		);
		
		
		include_once(ROOT_DIR.'plugins/xvauctions/fields/fields.php');
		foreach (glob(ROOT_DIR.'plugins/xvauctions/fields/*.fields.php') as $filename) {
			include_once($filename);
		}
		$XVwebEngine->DataBase->beginTransaction(); // start transaction
		if(!isset($allowed_auctions[$_POST['add']['type']]) || $allowed_auctions[$_POST['add']['type']] == false){
			exit("Hack not allowed :) ");
		}
		
		
		$_POST['add']['auction_start'] = floatval($_POST['add']['auction_start']);
		$_POST['add']['auction_min'] = floatval($_POST['add']['auction_min']);
		$_POST['add']['dutch_start'] = floatval($_POST['add']['dutch_start']);
		$_POST['add']['buynow'] = floatval($_POST['add']['buynow']);
		
		switch (((int) $_POST['add']['type'])) {
		case 1: //aukcja
			$create_array = array(
			":category" => $add_category,
			":pieces" => (int) trim($_POST['add']['pieces']),
			":title" => trim($_POST['add']['title']),
			":type" => "auction",
			":buynow" => number_format(0, 2, '.', ''),
			":auction" => number_format($_POST['add']['auction_start'], 2, '.', ''),
			":start" => date("Y-m-d H:i:s", time()),
			":end" =>  date("Y-m-d H:i:s", strtotime($category_config['auction_expire'])),
			":auctionmin" =>  number_format($_POST['add']['auction_min'], 2, '.', ''),
			":auctiondutch" =>  number_format(0, 2, '.', ''),
			":seller" => $XVwebEngine->Session->Session('user_name'),
			":premium" => (isset($price_list["on_top"]) ?  1 : 0),
			);
			break;
		case 2: // kup teraz + aukcja
			$create_array = array(
			":category" => $add_category,
			":title" => trim($_POST['add']['title']),
			":pieces" => (int) trim($_POST['add']['pieces']),
			":type" => "both",
			":buynow" => number_format($_POST['add']['buynow'], 2, '.', ''),
			":auction" => number_format($_POST['add']['auction_start'], 2, '.', ''),
			":start" => date("Y-m-d H:i:s", time()),
			":end" =>  date("Y-m-d H:i:s", strtotime($category_config['auction_expire'])),
			":auctionmin" =>  number_format($_POST['add']['auction_min'], 2, '.', ''),
			":auctiondutch" =>  number_format(0, 2, '.', ''),
			":seller" => $XVwebEngine->Session->Session('user_name'),
			":premium" => (isset($price_list["on_top"]) ?  1 : 0),
			);
			break;
		case 3: //aukcja holdenderska
			$create_array = array(
			":category" => $add_category,
			":title" => trim($_POST['add']['title']),
			":pieces" => (int) trim($_POST['add']['pieces']),
			":type" => "dutch",
			":buynow" => number_format($_POST['add']['dutch_start'], 2, '.', ''),
			":auction" => number_format($_POST['add']['dutch_start'], 2, '.', ''),
			":start" => date("Y-m-d H:i:s", time()),
			":end" =>  date("Y-m-d H:i:s", strtotime($category_config['auction_expire'])),
			":auctionmin" =>  number_format($_POST['add']['dutch_min'], 2, '.', ''),
			":auctiondutch" =>  number_format($_POST['add']['dutch_start'], 2, '.', ''),
			":seller" => $XVwebEngine->Session->Session('user_name'),
			":premium" => (isset($price_list["on_top"]) ?  1 : 0),
			);
			break;
		case 4: //og³oszenie
			$create_array = array(
			":category" => $add_category,
			":title" => trim($_POST['add']['title']),
			":pieces" => (int) trim($_POST['add']['pieces']),
			":type" => "advert",
			":buynow" => number_format($_POST['add']['buynow'], 2, '.', ''),
			":auction" => number_format(0, 2, '.', ''),
			":start" => date("Y-m-d H:i:s", time()),
			":end" =>  date("Y-m-d H:i:s", strtotime($category_config['auction_expire'])),
			":auctionmin" =>  number_format(0, 2, '.', ''),
			":auctiondutch" =>  number_format(0, 2, '.', ''),
			":seller" => $XVwebEngine->Session->Session('user_name'),
			":premium" => (isset($price_list["on_top"]) ?  1 : 0),
			);
			break;
		case 5: //zlecenie
			$create_array = array(
			":category" => $add_category,
			":pieces" => (int) trim($_POST['add']['pieces']),
			":title" => trim($_POST['add']['title']),
			":type" => "errand",
			":buynow" => number_format($_POST['add']['auction_start'], 2, '.', ''),
			":auction" => number_format($_POST['add']['auction_start'], 2, '.', ''),
			":start" => date("Y-m-d H:i:s", time()),
			":end" =>  date("Y-m-d H:i:s", strtotime($category_config['auction_expire'])),
			":auctionmin" =>  number_format(0, 2, '.', ''),
			":auctiondutch" =>  number_format(0, 2, '.', ''),
			":seller" => $XVwebEngine->Session->Session('user_name'),
			":premium" => (isset($price_list["on_top"]) ?  1 : 0),
			);
			break;
			
		default:
			$create_array = array(
			":category" => $add_category,
			":title" => trim($_POST['add']['title']),
			":pieces" => (int) trim($_POST['add']['pieces']),
			":type" => "buynow",
			":buynow" => number_format($_POST['add']['buynow'], 2, '.', ''),
			":auction" => number_format(0, 2, '.', ''),
			":start" => date("Y-m-d H:i:s", time()),
			":end" =>  date("Y-m-d H:i:s", strtotime($category_config['auction_expire'])),
			":auctionmin" =>  number_format(0, 2, '.', ''),
			":auctiondutch" =>  number_format(0, 2, '.', ''),
			":seller" => $XVwebEngine->Session->Session('user_name'),
			":premium" => (isset($price_list["on_top"]) ?  1 : 0),
			);
			break;
		}
		if($edit_mode == true){
			$create_array[':id'] = $edit_auction_id;
			$auction_info = xvp()->get_auction($XVauctions, $edit_auction_id, true);
			if(empty($auction_info)){
			exit;
				header("location: ".$URLS['Script'].'Page/xvAuctions/404/');
				exit;
			}
			
			if($auction_info['AuctionsCount'] > 0){
				header("location: ".$URLS['Script'].'Page/xvAuctions/Blocked/');
				exit;
			}
			
			$create_array[':start'] = $auction_info['Start'];
			$create_array[':end']   = $auction_info['End'];
			$create_array[':views']   = $auction_info['Views'];
			xvp()->clear_auction_data($XVauctions, $edit_auction_id);
		}
		
		$auction_id = xvp()->create_auction($XVauctions, $create_array);
		
		$fields = xvp()->get_fields($XVauctions, $add_category, true);
		$fields_classes = array();
		$add_result = true;
		$session_save = array();
		foreach($fields as $field){
			$class_field_name = $field['Class'];
			$field_name = $field['Name'];
			if (class_exists($class_field_name)) {
				if(!isset($fields_classes[$class_field_name]))
				$fields_classes[$class_field_name] = new $class_field_name($XVwebEngine);	
				if($edit_mode == true)
					$clear_data = $fields_classes[$class_field_name]->clear_data($field, $auction_id);
				
				$AddResult = $fields_classes[$class_field_name]->insert($field, $auction_id);
				
				$session_save[] = $fields_classes[$class_field_name]->session($field, $auction_id);

				if(!$AddResult){
					$add_result = false;
				}
			}
		}
		if($add_result){
			$XVwebEngine->DataBase->commit();
			$session_to_save = array(
				"xvauctions_add_category" => $XVwebEngine->Session->Session('xvauctions_add_category'),
				"xvauctions_valid_form" => $XVwebEngine->Session->Session('xvauctions_valid_form'),
				"xvauctions_gallery" => $XVwebEngine->Session->Session('xvauctions_gallery'),
				"xvauctions_add_fields" => $XVwebEngine->Session->Session('xvauctions_add_fields'),
				"xvauctions_price_list" => $XVwebEngine->Session->Session('xvauctions_price_list'), // ZAMIENIC TO NA PREFIX !!!wszystko po xvauctions_*
				"user_name" => $XVwebEngine->Session->Session('user_name'),
			);
			foreach($session_save as $session_v){
				if(is_array($session_v)){
						foreach($session_v as $val){
							$session_to_save[$val] =$XVwebEngine->Session->Session($val);
							$XVwebEngine->Session->delete($val);
						}
					}
			
			}
			xvp()->save_session($XVauctions, $auction_id, $session_to_save);
			
			xvp()->xvauctin_step_clear($add_class, false);
			
		include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvpayments.php');
		if(is_array($price_list)){
			foreach($price_list as $key=>$price){
				xvp()->add_transaction(xvp()->load_class($XVwebEngine,"xvpayments"),  $XVwebEngine->Session->Session('user_name'), -($price['cost']*100), "auction_".$key, $price['caption'], array(), "ad-".$key.'-'.$auction_id ,$auction_id);
			}
		}
		
		$XVwebEngine->Session->Session('xv_payments_amount', $XVwebEngine->load_class("xvpayments")->get_user_amount($XVwebEngine->Session->Session('user_name')));
		
			header('Location: '.$URLS['Auction'].'/'.$auction_id.'/');
			exit;
		}else{
			$XVwebEngine->DataBase->rollBack();
			header('Location: ?step=descriptions&error=true');
			exit();
		}
		
		
		

		xvp()->xvauctin_step_clear($add_class, false);
		exit;
	}

	function xvauctin_step_restore(){
		extract($GLOBALS);

		$session_restore = xvp()->get_session($XVauctions, (int) $_GET['id']);
		if(is_null($session_restore) || empty($session_restore) || $session_restore['user_name'] != $XVwebEngine->Session->Session('user_name')){
			header("location: ".$URLS['Script'].'Page/xvAuctions/Session_not_found/');
			exit;
		}		
		$XVwebEngine->Session->Session('xvauctions_add_category', $session_restore['xvauctions_add_category']);
		$XVwebEngine->Session->Session('xvauctions_valid_form', $session_restore['xvauctions_valid_form']);
		$XVwebEngine->Session->Session('xvauctions_add_fields', $session_restore['xvauctions_add_fields']);
		header('Location: ?step=descriptions');
		exit;	
	}
	
	function xvauctin_step_edit(){
		extract($GLOBALS);

		$session_restore = xvp()->get_session($XVauctions, (int) $_GET['id']);
		if(is_null($session_restore) || empty($session_restore) || $session_restore['user_name'] != $XVwebEngine->Session->Session('user_name')){
			header("location: ".$URLS['Script'].'Page/xvAuctions/Session_not_found/');
			exit;
		}
		
		foreach($session_restore as $key => $val){
			$XVwebEngine->Session->Session($key, $val);
		}
		$XVwebEngine->Session->Session('xvauctions_edit_mode', $_GET['id']);
		header('Location: ?step=descriptions');
		exit;	
	}
	function xvauctin_step_worker(){
	extract($GLOBALS);
		include_once(ROOT_DIR.'plugins/xvauctions/fields/fields.php');
		foreach (glob(ROOT_DIR.'plugins/xvauctions/fields/*.fields.php') as $filename) {
			include_once($filename);
		}
		$add_category = $XVwebEngine->Session->Session('xvauctions_add_category');
		$fields = xvp()->get_fields($XVauctions, $add_category, true);
		$fields_classes = array();
		$add_result = true;
		foreach($fields as $field){
			$class_field_name = $field['Class'];
			$field_name = $field['Name'];
			if (class_exists($class_field_name) && $_GET['class']==$class_field_name) {
				if(!isset($fields_classes[$class_field_name]))
				$fields_classes[$class_field_name] = new $class_field_name($XVwebEngine);	
					$worker_result = $fields_classes[$class_field_name]->worker($field, $auction_id);
			}
		}
		exit;
	}
}
$Smarty->display('xvauctions/add_show.tpl');


?>