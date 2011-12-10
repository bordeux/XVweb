<div data-role="page" id="xv-main-page-id" data-theme="c">
	<div data-role="header"> 
	<a href="#xv-menu-id" data-role="button" data-theme="b" data-transition="flip">Menu</a>
		<h1>{$SiteTopic}</h1> 
	<a href="{$URLS.Script}" data-icon="home" data-iconpos="notext" data-direction="reverse" data-theme="b" data-transition="slidedown">Home</a>
	</div><!-- /header -->
	<!--CONTENT -->
	<ul data-role="listview"> 
		<li data-role="list-divider">{$language.Nick}</li> 
		<li> {if $User.OpenID}<img src="{$UrlTheme}img/icon_openid.gif" />{/if} <span id="NickUser">{$User.Nick}</span></li>
	{if $User.Name}
		<li data-role="list-divider">{$language.Name}</li> 
		<li>{$User.Name}</li>
	{/if}
	
	{if $User.VorName}
      <li data-role="list-divider">{$language.VorName}</>
      <li>{$User.VorName}</li>
	{/if}

      <li data-role="list-divider">{$language.UserID}</li>
      <li>{$User.ID}</li>
	  
	{if $User.WhereFrom}
      <li data-role="list-divider">{$language.WhereFrom}</li>
      <li colspan="2">{$User.WhereFrom}</li>
	{/if}
	
	{if $User.Page}
      <li data-role="list-divider">{$language.Page}</li>
      <li><a href="{$User.Page}" target="_blank" >{$User.Page}</a></li>
	{/if}
	{if $User.GG}
		  <li data-role="list-divider">{$language.GaduGadu}</li>
		  <li><a href="gg:{$User.GG}">{$User.GG}</a></li>
	{/if}
	
{if $User.Skype}
      <li  data-role="list-divider">{$language.Skype}</li>
      <li><a href="skype:{$User.Skype}?chat">{$User.Skype}</a></li>
{/if}

{if $User.Tlen}
      <li  data-role="list-divider">{$language.Tlen}</li>
      <li> <a href="http://ludzie.tlen.pl/{$User.Tlen}/" target="_blank">{$User.Tlen}</a></li>
{/if}

{if $User.ICQ}
      <li  data-role="list-divider">{$language.ICQ}</li>
      <li>{$User.ICQ}</li>
{/if}
{if $User.Language}
      <li  data-role="list-divider">{$language.Languages}</li>
      <li>{$User.Language}</li>
{/if}
	</ul>	
	<div data-role="collapsible-set">
			<div data-role="collapsible" data-collapsed="true">
				<h3>{$language.Statistics}</h3>
					<ul data-role="listview"> 
					
					  <li data-role="list-divider">{$language.ModificationCount}</li>
					  <li>{$UserStats.ModCount}</li>
	
					  <li data-role="list-divider">{$language.VisitedCount}</li>
					  <li>{$User.Views}</li>
					
					
					  <li data-role="list-divider">{$language.RegistrationDate} </li>
					  <li>{$User.Creation}</li>
					
					
					  <li data-role="list-divider">{$language.VisitsPerDay}</li>
					  <li>{if $UserStats.CretoionDay == 0}{$User.LoginCount}{else}{math equation="x/y" x=$User.LoginCount y=$UserStats.CretoionDay format="%.2f"}{/if}</li>
					  
					 
					  <li data-role="list-divider">{$language.ProfileViews}</li>
					  <li>{$User.Views}</li>
					
					
					  <li data-role="list-divider">{$language.CreationAsDay}</li>
					  <li>{$UserStats.CretoionDay}</li>
					
	
					</ul>
			</div>
			{if $UserFiles}
				<div data-role="collapsible" data-collapsed="{if $smarty.get.Page}false{else}true{/if}">
					<h3>{$language.Files}</h3>
					{$Pager.0}
					{foreach from=$UserFiles key=k item=file}
						<ul data-role="listview"> 
							<li><a href="{$URLS.Script}File/{$file.ID}/">{$file.FileName}.{$file.Extension} <span class="ui-li-count">{$file.Downloads}</span></a></li> 
						</ul>
					{/foreach}
					{$Pager.1}
				</div>
			{/if}
	</div>
	
	

	<div style="clear:both"></div>
	
	<!--/CONTENT -->
{include  file='footer-main.tpl' inline}
</div><!-- /page xv-main-id -->