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
				<li class="ui-state-default ui-corner-top {if $Page == 'inbox'}ui-state-active{/if} ui-state-default ui-button-text-icon-primary ui-state-hover" >
					<a href="{$UrlScript}Messages/" title="{$language.Messages}"  style="padding-left:20px;"><span class="ui-icon ui-icon-mail-closed" style="margin-left:-16px;"></span>Odebrane</a>
				</li>
				<li class="ui-state-default ui-corner-top {if $Page == 'sent'}ui-state-active{/if} ui-state-default ui-button-text-icon-primary ui-state-hover">
					<a href="{$UrlScript}Messages/Sent/" style="padding-left:20px;"><span class="ui-icon ui-icon-mail-open" style="margin-left:-16px;"></span> {$language.Sent}</a>
				</li>
				<li class="ui-state-default ui-corner-top {if $Page == 'trash'}ui-state-active{/if}  ui-state-default ui-button-text-icon-primary ui-state-hover">
					<a href="{$UrlScript}Messages/Trash/"  style="padding-left:20px;"><span class="ui-icon ui-icon-trash" style="margin-left:-16px;"></span>{$language.Trash}</a>
				</li>

				<li class="ui-state-default ui-corner-top {if $Page == 'write'}ui-state-active{/if}  ui-state-default ui-button-text-icon-primary ui-state-hover">
					<a href="{$UrlScript}Messages/Write/"  style="padding-left:20px;"><span class="ui-icon ui-icon-pencil" style="margin-left:-16px;"></span>{$language.Write}</a>
				</li>
			
			<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
					<span class="ui-button  ui-icon ui-icon-zoomin"></span>
			</li>
			
			<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
					<span class="ui-button ui-icon ui-icon-zoomout"></span>
			</li>				
		</ul>
		
		<div id="MiniMap">
		{foreach from=$MiniMap item=Value name=minimap}
			{if $smarty.foreach.minimap.last}
				{$Value.Name}
			{else}
				<a href="{$UrlScript}{$Value.Url|replace:' ':'_'|urlrepair|substr:1}">{$Value.Name}</a> <img src="{$UrlTheme}img/blank.png" class="cssprite SpaceIconIMG" alt="&gt;&gt;"/>
			{/if}
		{/foreach}
		</div>
	</div>
<div id="TextDiv">
<!-- TEXT -->
 {if $smarty.get.Sort == "desc"}
		{assign var='SmartySort' value='asc'}
	 {else}
		{assign var='SmartySort' value='desc'}
 {/if}
{if $Page == 'message'}
<fieldset>
<legend>{$language.Message}</legend>
	<div class="table" id="Table">
		<div class="table-row">
		<div  class="table-cell avant"><a href=""><img src="{$AvantsURL}{if $Message.Avant}{$Message.From}{/if}_150.jpg"/><br/>{$Message.From}</a></div>
			<div  class="table-cell">
						<div class="table" id="Table">
							<div class="table-row">
								<div  class="table-cell fromsg">{$language.From}: <a href="{$UrlScript}Users/{$MessageItem.From|escape:'url'}/">{$Message.From}</a></div>
								<div  class="table-cell tomsg">{$language.To}: <a href="{$UrlScript}Users/{$Message.To|escape:'url'}/"><img src="{$AvantsURL}{if $Message.Avant}{$Message.From}{/if}_16.jpg"/> {$Message.To}</a></div>
							</div>
							<div class="table-row">
								<div  class="table-cell topic">{$language.Topic}: <a href="{$UrlScript}Messages/{$Message.ID}/">{$Message.Topic}</a></div>
							</div>
							<div class="table-row">
								<div  class="table-cell messagetxt"><div>{$Message.Message}</div><div id="MSGDate">{$Message.Date}</div></div>
							</div>
						</div>
			
			</div>
		</div>
	</div>
	<div>
	<div id="Replay">
		<form action="{$UrlScript}Messages/Write/?Send=true" method="post">
			<div id="RTitle"><span>&gt;&gt;</span> Odpowiedz</div>
			<div class="table" id="Table">
					<div class="table-row">
						<div  class="table-cell rlabeltopic">{$language.Topic}</div>
					</div>
					<div class="table-row">
						<div  class="table-cell rtopic"><input type="text" value="Re: {$Message.Topic}" name="Topic" /></div>
					</div>
					<div class="table-row">
						<div  class="table-cell rlabelmessage">{$language.Message}</div>
					</div>
					<div class="table-row">
						<div  class="table-cell rmessage"><textarea name="Message"></textarea> </div>
					</div>
					<div class="table-row">
						<div  class="table-cell rsubbmit">
						<input type="hidden" value="{$Message.From}" name="To" />
						<input type="submit" value="{$language.Send}" name="Send" class="ui-state-default ui-priority-primary ui-corner-all ui-state-hover"/>
						</div>
					</div>
			</div>
		</form>
	</div>
	</div>
