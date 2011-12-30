<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   debug.php         *************************
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
class DebugPDO extends PDOStatement
{
	protected $pdo;
	protected function __construct($pdo)
	{
		$this->pdo = $pdo;
	}
	public function execute( $args = null )
	{
		$GLOBALS['CounterSQL']++;
		if( is_array( $args ) )
		return parent::execute( $args );
		else
		{
			$args = func_get_args();
			return eval( 'return parent::execute( $args );' );
		}
	}
	public function prepare($statement, $driver_options = array()) {
		echo "no widzisz. ale zal";
		$this->LastQuery[] = array("query"=>$statement, "driver_options"=>$driver_options);
		return parent::prepare($statement, $driver_options);
	}
}
try {
	$dbh = new PDO('mysql:host='.BdServer.';dbname='.BdServer_Base, BdServer_User, BdServer_Password);
	$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbh->setAttribute( PDO::ATTR_STATEMENT_CLASS, array( 'DebugPDO', array($dbh) ) );
} catch (PDOException $e) {
	exit(sprintf($Language['DBConnectError'], ($e->getMessage())));
}
?>