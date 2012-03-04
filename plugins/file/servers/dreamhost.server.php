<?php
//************************* DREAMHOST ****************/

class XV_Files_dreamhost{
	var $xvDreamHostConfig = array(
		"user"=> "bordeux",
		"pass" => "polska",
		"host" => "demonit.pl",
		"catalog" => "/bfiles/"
	);
	public function download($file){
			return "ftp://".$this->xvDreamHostConfig['user'].":".$this->xvDreamHostConfig['pass']."@".$this->xvDreamHostConfig['host'].$this->xvDreamHostConfig['catalog'].$file;
	}
	
	public function delete($file){
				$conn_id = ftp_connect($this->xvDreamHostConfig['host']);
				$login_result = ftp_login($conn_id, $this->xvDreamHostConfig['user'], $this->xvDreamHostConfig['pass']);
				if (ftp_delete($conn_id, substr($this->xvDreamHostConfig['catalog'], 1).$file)) {
					ftp_close($conn_id);
					return true;
				} else {
					ftp_close($conn_id);
					return false;
				}

	}
	public function upload($fileLoc, $file){
				$conn_id = ftp_connect($this->xvDreamHostConfig['host']);
				$login_result = ftp_login($conn_id, $this->xvDreamHostConfig['user'], $this->xvDreamHostConfig['pass']);
				if (ftp_put($conn_id, substr($this->xvDreamHostConfig['catalog'], 1).$file, $fileLoc, FTP_BINARY)) {
					ftp_close($conn_id);
					return true;
				} else {
					ftp_close($conn_id);
					return false;
				}
		}
}
//************************* /DREAMHOST ****************/
?>