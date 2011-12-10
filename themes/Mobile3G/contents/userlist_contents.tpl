<div data-role="page" id="xv-main-page-id" data-theme="c">
	<div data-role="header"> 
	<a href="#xv-menu-id" data-role="button" data-theme="b" data-transition="flip">Menu</a>
		<h1>{$SiteTopic}</h1> 
	<a href="{$URLS.Script}" data-icon="home" data-iconpos="notext" data-direction="reverse" data-theme="b" data-transition="slidedown">Home</a>
	</div><!-- /header -->
	<!--CONTENT -->
	{$Pager.0}
		<ul data-role="listview"> 
			{foreach from=$UserList item=UserArray}
				<li>
					<a href="{$URLS.Script}Users/{$UserArray.User|urlrepair}"> 
						<img src="{$AvantsURL}{if $UserArray.Avant}{$UserArray.User}{/if}_150.jpg" /> 
						<h3>{$UserArray.User}</h3> 
						<p>{$language.CreatedDateAccount} : {$UserArray.Creation} {if $UserArray.GaduGadu} | {$language.GaduGadu} : {$UserArray.GaduGadu} {/if} {if $UserArray.WhereFrom} | {$language.WhereFrom} : {$UserArray.WhereFrom}{/if}</p> 
					</a>
				</li>
			{/foreach}
		</ul>
		
	{$Pager.1}
	<div style="clear:both"></div>
	
	<!--/CONTENT -->
{include  file='footer-main.tpl' inline}
</div><!-- /page xv-main-id -->