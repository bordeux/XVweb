<?php
set_time_limit(0);
function getGoogleTranslate($Text, $Lp="en", $Ln="pl") {
	$url = "http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=".urlencode($Text)."&langpair=".urlencode($Ln)."%7C".urlencode($Lp);
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HTTPGET, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$curl_result = curl_exec($curl);
	curl_close($curl);
	$json = json_decode($curl_result, true);
return $json['responseData']['translatedText'];
}

if(isset($_POST['sl'])){
include("pl/pl.php");
$File = "<?php
";
foreach ($Language as $key => $value){
if(is_array($value)){

foreach ($value as $key2 => $value2){
$File .= "\$Language['".$key."']['".$key2."'] = \"".getGoogleTranslate($value2, $_POST['sl'])."\";
";
}

}else{
$File .= "\$Language['".$key."'] = \"".getGoogleTranslate($value, $_POST['sl'])."\";
";
}
}
$File .= "
global \$l;
\$LPDF = Array();
\$LPDF['a_meta_charset'] = 'UTF-8';
\$LPDF['a_meta_dir'] = 'ltr';
\$LPDF['a_meta_language'] = '".$_POST['sl']."';
\$LPDF['w_page'] = '".getGoogleTranslate($LPDF['w_page'])."';

";
$File .= "?>";
@mkdir($_POST['sl']);
file_put_contents($_POST['sl'].'/'.$_POST['sl'].'.php', $File);
echo "Wykonano! <a href='?'>Nastepne</a>";
exit;
}
?>
<form action="?" method="post">
<select name=sl id=old_sl tabindex=0><option SELECTED value="en">angielski</option><option  value="ar">arabski</option><option  value="bg">bułgarski</option><option  value="zh-CN">chińsku</option><option  value="hr">chorwacki</option><option  value="cs">czeski</option><option  value="da">duński</option><option  value="tl">filipiński</option><option  value="fi">fiński</option><option  value="fr">francuski</option><option  value="el">grecki</option><option  value="iw">hebrajski</option><option  value="hi">hindi</option><option  value="es">hiszpański</option><option  value="nl">holenderski</option><option  value="id">indonezyjski</option><option  value="ja">japoński</option><option  value="ca">kataloński</option><option  value="ko">koreański</option><option  value="lt">litewski</option><option  value="lv">łotewski</option><option  value="de">niemiecki</option><option  value="no">norweski</option><option  value="pl">polski</option><option  value="pt">portugalski</option><option  value="ru">rosyjski</option><option  value="ro">rumuński</option><option  value="sr">serbski</option><option  value="sk">słowacki</option><option  value="sl">słoweński</option><option  value="sv">szwedzki</option><option  value="uk">ukraiński</option><option  value="vi">wietnamski</option><option  value="it">włoski</option></select>
	<input type="submit" value="Generuj!">
 </form>

