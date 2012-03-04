<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   default.php       *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :   1.0               *************************
****************   Authors   :   XVweb team        *************************
*************************XVweb Team*****************************************
				Krzyszof Bednarczyk, meybe you
/////////////////////////////////////////////////////////////////////////////
 Klasa XVweb jest na licencji LGPL v3.0 ( GNU LESSER GENERAL PUBLIC LICENSE)
****************http://www.gnu.org/licenses/lgpl-3.0.txt********************
		Pełna dokumentacja znajduje się na stronie domowej projektu: 
*********************http://www.bordeux.NET/Xvweb***************************
***************************************************************************/
if(!isset($XVwebEngine)){
	header("location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}

	class XV_Admin_xvauctions_auctions{
		var $style = "width: 90%;";
		var $contentStyle = "overflow-y:scroll; padding-bottom:10px;";
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
			$pager = pager($records_limit, (int) $auction_list->count_records,  "?".$XVweb->AddGet(array("Page"=>"-npage-id-"), true), $actual_page);
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
						<th><a href="?'.$XVweb->AddGet('sort_by=ID&sort='.$sort, true).'">'.xvLang("ID").'</a></th>
						<th><a href="?'.$XVweb->AddGet('sort_by=Category&sort='.$sort, true).'">'.xvLang("xca_category").'</a></th>
						<th><a href="?'.$XVweb->AddGet('sort_by=Title&sort='.$sort, true).'">'.xvLang("Title").'</a></th>
						<th><a href="?'.$XVweb->AddGet('sort_by=Type&sort='.$sort, true).'">'.xvLang("xca_auction_type").'</a></th>
						<th><a href="?'.$XVweb->AddGet('sort_by=Start&sort='.$sort, true).'">'.xvLang("xca_start").'</a></th>
						<th><a href="?'.$XVweb->AddGet('sort_by=End&sort='.$sort, true).'">'.xvLang("xca_end").'</a></th>
						<th><a href="?'.$XVweb->AddGet('sort_by=Seller&sort='.$sort, true).'">'.xvLang("xca_seller").'</a></th>
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
					<td><a target="_blank" href="'.$GLOBALS['URLS']['Script'].'Users/'.rawurlencode($auction_item['Seller']).'">'.$auction_item['Seller'].'</a></td>
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
					<form style="display:none"  class="xv-log-search-form xv-form" method="get" data-xv-result=".content" action="'.$GLOBALS['URLS']['Script'].'Administration/get/XVauctions/Auctions/?'.$XVweb->AddGet(array(), true).'">
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
			$this->title = xvLang("xca_auctions");
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/xvauctions/icons/auctions.png';
			
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