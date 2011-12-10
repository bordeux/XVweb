{if $smarty.get.ajax}
	{if $ComementReturn}
		<script type="text/javascript">
			$("#Comment-{$IDComment}").hide("slow", function(){
				$(this).remove();
			});
		</script>
		<div class="success">{$language.Success}</div>
	{else}
		<div class="failed">{$language.AccessDenied}</div>
	{/if}
{else}
toDo - jak ktos nie ma js
{/if}