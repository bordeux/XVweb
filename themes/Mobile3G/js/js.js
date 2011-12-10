$(document).bind("pagecreate", function() {
		$(".xv-comment-spambot-field").val($(".xv-comment-spambot-key").first().text());
		$(".xv-comment-spambot").hide();
    });
	
$(document).bind("mobileinit", function(){
  $.mobile.ajaxEnabled = false;
});