<div data-role="page" id="xv-main-page-id" data-theme="c">
	<div data-role="header"> 
	<a href="#xv-menu-id" data-role="button" data-theme="b" data-transition="flip">Menu</a>
		<h1>{$SiteTopic}</h1> 
	<a href="{$URLS.Script}" data-icon="home" data-iconpos="notext" data-direction="reverse" data-theme="b" data-transition="slidedown">Home</a>
	</div><!-- /header -->
	<!--CONTENT -->
	{if in_array($File.Extension, array('png', 'jpg', 'jpeg', 'bmp','gif'))}
	<div style="text-align:center; padding: 20px;">
		<a href="{$URLS.Script}File/{$File.ID}/{$File.FileName|escape:'url'}.{$File.Extension}" target="_blank">
			<img src="{$URLS.Script}File/{$File.ID}/{$File.FileName|escape:'url'}.{$File.Extension}?width=200" alt="{$File.FileName|escape:'html'}.{$File.Extension}" />
		</a>
	</div>
	{/if}
	
	<a href="{$URLS.Script}File/{$File.ID}/{$File.FileName|escape:'url'}.{$File.Extension}" target="_blank" data-role="button">Download</a>
	
	<ul data-role="listview"> 
		<li data-role="list-divider">{$language.IDFile}</li> 
		<li>{$File.ID}</li>
		
		<li data-role="list-divider">{$language.OwnerFile}</li> 
		<li><a href="{$URLS.Script}Users/{$File.UserFile|escape:'url'}/">{$File.UserFile}</a></li>
		
		<li data-role="list-divider">{$language.FileName}</li> 
		<li><a href="{$URLS.Script}File/{$File.ID}/{$File.FileName|escape:'url'}.{$File.Extension}"  id="FileNameJS">{$File.FileName|escape:'html'}.{$File.Extension}</a></li>
		
		<li data-role="list-divider">{$language.FileSize}</li> 
		<li>{$File.FileSize}</li>
		
		<li data-role="list-divider">{$language.FileType}</li> 
		<li>{$File.Extension}</li>
		
		<li data-role="list-divider">{$language.AddedDate}</li> 
		<li>{$File.Date}</li>
		
		<li data-role="list-divider">{$language.LastDownload}</li> 
		<li>{$File.LastDownload}</li>
		
		<li data-role="list-divider">{$language.MD5File}</li> 
		<li>{$File.MD5File}</li>
		
		<li data-role="list-divider">{$language.SHA1File}</li> 
		<li>{$File.SHA1File}</li>
		
		<li data-role="list-divider">{$language.Downloads}</li> 
		<li>{$File.Downloads}   ({$IntervalTime})</li>
	</ul>


	<div style="clear:both"></div>
	
	<!--/CONTENT -->
{include  file='footer-main.tpl' inline}
</div><!-- /page xv-main-id -->