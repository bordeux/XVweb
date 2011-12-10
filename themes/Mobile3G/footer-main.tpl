<!-- Footer -->	
	<div data-role="footer" style="text-align:center;"> 
						<div data-role="controlgroup" data-type="horizontal">
								{foreach from=$Menu.footer item=MainMenu}
											{foreach from=$MainMenu.links item=Submenu}
												<a  href="{$Submenu.url}" data-role="button">{$Submenu.title}</a> 
											{/foreach}
								{/foreach}
						</div>
						<div data-role="controlgroup" data-type="horizontal">
								<a href="?mobile=false" data-role="button" rel="external">{$language.FullVersion}</a>
								<a href="?mobile=true" data-role="button" rel="external">Easy mobile Version</a>
								<a href="{$URLS.Site}Search/" data-role="button" data-icon="search">{$language.Search}</a>
						</div>
						
						{$smarty.capture.ADVFooter}
						
	</div><!-- /footer --> 