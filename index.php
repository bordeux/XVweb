<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   index.php         *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :  1.0                *************************
****************   Authors   :  XVweb team         *************************
*************************XVweb Team*****************************************
				Krzyszof Bednarczyk, meybe you
/////////////////////////////////////////////////////////////////////////////
 Klasa XVweb jest na licencji LGPL v3.0 ( GNU LESSER GENERAL PUBLIC LICENSE)
****************http://www.gnu.org/licenses/lgpl-3.0.txt********************
		Pełna dokumentacja znajduje się na stronie domowej projektu: 
*********************http://www.bordeux.NET/Xvweb***************************
***************************************************************************/
$_SERVER['PHP_SELF'] = $_SERVER['REQUEST_URI'].'xv.php/';
if(!isset($XVwebEngine))
	include_once('xv.php');
?>