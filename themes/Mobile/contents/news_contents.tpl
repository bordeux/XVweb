<div id="NewsPageScript">
	<div id="PagerUp">{$Pager.0}</div>
		{foreach from=$News item=NewsItem}
		<hr />
			<div class="NewsItem tablediv">
				<div class="rowdiv">
					<div class="celldiv VoteLeft">
					<div class="UpVote"></div>
						<div class="VoteResult">{$NewsItem.Votes}</div>
					<div class="DownVote"></div>
					</div>
					<div class="celldiv RightContents">
					<div class="NewsTitle"><a href="{$UrlScript}{$NewsItem.URL|substr:1|urlrepair}">{$NewsItem.Topic}</a></div>
					<div class="NewsInfo">{$language.Date}: {$NewsItem.Date} | <a href="{$UrlScript}{$NewsItem.URL|substr:1|urlrepair}#fp_comment">{$language.Comments}: {$NewsItem.CommentsCount}</A> | {$language.Author}: <a href="{$UrlScript}Users/{$NewsItem.Author|urlrepair}/">{$NewsItem.Author}</a></div>
					<div class="NewsContents">{$NewsItem.Contents} <a href="{$UrlScript}{$NewsItem.URL|substr:1|urlrepair}">{$language.More}</a></div>
					</div>
				</div>
			</div>
		{/foreach}
		<hr/>
	<div id="PagerDown">{$Pager.1}</div>
</div>