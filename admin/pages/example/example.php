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
	$xv_admin_class_name = "xv_admin_example";
	class xv_admin_example{
		var $style = "height: 400px; width: 40%;";
		var $title = "testWindow";
		var $URL = "Test/";
		var $content = "test";
		var $id = "testWindow";
		var $contentAddClass = " xv-terminal";
		public function __construct(&$XVweb){
		
			$this->icon = $GLOBALS['URLS']['Site'].'admin/data/icons/ban.png';
		}
	}

?>