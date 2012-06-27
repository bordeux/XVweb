{$CCSLoad[22]="`$URLS.Theme`texts/css/css.css"}
{$CCSLoad[23]="`$URLS.Theme`texts/css/texts.css"}
{include file="header.tpl" inline}
{if $xv_texts_step == "select_editor"}
	{include file="texts/contents/edit_step_select_editor.tpl"}
{elseif $xv_texts_step == "editor"}
	{include file="texts/contents/edit_step_editor.tpl"}
{elseif $xv_texts_step == "preview"}
	{include file="texts/contents/edit_step_preview.tpl"}
{elseif $xv_texts_step == "select_version"}
	{include file="texts/contents/edit_step_select_version.tpl"}
{elseif $xv_texts_step == "set_changes"}
	{include file="texts/contents/edit_step_set_changes.tpl"}
{else}
	{include file="texts/contents/edit_step_select_page.tpl"}
{/if}
{include file="footer.tpl" inline}	