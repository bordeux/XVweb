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
					`b`.{ListArticles:URL} AS `index_url`,
					`b`.{ListArticles:Topic}AS `index_title`,
					`b`.{ListArticles:Category} AS `index_category`,
					`b`.{ListArticles:AdressInSQL} AS `index_ids`,
					`b`.{ListArticles:Views} AS `index_views`
				 FROM 
					{Articles} AS `a`
				 INNER JOIN  {ListArticles} AS `b`
				ON `a`.{Articles:AdressInSQL} =  `b`.{ListArticles:AdressInSQL}
				WHERE 
					`a`.{Articles:Author} = :author
				AND
					`b`.{ListArticles:Alias} =  :no
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