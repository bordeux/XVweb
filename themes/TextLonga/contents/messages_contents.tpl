<!-- Content -->
 <div id="Content">
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
	<div id="EditPanel" class="ui-tabs ui-widget ui-widget-content">
				<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
				<li class="ui-state-default ui-corner-top {if $Page == 'inbox'}ui-state-active{/if} ui-state-default ui-button-text-icon-primary ui-state-hover" >
					<a href="{$URLS.Script}Messages/" title="{$language.Messages}"  style="padding-left:20px;"><span class="ui-icon ui-icon-mail-closed" style="margin-left:-16px;"></span>Odebrane</a>
				</li>
				<li class="ui-state-default ui-corner-top {if $Page == 'sent'}ui-state-active{/if} ui-state-default ui-button-text-icon-primary ui-state-hover">
					<a href="{$URLS.Script}Messages/Sent/" style="padding-left:20px;"><span class="ui-icon ui-icon-mail-open" style="margin-left:-16px;"></span> {$language.Sent}</a>
				</li>
				<li class="ui-state-default ui-corner-top {if $Page == 'trash'}ui-state-active{/if}  ui-state-default ui-button-text-icon-primary ui-state-hover">
					<a href="{$URLS.Script}Messages/Trash/"  style="padding-left:20px;"><span class="ui-icon ui-icon-trash" style="margin-left:-16px;"></span>{$language.Trash}</a>
				</li>

				<li class="ui-state-default ui-corner-top {if $Page == 'write'}ui-state-active{/if}  ui-state-default ui-button-text-icon-primary ui-state-hover">
					<a href="{$URLS.Script}Messages/Write/"  style="padding-left:20px;"><span class="ui-icon ui-icon-pencil" style="margin-left:-16px;"></span>{$language.Write}</a>
				</li>
			
			<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
					<span class="ui-button  ui-icon ui-icon-zoomin"></span>
			</li>
			
			<li class="ui-state-default ui-corner-top ui-state-hover" style="float:right;">
					<span class="ui-button ui-icon ui-icon-zoomout"></span>
			</li>				
		</ul>
		<div class="xv-title-wrapper" style="text-align:center;">
				<div class="xv-link-map">
				{foreach from=$MiniMap item=Value name=minimap}
					{if $smarty.foreach.minimap.last}
						{$Value.Name}
					{else}
						<a href="{$URLS.Script}{$Value.Url|replace:' ':'_'|urlrepair|substr:1}">{$Value.Name}</a> >>
					{/if}
				{/foreach}
			</div>
			
			<h1 class="xv-topic">{$SiteTopic|default:"Messages"}</h1>
		</div>
	</div>

<div class="xv-text-wrapper">

<!-- TEXT -->
{if $ReadArticleIndexOut.Accepted == "no"}
	{$ReadArticleIndexOut.AcceptedMsg}
{/if}
<div class="xv-text-content">
{$Content}
</div>
{if $QuickSearch}
	<div class="xv-quick-search">
		<h3>Zobacz te¿:</h3>
			<ul>
		{foreach from=$QuickSearch item=QuickLink}
					<li><a href="{$URLS.Script}{$QuickLink.URL|substr:1|replace:' ':'_'}" class="xv-quick-search-link">{$QuickLink.Topic}</a></li>
		{/foreach}
		</ul>
	</div>
{/if}
{if $Divisions}
<hr />
{foreach from=$Divisions item=Column key=ColumnNO}
{if $Column}
<div class="DivisionsColumn" id="Column{$ColumnNO}">
{foreach from=$Column item=Value key=CharDivision}

	<li><span>{$CharDivision}</span>
	<ul>
		{foreach from=$Value item=ArticleLink}
		<li><a href="{$URLS.Script}{$ArticleLink.URL|substr:1|replace:' ':'_'}" id="art-{$ArticleLink.ID}">{$ArticleLink.Topic}</a></li>
		{/foreach}
	</ul>
	</li>

