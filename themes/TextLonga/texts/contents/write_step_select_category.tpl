<!-- Content -->
<div class="xv-text-wrapper xv-texts-select-category">
	<h2>{'txts_select_category'|xv_lang}:</h2>
	
	<div class="xv-texts-category-list">
		<a href="/">.</a>
	</div>
	
	<div class="xv-text-result">
		{'txts_selected_category'|xv_lang}: <span class="xv-text-selected-category">{$xv_texts_actual_category}</span>
	</div>
	<form class="xv-texts-category-form" action="{$URLS.Script}write/set_title/" method="post">
		<input type="hidden" name="xv-sid" value="{$JSVars.SIDUser}" />
		<input type="hidden" name="texts[category]" value="{$xv_texts_actual_category}" class="xv-texts-category-form-category"/>
		<input type="submit" value="{'txts_next'|xv_lang}" />
	</form>
</div>
		

<!-- TEXT -->

<div style="clear:both;"></div>
<script type="text/javascript" src="{$URLS.Theme}texts/js/texts.js" charset="UTF-8"> </script>
 <!-- /Content -->