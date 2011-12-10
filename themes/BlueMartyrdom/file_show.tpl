{$JSBinder[22]="file"}
{$CCSLoad[22]="`$URLS.Theme`css/File.css"}
{if $UploadForm}
{$JSBinder[25]="jquery.MultiFile.pack"}
{$JSBinder[26]="UploadForm"}
{/if}
{include file="header.tpl" inline}
{include file="menu.tpl" inline}
{if $FileInfo}
{include file="contents/file_contents.tpl"}
{elseif $UploadForm}
{include file="contents/uploadform_contents.tpl"}
{elseif $FileList}
{include file="filelist.tpl"}
{/if}
{include file="footer.tpl" inline}
