  <!-- Content -->
 <div id="Content">
 {if $Advertisement}
	<div class="reklamo" id="RTop">
		{$smarty.capture.ADVHeight}
	</div>
{/if}
 <div id="TitleDiv">
 {$SiteTopic}
 </div>
<div id="ContentDiv">
	{if $smarty.get.msg}
		<div class="{if $smarty.get.success}success{else}failed{/if}">
		{if $smarty.get.title}<h2>{$smarty.get.title|escape:"html"}</h2>{/if}
			{$smarty.get.msg|escape:"html"}
			{if $smarty.get.list}
			<ul>
				{foreach from=$smarty.get.list item=Value name=minimap}
				<li>{$Value|escape:"html"}</li>
				{/foreach}
			</ul>
			{/if}
		</div>
	{/if}
<div id="EditPanel" class="ui-tabs ui-widget ui-widget-content ui-corner-top">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
		{if "DeleteOtherFile"|perm or ( "DeleteFile"|perm and $File.UserFile eq $LogedUser)}
				<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;" id="DeleteFile">
				<span class="ui-button  ui-icon ui-icon-trash" title="{$language.Delete}" ></span>
				</li>
			{/if}
			
			
			
		</ul>
		
				
		<div class="xv-title-wrapper" style="text-align:center;">
				<div class="xv-link-map" style="float:left; position:absolute;">
				{foreach from=$MiniMap item=Value name=minimap}
					{if $smarty.foreach.minimap.last}
						{$Value.Name}
					{else}
						<a href="{$URLS.Script}{$Value.Url|replace:' ':'_'|urlrepair|substr:1}">{$Value.Name}</a> >>
					{/if}
				{/foreach}
			</div>
			
			<h1 class="xv-topic">{$SiteTopic}</h1>
		</div>
	</div>
<div class="xv-text-wrapper">

				<div id="wrapper">
	<div id="top">
   <div id="top-left">
        <div id="top-right">
              <div id="top-middle"> 
	
             </div>
        </div>
    </div>
</div>
<div id="frame-left"><div id="frame-right"><div id="content" >	  
{*$Content*}





<div id="MainFile">
<div class="IconPreview">
<a href="{$URLS.Script}File/{$File.ID}/{$File.FileName|escape:'url'}.{$File.Extension}" > 
{if $File.Extension == 'pdf'}
     <img src="{$UrlTheme}img/icons/pdf.png"  alt="PDF" />
{elseif $File.Extension == 'doc' or $File.Extension == 'docx'}
     <img src="{$UrlTheme}img/icons/doc.png"  alt="DOC" />
{elseif $File.Extension == 'flv'}
     <img src="{$UrlTheme}img/icons/flv.png"  alt="FLV" />
{elseif $File.Extension == 'html' or $File.Extension == 'htm'}
     <img src="{$UrlTheme}img/icons/html.png"  alt="HTML" />
{elseif $File.Extension == 'mp3'}
     <img src="{$UrlTheme}img/icons/mp3.png"  alt="MP3" />
{elseif $File.Extension == 'txt'}
     <img src="{$UrlTheme}img/icons/txt.png"  alt="TXT" />
{elseif $File.Extension == 'php'}
     <img src="{$UrlTheme}img/icons/php.png"  alt="PHP" />
{elseif $File.Extension == 'psd'}
     <img src="{$UrlTheme}img/icons/psd.png"  alt="PSD" />
{elseif $File.Extension == 'exe'}
     <img src="{$UrlTheme}img/icons/exe.png"  alt="EXE" />
{elseif $File.Extension == 'sql'}
     <img src="{$UrlTheme}img/icons/sql.png"  alt="SQL" />
{elseif $File.Extension == 'swf'}
     <img src="{$UrlTheme}img/icons/swf.png"  alt="SWF" />
{elseif $File.Extension == 'rar'}
     <img src="{$UrlTheme}img/icons/rar.png"  alt="RAR" />
{elseif $File.Extension == 'zip'}
     <img src="{$UrlTheme}img/icons/zip.png"  alt="ZIP" />
{elseif $File.Extension == 'tar'}
     <img src="{$UrlTheme}img/icons/tar.png"  alt="TAR" />
{elseif $File.Extension == 'jpg' or $File.Extension == 'png'  or $File.Extension == 'bmp' or $File.Extension == 'jpeg' or $File.Extension == 'tif'}
     <img src="{$UrlTheme}img/icons/img.png"  alt="IMAGE" />
{else}
     <img src="{$UrlTheme}img/icons/file.png"  alt="File" />
{/if}
</a>
</div>

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




{if in_array($File.Extension, array('png', 'jpg', 'jpeg', 'bmp','gif'))}
	<div id="Preview">
	<a href="#">{$language.PreView}</a>
		<div id="Image"></div>
	</div>
{/if}
<div style="clear: both;"> </div>
</div></div></div>
<div id="bottom">
   <div id="bottom-left">
        <div id="bottom-right">
             <div id="bottom-middle"> 
             </div>
        </div>
    </div>
</div>
</div>
</div>

</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->