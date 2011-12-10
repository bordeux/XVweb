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

class SqlAdmin
{
	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	function ExplodeQuery ( $queryBlock, $delimiter = ';' ) {
	$inString = false;
	$escChar = false;
	$sql = '';
	$stringChar = '';
	$queryLine = array();
	$sqlRows = explode( "\n", $queryBlock );
	$delimiterLen = strlen ( $delimiter );
	do {
		$sqlRow = current ( $sqlRows ) . "\n";
		$sqlRowLen = strlen ( $sqlRow );
		for ( $i = 0; $i < $sqlRowLen; $i++ ) {
			if ( ( substr ( ltrim ( $sqlRow ), $i, 2 ) === '--' || substr ( ltrim ( $sqlRow ), $i, 1 ) === '#' ) && !$inString ) {
				break;
			}
			$znak = substr ( $sqlRow, $i, 1 );
			if ( $znak === '\'' || $znak === '"' ) {
				if ( $inString ) {
					if ( !$escChar && $znak === $stringChar ) {
						$inString = false;
					}
				}
				else {
					$stringChar = $znak;
					$inString = true;
				}
			}
			if ( $znak === '\\' && substr ( $sqlRow, $i - 1, 2 ) !== '\\\\' ) {
				$escChar = !$escChar;
			}
			else {
				$escChar = false;
			}
			if ( substr ( $sqlRow, $i, $delimiterLen ) === $delimiter ) {
				if ( !$inString ) {
					$sql = trim ( $sql );
					$delimiterMatch = array();
					if ( preg_match ( '/^DELIMITER[[:space:]]*([^[:space:]]+)$/i', $sql, $delimiterMatch ) ) {
						$delimiter = $delimiterMatch [1];
						$delimiterLen = strlen ( $delimiter );
					}
					else {
						$queryLine [] = $sql;
					}
					$sql = '';
					continue;
				}
			}
			$sql .= $znak;
		}
	} while ( next( $sqlRows ) !== false );

	return $queryLine;
	}
}
/*
$RecordsLimit=30;
$ActualPage = (int) ifsetor($_GET['Page'], 0);
$LogList = $XVwebEngine->InitClass("PanelAdmin")->GetLog($ActualPage,$RecordsLimit);
$Smarty->assign('LogList', $LogList);
include_once($LocationXVWeb.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'Pager.php');
$pager = pager($RecordsLimit, (int) $LogList->LogCount,  "?".$XVwebEngine->AddGet(array("Page"=>"-npage-id-"), true), $ActualPage);
$Smarty->assign('Pager', $pager);

$Smarty->assign('LogSeleced', array_keys($LogList->Types));
*/
$Smarty->display('admin/admin_show.tpl');

?>