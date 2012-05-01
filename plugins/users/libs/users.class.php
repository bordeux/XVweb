<?php

class xv_users {
	var $XVweb;
	var $last_added_user_id =  0;
	public function __construct(&$XVweb){
		$this->XVweb = &$XVweb;
	}
	
	public function user_add($user, $password, $email, $group, $key){
		if (!preg_match("/^([a-zA-Z0-9+])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/", $email) ){
				return "wrong_email";
			}
		if(!preg_match("/^([a-zA-Z0-9_-])+$/i",  $user) || empty($user) || strlen($user) < 3){
			return  "invalid_username";
		}
		
		if(strlen($password) < 5)
			return "password_too_short";
		
	
		$check_user = $this->XVweb->DataBase->prepare('SELECT * FROM {Users} WHERE  {Users:User} = :UserExecute');
		$check_user->execute(array(':UserExecute' =>  $user));
		if($check_user->rowCount()){
			return "username_exsist";
		}
		
		$add_user = $this->XVweb->DataBase->prepare("INSERT INTO {Users} 
		({Users:User}, {Users:Password}, {Users:Mail}, {Users:Group}, {Users:RegisterCode}, {Users:Creation})
			VALUES
		(:user, :password, :mail, :group, :key, NOW())");
		
		$add_user->execute(array(
			":user" => $user,
			":password" => $password,
			":mail" => $email,
			":group" =>  $group,
			":key" =>  $key,
		));
		$this->last_added_user_id = $this->XVweb->DataBase->lastInsertId();
		return true;
	}
	
	public function get_user($user){
		$get_user_d = $this->XVweb->DataBase->prepare("SELECT {Users:*} FROM {Users} WHERE {Users:User} = :user LIMIT 1;");
		$get_user_d->execute(array(
			":user" => $user
		));
		return $get_user_d->fetch(PDO::FETCH_OBJ);
	}
	public function get_last_user_id(){
		return $this->last_added_user_id;
	}
	
	
	
	public function user_edit_password($user, $password){
		
	}
	
	public function user_send_email($user, $topic, $context, $vars= array()){
		global $URLS;
		$user_info = $this->get_user($user);
		if(empty($user_info))
			return false;
		
		foreach($user_info as $key=>$val)
			$vars['--xv-user-'.strtolower($key).'--'] = $val;
			
		foreach($URLS as $key=>$val)
			$vars['--xv-urls-'.strtolower($key).'--'] = $val;
			
		$context = strtr($context, $vars);
		$topic = strtr($topic, $vars);
		
		return $this->XVweb->MailClass()->mail($user_info->Mail, $topic, $context);
	}
	
	public function user_activate($user, $key = null){
		$sql_data = array();
		$sql_data[":user"] = $user;
		if(!is_null($key)){
			if(strlen($key) < 2)
				return false;
				$sql_data[":key"] = $key;
			}
		
		$update_user = $this->XVweb->DataBase->prepare("UPDATE {Users} SET {Users:RegisterCode} = 1 WHERE {Users:User} = :user ".(is_null($key) ? '' : ' AND {Users:RegisterCode} = :key')." LIMIT 1;");
		$update_user->execute($sql_data);
		return ($update_user->rowCount() ?  true : false);
	}
	public function user_remove($user){
	
	}
	public function user_login($user, $password, $check_password = true){
		$user_data = $this->get_user($user);
		if(empty($user_data)){
			return "invalid_username";
		}
		if($check_password && $user_data->Password !== $password)
			return "wrong_password";
		if($user_data->RegisterCode != 1)
			return "user_not_activated";
			
		$this->XVweb->Session->Session('Logged_Logged', true);
		$this->XVweb->Session->Session('Logged_ID', $user_data->ID);
		$this->XVweb->Session->Session('Logged_User', $user_data->User);
		$this->XVweb->Session->Session('Logged_Avant', $user_data->Avant);
		$this->XVweb->Session->Session('user_logged_in', true);
		$this->XVweb->Session->Session('user_group', $user_data->Group);
		$this->XVweb->Session->Session('user_permissions', $this->group_get_permissions($user_data->Group));
		$this->XVweb->Log("users.user_login", array(
			"user"=>$user_data->User
		));
	
			
		return true;
		
	
	}
	public function hash_password($pass){
		return hash('sha256',  substr($pass, -3).HASH_SALT.substr($pass, 3). HASH_SALT.$pass.HASH_SALT.substr($pass, -5));
	}
	public function user_edit($user, $fields = array()){
		if(empty($fields))
			return true;
			
		$fields_array = array();
		foreach($fields as $key=>$val){
			$fields_array[] = '{Users:'.$key.'} = '. $this->XVweb->DataBase->quote($val);
		}

		$query = 'UPDATE {Users} SET '.implode(" , ", $fields_array).' WHERE {Users:User} = '.$this->XVweb->DataBase->quote($user).' LIMIT 1;';

		$update_query = $this->XVweb->DataBase->prepare($query);
		$update_query->execute();
		
		return ($update_query->rowCount() ? true : false);
	
	}
	public function group_get_permissions($group){
			$permissions = array();
			$permissions_sql = $this->XVweb->DataBase->prepare('SELECT {Groups:Permission} AS `Permission`  FROM  {Groups} WHERE {Groups:Name} = :name ;');
			$permissions_sql->execute(array(
				":name" => $group
			));
			$permissions_sql = $permissions_sql->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($permissions_sql as $permission)
				$permissions[] = $permission['Permission'];
				
		return $permissions;
	}
	
}

?>