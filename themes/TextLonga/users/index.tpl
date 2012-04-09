{if $users_mode == "edit"}
	{$CCSLoad[22]="`$URLS.Theme`css/users.css"}
	{include file="header.tpl" inline}
	{include file="users/edit.tpl" inline}
	{include file="footer.tpl" inline}	
{else}
	{$CCSLoad[22]="`$URLS.Theme`css/users.css"}
	{include file="header.tpl" inline}
	{include file="users/profile.tpl" inline}
	{include file="footer.tpl" inline}
{/if}
