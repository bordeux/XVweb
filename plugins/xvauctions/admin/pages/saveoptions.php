<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
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

class XV_Admin_xvauctions_saveoptions{
	public function __construct(&$XVweb){
		if($XVweb->Session->GetSID() != $_POST['xv-sid']){
			exit("<div class='failed'>Error: Bad SID!</div>");
		}

		include_once(ROOT_DIR.'plugins/xvauctions/libs/class.xvauctions.php');
		$XVauctions = &$XVweb->InitClass("xvauctions");
		
function convert_type( $var ){
		
    if( is_numeric( $var ) ) {
        if( (float)$var != (int)$var ) {
            return (float)$var;
        }
        else{
            return (int)$var;
        }
    }
    
    if( $var == "true" )    return true;
    if( $var == "false" )    return false;  
    return $var;
}
		foreach($_POST['options'] as $key=>$val){
				$_POST['options'][$key] = convert_type($val);
		}

		
		if($_POST['category'] == "/"){
			file_put_contents(ROOT_DIR.'plugins/xvauctions/config/default.php', "<?php \n".'$xva_config = '.var_export($_POST['options'], true)."; \n ?>");
		}else{
			$all_cats = $XVauctions->get_category_tree($_POST['category']);
			$actual_cat_options = end($all_cats);
			$actual_cat_options = $actual_cat_options['Options'];
			$pre_end_cat_options = array();
			
			if(count($all_cats) == 1 ){
				include(ROOT_DIR.'plugins/xvauctions/config/default.php');
				$pre_end_cat_options = $xva_config;
			}else{
				$pre_end_cat_options = $all_cats[count($all_cats)-2]['Options'];
			}
			$to_save = array();
			foreach($_POST['options'] as $key_k=>$val){
				if($pre_end_cat_options[$key_k] != $val){
					$to_save[$key_k] = $val;
				}
			}
			
			$update_categort = $XVweb->DataBase->prepare('UPDATE {AuctionCategories} SET {AuctionCategories:Options} = :options WHERE {AuctionCategories:Category} = :category  ');
			$update_categort->execute(array(
				":options" => serialize($to_save),
				":category" => $_POST['category'],
			));
			
		}
		
		echo "<div class='success'>Zapisano</div>";
		exit;
	}
}

?>