<!--MENU -->
<div id="Menu">
	<li>
	
									{foreach from=$Menu.main item=MainMenu}
									 <ul>
										<a href="#" class="CatMenu">{$MainMenu.title}</a>
										<div class="SubMenu">
				<ul>
											{foreach from=$MainMenu.links item=Submenu}
												&gt; <li><a href="{$Submenu.url}">{$Submenu.title}</a></li>
											{/foreach}
													</ul>
										</div>
									</ul>
								{/foreach}
								
	</li>
	
</div>
<!--END-MENU-->