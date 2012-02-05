<?php

class user_info
{	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function get_modifications($user, $page = 0, $limit = 30){
		$list_modifications = $this->Date['XVweb']->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS
					`a`.{Articles:Date} AS `text_date`,
					`a`.{Articles:Topic} AS `text_title`,
					`a`.{Articles:Version} AS `text_ver`,
					`b`.{Text_Index:URL} AS `index_url`,
					`b`.{Text_Index:Topic}AS `index_title`,
					`b`.{Text_Index:Category} AS `index_category`,
					`b`.{Text_Index:AdressInSQL} AS `index_ids`,
					`b`.{Text_Index:Views} AS `index_views`
				 FROM 
					{Articles} AS `a`
				 INNER JOIN  {Text_Index} AS `b`
				ON `a`.{Articles:AdressInSQL} =  `b`.{Text_Index:AdressInSQL}
				WHERE 
					`a`.{Articles:Author} = :author
				AND
					`b`.{Text_Index:Alias} =  :no
				LIMIT '.($page*$limit).' , '.$limit.'
				');
		$list_modifications->execute(array(
			":no" => "no",
			":author" => $user,
		));
		return $list_modifications->fetchAll(PDO::FETCH_ASSOC);
	
	}
	public function get_files($user, $page = 0, $limit = 30){
		$list_files = $this->Date['XVweb']->DataBase->prepare('SELECT SQL_CALC_FOUND_ROWS 
				{Files:*}
			FROM 
				{Files}
			WHERE
				{Files:UserFile} = :user
			LIMIT '.($page*$limit).' , '.$limit.'
				');
		$list_files->execute(array(
			":user" => $user,
		));
		return $list_files->fetchAll(PDO::FETCH_ASSOC);
	
	}
	public function get_last_count_records(){
		return ((int) $this->Date['XVweb']->DataBase->pquery('SELECT FOUND_ROWS() AS `Count`;')->fetch(PDO::FETCH_OBJ)->Count);
	}
}

?>