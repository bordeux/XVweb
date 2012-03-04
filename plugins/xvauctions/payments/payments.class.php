<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

/**
 * xvpayments_method
 * To jest szablon dla pluginów dotyczących nowych metod płatności. Aby stworzyć nową metodę płatnośći, należy utworzyć nowy plik 
 * w folderze XVweb/xvauctions/payments/ o nazwie NAZWA_MODULU.payments.class.php a w pliku zadeklarować klasę na wzór:
	 @code
	 xvpayments_method_NAZWA_MODULU  extends xvpayments_method {
		var $config_file = "your.config"; //tutaj nazwa twojego pliku konfiguracyjnego z folderu XVweb/config , bez rozszerzenia .xml
	 }
	 @endcode
	 W tej klasie tylko podmieniasz metody, które są ci potrzebne. Więcej o nich poniżej.
 */
class xvpayments_method {
	/**
	 * Tutaj nazwa twojego pliku konfiguracyjnego z folderu XVweb/config , bez rozszerzenia .xml
	 */
	var $config_file = "your.config";
	var $Data;
	/**
	 * Kontruktor - w parametrze jest przekazywane obiekt XVweb, na potrzeby klasy. W środku zapisujemy do logów wywołanie klasy
	 * @param $Xvweb XVweb - referencja do obiektu XVweb
	 * @return void
	 */
	public function __construct(&$Xvweb) {
		$this->Data['XVweb'] = &$Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	/**
	 * Jest to miejsce, gdzie możemy kierować wywołania z płatności (URL backend, URLC etc, gdzie pod podany adres są wysyłane dane o płatności). 
	 * Aby wywołać tą metodę, należy wejść na adres, według
	 @code
		$GLOBALS['URLS']['AuctionPanel'].'/payment_add/NAZWA_MODULU/worker/
	 @endcode
	 * @return void
	 */
	public function worker(){
	}
	
	/**
	 * Metoda jest wykonywana w celu pobrania formularza na stronie
	 @code
		$GLOBALS['URLS']['AuctionPanel'].'/payment_add/NAZWA_MODULU/
	 @endcode
	 * @return STRING - Formularz w postaci text/html
	 */
	public function form(){
		return '';
	}
	
	/**
	 * Metoda jest wykonywana w celu pobrania przycisku na stronie
	 @code
		$GLOBALS['URLS']['AuctionPanel'].'/payment_add/
	 @endcode
	 * @return STRING - przycisk z linkiem w postaci text/html
	 */
	public function button(){
		return '';
	}
}

	?>