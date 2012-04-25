{if  $smarty.get.ajax}
	{include file="login/login_ajax.tpl" inline}
{else}
	{$CCSLoad[22]="`$URLS.Theme`login/css/login.css"}
	{include file="header.tpl" inline}
	{include file="login/login.tpl" inline}
	{include file="footer.tpl" inline}
{/if}