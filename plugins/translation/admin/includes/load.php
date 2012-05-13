<?php
global $URLS, $XVwebEngine;
?><style>
	.xv-translation-item a {
		display: block;
		float:left;
		border: 1px solid #737373;
		background: #949494;
		padding: 5px;
		border-radius: 10px;
		color : #E0E0E0;
		font-weight: bold;
		font-size: 15px;
		text-decoration: none;
		padding-left: 20px;
		padding-right: 20px;
		margin: 10px;
	}
</style>
<fieldset>
<legend>Select language</legend>
<div class="xv-translation-item">
<?php foreach($XVwebEngine->DataBase->pquery('SELECT {Translation:Lang} as lang FROM {Translation} GROUP BY {Translation:Lang};')->fetchAll(PDO::FETCH_ASSOC) as $item){
?>
	<a href="<?=$URLS['Script'] ?>Administration/get/Translation/?lang=<?=$item['lang']?>"><?=$item['lang']?></a>
<?php
}
?>
</div>
</fieldset>

<legend>Add new language</legend>
<form method="get" class="xv-form" action="<?=$URLS['Script'] ?>Administration/get/Translation/" data-xv-result=".content" >
Short lang name (like en,pl) : <input type="text" maxlength="2" value='' name='lang' /> <input type="submit" value="Next" />
</form>
</fieldset>
<script>
	$(function(){
		$('.xv-translation-item a').click(function(){
				$("#xv-translation-main .content").load($(this).attr('href'));
			return false;
		});
	});
</script>