// Autosize 1.7 - jQuery plugin for textareas
// (c) 2011 Jack Moore - jacklmoore.com
// license: www.opensource.org/licenses/mit-license.php
(function(a,b){var c="hidden",d='<textarea style="position:absolute; top:-9999px; left:-9999px; right:auto; bottom:auto; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden">',e=["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing"],f="oninput",g="onpropertychange",h=a(d)[0];h.setAttribute(f,"return"),a.isFunction(h[f])||g in h?a.fn.autosize=function(b){return this.each(function(){function p(){var a,b;m||(m=!0,j.value=h.value,j.style.overflowY=h.style.overflowY,j.style.width=i.css("width"),j.scrollTop=0,j.scrollTop=9e4,a=j.scrollTop,b=c,a>l?(a=l,b="scroll"):a<k&&(a=k),h.style.overflowY=b,h.style.height=h.style.minHeight=h.style.maxHeight=a+o+"px",setTimeout(function(){m=!1},1))}var h=this,i=a(h).css({overflow:c,overflowY:c,wordWrap:"break-word"}),j=a(d).addClass(b||"autosizejs")[0],k=i.height(),l=parseInt(i.css("maxHeight"),10),m,n=e.length,o=i.css("box-sizing")==="border-box"?i.outerHeight()-i.height():0;l=l&&l>0?l:9e4;while(n--)j.style[e[n]]=i.css(e[n]);a("body").append(j),g in h?f in h?h[f]=h.onkeyup=p:h[g]=p:h[f]=p,a(window).resize(p),i.bind("autosize",p),p()})}:a.fn.autosize=function(){return this}})(jQuery);

var xv_message = {
	is_activate : false,
	send : function(){
		var message_to_send = $('.xv-message-textarea').val();
		var message_reciver = $('.xv-message-conversation-header a').text();
		if(message_to_send == "" || message_reciver == "")
			return false;
		$('.xv-message-textarea').attr("disabled", "disabled");
		$.post(URLS['Script']+'api/messages/messages/json/', { 'send_message': [message_reciver, message_to_send]}, function(data){
			$('.xv-message-textarea').val("");
		}, "json").complete(function() { 
			$('.xv-message-textarea').removeAttr("disabled");
		});;
	},	
	play_sound : function(){
		var audio_url = URLS['Theme']+"messages/js/beep.wav";
		$("<audio autoplay='autoplay'><source src='"+audio_url+"' type='audio/wav' /></audio>");
	},
	refresh_messages : function(){
		var message_reciver = $('.xv-message-conversation-header a').text();
		var message_last_time = $('.xv-message-history div:last .time').text();
		if(message_last_time == "")
			message_last_time = '0000-00-00 00:00:00';
			
		$.post(URLS['Script']+'api/messages/messages/json/', { 'get_messages': [message_reciver, message_last_time]}, function(data){
			$.each(data.get_messages.result, function(key, val){
			
			if(xv_message.is_activate == false && val['Me'] == "0"){
				xv_message.play_sound();
			};
				$(".xv-message-history").append('<div class="'+(val.Me == "1" ? "me": "sender")+'">'+
						"<span class='time' >"+val['Date']+"</span>"+
						val.Message+
					'</div>');
				$(".xv-message-history").scrollTop(99999999);
			});
		}, "json");
	},

};
$(function(){
	var scroll_speed  = 0.20;
	
	$(".xv-message-scroll div" ).draggable({ 
		axis: "y" ,
		containment: "parent",
		revert: true,
	 drag: function(event, ui) {
		var scroll_actial_pos = parseInt($(this).css("top"), 10);
		
		var element_to_scroll =	$($(this).data("scroll"));
		
		element_to_scroll.scrollTop((element_to_scroll.scrollTop())+(scroll_actial_pos*scroll_speed));
			//scroll_actial_pos
	 },
	 start : function(){
		$("body").addClass("xv-no-select");
	 },
	 stop: function(){
		$("body").removeClass("xv-no-select");
	 }
	});
	
	$(".xv-message-history").scrollTop(99999999);

	$('.xv-message-textarea').autosize();  

	$(".xv-message-form").submit(function(){
		xv_message.send();
		return false;
	});
	
	$('.xv-message-textarea').keydown(function (e) {
	  if (e.keyCode == 13 && !e.shiftKey) {
		$(".xv-message-form").submit();
	  }
	});
	
	setInterval(function(){
		xv_message.refresh_messages();
	},1000);
	
	var isActive;
	window.onfocus = function () { 
		xv_message.is_activate = true; 
	}; 

	window.onblur = function () { 
	  xv_message.is_activate = false; 
	}; 

});