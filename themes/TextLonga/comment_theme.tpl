		<div class="xv-comment" id="Comment-{$Comment.ID}" data-comment-id="{$Comment.ID}"  data-comment-author="{$Comment.Author}">
			<div class="xv-comment-up">
				<a href='{$URLS.Script}Users/{$Comment.Author}' ><img src="{$AvantsURL}{if $Comment.Avant}{$Comment.Author}{/if}_16.jpg" alt="{$Comment.Author}"/> <span>{$Comment.Author}</span></a> {$language.Day} {$Comment.Date|replace:'-':'.'} {if $Comment.ModificationDate}, {$language.Modification} {$Comment.ModificationDate|replace:'-':'.'} {/if}
				{if ("EditComment"|perm and ($Comment.Author eq $LogedUser)) or "EditCommentOther"|perm}| <a href='#' class="xv-edit-comment" data-xv-comment-id="{$Comment.ID}">{$language.Edit}</a>{/if}
				{if ("DeleteComment"|perm and ($Comment.Author eq $LogedUser)) or "DeleteCommentOther"|perm}| <a href='{$URLS.Script}Receiver/DC?CommentID={$Comment.ID}&amp;SIDCheck={$JSVars.SIDUser}' class='xv-delete-comment' data-xv-comment-id="{$Comment.ID}">{$language.Delete}</a>{/if}
			</div>
			<div id="CommentID-{$Comment.ID}">
				{$Comment.Comment}
			</div>
		</div>