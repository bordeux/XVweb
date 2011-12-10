{if $smarty.get.file}
taaa
{else}{$CCSLoad[22]="`$UrlTheme`css/Users.css"}
{$JSBinder[25]="Users"}
{$JSBinder[26]="ajaxfileupload"}
{include file="header.tpl" inline}
{include file="contents/user_edit.tpl" inline}
{include file="footer.tpl" inline}{/if}