{$JSBinder[22]='article'}
{$CCSLoad[22]="`$UrlTheme`css/article.css"}
{include file="header.tpl" inline}
{include file="menu.tpl" inline}
{if $NotFoundArticle}
	{include file="contents/NotFoundArticle_contents.tpl"}
{else}
	{include file="contents/article_contents.tpl"}
{/if}
{include file="footer.tpl" inline}