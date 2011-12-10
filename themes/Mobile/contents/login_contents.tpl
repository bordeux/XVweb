<!-- Content -->
<div id="Content">
	<div id="Title">
	{$SiteTopic}
	</div>
	<div id="ContentDiv">
		<div id="TextDiv">
			<!-- TEXT -->
{if $action == "signin"}
<div style="text-align:center;">
	{if $LogedReturn}
	<span style='color:#2CCC04; font-weight:bold;'>{$LogedUser|string_format:$language.LogegedSuccessGreeting}</span><br/>
	{$language.LogegedSuccessContent}<br/>
	<a href='{$URLS.Script}{$smarty.post.RedirectPath|substr:1}'>{$language.Continue}</a>
	{else}
			{if $LogedError == 1}
			<span style='color:#FF0000; font-weight:bold;'>{$language.LogegedBadLogin}</span>
			{else}
			<span style='color:#FF0000; font-weight:bold;'>{$language.LogegedBadPassword}</span>
			{/if}
	{/if}
</div>
{/if}
{if !$Session.Logged_Logged}
					<form method='post' action="{$UrlScript}Login/SignIn/">
						<div class="tablediv">
							<div class="rowdiv">
								<div  class="celldiv"><label for='textinput'>{$language.Nick}</label> :</div>
								<div  class="celldiv"><input type='text' class='StyleForm' name='LoginLogin' id='LoginLogin' /></div>
							</div>
							<div class="rowdiv">
								<div  class="celldiv"><label for='passwordinput'>{$language.Password}</label> :</div>
								<div  class="celldiv"><input type='password' class='StyleForm' type='text' name='LoginPassword' id='LoginPassword' /></div>
							</div>
							<div class="rowdiv">
								<div  class="celldiv">
									<input type='checkbox' value='true' name='LoginRemember' id='LoginRememberID' />
									<input type='hidden' value='{$smarty.get.Path|escape:"html"}' name='RedirectPath' />
								</div>
								<div  class="celldiv"><label for="LoginRememberID">{$language.RememberPassword} </label>  <input type='submit' name='ButtonOk' value='{$language.Send}'  /></div>
							</div>
						</div>
					</form>
{/if}
					
			<!-- TEXT -->
			<div style="clear:both;"></div>
		</div>
	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->