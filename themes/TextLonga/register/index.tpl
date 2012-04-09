{if  $smarty.get.ajax}
	{include file="register/register_ajax.tpl" inline}
{else}
	{$CCSLoad[22]="`$URLS.Theme`register/css/register.css"}
	{include file="header.tpl" inline}
	{include file="register/register.tpl" inline}
	{include file="footer.tpl" inline}
{/if}