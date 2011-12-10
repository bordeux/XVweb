<!-- Content -->
<div id="Content">
		<div id="MiniMap">
		{foreach from=$MiniMap item=Value name=minimap}
		{if $smarty.foreach.minimap.last}
			{$Value.Name}
		{else}
			<a href="{$UrlScript}{$Value.Url|urlrepair|substr:1}">{$Value.Name}</a> &gt;
		{/if}
		{/foreach}
		</div>
	<div id="Title">
	{$SiteTopic}
	</div>
	<div id="ContentDiv">
		<div id="TextDiv">
			<!-- TEXT -->
			
			<fieldset id="EditForm">
	<form name="ArticleEditForm" id="ArticleEditForm" method="post" action="{$UrlScript}Write/?save={$IDArticle}">
			<textarea class="EditArt" id="EditArtPost" name="EditArtPost">{$ContextEdit}</textarea><br/>
		{if $WriteUrlArticle}
			 <b><label for="UrlArticleID">{$language.WriteURL}</label></b>: <input type="text" id="UrlArticleID" name="xv-path" class="StyleForm" value="{$smarty.get.url|escape:'html'}" /><br /><br />
		{/if}
		{if $WriteDescription}
			 <b><label for="DescriptionID">{$language.DescriptionOfChanges}</label></b>: <input type="text" id="DescriptionID" name="Description" class="StyleForm" /><br />
			{if "Amendments"|perm}<b><label for="amendmentID">{$language.Amendment}</label></b>: <input type="checkbox" id="amendmentID" name="amendment" class="StyleForm" value="true" /><br />{/if}
			{/if}
			<b>{$language.Title}</b>: <input type="text" id="TitleID" name="arttitle" class="StyleForm" value="{$TitleArt}" /><br /><br />
			<input type="checkbox" name="AceptRules" id ="AceptRulesID" value="on" /> {$language.QuestionRules} <br />
			
	</form>
</fieldset>


			<fieldset id="EditStetting">
<legend>{$language.Settings}</legend>
<form action="{$UrlScript}Write/?settings={$IDArticle}" name="SettingsForm" method="post">
<div class="table">
{foreach from=$SettingsInputs item=field key=handlefield name=InputsFields}
	<div class="table-row {if $smarty.foreach.InputsFields.index % 2 == 0}ZebraWhite{else}ZebraLight{/if}">
		<div class="table-cell"><b>{$handlefield}</b></div>
		<div class="table-cell">{$language[$handlefield]|default:"------"}</div>
		<div class="table-cell">
		{if $field.tag == "select"}
		<select {foreach from=$field.attr item=attrvalue key=attrkey} {$attrkey}="{$attrvalue}" {/foreach}>
			{foreach from=$field.options item=option key=optionkey}
				<option value="{$optionkey}" {if $field.checked[$optionkey]}selected="selected"{/if}>{$option}</option>
			{/foreach}
		</select>
		{elseif $field.tag == "input"}
		<input{foreach from=$field.attr item=attrvalue key=attrkey}{if $attrkey == "checked" && $attrvalue !="checked"} {else} {$attrkey}="{$attrvalue}"{/if}{/foreach}>
		{elseif $field.tag == "multiinput"}
			{foreach from=$field.inputs item=input}
				<input{foreach from=input item=attrvalue key=attrkey} {$attrkey}="{$attrvalue}" {/foreach}> <br/>
			{/foreach}
			{elseif $field.tag == "textarea"}
				<textarea {foreach from=$field.attr item=attrvalue key=attrkey} {$attrkey}="{$attrvalue}" {/foreach}>{$field.text|escape:"html"}</textarea>
		{/if}
		
		</div>
	</div>
{/foreach}
		<div class="table-row">
		<div class="table-cell"><input type="submit" value="{$language.Save}" /></div>
		</div>
</div>
</form>
</fieldset>
			<!-- TEXT -->
			<div style="clear:both;"></div>
		</div>
	</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->