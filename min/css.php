<?php
/***************************************************************************
****************   Bordeux.NET Project             *************************
****************   File name :   performance.php   *************************
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
ob_clean(); // czyszczenie wyjscia
chdir(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'); 
	if (isset($_GET['file']) && file_exists($_GET['file']) && pathinfo($_GET['file'], PATHINFO_EXTENSION) == "css") { //sprawdzanie czy plik istnieje, i czy ma rozrzeszenie css
		chdir(dirname($_GET['file']));//zmiana katalogu wywoływania skryptu, na ten, gdzie znajduje sie plik css
		$TMPDir = dirname(__FILE__).'/../tmp/'; // ustawienie folderu z cache
		$IDFile = md5($_GET['file']).(isset($_GET["ie"]) ? "IE" : ""); // generowanie ID file
		
		function compressCSS($buffer) { //funkcja kompresujaca kod
			$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer); // usuwanie komentarzy
			$buffer = str_replace(array("\r\n", "\r", "\n", "\t"), '', $buffer); // usuwamy niepotrzebne spacje, tabulatory, nowe linie (białe znaki)
			$buffer = str_replace(array("{ ", " }", "  "), array("{", "}", " "), $buffer);
			return $buffer; // resultat
		}
		function ReplaceImage($matches){ // funkcja zamieniajaca plik na CSS z data URI scheme
			if(stripos($matches[1], "noinclude=true"))
			return "url('".str_replace(array("?noinclude=true", "noinclude=true"), "", $matches[1])."')"; // jesli jest paramter noinclude na true  (obrazek.jpg?noinclude=true) to obrazek nie jest osadzany w CSS
			if(!file_exists(trim($matches[1])))
				return "transparent";
				
			return " url(data:image/".pathinfo($matches[1], PATHINFO_EXTENSION).";base64,".base64_encode(file_get_contents(trim($matches[1]))).") "; // kod css, wykrywanie typu mime, oraz kodowanie zawartosci danego pliku do Base64
		}
		
		if(!file_exists($TMPDir.$IDFile.'.css')){ // sprawdzanie czy plik istnieje w cache
			$file = file_get_contents(basename($_GET['file'])); // jesli nie, pobierz jego zawartosc
			try {
				include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'lessc.inc.php');
				$less = new lessc();
				$file  = $less->parse($file);
			} catch (exception $ex) {
			//	exit('lessc fatal error:<br />'.$ex->getMessage());
			}

			$CSSCompres = compressCSS($file); // przelanie przez funkcję
			
			/*if(!isset($_GET["ie"])){
				$CSSCompres = preg_replace_callback( // wyrazenie regularne, do wyszukiwania zawartosci pomiedzy url() w css
				"/url\((.*?)\)/si",
				'ReplaceImage'
				, $CSSCompres);
			}*/
			file_put_contents($TMPDir.$IDFile.'.css',$CSSCompres); //zapisanie do cache
		}

		if (substr_count ($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) { //sprawdzanie czy klient obsługuje gzip
			$filegz = $TMPDir.$IDFile.'.css.gz'; // lokalizacja pliku w gzip w cache
			if(!file_exists($TMPDir.$IDFile.'.css.gz')){ // sprawdzanie czy istnieje
				$BindFile = file_get_contents($TMPDir.$IDFile.'.css'); //jesli nie istnieje, otworz przekonwertowany juz plik css (powyzej juz zostalo to robione)
				$handle = gzopen ($filegz, 'w9'); // skompresuj najlepsza jakością
				gzwrite ($handle, $BindFile); // zapisz w cache
				gzclose ($handle); // zamknij archiwum
				chmod ($filegz, 0755); // ustaw plikowi odpowiednie uprawnienia
			}
			
			ob_clean(); // czysc bufor wyjscia
			$FileModification = filemtime($filegz); // sprawdź, kiedy plik został zmodyfikowany
			$expires = 1209600; //60*60*24*14 wygasniecie
			if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $_SERVER['HTTP_IF_MODIFIED_SINCE'] == gmdate('D, d M Y H:i:s',$FileModification).' GMT') { //sprawdzenie czy klient ma dany plik w cache, i czy jest nie za stary
				header("HTTP/1.0 304 Not Modified"); //jesli ma odpowiedni, wyslij mu nagłówek 304 - nie zmodyfikowany
				exit; // zakoncz skrypt
			}

			//zadania wykonywane dla pliku gzip
			header("Pragma: public"); // wysylanie naglowkow
			header("Last-Modified: ".gmdate("D, d M Y H:i:s", $FileModification)." GMT");  // data zmodyfikowania pliku
			header('ETag: "'.$IDFile.'GZ"'); //Etag jest naszym ID file w md5+GZ
			header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT'); // czas wygasniecia pliku w cache
			header("content-type: text/css; charset: UTF-8");   // wysylanie naglowka mime i kodowania pliku
			header("cache-control: must-revalidate");   //Zakazuje serwerowi proxy udostępniania unieważnionych kopii obiektów w sytuacjach np. awarii połączenia z serwerem czy niskiej przepustowości sieci
			header('Content-Encoding: gzip'); //kompresja
			header('Vary: Accept-Encoding'); 
			header("Cache-Control: private, max-age=10800, pre-check=10800"); // czas pliku w cache
			header('XVwebMSG: Gzip, all files send'); //Naglowek informacyjny dla webdevelopera
			readfile($filegz); //odczyt i wyswietlenie pliku
			exit; // zakonczenie pliku
		}
		$expires = 1209600; //60*60*24*14 wygasniecie
		header("Pragma: public");// wysylanie naglowkow
		header('Etag: '.$IDFile.';');//Etag jest naszym ID file w md5
		header("Cache-Control: maxage=".$expires);// czas wygasniecia pliku w cache
		header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');// czas wygasniecia pliku w cache
		header('Content-type: text/css; charset=utf-8'); // wysylanie naglowka mime i kodowania pliku
		header('XVwebMSG: "Not gzip";'); //Naglowek informacyjny dla webdevelopera
		readfile($TMPDir.$IDFile.'.css');//odczyt i wyswietlenie pliku
		exit; // zakonczenie skryptu
	}

?>