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

class XV_Admin_xvauctions_newfield{ 
	public function __construct(&$XVweb){
		if($XVweb->Session->GetSID() != $_POST['xv-sid']){
			exit("<div class='failed'>Error: Bad SID!</div>");
		}
		include_once(ROOT_DIR.'plugins/xvauctions/fields/fields.php');
		foreach (glob(ROOT_DIR.'plugins/xvauctions/fields/*.fields.php') as $filename) {
			include_once($filename);
		}
		
		$FieldName = preg_replace('#[^a-z0-9_]+#', '', strtolower($_POST['newfield']['name']));
		if(strlen($FieldName) < 2){
			exit("<div class='failed'>Field name is too short! Min: 2 chars</div>");
		}
		$TypeClassName = 'xvauction_fields_'.$_POST['newfield']['type'];
		if (!class_exists($TypeClassName)) {
			exit("<div class='failed'>Bad field type</div>");
		}
		
		
		$ParentsCategories = getCategoryParents($_POST['newfield']['category']);
		foreach($ParentsCategories as &$item){
			$item = $XVweb->DataBase->quote($item);
		}
		
		
		
		$FieldsParent = $XVweb->DataBase->prepare('
			SELECT
					{AuctionFields:Category}  AS `Category`
			FROM 
				{AuctionFields}
			WHERE
				{AuctionFields:Category} IN ('.implode(",", $ParentsCategories).')
			AND
				{AuctionFields:Name} = '.$XVweb->DataBase->quote($FieldName).'
			LIMIT 1;
		');
		
		$FieldsParent->execute();
		$FieldsParent = $FieldsParent->fetch();
		if(isset($FieldsParent['Category'])){
			
			exit('<div class="failed">This name of field is used in <a href="'.$GLOBALS['URLS']['Script'].'Administration/XVauctions/EditFields/?cat='.urlencode($FieldsParent['Category']).'" class="xv-get-window">'.$FieldsParent['Category']."</a></div>");
		}
		$FieldClass = new $TypeClassName($XVweb);
		
		$AddField = $XVweb->DataBase->prepare('INSERT INTO {AuctionFields} ({AuctionFields:ID}, {AuctionFields:Category}, {AuctionFields:Name}, {AuctionFields:Search}, {AuctionFields:FieldOptions}, {AuctionFields:SearchType}, {AuctionFields:Type}, {AuctionFields:Class}, {AuctionFields:Priority}) VALUES (NULL, :category , :name, :searchL, :options, :stype, :type, :class,  :priority);
		');
		try {
			$AddField->execute(array(
			":category"=> $_POST['newfield']['category'],
			":class"=> $TypeClassName,
			":name"=>  $FieldName,
			":searchL"=> "none",
			":options" => serialize($FieldClass->options($FieldName)),
			":stype" => "none",
			":type" => $FieldClass->Type,
			":priority" => 0
			));
		}catch(Exception $e) {
			exit("<div class='failed'>Error: ".$e->getMessage()."</div>");
		}
		exit("<div class='success'>Field added! Please refresh this page to show new result</div>");
	}
}
?>