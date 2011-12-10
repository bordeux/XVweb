{if $smarty.get.ajax}
	{if $result}
		<script type="text/javascript">
			var RemoveCommentID = {$IDComment};
			{literal}

				$("#Comment-"+RemoveCommentID).hide("slow", function () {
					 $("#Comment-"+RemoveCommentID).remove();
					}, 4000);

			{/literal}
		</script>
		<div class="success"><span style="font-weight: bold;">{$language.Success}</span></div>
	{else}
		<div class="failed"><span style="font-weight: bold;">{$language.AccessDenied}</span></div>
	{/if}
{else}
todo
{/if}