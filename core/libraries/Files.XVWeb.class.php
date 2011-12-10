<?php

class FilesClass
{	var $Date;

	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$this->Date['FilesDir'] = "files".DIRECTORY_SEPARATOR;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function GetFile($ID, $Download=false){
		if(!is_numeric($ID)){
			$this->Date['XVweb']->LoadException();
			throw new XVwebException(100);
		}
		if($this->Date['XVweb']->Cache->exist("File", $ID)){
			$File = $this->Date['XVweb']->Cache->get();
		}else{
			$FileSQL = $this->Date['XVweb']->DataBase->prepare('SELECT {Files:*} FROM {Files} WHERE {Files:ID} = :IDExec LIMIT 1;');
			$FileSQL->execute(array(
				":IDExec" => $ID
			));
			
			$File = $FileSQL->fetch();
			if(empty($FileSQL))
			return false;

			$this->Date['XVweb']->Cache->put("File", $ID, $File);
		}	
		if($Download){
			$FileUpdateSQL = $this->Date['XVweb']->DataBase->prepare('UPDATE {Files} SET  {Files:LastDownload} = NOW() , {Files:Downloads} = {Files:Downloads} +1 WHERE {Files:ID} = :IDExec LIMIT 1;');
			$FileUpdateSQL->execute(array(
			":IDExec" => $ID
			));
		}
		return $File;
		
	}

