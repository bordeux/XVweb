{$CCSLoad[22]="`$URLS.Theme`css/users.css"}
{include file="header.tpl" inline}
{if $users_mode == "edit"}
	{include file="users/edit.tpl" inline}
{else}
	{include file="users/profile.tpl" inline}
{/if}
{include file="footer.tpl" inline}	
