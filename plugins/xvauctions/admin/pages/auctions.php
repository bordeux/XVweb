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

	class xv_admin_xvauctions_auctions{
		var $style = "width: 90%;";
		var $contentStyle = "overflow-y:scroll; overflow-x: hidden; padding-bottom:10px;";
		var $URL = "XVauctions/Auctions/";
		var $content = "";
		var $id = "xva-auctions-window";
		var $Date;
		//var $contentAddClass = " xv-terminal";
		public function __construct(&$XVweb){
		$this->URL = "XVauctions/Auctions/".(empty($_SERVER['QUERY_STRING']) ? "" : "?".$_SERVER['QUERY_STRING']);
			$records_limit=30;
			$actual_page = (int) ifsetor($_GET['Page'], 0);
			$auction_list = $this->get_auctions($XVweb, $actual_page,$records_limit, $_GET);
			include_once($GLOBALS['LocationXVWeb'].DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
			$pager = pager($records_limit, (int) $auction_list->count_records,  "?".$XVweb->add_get_var(array("Page"=>"-npage-id-"), true), $actual_page);
				if(isset($_GET['sort']) && $_GET['sort'] == "desc")
			$sort = 'asc'; else
			$sort = 'desc';
		$this->content = '
		<style>
		.xv-auctions-wrapper {
			max-height: 500px;
		}
		</style>
		<div class="xv-auctions-wrapper">
		<div class="xv-table xva-auctions-list">
			<table style="width : 100%; text-align: center;">
				<caption>'.$pager[0].'</caption>
				<thead> 
					<tr class="xv-pager">
						<th><a href="?'.$XVweb->add_get_var('sort_by=ID&sort='.$sort, true).'">'.xv_lang("ID").'</a></th>
						<th><a href="?'.$XVweb->add_get_var('sort_by=Category&sort='.$sort, true).'">'.xv_lang("xca_category").'</a></th>
						<th><a href="?'.$XVweb->add_get_var('sort_by=Title&sort='.$sort, true).'">'.xv_lang("Title").'</a></th>
						<th><a href="?'.$XVweb->add_get_var('sort_by=Type&sort='.$sort, true).'">'.xv_lang("xca_auction_type").'</a></th>
						<th><a href="?'.$XVweb->add_get_var('sort_by=Start&sort='.$sort, true).'">'.xv_lang("xca_start").'</a></th>
						<th><a href="?'.$XVweb->add_get_var('sort_by=End&sort='.$sort, true).'">'.xv_lang("xca_end").'</a></th>
						<th><a href="?'.$XVweb->add_get_var('sort_by=Seller&sort='.$sort, true).'">'.xv_lang("xca_seller").'</a></th>
					</tr>
				</thead> 
				<tbody>';
				
			

				
		foreach($auction_list->list as $auction_item){
				$this->content .= '
				<tr>
					<td><a href="'.$GLOBALS['URLS']['Script'].'Administration/XVauctions/Auction/'.$auction_item['ID'].'" class="xv-get-window" >'.$auction_item['ID'].'</a></td>
					<td><a href="'.$GLOBALS['URLS']['Script'].'Administration/XVauctions/Categories/?cat='.urlencode($auction_item['Category']).'" class="xv-get-window" >'.$auction_item['Category'].'</a></td>
					<td><a href="'.$GLOBALS['URLS']['Script'].'Administration/XVauctions/Auction/'.$auction_item['ID'].'" class="xv-get-window" >'.$auction_item['Title'].'</a></td>
					<td>'.$auction_item['Type'].'</td>
					<td>'.$auction_item['Start'].'</td>
					<td>'.$auction_item['End'].'</td>
					<td><a href="'.$URLS['Script'].'Administration/Users/Get/'.$auction_item['Seller'].'/" class="xv-get-window" >'.$auction_item['Seller'].'</a>
					[<a target="_blank" href="'.$GLOBALS['URLS']['Script'].'Users/'.rawurlencode($auction_item['Seller']).'">preview</a>]</td>
				</tr>';
			}
			
				$this->content .= '</tbody> 
				</table>
				<div class="xv-table-pager">
				'.$pager[1].'
				</div>
			</div>
			
			<div class="xv-log-search">
				<a href="#" class="xv-toggle" data-xv-toggle=".xv-log-search-form"  > Szukaj </a>
					<form style="display:none"  class="xv-log-search-form xv-form" method="get" data-xv-result=".content" action="'.$GLOBALS['URLS']['Script'].'Administration/get/XVauctions/Auctions/?'.$XVweb->add_get_var(array(), true).'">
						<table>
						<tbody>';
				foreach($XVweb->DataBase->get_fields("AuctionAuctions") as $keyf=>$field){		
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
					
			</div>
			</div>
			';
			if(isset($_GET['search_mode']))
				exit($this->content);
			$this->title = xv_lang("xca_auctions");
			$this->icon = $GLOBALS['URLS']['Site'].'plugins/xvauctions/admin/xvauctions/icons/auctions.png';
			
		}
	public function get_auctions(&$XVweb, $actual_page = 0, $records_limit =30, $Search = array()){
			$LLimit = ($actual_page*$records_limit);
			$RLimit = $records_limit;

			$SearchAddQuery = array();
			$ExecVars = array();
			if(isset($Search["xv-value"]) && isset($Search["xv-func"]) && is_array($Search["xv-func"]) && is_array($Search["xv-value"])){
				foreach($Search["xv-func"] as $funckey=>$funcN){
					if($funcN !="none"){
					$UniqVar = ':'.uniqid();
						$SearchAddQuery[] = ' {AuctionAuctions:'.$funckey.'} '.$funcN.' '.$UniqVar.' ';
						$ExecVars[$UniqVar] = ifsetor($Search["xv-value"][$funckey], "");
					}
				}
			
			}
			$Query = 'SELECT SQL_CALC_FOUND_ROWS
			{AuctionAuctions:*}
	FROM {AuctionAuctions} '.(empty($SearchAddQuery) ? '' : 'WHERE '.implode(" AND ", $SearchAddQuery)).' ORDER BY {AuctionAuctions:'.(isset($Search['sort_by']) ? $Search['sort_by'] : 'ID' ).'} '.($Search['sort'] == "ASC" ? "ASC" : "DESC").' LIMIT '.$LLimit.', '.$RLimit.';';

			$auction_get_query = $XVweb->DataBase->prepare($Query);
			$auction_get_query->execute($ExecVars);
			$auctions_list = $auction_get_query->fetchAll();

			
			$count_records = $XVweb->DataBase->pquery('SELECT FOUND_ROWS() AS `count_records`;')->fetch(PDO::FETCH_OBJ)->count_records;

			return (object) array("list"=>$auctions_list , "count_records"=>$count_records);
	}
	}

?>