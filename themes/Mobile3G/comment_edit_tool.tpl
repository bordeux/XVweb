{if !$IDComment}<hr />{/if}
<div>
	<form action="{$URLS.Script}Receiver/AddComment" method="post" class="xv-comment-form">
		<input type="hidden" name="ArticleID" value="{$ReadArticleIndexOut.ID}" />
		{if $IDComment}<input type="hidden" name="xv-edit-comment" value="{$IDComment}" />{/if}
		<div><textarea class="xv-comment-edit-tool" name="CommentContent" style="width: 100%;" placeholder="Comment...">{$EditToolContent|escape}</textarea></div>
		<div>
			<div class="xv-comment-spambot">
				{$language.RewriteKey} : <span class="xv-comment-spambot-key">{$JSVars.SIDUser|substr:0:5}</span> : <input type="text" name="xv-captcha" value="" class="xv-comment-spambot-field" />
			</div>
			<div data-role="controlgroup" data-type="horizontal">
				<input type="submit" value="{$language.AddComment}" /> 
				<input type="button" value="{$language.Preview}" /> 
			</div>
		</div>
	</form>
</div>