<div id="fp_comment">
	<div class="cssprite CommentIMG">&nbsp;</div>
	<div style="margin : 10px;" id="fp_comment_two">
		{foreach from=$Comments item=Comment}
		<div class="CommentTable" id="Comment-{$Comment.ID}">
			<div class="CommentUP">
			<div class="CInfo">
			<a href='{$UrlScript}Users/{$Comment.Author}' ><img src="{$AvantsURL}{if $Comment.Avant}{$Comment.Author}{/if}_16.jpg" alt="{$Comment.Author}"/> <span>{$Comment.Author}</span></a> {$language.Day} {$Comment.Date|replace:'-':'.'} {if $Comment.ModificationDate}, {$language.Modification} {$Comment.ModificationDate|replace:'-':'.'} {/if}
			{if ("EditComment"|perm and ($Comment.Author == $Session.Logged_User)) or "EditCommentOther"|perm}| <a href='#' id='EditCommentLabel-{$Comment.ID}' onclick='EditComment(this,{$Comment.ID}); return false;'>{$language.Edit}</a>{/if}
			{if ( "DeleteComment"|perm and ($Comment.Author == $Session.Logged_User)) or "DeleteCommentOther"|parm}| <a href='#' onclick='DeleteComment({$Comment.ID}); return false;'>{$language.Delete}</a>{/if}</div>
			<div class="CVote"><span class="Votes">{if $Comment.Votes > 0}+{/if}{$Comment.Votes}</span> {if "Voting"|perm && $Comment.Author != $Session.Logged_User}<a href="?vote=1&amp;t=comment&amp;id={$Comment.ID}&amp;SIDCheck={$JSVars.SIDUser}" class="vote voteup"><img src="{$UrlTheme}img/blank.png" alt="Vote UP" /></a> <a href="?vote=0&amp;t=comment&amp;id={$Comment.ID}&amp;SIDCheck={$JSVars.SIDUser}" class="vote votedown"><img src="{$UrlTheme}img/blank.png" alt="Vote Down" /></a>{/if} </div>
			</div>
			<div id="CommentID-{$Comment.ID}">
			{$Comment.Parsed}
			</div>
		</div>
		{/foreach}
		{if "WriteComment"|perm}
			{include file='comment_edit_tool.tpl'}
		{/if}
	</div>
</div> 