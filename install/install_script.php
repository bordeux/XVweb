<?php
class xv_instalator {
	var $file_status = 'status.txt';
	var $seperator = "\n---------------------------------------\n";
	public function log($string){
		return file_put_contents($this->file_status, $string.$this->seperator.file_get_contents($this->file_status));
	}
	public function clear_status(){
		return file_put_contents($this->file_status, '');
	}
	public function start(){
		$this->clear_status();
		$this->log('----------------START------------------');
	}
	public function end(){
		$this->log('-----------------END------------------');
		exit;
	}
}
function error_handler($errno, $errstr, $errfile, $errline){
	global $instalator_class;
		$instalator_class->log("Error: ".$errstr. ' File:'.$errfile.' Line: '.$errline);
    return true;
}
function shutdown_handler(){
	global $instalator_class;
	$instalator_class->end();
	return true;
}
set_error_handler("error_handler");
register_shutdown_function('shutdown_handler');

$instalator_class = new xv_instalator();

$instalator_class->start();
if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){ 
			$instalator_class->log("Invalid email adress: ".$_POST['mail']);
			$instalator_class->end();
}
	$required_ext = array(
			"tidy",
			"pdo",
			"dom",
			"pdo_mysql",
			"json",
			"libxml",
			"iconv",
			"date",
			"mcrypt",
			"zip"
		);
		
	foreach($required_ext as $ext){
		if(!extension_loaded($ext)){
			$instalator_class->log("You need enable ".$ext.' module');
			$instalator_class->end();
		}
	}
	
$instalator_class->log("Trying to login into MySQL server");
try {
	$dbh = new PDO('mysql:host='.$_POST['db_server'].';dbname='.$_POST['db_name'], $_POST['db_user'], $_POST['db_password']);
} catch (PDOException $e) {
	$instalator_class->log("I cant connect to MySQL server. Error message: ".($e->getMessage()));
	$instalator_class->end();
}
$instalator_class->log("Connected to MySQL server");

$instalator_class->log("Start import db file");
$db_file_content = file_get_contents(dirname(__FILE__).'/db/db.sql');
$db_file_content = str_replace(array('`xv_', "xvwebcms@bordeux.net") ,array('`'.$_POST['db_prefix'], $_POST['mail']), $db_file_content);

try {
	$dbh->exec($db_file_content);
	unset($db_file_content);
} catch (PDOException $e) {
	$instalator_class->log("I cant import db file. Error message: ".($e->getMessage()));
	$instalator_class->end();
}
$instalator_class->log("DB file imported!");
$instalator_class->log("Start moving config files to root dir");

foreach(glob(dirname(__FILE__).'/files_to_root/*') as $filename){
	@rename($filename, dirname(__FILE__).'/../'.basename($filename));
}

$instalator_class->log("End moving config files");

$instalator_class->log("Start edit config file");
$db_config = json_decode(file_get_contents(dirname(__FILE__).'/../config/db_config.config'));
$db_config->db_prefix = $_POST['db_prefix'];
$db_config->db_name = $_POST['db_name'];
$db_config->db_user = $_POST['db_user'];
$db_config->db_password = $_POST['db_password'];
$db_config->db_host = $_POST['db_server'];
file_put_contents(dirname(__FILE__).'/../config/db_config.config', json_encode($db_config));
$instalator_class->log("End edit config file");


$instalator_class->log("Installing done! Now you can restore your admin password with http://yourdomain.com/Forgot/. 
User: admin
Pass: admin
Email: ".$_POST['mail']);
$instalator_class->log("Thank you!");