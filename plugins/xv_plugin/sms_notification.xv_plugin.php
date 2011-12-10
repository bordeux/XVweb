<?php
class xv_plugin_sms_notification {
	public function main_sendsms($text){
		$params = array(

			'username'    => 'xvweb',        //login z konta smsAPI.pl
			'password'    => md5('polska'),        //lub $password="ci¹g md5"
			'to'        => '48794413911',        //numer odbiorcy
			'from'        => '',            //nazwa nadawcy musi byæ aktywna
			'message'    => $text,    //treœæ wiadomoœci
		);
		$data = '?'.http_build_query($params);
		$plik = fopen('http://api.smsapi.pl/send.do'.$data,'r');
		$wynik = fread($plik,1024);
		fclose($plik);
    return true;
	// echo $wynik;
	}
	public function after_xvpayments__add_transaction($result, $args){
		//xv_plugin_sms_notification::main_sendsms("Wlasnie doladowalismy twoje konto, user: ".$args[0].' , kwota: '.($args[1]/100).'zl, tytul:'.$args[3]);
		
		return $result;
	}	
}

?>