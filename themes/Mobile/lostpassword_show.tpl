{if $Result}
	<script type="text/javascript">
	 $("#LostPIcon").attr("src", URLS.Theme+"img/success.png");
	</script>
	{$Content} 
	<br/>
	<input type="button" value="{$language.OK}" />
{else}
<div id="LostPMessage"></div>
	{literal}
	<script type="text/javascript">
	$("#LostPMessage").html($(ThemeClass.LostPasswordForm).find(".LightBulbTip").html("Zły adres email!").css("min-width", "300px").attr("class", "ErrorTip").parent());
	 $("#LostPIcon").attr("src", URLS.Theme+"img/cancel.png");
	 $("#LostPContent form").submit(function() {
		ThemeClass.LostPasswordSend();
	});
	</script>
	{/literal}
{/if}