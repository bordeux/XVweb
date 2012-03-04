<!doctype html>
<html style="margin:0; padding:0;">
  <head>
		<title>{$file_info.FileName}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="http://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
		<script src="http://vjs.zencdn.net/c/video.js"></script>
	</head>
{if $error == "bad_id_file"}
<body style="margin:0; padding:0;">
<style>
body {
    background:#0000aa;
    color:#ffffff;
    font-family:courier;
    font-size:12pt;
    text-align:center;
    margin:100px;
}
.neg {
    background:#fff;
    color:#0000aa;
    padding:2px 8px;
    font-weight:bold;
}
p {
    margin:30px 100px;
    text-align:left;
}
a,a:hover {
    color:inherit;
    font:inherit;
}
.menu {
    text-align:center;
    margin-top:50px;
}
</style>
<div>
	<span class="neg">ERROR 404</span>
	<p>
	The video is missing or never was recorded or is invalid. You can wait and<br />
	do nothing, but this is very boring. For fun you can restart your computer - meybe this solve this problem.
	</p>
	<p>
	* Send this video to us.<br />

	* Press CTRL+ALT+DEL to restart your computer. You will<br />
	 &nbsp; lose unsaved information in any programs that are running.
	</p>
	Press do anything to continue...
</div>
{else}
<body style="margin:0; padding:0; ax-height: 100%; max-width: 100%; overflow: hidden; background: #000;">
{if $convert_mode}
<div style="position:absolute; left:1px; top:1px; background: rgba(255, 0, 0, 0.7); z-index:99999; padding:5px; padding-right: 30px; border-bottom-right-radius: 20px;"> This file is now in convert mode</div>
{/if}
	<video id="video_player" class="video-js vjs-default-skin" controls
	  preload="auto" poster="{$URLS.Site}plugins/video/jpg/{$file_info.ID}.jpg"
	  data-setup="{}">
	  <source src="{$URLS.Site}plugins/video/webm/{$file_info.ID}.webm" type='video/webm'>
	  <source src="{$URLS.Site}plugins/video/mp4/{$file_info.ID}.mp4" type='video/mp4'>
	  <source src="{$URLS.Site}plugins/video/ogg/{$file_info.ID}.ogg" type='video/ogg'>
	</video>
		<script>
		   _V_("video_player").ready(function(){

				var myPlayer = this;
				myPlayer.size(window.innerWidth,window.innerHeight);
				
				window.onresize = function(){
					myPlayer.size(window.innerWidth,window.innerHeight);
				};

			});
		</script>
{/if}
</body>
</html>