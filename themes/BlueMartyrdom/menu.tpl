<!--MENU -->
<div id="Menu">

							{foreach from=$Menu.main item=MainMenu}
									<h1>{$MainMenu.title}</h1>
											{foreach from=$MainMenu.links item=Submenu}
												<a class="linkmenu" href="{$Submenu.url}">{$Submenu.title}</a>
											{/foreach}
								{/foreach}
</div>
<!--END-MENU-->