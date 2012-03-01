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
	$XVClassName = "XV_Admin_logs";
	class XV_Admin_logs{
		var $style = "height: 500px; width: 90%;";
		var $contentStyle = "overflow-y:scroll; padding-bottom:10px;";
		var $URL = "Logs/";
		var $content = "test";
		var $id = "logs-window";
		var $Date;
		//var $contentAddClass = " xv-terminal";
		public function __construct(&$XVweb){
		$this->URL = "Logs/".(empty($_SERVER['QUERY_STRING']) ? "" : "?".$_SERVER['QUERY_STRING']);
			$RecordsLimit=30;
			$ActualPage = (int) ifsetor($_GET['Page'], 0);
			$LogList = $this->GetLog($XVweb, $ActualPage,$RecordsLimit, (isset($_GET['LogSelect']) ? $_GET['LogSelect'] : null), $_GET);
			include_once($GLOBALS['LocationXVWeb'].DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
			$pager = pager($RecordsLimit, (int) $LogList->LogCount,  "?".$XVweb->AddGet(array("Page"=>"-npage-id-"), true), $ActualPage);
			$Types = array_keys($LogList->Types);
			
		$this->content = '	<div class="xv-table">
			<table style="width : 100%; text-align: center;">
				<caption>'.$pager[0].'</caption>
				<thead> 
					<tr>
						<th>'.$GLOBALS['Language']['ID'].'</th>
						<th>'.$GLOBALS['Language']['Date'].'</th>
						<th>'.$GLOBALS['Language']['User'].'</th>
						<th>'.$GLOBALS['Language']['IP'].'</th>
						<th>'.$GLOBALS['Language']['Event'].'</th>
						<th>'.$GLOBALS['Language']['Info'].'</th>
					</tr>
				</thead> 
				<tbody>';
				
			

				
		foreach($LogList->List as $LogVal){
				$this->content .= '<tr>
					<td>'.$LogVal['ID'].'</td>
					<td>'.$LogVal['Date'].'</td>
					<td><a href="'.$GLOBALS['URLS']['Script'].'Users/'.rawurlencode($LogVal['User']).'">'.$LogVal['User'].'</a></td>
					<td>'.$LogVal['IP'].'</td>
					<td>'.$LogVal['Type'].'</td>
					<td><textarea style="width:400px;height:200px;">'.htmlspecialchars($LogVal['UnSerialized']).'</textarea> </td>
				</tr>';
			}
			
				$this->content .= '</tbody> 
				</table>
				<div class="xv-table-pager">
				'.$pager[1].'
				</div>
			</div>
			
			<div class="xv-log-search">
				<a href="#" class="xv-toggle" data-xv-toggle=".xv-log-search-form" action="?'.$XVweb->AddGet(array(), true).'" > Szukaj </a>
					<form style="display:none" class="xv-log-search-form xv-form" method="get" data-xv-result=".content" action="'.$GLOBALS['URLS']['Script'].'Administration/get/Logs/?'.$XVweb->AddGet(array(), true).'">
						<table>
						<tbody>';
				foreach($XVweb->DataBase->get_fields("Logs") as $keyf=>$field){		
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
			';
			if(isset($_GET['search_mode']))
				exit($this->content);
			$this->title = $GLOBALS['Language']['Logs'];
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/logs.png';
			
		}
	public function GetLog(&$XVweb, $ActualPage = 0, $EveryPage =30, $SelectLog= null, $Search = array()){
			$LLimit = ($ActualPage*$EveryPage);
			$RLimit = $EveryPage;
			if(!is_null($SelectLog)){
				foreach($SelectLog as $key=>$Type)
					$SelectLog[$key] = $XVweb->DataBase->quote($Type);
			}
			$SearchAddQuery = array();
			$ExecVars = array();
			if(isset($Search["xv-value"]) && isset($Search["xv-func"]) && is_array($Search["xv-func"]) && is_array($Search["xv-value"])){
				foreach($Search["xv-func"] as $funckey=>$funcN){
					if($funcN !="none"){
					$UniqVar = ':'.uniqid();
						$SearchAddQuery[] = ' {Logs:'.$funckey.'} '.$funcN.' '.$UniqVar.' ';
						$ExecVars[$UniqVar] = ifsetor($Search["xv-value"][$funckey], "");
					}
				}
			
			}
			$Query = 'SELECT SQL_CALC_FOUND_ROWS
			{Logs:*}
	FROM {Logs} '.(empty($SearchAddQuery) ? '' : 'WHERE '.implode(" AND ", $SearchAddQuery)).' ORDER BY {Logs:ID} DESC LIMIT '.$LLimit.', '.$RLimit.';
	';
	
			$LogSQL = $XVweb->DataBase->prepare($Query);
			$LogSQL->execute($ExecVars);
			$ArrayLog = $LogSQL->fetchAll();
			foreach($ArrayLog as $key=>$value)
				$ArrayLog[$key]['UnSerialized'] = print_r(unserialize($value['Text']), true);
			
			$LogCount = $XVweb->DataBase->pquery('SELECT FOUND_ROWS() AS `LogCount`;')->fetch(PDO::FETCH_OBJ)->LogCount;
			$Types = $XVweb->DataBase->pquery('SELECT DISTINCT ( {Logs:Type} ) AS `Types` FROM {Logs};')->fetchAll(PDO::FETCH_COLUMN);
			$Types  = array_combine(array_values($Types),array_values($Types));
			return (object) array("List"=>$ArrayLog , "LogCount"=>$LogCount, "Types"=>$Types);
	}
	}

?>