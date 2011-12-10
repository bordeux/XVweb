{include file="header.tpl"}
{include file="menu.tpl"}
{if $FileInfo}
{include file="contents/file_contents.tpl"}
{elseif $UploadForm}
{include file="contents/uploadform_contents.tpl"}
{elseif $FileList}
{include file="filelist.tpl"}
{/if}
{include file="footer.tpl"}
