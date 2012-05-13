<?php
global $URLS;
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
<legend>Select file to translate</legend>
<div class="xv-translation-item">
<?php
foreach (glob(ROOT_DIR."languages/pl/*.php") as $filename) {
?>
<a href="<?=$URLS['Script'] ?>Administration/get/Translation/?lang=<?=$_GET['lang']?>&amp;file=<?=basename($filename)?>"><?=basename($filename)?></a>
 <?php 
}
?>
</div>
</fieldset>

<script>
	$(function(){
		$('.xv-translation-item a').click(function(){
				$("#xv-translation-main .content").load($(this).attr('href'));
			return false;
		});
	});
</script>