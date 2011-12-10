<?php
class GOpenID{
	var $GoogleAuthURL = "https://www.google.com/accounts/o8/ud";
	var $openid_params = array(
	'openid.ns'                => 'http://specs.openid.net/auth/2.0',
	'openid.claimed_id'        => 'http://specs.openid.net/auth/2.0/identifier_select',
	'openid.identity'          => 'http://specs.openid.net/auth/2.0/identifier_select',
	'openid.return_to'         => "http://localhost/script.php",
	'openid.realm'             => "http://localhost/",
	'openid.mode'              => "checkid_setup",
	'openid.ns.ui'             => 'http://specs.openid.net/extensions/ui/1.0',
	'openid.ns.ext1'           => 'http://openid.net/srv/ax/1.0',
	'openid.ext1.mode'         => 'fetch_request',
	'openid.ext1.type.email'   => 'http://axschema.org/contact/email',
	'openid.ext1.type.first'   => 'http://axschema.org/namePerson/first',
	'openid.ext1.type.last'    => 'http://axschema.org/namePerson/last',
	'openid.ext1.type.country' => 'http://axschema.org/contact/country/home',
	'openid.ext1.type.lang'    => 'http://axschema.org/pref/language',
	'openid.ext1.required'     => 'email,first,last,country,lang',
	);

	public function Set($var, $value){
		$this->openid_params[$var] = $value;
	}

	public function GetFirst(){
		return (isset($_GET['openid_ext1_value_first']) ? $_GET['openid_ext1_value_first'] : null);
	}

	public function GetLast(){
		return (isset($_GET['openid_ext1_value_last']) ? $_GET['openid_ext1_value_last'] : null);
	}


	public function GetEmail(){
		return (isset($_GET['openid_ext1_value_email']) ? $_GET['openid_ext1_value_email'] : null);
	}

	public function GetCountry(){
		return (isset($_GET['openid_ext1_value_country']) ? $_GET['openid_ext1_value_country'] : null);
	}

	public function Redirect(){
		header('Location: '. $this->GoogleAuthURL .'?'. http_build_query($this->openid_params));
		exit;

	}

	public function Validate(){
		if(isset($_GET['openid_mode']) && $_GET['openid_mode'] == "id_res") return true; else
		return false;
	}
}
?>