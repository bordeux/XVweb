<!-- Footer --></div>
<footer>
			<nav id="FooterMenu"> 
			
							{foreach from=$Menu.footer item=MainMenu}
											{foreach from=$MainMenu.links item=Submenu}
												<a  href="{$Submenu.url}">{$Submenu.title}</a> |
											{/foreach}
								{/foreach} {if $LogedUser}<a  href="#" href="{$URLS.Script}Logout/{$JSVars.SIDUser}/" class="xv-confirm-link" data-xv-question="Czy napewno chcesz się wylogować? ">{$language.LogOut}</a>{else}<a  href="#" rel="nofollow" class="xvshow" data-tohide=".xvlogin-tohide" data-toshow=".xvlogin-login">{$language.Login}</a>{/if}
</nav>
				{if $Advertisement}
					<div class="reklamo" id="RFooter">
						{$smarty.capture.ADVFooter}
					</div>
				{/if}
  </footer>
	{foreach from=$JSLoad item=JSLink}
		<script type="text/javascript" src="{$JSLink}"  charset="UTF-8"></script>
	{/foreach}

	{foreach from=$footer item=footerItem}
		{$footerItem}
	{/foreach}

</body>
</html>