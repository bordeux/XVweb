<!-- Content -->
<div id="Content">
		<div id="MiniMap">
		{foreach from=$MiniMap item=Value name=minimap}
		{if $smarty.foreach.minimap.last}
			{$Value.Name}
		{else}
			<a href="{$URLS.Script}{$Value.Url|urlrepair|substr:1}">{$Value.Name}</a> &gt;
		{/if}
		{/foreach}
		</div>
	<div id="ArticleTools">
		<ul>
			{if "DeleteOtherFile"|perm or ( "DeleteFile"|perm and $File.UserFile eq $LogedUser)}
				<li class="hoverClass">
					<a href="#DeleteFile" onclick="ThemeClass.DeleteBind(); return false;">{$language.Delete}</a>
				</li>
			{/if}
		</ul>
	</div>
	<div id="Title">
	{$SiteTopic}
	</div>
	<div id="ContentDiv">
		<div id="TextDiv">
			<!-- TEXT -->
		
		
<div id="MainFile">

<div class="FileInfoRow">
<div class="InfoFile"> {$language.IDFile}:</div>  <div class="FileInformation" id="FileID"> {$File.ID}</div>
</div>

<div class="FileInfoRow">
<div class="InfoFile"> {$language.OwnerFile}:</div>  <div class="FileInformation"><a href="{$URLS.Script}Users/{$File.UserFile|escape:"url"}/">{$File.UserFile}</a></div>
</div>

<div class="FileInfoRow">
<div class="InfoFile"> {$language.FileName}:</div>  <div class="FileInformation"> <a href="{$URLS.Script}File/{$File.ID}/{$File.FileName|escape:'url'}.{$File.Extension}"  id="FileNameJS">{$File.FileName|escape:'html'}.{$File.Extension}</a></div>
</div>

<div class="FileInfoRow">
<div class="InfoFile"> {$language.FileSize}:</div>  <div class="FileInformation"> {$File.FileSize}</div>
</div>

<div class="FileInfoRow">
<div class="InfoFile"> {$language.FileType}:</div>  <div class="FileInformation"> {$File.Extension}</div>
</div>

<div class="FileInfoRow">
<div class="InfoFile"> {$language.AddedDate}:</div>  <div class="FileInformation"> {$File.Date}</div>
</div>

<div class="FileInfoRow">
	<div class="InfoFile"> {$language.LastDownload}:</div>  <div class="FileInformation"> {$File.LastDownload}</div>
</div>

<div class="FileInfoRow">
	<div class="InfoFile"> {$language.MD5File}:</div>  <div class="FileInformation"> {$File.MD5File}</div>
</div>

<div class="FileInfoRow">
	<div class="InfoFile"> {$language.SHA1File}:</div>  <div class="FileInformation"> {$File.SHA1File}</div>
</div>

<div class="FileInfoRow">
	<div class="InfoFile"> {$language.Downloads}:</div>  <div class="FileInformation"> {$File.Downloads}   ({$IntervalTime})</div>
</div>
</div>




			<!-- TEXT -->
			<div style="clear:both;"></div>
		</div>
	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->