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
			<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover">
				<a href="{$UrlScript}Users/{$User.Nick|escape:'url'}" title="{$language.Profile}"  id="btViewProfile" style="padding-left:20px;"> <span class="ui-icon ui-icon-person" style="margin-left:-16px;"></span> {$language.Profile}</a>
			</li>
			{if "EditOtherProfil"|perm or ( "EditProfil"|perm and $User.Nick eq $LogedUser)}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-state-active ui-button-text-icon-primary ui-state-hover">
					<a href="{$UrlScript}Users/{$User.Nick|escape:'url'}/Edit/" id="btEditProfile" style="padding-left:20px;"> <span class="ui-icon ui-icon-pencil" style="margin-left:-16px;"></span>{$language.EditProfile}</a>
				</li>
			{/if}
			{if  "DeleteUser"|perm}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover">
					<a href="#DeleteUser" title="{$language.DeleteProfile}" id="btDeleteUser"style="padding-left:20px;"> <span class="ui-icon ui-icon-trash" style="margin-left:-16px;"></span>{$language.DeleteProfile}</a>
				</li>
			{/if}
			{if  "BanUser"|perm}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover">
					<a href="#BanUser" title="{$language.BanUser}" id="btBanUser" style="padding-left:20px;"> <span class="ui-icon ui-icon-cancel" style="margin-left:-16px;"></span>{$language.BanUser}</a>
				</li>
			{/if}
				<li class="ui-state-default ui-corner-top ui-state-hover ui-button-text-icon-primary ui-state-hover">
					<a href="{$UrlScript}Messages/Write/?To={$User.Nick|escape:'url'}" title="{$language.Write}" style="padding-left:20px;"><span class="ui-icon ui-icon-mail-closed" style="margin-left:-16px;"></span> {$language.Write}...</a>
				</li>
		
			
		</ul>
		{if $MiniMap}
		<div id="MiniMap">
		{foreach from=$MiniMap item=Value name=minimap}
			{if $smarty.foreach.minimap.last}
				{$Value.Name}
			{else}
				<a href="{$UrlScript}{$Value.Url|replace:' ':'_'|urlrepair|substr:1}">{$Value.Name}</a> <img src="{$UrlTheme}img/blank.png" class="cssprite SpaceIconIMG" alt="&gt;&gt;"/>
			{/if}
		{/foreach}
		</div>{/if}
	</div>
	
<div class="xv-text-wrapper">
<!-- TEXT -->
{if $Edited}
	{if $Error != true}
		<div class="success">
			{$language.EditSuccess}
		</div>
	{else}
		<div class="failed">
			{$language.EditFailed}
			{if $ErrorSave}
			<ul>
			{foreach from=$ErrorSave item=EMessage}
				<li>{$EMessage}</li>
			{/foreach}
			</ul>
			{/if}
		</div>
	{/if}
{/if}

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
<div id="UserInfo">
	<div id="ProfileText">
		
		<div id="UserTableEdit">
<form id="ProfilForm" name="ProfilForm" action="?Save" enctype="multipart/form-data" method="post">
	<input type="hidden" name="SIDCheck" value="{$JSVars.SIDUser}" />
	<table class="TableUser" summary="User Table Profil" style="width:800px;">
	 <tr class="TableCell">
	<td  rowspan="5" align="center"> 
		<img src="{$AvantsURL}{if $User.Avant}{$User.Nick}{/if}_150.jpg" alt="{$User.Nick}" />
	 </td>

	 </tr>
	{foreach from=$UserInputs item=field key=handlefield name=InputsFields}
	<tr class="TableCell">
			<td>{$language[$handlefield]|default:"------"}</td>
			<td>
			{if $field.tag == "select"}
			<select {foreach from=$field.attr item=attrvalue key=attrkey} {$attrkey}="{$attrvalue}" {/foreach}>
				{foreach from=$field.options item=option key=optionkey}
					<option value="{$optionkey}" {if $field.checked[$optionkey]}selected="selected"{/if}>{$option}</option>
				{/foreach}
			</select>
			{elseif $field.tag == "input"}
			<input{foreach from=$field.attr item=attrvalue key=attrkey}{if $attrkey == "checked" && $attrvalue !="checked"} {else} {$attrkey}="{$attrvalue}"{/if}{/foreach} />
			{elseif $field.tag == "multiinput"}
				{foreach from=$field.inputs key=inkey item=inputh}
					{$language[$inkey]|default:"------"}: <input {foreach from=$inputh item=attrvalue key=attrkey} {$attrkey}="{$attrvalue}" {/foreach} /> <br/>
				{/foreach}
				{elseif $field.tag == "textarea"}
					<textarea {foreach from=$field.attr item=attrvalue key=attrkey} {$attrkey}="{$attrvalue}" {/foreach}>{$field.text|escape:"html"}</textarea>
			{/if}
			</td>
			 </tr>
	{/foreach}
		<tr class="TableCell">
	  <td> <input type="submit" name="EditSend" value="Save" /></td>
	 </tr>
	 
	 </table>
 </form>
</div>
		
		
	</div>
</div>

<div style="clear:both;"></div>






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
<!-- TEXT -->
</div>
</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->