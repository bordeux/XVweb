{if $ComementReturn}
<script type="text/javascript">
var RemoveCommentID = {$IDComment};
{literal}

$("#Comment-"+RemoveCommentID).hide("slow", function () {
     $("#Comment-"+RemoveCommentID).remove();
    }, 2000);

{/literal}
</script>
<span style="color: green; font-weight: bold; margin-left:20px;">{$language.Success}</span>
{else}
<span style="color: red; font-weight: bold; margin-left:20px;">{$language.AccessDenied}</span>
{/if}