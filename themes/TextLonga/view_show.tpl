{$JSBinder[19]='jquery.lazyload.mini'}
{$JSBinder[22]='article'}
{$CCSLoad[22]="`$URLS.Theme`css/article.css"}
{$JSLoad[15]="http://apis.google.com/js/plusone.js"}
{include file="header.tpl" inline}
{if $NotFoundArticle}
	{include file="contents/NotFoundArticle_contents.tpl"}
{else}
	{if "ViewArticle"|perm}
	{include file="contents/article_contents.tpl" inline}
	{else}
		{include file="contents/not_access.tpl"}
	{/if}
{/if}
{include file="footer.tpl" inline}