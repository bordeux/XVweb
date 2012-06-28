{if $xvauctions_mode == "descriptions"}
{$JSLoad[26]="`$URLS.Theme`js/jqueryui.js"}

{$CCSLoad[22]="`$URLS.Theme`xvauctions/css/add_descriptions.css"}
{$JSLoad[22]="`$URLS.Theme`xvauctions/js/add_descriptions_contents.js"}
{include file="header.tpl" inline}
{include file="xvauctions/contents/add_descriptions_contents.tpl" inline}
{include file="footer.tpl" inline}
{elseif $xvauctions_mode == "preview"}
{$CCSLoad[22]="`$URLS.Theme`xvauctions/css/add_preview.css"}
{$JSLoad[22]="`$URLS.Theme`xvauctions/js/add_preview_contents.js"}
{include file="header.tpl" inline}
{include file="xvauctions/contents/add_preview_contents.tpl" inline}
{include file="footer.tpl" inline}
{else}
{$CCSLoad[22]="`$URLS.Theme`xvauctions/css/add_categories.css"}
{$JSLoad[22]="`$URLS.Theme`xvauctions/js/add_categories_contents.js"}
{include file="header.tpl" inline}
{include file="xvauctions/contents/add_categories_contents.tpl" inline}
{include file="footer.tpl" inline}
{/if}