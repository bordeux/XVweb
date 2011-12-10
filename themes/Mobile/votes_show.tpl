{strip}{if $smarty.get.json}
{if $Failed}
		{$JsonResult.result="false"}
		{if $Failed=="AccessDenied"}
			{$JsonResult.message=$language.AccessDenied}
		{elseif $Failed=="SIDFailed"}
			{$JsonResult.message=$language.SIDCheckFailed}
		{else}
			{$JsonResult.message=$language.Error}
		{/if}
	{else}
		{$JsonResult.result="true"}
		{$JsonResult.message=$language.VoteSucces}
{/if}
{$JsonResult.modified=$Modified}
{$JsonResult|@json_encode}
{else}{"Location: ?"|header}
<script>
location.href="?";
</script>
{/if}
{/strip}