{if $Comments}
{foreach from=$Comments item=Comment}
<div class="CommentTable" id="Comment-{$Comment.ID}">
<div class="CommentUP">
<a href='{$UrlScript}Users/{$Comment.Author}' ><img src="{$AvantsURL}{if $Comment.Avant}{$Comment.Author}{/if}_16.jpg" alt="{$Comment.Author}"/> <span>{$Comment.Author}</span></a> {$language.Day} {$Comment.Date|replace:'-':'.'} {if $Comment.ModificationDate}, {$language.Modification} {$Comment.ModificationDate|replace:'-':'.'} {/if}
{if ( "EditComment"|perm and ($Comment.Author eq $LogedUser)) or "EditCommentOther"|perm}| <a href='#' id='EditCommentLabel-{$Comment.ID}' onclick='EditComment(this,{$Comment.ID}); return false;'>{$language.Edit}</a>{/if}
{if ( "DeleteComment"|perm and ($Comment.Author eq $LogedUser)) or "DeleteCommentOther"|perm}| <a href='#' onclick='DeleteComment({$Comment.ID}); return false;'>{$language.Delete}</a>{/if}
</div>
	<div id="CommentID-{$Comment.ID}">
		{$Comment.Comment}
	</div>
</div>
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