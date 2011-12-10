<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
  <channel>
    <title>{$SiteName}</title>
    <link>{$Url}</link>
    <description>{$Description}</description>
    <language>{$language.Lang}</language>
    <docs>http://blogs.law.harvard.edu/tech/rss</docs>
    <generator>XVweb RSS</generator>
    <webMaster>{$Email}</webMaster>
	
{foreach from=$News item=NewsItem}
    <item>
      <title>{$NewsItem.Topic|escape:"html"}</title>
      <link>{$UrlScript}{$NewsItem.URL|substr:1|urlrepair}</link>
      <description>{$NewsItem.Contents|strip_tags|escape:"html"|wordwrap:100:" ":1}...{$language.More}</description>
      <pubDate>{$NewsItem.Date}</pubDate>
      <author>{$NewsItem.Author}</author>
      <comments>{$UrlScript}{$NewsItem.URL|substr:1|urlrepair}#fp_comment</comments>
    </item>
{/foreach}

  </channel>
</rss>