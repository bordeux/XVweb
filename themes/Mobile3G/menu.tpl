<!-- Start of second page: #xv-menu-id --> 
<div data-role="page" id="xv-menu-id" data-theme="a"> 
	<div data-role="header"> 
	<a href="#xv-main-page-id" data-direction="reverse"  data-icon="back" data-iconpos="notext" data-transition="flip" data-theme="b">Back</a>
		<h1>Menu</h1> 
	</div><!-- /header --> 
 
	<div data-role="content" data-theme="a">
	
		<div data-role="collapsible-set">
							{foreach from=$Menu.main item=MainMenu}
									<div data-role="collapsible" data-collapsed="true">
										<h3>{$MainMenu.title}</h3>
											<ul data-role="listview" data-theme="g">
													{if $MainMenu.url}<li><a href="{$MainMenu.url}">{$MainMenu.title}</a></li>{/if}
												{foreach from=$MainMenu.links item=Submenu}
													<li><a href="{$Submenu.url}">{$Submenu.title}</a></li>
												{/foreach}
											</ul>
									</div>
								{/foreach}
			</div>	
		<p style="margin-top: 80px;"><a href="#xv-main-page-id" data-direction="reverse" data-role="button" data-theme="b" data-transition="flip">Back</a></p>	
		
	</div><!-- /content --> 
	

</div><!-- /page xv-menu-id --> 