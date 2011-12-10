{if $smarty.get.ajax}
<div class="xv-ajax-remove" style="display:none;">
	<script type="text/javascript">
	$(function(){
			ThemeClass.dialog.create({
						content : $('.xv-edit-form').html()
					});
					spamBotSecruity();
				$('.xv-ajax-remove').remove();
				
	});
	</script>
		<div class="xv-edit-form">
			<div style="width: 80%; padding: 30px; margin:auto; ">
				{include file="comment_edit_tool.tpl" inline}
			</div>
		</div>
</div>
{else} 
ToDO - jeœli ktoœ nie ma JS
{/if}