{$CCSLoad[22]="`$URLS.Theme`texts/css/css.css"}
{$CCSLoad[23]="`$URLS.Theme`texts/css/texts.css"}
{include file="header.tpl" inline}
{if $xv_texts_step == "select_editor"}
	{include file="texts/contents/write_step_select_editor.tpl"}
{elseif $xv_texts_step == "editor"}
	{include file="texts/contents/write_step_editor.tpl"}
{elseif $xv_texts_step == "set_title"}
	{include file="texts/contents/write_step_set_title.tpl"}
{elseif $xv_texts_step == "preview"}
	{include file="texts/contents/write_step_preview.tpl"}
{else}
	{include file="texts/contents/write_step_select_category.tpl"}
{/if}
{include file="footer.tpl" inline}	