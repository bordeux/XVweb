$(document).ready(function() {
$("#progressID").hide("slow");
if(navigator.plugins["Shockwave Flash"]){
var YTLink = "";
var YTClass = "";
	$(".ytvideo").each(function(){
	var YTID = $(this).attr('alt');
	YTClass = $(this).parent().attr('class');
	YTLink = $(this).parent().attr("href");
	$(this).parent().after(
		$('<div id="YouTube-'+YTID+'" class="Video YouTube"></div>').attr({ link: $(this).parent().attr("href"), player : $(this).parent().attr("class")}).flash(
		{   
			swf: 'http://www.youtube.com/v/'+YTID+'&fs=1&color1=0x006699&color2=0x54abd6',
			height:385,
			width:480,
			flashvars: {      }   
		}
		)).remove();
	});
	$(".ytplaylist").each(function(){
	YTID = $(this).attr('alt');
	YTClass = $(this).parent().attr('class');
	$(this).parent().after(
		$('<div id="YouTubePlaylist-'+YTID+'" class="Video Youtube Playlist"></div>').attr({ link: $(this).parent().attr("href"), player : $(this).parent().attr("class")}).flash(
		{
			swf: 'http://www.youtube.com/p/'+YTID+'&hl=pl_PL&fs=1',
			height:385,
			width:480,
			flashvars: {      }   
		}
		)).remove();
	});
	$(".vimeo").each(function(){
	VimLink = $(this).parent().attr("href");
	VimID = $(this).attr("alt");
	$(this).parent().after(
		$('<div id="Vimeo-'+VimID+'" class="Video Vimeo"></div>').attr({ link: $(this).parent().attr("href"), player : $(this).parent().attr("class")}).flash(
		{   
			swf: 'http://vimeo.com/moogaloop.swf?clip_id='+VimID+'&server=vimeo.com&show_title=1&show_byline=1&show_portrait=0&color=&fullscreen=1',
			height:300,
			width:500,
			flashvars: {      }   
		}
		)).remove(); 
	});
	
	$(".Video").each(function (i) {
	if(!$(this).attr('palyer'))
		$(this).css({background:"#000 url('"+URLS.Theme+"img/playerbg.png') repeat-x bottom", padding:"20px", "textAlign":"center"}).append("<div style='float:right;'><a href='"+$(this).attr('link')+"'><img src='"+URLS.Theme+"img/ytlink.png' alt='Video Link' /></a></div>");
	});
	
}
 });
 
 