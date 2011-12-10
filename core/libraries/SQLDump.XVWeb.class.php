<?php


class SQLDump
{
	var $Date;
	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = &$Xvweb;
		$this->Date['SaveTo'] = "sql";
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function ToQuotes($n){
		return '`'.$n.'`';
	}
	function gzip($src, $level = 5, $dst = false){
		if($dst == false){
			$dst = $src.".gz";
		}
		if(file_exists($src)){
			$filesize = filesize($src);
			$src_handle = fopen($src, "r");
			if(!file_exists($dst)){
				$dst_handle = gzopen($dst, "w$level");
				while(!feof($src_handle)){
					$chunk = fread($src_handle, 2048);
					gzwrite($dst_handle, $chunk);
				}
				fclose($src_handle);
				gzclose($dst_handle);
				return true;
			} else {
				error_log("$dst already exists");
			}
		} else {
			error_log("$src doesn't exist");
		}
		return false;
	}

	public function &dump($file){
		$this->Date['File'] = $file;
		@unlink($this->Date['File']);
		
		$this->append('/*'."\n"); // Header for file / Nagłówek dla pliku
		$this->append('# SQL DUMP: '.(BdServer_Base)."\n"); // Name database / Nazwa bazy danych
		$this->append('# GENERATED: '.date("d.m.Y H:i:s")."\n"); //Date generated / Data wygenerowania
		$this->append('*/'."\n"); // END Header
			
			foreach ($this->Date['XVweb']->DataBase->query('SHOW TABLES;') as $Table) { // Get tables / Pobieranie tabel
				$TableStructure = $this->Date['XVweb']->DataBase->query('SHOW CREATE TABLE `'.$Table[0].'`')->fetch(); // Get table structure / Pobieranie struktury tabeli
				$this->append('/*TABLE STRUCTURE FOR `'.$Table[0].' */ '."\n"."\n"); //Header for table structure / Nagłówek dla struktury tabeli
				$this->append($TableStructure[1].';'."\n");  //Adding table structure to variable / Dodawanie struktury tabeli do zmiennej
				$this->append("\n".'/*SQL TABLE RECORDS FOR `'.$Table[0].' */ '."\n"."\n"); // Header for table records / Nagłówek dla rekordów tabeli
				$TableRows = $this->Date['XVweb']->DataBase->query('SELECT * FROM `'.$Table[0].'`;');  // Query for all rows in table / Zapytanie o wszystkie rekordy w tabeli
				while ($SelectRow = $TableRows->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) // While loop with records / Pętla z reordami tabeli
				$this->append(sprintf('INSERT INTO `'.$Table[0].'` (%s) VALUES (%s);', implode(', ',  array_map(array($this, "ToQuotes") ,array_keys($SelectRow))), implode(', ',array_map(array($this->Date['XVweb']->DataBase, 'quote'), $SelectRow)))."\n"); //Generate sql query with records / Generowanie zapytań SQL z rekordami
				$this->append("\n"."\n"); //Two empty lines for aesthetics / Dwie puste linie dla estetyki
			}
		return $this;
	}
	
	public function append($content){
		return file_put_contents($this->Date['File'], $content, FILE_APPEND);
	}
	function &toGZip(){
	$this->gzip($this->Date['File'], $level = 9);
		return $this;
	}
	public function toZip(){
	$zip = new ZipArchive;
		if ($zip->open($this->Date['File'].'.zip', ZipArchive::CREATE) === TRUE) {
			$zip->addFile($this->Date['File'], pathinfo ($this->Date['File'], PATHINFO_BASENAME ));
			$zip->close();
		}
	}
	public function remove($file){
	//@unlink($file);
	//@unlink($file.'.zip');
	return true;
	}
}

?>