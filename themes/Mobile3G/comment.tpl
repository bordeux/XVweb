<div class="xv-mod-comments">
{$smarty.capture.ADVComments}
	<div style="margin : 10px;" class="xv-comment-area">
		<ul data-role="listview"> 
			{foreach from=$Comments item=Comment}
				{include file="comment_theme.tpl" inline}
			{/foreach}
		</ul>
		{if "WriteComment"|perm}
			{include file='comment_edit_tool.tpl'}
		{/if}
	</div>
</div>