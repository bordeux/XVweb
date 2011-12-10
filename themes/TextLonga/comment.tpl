<div class="xv-mod-comments">
	<div class="xv-mod-comments-title">Komentarze - Zadaj pytanie, oceń!</div>
	<div style="margin : 10px;" class="xv-comment-area">
		{foreach from=$Comments item=Comment}
			{include file="comment_theme.tpl" inline}
		{/foreach}
		{if "WriteComment"|perm}
			{include file='comment_edit_tool.tpl'}
		{/if}
	</div>
</div>