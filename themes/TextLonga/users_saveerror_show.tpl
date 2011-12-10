<script type="text/javascript" charset="UTF-8">
EditProfile.ViewProfile = function(x){literal}{{/literal}  
	location.reload();
	{literal}}{/literal} 
GetAjax(document.location+'/edit/', 'UserTable', function(){literal}{{/literal}  
	$("#UserTable").prepend("<div class='ErrorTip' id='ErrorMessage' style=' margin-left:15%; margin-right:30%;'></div><br/>");
	{foreach from=$ErrorSave item=ErrorLine}
	$("#ErrorMessage").append("{$ErrorLine}");
	{/foreach}

	{literal}}{/literal} 
);
</script>
