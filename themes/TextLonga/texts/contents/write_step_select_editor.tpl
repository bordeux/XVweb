<!-- Content -->
<div class="xv-text-wrapper xv-texts-select-editor">
	<h2>{'txts_select_editor'|xv_lang}: </h2>
	
	<div class="xv-texts-editors-list">
		{foreach from=$xv_texts_buttons item=xv_texts_button}
			<a href="{$URLS.Script}write/editor/{$xv_texts_button.class}/" title="{$xv_texts_button.name|escape}"><div>{$xv_texts_button.html}</div></a>
		{/foreach}
	</div>

</div>
		

<!-- TEXT -->

<div style="clear:both;"></div>
<script type="text/javascript" src="{$URLS.Theme}texts/js/texts.js" charset="UTF-8"> </script>
 <!-- /Content -->