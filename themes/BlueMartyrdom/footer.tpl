<!-- Footer --></div>
<div id="Footer">
<div id="PageInfo">Copyright by <a href="mailto:&#x61;dm&#x69;&#x6E;&#64;&#x62;&#x6F;rd&#101;ux&#x2E;&#x6E;&#101;&#116;"><span style="color: #ffffff;">
			Bordeux</span> </a>  Design <br />
			Chorzów 2006-2010. <br />
			<span><a href="http://www.gnu.org/">GNU</a></span> <br />
			Zapytań SQL : {*echo $GLOBALS['CounterSQL']*}
			Czas generowania strony : {*echo round(microtime()-$LoadingPageTime, 6);*}
			{$SiteFooter}
			</div>
			<div id="FooterMenu"> 
							{foreach from=$Menu.footer item=MainMenu}
											{foreach from=$MainMenu.links item=Submenu}
												<a  href="{$Submenu.url}">{$Submenu.title}</a> |
											{/foreach}
								{/foreach}{if $LogedUser}<a  href="#" onclick='LogOut(); return false;' >{$language.LogOut}</a>{else}<a  href="#" onclick='AjaxLoged(); return false;' >{$language.Login}</a>{/if}
</div>
				{if $Advertisement}
					<div class="reklamo" id="RFooter">
						{$smarty.capture.ADVFooter}
					</div>
				{/if}
  </div>
</div>

	{foreach from=$JSLoad item=JSLink}
		<script type="text/javascript" src="{$JSLink}"  charset="UTF-8"></script>
	{/foreach}
	{foreach from=$footer item=footerItem}
		{$footerItem}
	{/foreach}
</body>
</html>