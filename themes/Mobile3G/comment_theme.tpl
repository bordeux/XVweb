<li id="Comment-{$Comment.ID}" >
<div class="ui-li ui-li-divider ui-btn ui-bar-b ">
	<a href='{$URLS.Script}Users/{$Comment.Author}' data-role="button" data-inline="true" style="margin:0;">{$Comment.Author}</a> {$language.Day} {$Comment.Date|replace:'-':'.'} {if $Comment.ModificationDate}, {$language.Modification} {$Comment.ModificationDate|replace:'-':'.'} {/if}
		<div data-role="controlgroup" data-type="horizontal" style="float:right; margin-top: 0px;">
				{if ( "EditComment"|perm and ($Comment.Author eq $LogedUser)) or "EditCommentOther"|perm} <a href='#' class="xv-edit-comment" data-xv-comment-id="{$Comment.ID}" data-role="button" data-icon="gear" data-iconpos="notext">{$language.Edit}</a>{/if}
				{if ( "DeleteComment"|perm and ($Comment.Author eq $LogedUser)) or "DeleteCommentOther"|perm} <a href='{$URLS.Script}Receiver/DC?CommentID={$Comment.ID}&amp;SIDCheck={$JSVars.SIDUser}' class='xv-delete-comment' data-xv-comment-id="{$Comment.ID}"  data-role="button" data-icon="delete" data-iconpos="notext">{$language.Delete}</a>{/if}
		</div>
</div>
<div style="padding-left: 10px; padding-top: 10px;">{$Comment.Comment}</div>
</li>
