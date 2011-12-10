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
		<div class="error">
			{if $LogedError == 1}
				<div>{$language.LogegedBadLogin}</div>
			{else}
				<div>{$language.LogegedBadPassword}</div>
			{/if}
			<div><a href="{$URLS.Site}LostPass/Get/" class="xvshow" data-tohide=".xvlogin-tohide" data-toshow=".xvlogin-reset-password">Zapomniałeś hasła?</a></div>	
		</div>
			
	{/if}
{else}
{$JSBinder[22]="SingIn"}
{include file="header.tpl"}
{include file="contents/login_contents.tpl"}
{include file="footer.tpl"}
{/if}