</fieldset>
{elseif $Page == 'write'}

<fieldset>
<legend>{$language.Message}</legend>
	<div>
	{if $smarty.get.Send}
	<div id="RResult" class="{if $Result}success{else}failed{/if}">{if $Result}{$language.Sent}{else}{$language.SendFailed}{/if}</div>
	{/if}
	<div id="Replay">
		<form action="{$UrlScript}Messages/Write/?Send=true" method="post">
			<div id="RTitle"><span>&gt;&gt;</span> {$language.Write}</div>
			<div class="table" id="Table">
					<div class="table-row">
						<div  class="table-cell rlabeltopic">{$language.To}</div>
					</div>
					<div class="table-row">
						<div  class="table-cell rtopic"><input type="text" value="{$smarty.get.To|escape:'url'}" name="To" /></div>
					</div>
					<div class="table-row">
						<div  class="table-cell rlabeltopic">{$language.Topic}</div>
					</div>
					<div class="table-row">
						<div  class="table-cell rtopic"><input type="text" value="Re: {$Message.Topic}" name="Topic" /></div>
					</div>
					<div class="table-row">
						<div  class="table-cell rlabelmessage">{$language.Message}</div>
					</div>
					<div class="table-row">
						<div  class="table-cell rmessage"><textarea name="Message"></textarea> </div>
					</div>
					<div class="table-row">
						<div  class="table-cell rsubbmit">
						<input type="submit" value="{$language.Send}" name="Send" />
						</div>
					</div>
			</div>
		</form>
	</div>
	</div>
</fieldset>


{else}
<fieldset>
<legend>{$language.Messages}</legend>
{$Pager.0}
<form action="?{if $Page == 'trash'}Delete{else}Trash{/if}" method="post">
	<div class="table" id="Table">
			<div class="table-row" id="TableHeader">
				{if $Page != 'sent'}<div  class="table-cell delete"> <input type="checkbox" name="All" id="SelectAll" value="all"></div>{/if}
				<div  class="table-cell date"><a href='?{addget value="SortBy=Date&Sort=$SmartySort"}'>{$language.Date}</a></div>
				<div  class="table-cell {if $Page == 'sent'}to{else}from{/if}">{if $Page == 'sent'}<a href='?{addget value="SortBy=To&Sort=$SmartySort"}'>{$language.To}</a>{else}<a href='?{addget value="SortBy=From&Sort=$SmartySort"}'>{$language.From}</a>{/if}</div>
				<div  class="table-cell message"><a href='?{addget value="SortBy=Topic&Sort=$SmartySort"}'>{$language.Message}</a></div>
			</div>
			{if $MessagesList->List}
			{foreach from=$MessagesList->List item=MessageItem name=MessagesForeach}
			<div class="table-row {if $smarty.foreach.MessagesForeach.index % 2 == 0}Zebra{/if} {if $MessageItem.Read}read{/if}">
				{if $Page != 'sent'}<div  class="table-cell delete"><input type="checkbox" name="DeleteMSG[]" value="{$MessageItem.ID}" ></div>{/if}
				<div  class="table-cell date">{$MessageItem.Date}</div>
				<div  class="table-cell from">
				{if $Page == 'sent'}<a href="{$UrlScript}Users/{$MessageItem.To|escape:'url'}/"><img src="{$AvantsURL}{if $MessageItem.Avant}{$MessageItem.To}{/if}_16.jpg" alt="{$MessageItem.Author}"/> {$MessageItem.To}</a>{else}<a href="{$UrlScript}Users/{$MessageItem.To|escape:'url'}/"><img src="{$AvantsURL}{if $MessageItem.Avant}{$MessageItem.From}{/if}_16.jpg" alt="{$MessageItem.Author}"/> {$MessageItem.From}</a>{/if}
				</div>
				<div  class="table-cell message">
					<div class="MsgTitle"><a href="{$UrlScript}Messages/{$MessageItem.ID}/">{$MessageItem.Topic}</a></div>
					<div class="MsgText">
					{$MessageItem.Message|strip_tags:true|escape:'html'}
					</div>
				</div>
			</div>
			{/foreach}
		<div class="table-row">
			<div  class="table-cell delete"> <input type="submit" style="padding:4px; font-size :11px;" name="Delete" value="{$language.Delete}" class="ui-state-default ui-priority-primary ui-corner-all ui-state-hover">
			
			</div>
		</div>
			{else}
				</div>
				<div  style="text-align:center; font-size:14px; font-weight:bold;">{$language.EmptyBox}
			
			{/if}
	</div>
</form>
{$Pager.1}
</fieldset>
{/if}
<!-- TEXT -->
<div style="clear:both;"></div>
</div>
</div>

</div>
<div style="clear:both;"></div>
 <!-- /Content -->