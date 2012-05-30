<!--MENU -->
			<div class="xvWrapper">
				<nav>
					<ul>
								{foreach from=$Menu.main item=MainMenu}
									<li><a href="{$MainMenu.url}"><span><span>{$MainMenu.title}</span></span></a>
										<ul>
											{foreach from=$MainMenu.links item=Submenu}
												<li><a class="linkmenu" href="{$Submenu.url}">{$Submenu.title}</a></li>
											{/foreach}
										</ul>
									</li>
								{/foreach}
					</ul>
					<!--
					<div class="xvAddText">
							<a href="{$URLS.Script}Write/">Dodaj tekst!</a>
					</div>
					-->
				</nav>
				
				{if $Advertisement}
					<div class="reklamo" id="RTop">
						{$smarty.capture.ADVHeight}
					</div>
				{/if}

			</div>
<!--END-MENU-->