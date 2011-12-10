<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   GOpenID.class.php *************************
****************   Start     :   22.05.2007 r.     *************************
****************   License   :   LGPL              *************************
****************   Version   :   1.0               *************************
****************   Authors   :   XVweb team        *************************
*************************XVweb Team*****************************************
				Krzyszof Bednarczyk, meybe you
/////////////////////////////////////////////////////////////////////////////
Klasa XVweb jest na licencji LGPL v3.0 ( GNU LESSER GENERAL PUBLIC LICENSE)
****************http://www.gnu.org/licenses/lgpl-3.0.txt********************
		Pe³na dokumentacja znajduje siê na stronie domowej projektu: 
*********************http://www.bordeux.NET/Xvweb***************************
***************************************************************************/

class GOpenID{

	var $GoogleAuthURL = "https://www.google.com/accounts/o8/ud"; // URL to google openid server / Adres serwera openid od google
	
	var $openid_params = array( // set default parameters / ustawienie domyslnych parametrow
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
	'openid.ext1.required'     => 'email,first,last,country,lang', // data to select - this is max options / dane ktore mamy pobrac - to jest maxymalna ilosc
	);

	public function Set($var, $value){ // function to change parameters / funkcja do zmiany powyzszych parametrow
		$this->openid_params[$var] = $value;
	}

	public function GetFirst(){ // function to get frist name / funkcja do pobrania imienia
		return (isset($_GET['openid_ext1_value_first']) ? $_GET['openid_ext1_value_first'] : null);
	}

	public function GetLast(){ // function to get vorname / funkcja do pobrania nazwiska
		return (isset($_GET['openid_ext1_value_last']) ? $_GET['openid_ext1_value_last'] : null);
	}


	public function GetEmail(){ // function to get user email / funkcja do pobrania emaila uzytkownika
		return (isset($_GET['openid_ext1_value_email']) ? $_GET['openid_ext1_value_email'] : null);
	}

	public function GetCountry(){ // function to get user couuntry / pobieranie narodowosci
		return (isset($_GET['openid_ext1_value_country']) ? $_GET['openid_ext1_value_country'] : null);
	}

	public function Redirect(){ // redirect to google server  - authorize user / przekierowanie na serwer google w celu autoryzacji
		header('Location: '. $this->GoogleAuthURL .'?'. http_build_query($this->openid_params));
		exit;
	}

	public function Validate(){ // Verifying data downloaded via GET methid / funkcja sprawdza czy dane poslane metoda get sa prawdziwe (oszustwo itp)
		$Data = array();
		$QueryString = $_SERVER['QUERY_STRING']; // get query string / pobranie zapytania na serwer (likie var=value&var2=value2)
		$QueryString = str_replace("openid.mode=id_res", "openid.mode=check_authentication", $QueryString ); // replace mode / zmiana trybu
		$URL = $this->GoogleAuthURL.'?'.$QueryString; // build url to google server / budowanie adresu url by sprawdzic poprawnosc danych
		$Result = @file_get_contents($URL);

		if(strpos($Result, "is_valid:true") === false) // check result
			return false;
			
		return true;	
	}
	
}
?>