{/foreach}
</div>
{/if}
{/foreach}

{/if}

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
								<div  class="table-cell fromsg">{$language.From}: <a href="{$URLS.Script}Users/{$MessageItem.From|escape:'url'}/">{$Message.From}</a></div>
								<div  class="table-cell tomsg">{$language.To}: <a href="{$URLS.Script}Users/{$Message.To|escape:'url'}/"><img src="{$AvantsURL}{if $Message.Avant}{$Message.From}{/if}_16.jpg"/> {$Message.To}</a></div>
							</div>
							<div class="table-row">
								<div  class="table-cell topic">{$language.Topic}: <a href="{$URLS.Script}Messages/{$Message.ID}/">{$Message.Topic}</a></div>
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
		<form action="{$URLS.Script}Messages/Write/?Send=true" method="post">
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
		<form action="{$URLS.Script}Messages/Write/?Send=true" method="post">
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
<form action="?{if $Page == 'trash'}Delete{else}Trash{/if}" method="post" class="xv-table">
			<table style="width : 100%; text-align: center;">
				<caption>{$Pager.0}</caption>
				<thead> 
					<tr>
						{if $Page != 'sent'}<th> <input type="checkbox" name="All" id="SelectAll" value="all"> </th>{/if}
						<th><a href='?{add_get_var value="SortBy=Date&Sort=$SmartySort"}'>{$language.Date}</a></th>
						<th>{if $Page == 'sent'}<a href='?{add_get_var value="SortBy=To&Sort=$SmartySort"}'>{$language.To}</a>{else}<a href='?{add_get_var value="SortBy=From&Sort=$SmartySort"}'>{$language.From}</a>{/if}</th>
						<th><a href='?{add_get_var value="SortBy=Topic&Sort=$SmartySort"}'>{$language.Message}</a></th>
					</tr>
				</thead> 
				<tbody> 
				{if $MessagesList->List}
				{foreach from=$MessagesList->List item=MessageItem name=MessagesForeach}
				<tr{if $MessageItem.Read} class="xv-message-read"{/if}>
					{if $Page != 'sent'}<td> <input type="checkbox" name="DeleteMSG[]" value="{$MessageItem.ID}" /> </td>{/if}
					<td><a href="{$URLS.Script}Users/{$MessageItem.User|urlrepair}">{$MessageItem.Date}</a></td>
					<td>{if $Page == 'sent'}<a href="{$URLS.Script}Users/{$MessageItem.To|escape:'url'}/"><img src="{$AvantsURL}{if $MessageItem.Avant}{$MessageItem.To}{/if}_16.jpg" alt="{$MessageItem.Author}"/> {$MessageItem.To}</a>{else}<a href="{$URLS.Script}Users/{$MessageItem.To|escape:'url'}/"><img src="{$AvantsURL}{if $MessageItem.Avant}{$MessageItem.From}{/if}_16.jpg" alt="{$MessageItem.Author}"/> {$MessageItem.From}</a>{/if}</td>
					<td>
						<div class="MsgTitle"><a href="{$URLS.Script}Messages/{$MessageItem.ID}/">{$MessageItem.Topic}</a></div>
						<div class="MsgText">
						{$MessageItem.Message|strip_tags:true|escape:'html'}
						</div>
					</td>
				</tr>
				{/foreach}
				{else}
					<div  style="text-align:center; font-size:14px; font-weight:bold;">{$language.EmptyBox}</div>
				{/if}
				</tbody> 
			</table>
			<div class="xv-table-pager">
			{$Pager.1}
			</div>
	
</form>
</fieldset>
{/if}

<div style="clear:both;"></div>
</div>


	<div class="reklamo" id="RCenter">
		{$smarty.capture.ADVCenter}
	</div>
	

</div>
</div>
<div style="clear:both;"></div>
 <!-- /Content -->