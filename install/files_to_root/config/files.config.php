<?php
//************************* LOCAL *******************/

class xv_files_local{
	public function download($file){
		return dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.$file;
	}
	public function delete($file){
		return @unlink(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.$file);
	}
	public function upload($fileLoc, $file){
		return copy($fileLoc, dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.$file);
	}
}
//************************* /LOCAL *******************/

?>