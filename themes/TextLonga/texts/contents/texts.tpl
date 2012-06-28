<!-- Content -->
<div class="xv-texts-info" >
	<div class="xv-texts-info-icon"></div>
	<div class="xv-text-info-links">
		<a href="{$URLS.Script}edit/?page={$xv_texts_page.URL|escape:'url'}" class="xv-text-info-links-edit">{'txts_edit'|xv_lang}</a>
		<a href="{$URLS.Script}write/?cat={$xv_texts_page.URL|escape:'url'}" class="xv-text-info-links-write">{'txts_write_new_page_here'|xv_lang}</a>
		<a href="{$URLS.Script}history{$xv_texts_page.URL}" class="xv-text-info-links-history">{'txts_history_and_authors'|xv_lang}</a>
	</div>
	
	
</div>
<div class="xv-text-wrapper xv-texts-content">
	{$xv_texts_page.Content}
</div>
{if $xv_texts_categories}
<div class="xv-text-wrapper xv-texts-categories">
	<div class="xv-texts-cat-caption"><span>{'txts_sub_pages'|xv_lang}</span></div>
	<div class="xv-texts-cat-links">
		{foreach from=$xv_texts_categories item=xv_text_category}
			<a href="{$URLS.Script}{$xv_text_category.URL|substr:1}">{$xv_text_category.Title|escape}</a>
		{/foreach}
	</div>
</div>
{/if}		

<!-- TEXT -->

<div style="clear:both;"></div>
<script type="text/javascript" src="{$URLS.Theme}texts/js/page.js" charset="UTF-8"> </script>
 <!-- /Content -->