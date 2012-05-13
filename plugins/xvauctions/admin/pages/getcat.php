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


class xv_admin_xvauctions_getcat{ // get categories
	public function __construct(&$XVweb){
		$Parent = (isset($_GET['cat']) ?  $_GET['cat']  : "/");
		$SelectCategories = $XVweb->DataBase->prepare('SELECT
				AA.{AuctionCategories:ID} as `ID`,
				AA.{AuctionCategories:Title} as `Title`,
				AA.{AuctionCategories:Name} as `Name`,
				AA.{AuctionCategories:Category} as `Category`,
				AA.{AuctionCategories:Parent} as `Parent`,
				AA.{AuctionCategories:Depth} as `Depth`,
				(SELECT COUNT(*) FROM {AuctionCategories} AB WHERE AB.{AuctionCategories:Parent} =  AA.{AuctionCategories:Category} ) as `Childrens`
				
		FROM 
			{AuctionCategories} AA
		WHERE
			{AuctionCategories:Parent} = :Parent 
		ORDER BY  {AuctionCategories:Name} ASC
		');
		
		$SelectCategories->execute(array(
		":Parent" => $Parent,
		));	
		
		$SelectCategory = $XVweb->DataBase->prepare('SELECT
				{AuctionCategories:*} 
				
		FROM 
			{AuctionCategories}
		WHERE
			{AuctionCategories:Category} = :Category 
		ORDER BY  {AuctionCategories:Name} ASC
		LIMIT 1;
		');
		
		$SelectCategory->execute(array(
		":Category" => $Parent,
		));
		$CatInfo = $SelectCategory->fetch(PDO::FETCH_ASSOC);
		if(empty($CatInfo)){
			$CatInfo = array("CatURL" => "/", "Title" =>"You can't edit this", "Name"=>"You can't edit this", "Use" => "0", "Category" => "/" );
		}else{
			$CatInfo['CatURL'] = $XVweb->read_sufix_from_url($CatInfo['Category']);
		}
		
		$ParentsCategories = getCategoryParents($CatInfo['Category']);
		foreach($ParentsCategories as &$item){
			$item = $XVweb->DataBase->quote($item);
		}
		
		
		$FieldsParent = $XVweb->DataBase->prepare('SELECT
				{AuctionFields:Category}  AS Category,
				COUNT({AuctionFields:Category})  AS CountFields
		FROM 
			{AuctionFields}
		WHERE
			{AuctionFields:Category} IN ('.implode(",", $ParentsCategories).') 
			GROUP BY {AuctionFields:Category}
		ORDER BY {AuctionFields:Category} ASC  
		');
		
		$FieldsParent->execute();
		
		echo json_encode(array("sub"=>$SelectCategories->fetchAll(PDO::FETCH_ASSOC), "info" => $CatInfo, "fields"=>$FieldsParent->fetchAll(PDO::FETCH_ASSOC), "parent"=> xvauctions_operations::get_category_parent($Parent)));
		exit();
	}
}



?>