{$CCSLoad[22]="`$URLS.Theme`users/css/css.css"}
{$CCSLoad[23]="`$URLS.Theme`texts/css/texts.css"}
{include file="header.tpl" inline}
{if $users_mode == "edit"}
	{include file="users/edit.tpl"}
{elseif $users_mode == "about"}
	{include file="users/about.tpl"}
{else}
	{include file="users/profile.tpl"}
{/if}
{include file="footer.tpl" inline}	
