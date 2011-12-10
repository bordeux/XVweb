{if !$IDComment}<hr />{/if}
<table style="margin-top:10px;" border="0" width="100%">
	<tr>
	<td width="100%" ><div id="divkomentarze">
		<div id='PreView{if $IDComment}$IDComment{/if}'></div>
		<form name="CommentForm{$IDComment|default:''}" action="?" id="CommentForm{$IDComment|default:''}" method="post">
		<input type="hidden" name="ArticleID" value="{$ReadArticleIndexOut.ID}" />
		{if $IDComment}<input type="hidden" name="CommentID" value="{$IDComment}" />{/if}
		<textarea class="EditTextAreaComment" name="CommentContent" id="CommentAreaID{$IDComment|default:''}" rows="10" cols="90%">{$EditToolContent|escape}</textarea>
		
		<input type="hidden" name="xv-captcha" value="{$JSVars.SIDUser|substr:0:5}" class="xv-comment-spambot-field" />
			
		</form>
<button  onclick="SendComment({$IDComment})" class="StyleForm"> {$language.AddComment} </button> <button  onclick="PreviewComment({$IDComment|default:''})" class="StyleForm"> {$language.Preview} </button> </div></td>
	</tr>
</table>