	public function AddFile($FileLocation){
			$File['UserFile'] = $this->Date['XVweb']->Session->Session('Logged_User');
			$File['IP'] = $_SERVER['REMOTE_ADDR'];
			$File['MD5File'] = md5(MD5Key.$FileLocation);
			$File['SHA1File'] = sha1_file($FileLocation);
			$File['FileSize'] = filesize($FileLocation);
			$path_parts = pathinfo($FileLocation);
			$File['FileName'] = $path_parts['filename'];
			$File['Extension'] = $path_parts['extension'];
			$CheckExsist = $this->Date['XVweb']->DataBase->prepare('SELECT COUNT(1) AS `count` FROM {Files} WHERE {Files:MD5File} = :MD5Exec AND {Files:SHA1File} = :SHA1Exec ;');
			$CheckExsist->execute(array(
				":MD5Exec" => $File['MD5File'],
				":SHA1Exec" => $File['SHA1File']
			));
			$CheckExsist = $CheckExsist->fetch();
			$CheckExsist = $CheckExsist[0]['count'];
			if($CheckExsist) {
				unlink($FileLocation);
				$File['Owner'] = false;
			} else {
				$File['Owner'] = true; 
				rename($FileLocation, ($this->Date['FilesDir']).$File['MD5File'].$File['SHA1File']);
			}
			$AddFileSQL = $this->Date['XVweb']->DataBase->prepare('INSERT INTO {Files}
		({Files:Date}, {Files:UserFile} , {Files:FileName} , {Files:Extension}  , {Files:IP} , {Files:MD5File} , {Files:SHA1File} , {Files:FileSize} , {Files:Owner}, {Files:Server}) 
VALUES  (NOW() , :UserFileExec, :FileNameExec , :ExtensionExec, :IPExec , :MD5FileExec , :SHA1FileExec , :FileSizeExec , :OwnerExec, :ServerExec )' ) ;

			$AddFileSQL->execute(array(
			":UserFileExec" => $File['UserFile'],
			":FileNameExec" => $File['FileName'],
			":ExtensionExec" => $File['Extension'],
			":IPExec" =>  $File['IP'],
			":MD5FileExec" => $File['MD5File'],
			":SHA1FileExec" => $File['SHA1File'],
			":FileSizeExec" => $File['FileSize'],
			":OwnerExec" => $File['Owner'],
			":ServerExec" => "local",
			));
			$File['FileSize'] = $this->size_comp($File['FileSize']);
			$File['ID'] =  $this->Date['XVweb']->DataBase->lastInsertId();
			$File['Date'] = date("Y-m-d G:i:s");
			$File['Downloads']=0;
			
			$this->Date['XVweb']->Log("NewFile", ($File));
			return $File;
	}
	public function size_comp($size, $retstring = null) {
		$sizes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
		if ($retstring === null) { $retstring = '%01.2f %s'; }
		$lastsizestring = end($sizes);
		foreach ($sizes as $sizestring) {
			if ($size < 1024) { break; }
			if ($sizestring != $lastsizestring) { $size /= 1024; }
		}
		if ($sizestring == $sizes[0]) { $retstring = '%01d %s'; }
		return sprintf($retstring, $size, $sizestring);
	}


	public function FileList($Options=array()) {
		$MD5Array = md5(MD5Key.print_r($Options, true));
		if($this->Date['XVweb']->Cache->exist("FileList", $MD5Array))
		return $this->Date['XVweb']->Cache->get();
		
		
		if(!isset($Options['ActualPage']))
		$Options['ActualPage'] = 0;
		if(!isset($Options['EveryPage']))
		$Options['EveryPage'] = 30;
		$AddWhereSQL="";
		$SQLExec = array();
		if(isset($Options['Where'])){
		$AddWhereSQL = 'WHERE '.($this->Date['XVweb']->DataBase->isset_field("Files", $Options['Where']['Key'] ) ? "{Files:".$Options['Where']['Key']."}" : "{Files:ID}").' = :WhereExec';
		$SQLExec[':WhereExec'] = $Options['Where']['Value'];
		}
		
		if(isset($Options['SortBy'])){
			$SQLSort = 'ORDER BY '.($this->Date['XVweb']->DataBase->isset_field("Files", $Options['SortBy']) ? "{Files:".$Options['SortBy']."}" : "{Files:ID}").' '.(isset($Options['ASC']) && $Options['ASC']==true ? "ASC" : "DESC");
		}
		$FileCount= 0;

		$LLimit = ($Options['ActualPage']*$Options['EveryPage']);
		$RLimit = $Options['EveryPage'];
		$FileListSQL = $this->Date['XVweb']->DataBase->prepare('SELECT  SQL_CALC_FOUND_ROWS  {Files:*} FROM {Files} '.$AddWhereSQL.' '.$SQLSort.' LIMIT '.$LLimit.', '.$RLimit.';');
		$FileListSQL->execute($SQLExec);
		if(isset($Options['CountRecord'])){
		$FileCount = (int) $this->Date['XVweb']->DataBase->pquery('SELECT FOUND_ROWS() AS `Count`;')->fetch(PDO::FETCH_OBJ)->Count;
		}
		return $this->Date['XVweb']->Cache->put("FileList", $MD5Array, array($FileListSQL->fetchAll(), $FileCount));
	}
	public function DeleteFile($IDFile){
	$FileInfo = $this->GetFile($IDFile);
			if(( (!$this->Date['XVweb']->permissions('DeleteFile') && $FileInfo['UserFile'] != $this->Date['XVweb']->Session->Session('Logged_User')) or !$this->Date['XVweb']->permissions('DeleteOtherFile'))){
			$this->Date['XVweb']->LoadException();
			throw new XVwebException(1);
			return false;
		}
		$DeleteFile = $this->Date['XVweb']->DataBase->prepare('DELETE FROM {Files} WHERE {Files:ID} = :IDExec ;');
		
				$DeleteFile->execute(array(":IDExec"=>$IDFile));
				
						$DeleteFile = $this->Date['XVweb']->DataBase->prepare('UPDATE {Files} SET {Files:Owner} = 1  WHERE {Files:MD5File} = :MD5Exec AND {Files:SHA1File} = :SHA1Exec LIMIT 1 ;');
						$DeleteFile->execute(array(":MD5Exec"=>$FileInfo['MD5File'], ":SHA1Exec"=>$FileInfo['SHA1File']));
					if($DeleteFile->rowCount() < 1){
						$NameClassFile = 'XV_Files_'.$FileInfo['Server'];
						$ClassFile = new $NameClassFile;
						$ClassFile->delete($FileInfo['MD5File'].$FileInfo['SHA1File']);
					}
				$this->Date['XVweb']->Cache->clear("File", $IDFile);
				$this->Date['XVweb']->Log("DeleteFile", $IDFile);
			return true;
		}
		public function GetStructureZIP($file){
			$result = "";

		$za = new ZipArchive();
		$za->open($file);
		for ($i=0; $i<$za->numFiles;$i++) {
			$File = $za->statIndex($i);
			$result .= $File["name"]." Size: ".$this->size_comp($File["size"])."\n";
		}
		return $result;

	}
}

?>