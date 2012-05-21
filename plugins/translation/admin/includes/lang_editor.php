<?php
global $URLS;
$lang_array = array();
foreach($XVwebEngine->DataBase->pquery('SELECT {Translation:*}  FROM {Translation} WHERE {Translation:Lang} = '.$XVwebEngine->DataBase->quote($_GET['lang']).';')->fetchAll(PDO::FETCH_ASSOC) as $lang_sql){
	$lang_array[$lang_sql['Key']] = $lang_sql['Val'];
}
$Language = array();
include(ROOT_DIR."languages/pl/".$_GET['file']);

if(isset($_GET['generate'])){
header('Content-Type: text/plain; charset=utf-8');
echo "<?php \n";
echo '$Language = array_merge((isset($Language) ? $Language : array() ), array ( '."\n";
foreach($Language as $key=>$val){
	echo "  '{$key}' => ".$XVwebEngine->DataBase->quote(ifsetor($lang_array[$key], $val)).", \n";
}
echo ")); \n";
echo "?>";
exit;
}
?><style>
	.xv-translations-lang-items {
		overflow-y: scroll;
		max-height: 590px;
	}
	.xv-translations-hide {
		display:none;
	}
	.xv-translations-lang-items textarea{
		min-width: 500px;
	}
</style>
<div class="xv-translations-lang-items">
<a href="#" class="xv-translation-show">Show all keys</a>
<?php

foreach($Language as $key=>$val){
$content_textarea = ifsetor($lang_array[$key], '');
$uniq_id = uniqid();
?>
<form action="<?=$URLS['Script']?>Administration/get/Translation/Save/" method="post" class="xv-form" id="<?=$uniq_id?>" data-xv-result="#<?=$uniq_id?>">
<fieldset class="<?php echo empty($content_textarea) ? '':'xv-translations-hide'; ?>">
	<legend><?=$key?></legend>
	<input type="hidden" name="key" value="<?=$key?>" />
	<input type="hidden" name="lang" value="<?=$_GET['lang']?>" />
	<input type="hidden" value="<?=$XVwebEngine->Session->get_sid()?>" name="xv-sid" />
	<table>
		<tr>
			<td style="width: 400px;"><?php echo htmlspecialchars($val);?></td>
			<td><textarea name="val"><?php echo htmlspecialchars($content_textarea); ?></textarea></td>
			<td style="padding-left: 40px;"><input type="submit" value="Save" /></td>
		</td>
	</table>
</fieldset>
</form>
<?php
}
?>
<a href="<?=$URLS['Script']?>Administration/get/Translation/?lang=<?=$_GET['lang']?>&amp;file=<?=$_GET['file']?>&amp;generate=true" target="_blank"><input type="submit" value="Generate php file" /></a>
</div>

<script>
$(".xv-translation-show").click(function(){
	$(".xv-translations-hide").show('slow');
});
</script>