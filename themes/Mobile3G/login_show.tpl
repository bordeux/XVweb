{if $action == "signin"}
	{if $LogedReturn}
		<div class="success"><h2>{$LogedUser|string_format:$language.LogegedSuccessGreeting}</h2> {$language.LogegedSuccessContent}</div>
		<script type="text/javascript">
		$(".xvlogin-login form").fadeTo('slow', 0.0, function(){
			$(this).remove();
		});
		setTimeout("location.reload();",1300 );
		</script>
	{else}
			{if $LogedError == 1}
				<div class="error">{$language.LogegedBadLogin}</div>
			{else}
				<div class="error">{$language.LogegedBadPassword}</div>
			{/if}
	{/if}
{else}
{$JSBinder[22]="SingIn"}
{include file="header.tpl"}
{include file="menu.tpl"}
{include file="contents/login_contents.tpl"}
{include file="footer.tpl"}
{/if}