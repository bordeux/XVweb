<?php
header("Cache-Control: no-cache, must-revalidate");
xv_load_lang('edit');
include_once($XVwebDir.'libraries'.DIRECTORY_SEPARATOR.'phpQuery'.DIRECTORY_SEPARATOR.'phpQuery.php');

	$Smarty->assign('WriteUrlArticle', true);
		if(!(xv_perm('WriteArticle'))){ // Brak dostepu
			header("location: ".$URLS['Script'].'Page/System/Permissions/');
			exit;
			}
if(!isset($_GET['converted'])){
$FileEx = strtolower(pathinfo($_FILES['doctohtml']['name'], PATHINFO_EXTENSION));
if(!in_array($FileEx, array("doc", "docx", "rtf", "txd"))){
			header("location: ".$URLS['Script'].'System/Error/?line='.(__LINE__).'&file='.urlencode(__FILE__).'&description='.urlencode("Invalid file type"));
			exit;
}

define ('LIVEDOCXUSERNAME', 'bordeux');
define ('LIVEDOCXPASSWORD', '1qwertyuiop0');
define ('LIVEDOCXENDPOINT', 'https://api.livedocx.com/1.2/mailmerge.asmx?WSDL');


$soap = new SoapClient(LIVEDOCXENDPOINT);
 
$soap->LogIn(
    array(
        'username' => LIVEDOCXUSERNAME,
        'password' => LIVEDOCXPASSWORD
    )
);

$data = file_get_contents($_FILES['doctohtml']['tmp_name']);


$soap->SetLocalTemplate(
    array(
        'template' => base64_encode($data),
        'format'   => $FileEx
    )
);

$soap->CreateDocument();


$result = $soap->RetrieveDocument(
    array(
        'format' => 'html'
    )
);

$data = $result->RetrieveDocumentResult;
	$UniqID  = uniqid();
	file_put_contents(Cache_dir.'dth_'.$UniqID.'.tmp', base64_decode($data));
	header('Location: ?converted='.$UniqID.'&File='.urlencode(pathinfo($_FILES['doctohtml']['name'], PATHINFO_FILENAME)));

}else{
if(!file_exists(Cache_dir.'dth_'.$_GET['converted'].'.tmp')){
		header("location: ".$URLS['Script'].'System/Error/?line='.(__LINE__).'&file='.urlencode(__FILE__).'&description='.urlencode("File not uploaded"));
		exit;
	}
$XPathSimple = phpQuery::newDocument(file_get_contents(Cache_dir.'dth_'.$_GET['converted'].'.tmp'));

$FileDoned = array();
foreach($XPathSimple['img'] as $element){
	$FileID = uniqid();
	$FileLoc = $RootDir.'tmp/'.$FileID.'.png';
	$FileContent =  file_get_contents(pq($element)->attr("src"));
	$FileMD5 = md5($FileContent); 
	if(!isset($FileDoned[$FileMD5])){
		file_put_contents($FileLoc, $FileContent);
		try{
		$FileDoned[$FileMD5] = $XVwebEngine->FilesClass()->AddFile($FileLoc);
		}catch(XVwebException $e){
		
		}
	}
		pq($element)->attr("src",  "{{file:".$FileDoned[$FileMD5]['ID']."}}");
		pq($element)->attr("file",  $FileDoned[$FileMD5]['ID']);
		pq($element)->attr("replace" , "{{file:".$FileDoned[$FileMD5]['ID']."}}");
}

foreach($XPathSimple['body'] as $element){
 $Smarty->assign('ContextEdit', '<nobr all="true" /> '.pq($element)->html());
}
$_GET['url'] = "/Bez_kategorii/".trim($_GET['File']).'/';
 $Smarty->assign('UrlWrite', "/Bez_kategorii/".$_GET['File'].'/');
/**************************THEME*******************/
$Smarty->display('write_show.tpl');
}
 
?>