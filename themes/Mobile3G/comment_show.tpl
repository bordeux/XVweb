{if $smarty.get.ajax}
{if $Comments}
	{foreach from=$Comments item=Comment}
		{include file="comment_theme.tpl" inline}
		<script type="text/javascript">
				location.href= "#Comment-{$Comment.ID}";
				$("#Comment-{$Comment.ID}").fadeTo(700, 0.1, function(){
					$(this).fadeTo(700, 1);
				});
		</script>
	{/foreach}
	{elseif $Exception}
		{if $ExceptionCode=="10"}
			{$AntiFlood|string_format:$language.AntiFloodProtection} ({math equation="floor(x/60)" x=$AntiFlood}min, {math equation="floor(x/60/60)" x=$AntiFlood}h)! 
		{elseif $ExceptionCode=="125"}
			{$language.AccessForLogedUser}!
		{elseif $ExceptionCode=="41"}
				{$language.ArticleBlocked}
		{else}
			{$language.AccessDenied}!
		{/if}
{/if}
{else}
{$NPath=$ArticleURL|substr:1}
{if $Comments}
{$RedirectTo = "Location: %s%s#Comment-%s"|sprintf:$URLS.Script:$NPath:$Comments[0].ID}{$RedirectTo|header}
	{elseif $Exception}
		{if $ExceptionCode=="10"}
			{$AntiFlood|string_format:$language.AntiFloodProtection} ({math equation="floor(x/60)" x=$AntiFlood}min, {math equation="floor(x/60/60)" x=$AntiFlood}h)! 
		{elseif $ExceptionCode=="125"}
		{$RedirectTo = "Location: %s%s?error=true&msg=%s"|sprintf:$URLS.Script:$NPath:$language.AccessForLogedUser}{$RedirectTo|header}
		{elseif $ExceptionCode=="41"}
		{$RedirectTo = "Location: %s%s?error=true&msg=%s"|sprintf:$URLS.Script:$NPath:$language.ArticleBlocked}{$RedirectTo|header}
			{$language.ArticleBlocked}
		{else}
			{$RedirectTo = "Location: %s%s?error=true&msg=%s"|sprintf:$URLS.Script:$NPath:$language.AccessDenied}{$RedirectTo|header}
		{/if}
{/if}

{/if}