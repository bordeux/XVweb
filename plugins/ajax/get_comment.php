<?php
class XV_Ajax_get_comment {
	var $Date;
	public function __construct(&$Xvweb) {
		$this->Date['XVweb'] = $Xvweb;
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function run(){
	global $XVwebEngine;
		$CommentResult = $XVwebEngine->CommentRead((int) $_GET['id']);
		header ("content-type: text/javascript; charset: UTF-8");   
		exit(
			json_encode(
				array(
					'Result' => $CommentResult ,
					'ID'	=> $XVwebEngine->CommentRead['ID'],
					'Author'	=> $XVwebEngine->CommentRead['Author'],
					'Comment'	=> $XVwebEngine->CommentRead['Date'],
					'Comment'	=> $XVwebEngine->CommentRead['Comment'],
					'Parsed'	=> $XVwebEngine->CommentRead['Parsed'],
				)
			)
		);
	}
}
?>