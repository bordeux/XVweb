{if !$IDComment}<hr />{/if}
<table style="margin-top:10px;" border="0" width="100%">
	<tr>
	<td width="100%" >
		<div id="divkomentarze">
			<div id='PreView{if $IDComment}$IDComment{/if}'></div>
			<form name="CommentForm{$IDComment|default:''}" action="{$URLS.Script}Receiver/AddComment" id="CommentForm{$IDComment|default:''}" method="post">
				<input type="hidden" name="ArticleID" value="{$ReadArticleIndexOut.ID}" />
				<input type='hidden' value='{$URLS.Path|escape:"html"}' name='RedirectPath' />
				{if $IDComment}<input type="hidden" name="CommentID" value="{$IDComment}" />{/if}
				<textarea class="EditTextAreaComment" name="CommentContent" id="CommentAreaID{$IDComment|default:''}" style="width:80%;">{$EditToolContent|escape}</textarea><br/>
				<input type="submit" value="{$language.AddComment}" /> <button  onclick="PreviewComment({$IDComment|default:''})" class="StyleForm"> {$language.Preview} </button>
			</form>
		</div>
	</td>
	</tr>
</table>