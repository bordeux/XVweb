<?php
/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE application!   *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}
class xv_admin_xvauctions_payments {
	var $style = "width: 60%;";
	var $title = "XVauctions Payments";
	var $URL = "XVauctions/Payments/";
	var $content = "";
	var $id = "xv-payments-main";
	public function __construct(&$XVweb){
	global $URLS, $PathInfo;
		$id_payment = strtolower($XVweb->GetFromURL($PathInfo, 5));
		if(!empty($id_payment) && is_numeric($id_payment)){
			$this->get_details($XVweb, $id_payment);
			return true;
		}elseif($id_payment == "csv"){
			$this->get_to_csv($XVweb);
			exit;
		}
		$this->icon = $GLOBALS['URLS']['Site'].'plugins/xvauctions/admin/xvauctions/icons/payments.png';
		
			$this->URL = "XVauctions/Payments/".(empty($_SERVER['QUERY_STRING']) ? "" : "?".$XVweb->add_get_var(array(), true));

			$payments_list = $this->get_records($XVweb, ((int) ifsetor($_GET['page'], 0)), 30);
			include_once(ROOT_DIR.'core'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
			$pager = pager(30, (int) $payments_list->list_count,  "?".$XVweb->add_get_var(array("page"=>"-npage-id-"), true), $actual_page);
			
			$this->content =  '
				<div style="float:right; margin-right: 20px;">
					<a href="'.$URLS['Script'].'Administration/get/XVauctions/Payments/csv/'.uniqid().'/" target="_blank">Get all in CSV</a>
				</div>
			<div class="xv-payments-table-div xv-table">
			<table style="width : 100%; text-align: center;">
			<caption>'.$pager[0].'</caption>
				<thead> 
					<tr class="xv-pager">
						<th><a>ID</a></th>
						<th><a>Date</a></th>
						<th><a>Title</a></th>
						<th><a>Amount</a></th>
						<th><a>Type</a></th>
						<th><a>User</a></th>
						<th><a>UniqID</a></th>
			
					</tr>
				</thead> 
				<tbody>';
				foreach($payments_list->list as $payment_item){
					$this->content .= '<tr>
							<td><a href="'.$URLS['Script'].'Administration/XVauctions/Payments/'.$payment_item['ID'].'/" class="xv-get-window" >'.$payment_item['ID'].'</a></td>
							<td>'.$payment_item['Date'].'</td>
							<td><a href="'.$URLS['Script'].'Administration/XVauctions/Payments/'.$payment_item['ID'].'/" class="xv-get-window" >'.$payment_item['Title'].'</a></td>
							<td>'.number_format(($payment_item['Amount']/100), 2, '.', ' ').'</td>
							<td>'.$payment_item['Type'].'</td>
							<td><a href="'.$URLS['Script'].'Administration/Users/Get/'.$payment_item['User'].'/" class="xv-get-window" >'.$payment_item['User'].'</a> <a href="'.$URLS['Script'].'Administration/XVauctions/Wallet/'.$payment_item['User'].'/" class="xv-get-window" >[edit wallet]</a></td>
							<td>'.$payment_item['UniqID'].'</td>
						</tr>';
				}
				$this->content .= '</tbody>
				</table>
				<div class="xv-table-pager">
				'.$pager[1].'
				</div>
		</div>';
		
		$this->content .=  '<div class="xv-payments-search">
				<a href="#" class="xv-toggle" data-xv-toggle=".xv-payments-search-form" action="?'.$XVweb->add_get_var(array(), true).'" > Search... </a>
					<form style="display:none" class="xv-payments-search-form xv-form" method="get" data-xv-result=".content" action="'.$GLOBALS['URLS']['Script'].'Administration/get/XVauctions/Payments/?'.$XVweb->add_get_var(array(), true).'">
						<table>
						<tbody>';
				foreach($XVweb->DataBase->get_fields("Payments") as $keyf=>$field){		
					$this->content .=	'
						<tr>
							<td style="font-weight:bold;">'.$keyf.'</td>
							<td>
								<select name="xv-func['.$keyf.']">
									<option value="none">----</option>
									<option value="LIKE">LIKE</option>
									<option value="NOT LIKE">NOT LIKE</option>
									<option value="=">=</option>
									<option value="!=">!=</option>
									<option value="REGEXP">REGEXP</option>
									<option value="NOT REGEXP">NOT REGEXP</option>
									<option value="&lt;">&lt;</option>
									<option value="&gt;">&gt;</option>
								</select>
							</td>
							<td><input type="text" name="xv-value['.$keyf.']" /></td>
						</tr>';
						}
						$this->content .= '<tr>
						<td><input type="hidden" value="true" name="search_mode" /> <input type="submit" value="Search..." /></td>
							</tr>
							</tbody>
						</table>
					</form>
					
			</div>';
		if(isset($_GET['search_mode']))
				exit($this->content);
	}
	public function get_records(&$XVweb, $actual_page = 0, $every_page =30){
			$table = "Payments";
			$l_limit = ($actual_page*$every_page);
			$r_limit = $every_page;

			$search_add_query = array();
			$exec_vars = array();
			if(isset($_GET["xv-value"]) && isset($_GET["xv-func"]) && is_array($_GET["xv-func"]) && is_array($_GET["xv-value"])){
				foreach($_GET["xv-func"] as $funckey=>$funcN){
					if($funcN !="none"){
					$UniqVar = ':'.uniqid();
						$search_add_query[] = ' {'.$table.':'.$funckey.'} '.$funcN.' '.$UniqVar.' ';
						$exec_vars[$UniqVar] = ifsetor($_GET["xv-value"][$funckey], "");
					}
				}
			
			}
			$select_query = 'SELECT SQL_CALC_FOUND_ROWS
			{'.$table.':*}
				FROM {'.$table.'} '.(empty($search_add_query) ? '' : 'WHERE '.implode(" AND ", $search_add_query)).' ORDER BY {'.$table.':ID} DESC LIMIT '.$l_limit.', '.$r_limit.';
	';
	
			$select_payments_sql = $XVweb->DataBase->prepare($select_query);
			$select_payments_sql->execute($exec_vars);
			$result_list = $select_payments_sql->fetchAll();
			$result_count = $XVweb->DataBase->pquery('SELECT FOUND_ROWS() AS `count_list`;')->fetch(PDO::FETCH_OBJ)->count_list;
			return (object)  array('list'=>$result_list, 'list_count'=>$result_count );
	}
	
	public function get_to_csv(&$XVweb){
		set_time_limit(0);
		header( 'Content-Type: text/csv' );
        header( 'Content-Disposition: attachment;filename=payments.csv');
        $fp = fopen('php://output', 'w');
		
		$select_payments_sql = $XVweb->DataBase->prepare("SELECT {Payments:*} FROM {Payments} ORDER BY {Payments:ID} DESC;");
		$select_payments_sql->execute();
		$headers_set = false;
		while ($row = $select_payments_sql->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
			if(!$headers_set)
				fputcsv($fp, array_keys($row));
			$row['Amount'] = number_format(($row['Amount']/100), 2, '.', '');
 			fputcsv($fp, $row);
		}	
		fclose($fp);
		return false;
	}
	
	public function get_details(&$XVweb, $id){
		global $URLS;
			$this->title = "XVauctions Payment Detail: ".$id;
			$this->URL = "XVauctions/Payments/".$id.'/';
			$this->content = '';
			$this->id = "xv-payments-".$id."-main";
			$this->style = "width: 30%;";
			include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvpayments.php');
			$xv_payments =  &$XVweb->load_class("xvpayments");
			
			$payment_details = xvp()->get_payment_details($xv_payments, $id);
			if($payment_details === false){
				if(empty($_POST)){
					$this->content ="<div class='failed'>Error: Payment not found</div>";
					return true;
				}else{
					exit("<div class='failed'>Error: Payment not found</div>");
				}
			}
			//delete payment
			if(isset($_POST['payment_delete'])){
				if($XVweb->Session->get_sid() != $_POST['xv_sid']){
					exit("<div class='failed'>Error: Bad SID!</div>");
				}
				xvp()->delete_payment($xv_payments, $id);
				exit("<div class='success'>Payment deleted</div>");
			}
			$this->content .= "<fieldset>";
			$this->content .= "<legend>Delete Payment</legend>";
			$this->content .= '<form action="'.$URLS['Script'].'Administration/get/XVauctions/Payments/'.$id.'/" method="post" class="xv-form" data-xv-result=".content">';
			$this->content .= '<input type="hidden" value="delete" name="payment_delete" />';
			$this->content .= '<input type="hidden" value="'.htmlspecialchars($XVweb->Session->get_sid()).'" name="xv_sid" />';
			$this->content .= "<input type='submit' value='Delete payment ID: {$id}' />";
			$this->content .= "</form>";
			$this->content .= "</fieldset>";
			//delete payment			
			
			//edit
			
			if(isset($_POST['payment_edit'])){
				if($XVweb->Session->get_sid() != $_POST['xv_sid']){
					exit("<div class='failed'>Error: Bad SID!</div>");
				}
				xvp()->edit_payment($xv_payments, $id, array(
					"Title" => $_POST['payment']['title'],
					"User" => $_POST['payment']['user'],
					"Amount" => $_POST['payment']['amount']*100,
				));
				exit("<div class='success'>Payment edited</div>");
			}
			
			$this->content .= "<fieldset>";
			$this->content .= "<legend>Edit Payment</legend>";
			$this->content .= '<form action="'.$URLS['Script'].'Administration/get/XVauctions/Payments/'.$id.'/" method="post" class="xv-form" data-xv-result=".xv-payment-result">';
			$this->content .= '<input type="hidden" value="delete" name="payment_edit" />';
			$this->content .= '<input type="hidden" value="'.htmlspecialchars($XVweb->Session->get_sid()).'" name="xv_sid" />';
			$this->content .= "<div class='xv-payment-result'></div>
			<table>
				<tr>
					<td style='width: 70px;'>Title</td>
					<td><input type='text' name='payment[title]' value='".htmlspecialchars($payment_details['Title'])."' /></td>
				</tr>	
				<tr>
					<td>User</td>
					<td><input type='text' name='payment[user]' value='".htmlspecialchars($payment_details['User'])."' /></td>
				</tr>	
				<tr>
					<td>Amount<br /> (ex. -45.62)</td>
					<td><input type='text' name='payment[amount]' value='".number_format(($payment_details['Amount']/100), 2, '.', '')."' /></td>
				</tr>			
				<tr>
					<td></td>
					<td><input type='submit' value='Save' /></td>
				</tr>
			</table>
			";
			$this->content .= "</form>";
			$this->content .= "</fieldset>";
			//delete payment
			
			
	}
}

?>