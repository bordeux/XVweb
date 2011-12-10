var ThemeClass = {}, WindowCenter = [];
function isset(a) {
	return typeof a == "undefined" ? false : true
}
function $GetID(a) {
	return document.getElementById(a)
}
ThemeClass.LoadLang = function(a, b) {
	ThemeClass.LoadJS(URLS.Script + "receiver/language.js?include=" + a, b)
};
ThemeClass.LoadJS = function(a, b) {
	$("#progressID").html("<img src='" + URLS.Theme + "img/progress.gif' alt='Progress' /> " + Language.Loading + ": " + a);
	$("#progressID").show();
	$.getScript(a, function() {
		b();
		$("#progressID").hide("slow");
		$("#progressID").text("")
	})
};
ThemeClass.Shake = function(a) {
	ThemeClass.ShakeID = a;
	ThemeClass.LoadJS(JSCatalog + "js/JQshake.min.js", function() {
		$(ThemeClass.ShakeID).effect("shake", {times:3}, 300)
	})
};
jQuery.preloadImages = function() {
	for(var a = 0;a < arguments.length;a++)
	jQuery("<img>").attr("src", arguments[a]);
};
function CreateWindowLayer(a, b, c) {
	if(!isset(c))
	c = '#000';
	$(document.createElement("div")).attr({id:"OpacityLayer-" + a}).addClass("AjaxLayer").click(function() {
		$(this).hide(700, function() {
			$(this).remove()
		})
	}).css({"background-color":c, opacity:0.01}).appendTo(document.body).fadeTo(700, 0.6);
	$(document.createElement("div")).attr({id:"Window" + a}).addClass("AjaxLayer").click(function(d) {
		$(d.target).attr("id") == "Window" + a && CancelWindowLayer(a)
	}).css({opacity:0.01}).html($(['<div id="wrapper">', '<div id="top">', '<div id="top-left">', '<div id="top-right">', '<div id="top-middle">', '<div style="float:right; margin-right:5px; cursor:pointer;" onclick="CancelWindowLayer(\'' + a + "'); return false;\">", '<img src="' + URLS.Theme + 'img/alphacube/button-close-focus.gif"/>', "</div>", "</div>", "</div>", "</div>", "</div>", '<div id="frame-left">', '<div id="frame-right">', '<div id="WinContent">', b, "</div>", "</div>", "</div>", '<div id="bottom">', 
	'<div id="bottom-left">', '<div id="bottom-right">', '<div id="bottom-middle">', "</div>", "</div>", "</div>", "</div>", "</div>"].join(String.fromCharCode(13)))).appendTo(document.body).fadeTo(700, 1)
}
function CancelWindowLayer(a) {
	$("#OpacityLayer-" + a + " , #Window" + a).hide(900, function() {
		$("#OpacityLayer-" + a + " , #Window" + a).remove()
	})
}
function GetAjax(a, b, c) {
	$.get(a, function(d) {
		$("#" + b).html(d);
		typeof c != "undefined" && c()
	})
}
var cachePost = [];
function sendPost(a, b, c, d) {
	$.ajax({type:"POST", url:c, data:$("#" + b).serialize(), cache:false, dataType:"html", error:function() {
			ErrorAlert("<b>" + Language.ServerError + "</b>")
		}, success:function(e) {
			typeof d != "undefined" ? $("#" + a).append(e) : $("#" + a).html(e)
		}});
	return true
}
$(function() {
	$("#progressID").bind("ajaxSend", function(a, b, c) {
		if(typeof c != "undefined")if(c.url.indexOf("online/"))return false;
		$(this).html("<img src='" + URLS.Theme + "img/progress.gif' alt='Progress' /> " + Language.Loading + ": " + c.url);
		$(this).show()
	}).bind("ajaxComplete", function() {
		if(typeof settings != "undefined")if(settings.url.indexOf("online/"))return false;
		$(this).hide("slow");
		$(this).text("")
	});
	$("#FinallContent img").each(function() {
		if($(this).width() > $("#FinallContent").width()) {
			$("#FinallContent").width();
			$(this).width();
			$(this).width($("#FinallContent").width())
		}
	})
});
function RegisterWindows() {
	ThemeClass.LoadJS(JSCatalog + "js/Register.js", function() {
		ThemeClass.GetRegisterWindow()
	})
}
function LostPasswordJS() {
	ThemeClass.LoadJS(JSCatalog + "js/GetLostPassowrd.js", function() {
		ThemeClass.GetLostPassword()
	})
}
function AjaxLoged() {
	ThemeClass.LogedWindow = function() {
	};
	ThemeClass.LoadJS(JSCatalog + "js/SingIn.js", function() {
		ThemeClass.LogedWindow()
	})
}
function ErrorAlert(a) {
	CreateWindowLayer("ErrorWindow", "<table border='0' width='389' height='81'><tr><td><img src='" + URLS.Theme + "img/warning.png' width='90' height='87'></td><td height='75' width='278'><p align='center'>" + a + "</td></tr></table>", "#ff0000");
	ThemeClass.Shake("#ErrorWindowIN")
}
function LogOut() {
	ThemeClass.LoadJS(JSCatalog + "js/LogOut.js", function() {
		ThemeClass.LogOut()
	})
}
function addsmile(a, b) {
	$GetID(a).value += b
}
function resizeelement(a, b) {
	$GetID(a).style.height = $GetID(a).offsetHeight + b + "px";
}

function ShowHide(a) {
	if($GetID(a).style.display == "none")$GetID(a).style.display = "block";
	else $GetID(a).style.display = "none"
}
$(function() {
function AjaxCounterOnline() {

	$.getJSON(URLS.Script + "online/", {LogedUsers:true, UrlLocation:location.href, HideProgres:true}, function(a) {
		$(".OAllUsers").html(a.OnlineUsers);
		$(".OLogedUsers").html(a.LogedUser);
		this.HideProgress = true
	})

}
	AjaxCounterOnline();
	setInterval("AjaxCounterOnline()", 10000);
});
var saves = 1;
function emotaddajax() {
	CreateWindowLayer("EmotAddAjaxWindow", "<div id='emotadddivs'>Zaraz</div>")
}
function RemoveEdit(a) {
	$GetID("EditLabelID" + a).innerHTML = ""
}
function showlayer(a) {
	a = document.getElementById(a);
	a.style.display = a.style.display == "none" || a.style.display == "" ? "block" : "none"
}
function PrintPage(a, b, c) {
	window.open(a, "PrintWindow", "width=" + b + ",height=" + c + ",resizable=0,scrollbars=yes,menubar=no").window.print()
}
function QueryView(a, b, c) {
	var d = "";
	if(typeof c != "undefined")d = "<div>" + c + "</div>";
	return'<div id="QueryID-' + a + '"><div style="display: table;"><div style="display: table-cell; vertical-align: middle;"><img id="QueryImage" src="' + URLS.Theme + 'img/query.png" /></div><div style="display: table-cell; vertical-align: middle;" id="QueryIDText-' + a + '"><p style="margin-left:10px;">' + b + '</p></div></div><div id="Footer-' + a + '">' + d + "</div></div>"
}
function FontResize(a) {
	$("#FinallContent").css("font-size", parseInt($("#FinallContent").css("font-size").replace("px", "")) + parseInt(a) + "px");
	$("#progressID").html(parseInt($("#FinallContent").css("font-size").replace("px", "")) + parseInt(a) + "px").show()
}
ThemeClass.StarUpdate = function() {
};
$(document).ready(function() {
	$.preloadImages(URLS.Theme + "img/blank.png");
	$(".ZabraCell tr:odd").addClass("TableCellWhite");
	$("#xdebugb").click(function() {
		$("#xdebug").toggle();
		return false
	});

	$('#EditPanel ul li a').click(function() {
		$('#EditPanel ul li a').removeClass('selected');
		$(this).addClass("selected");
	});

	$(".OpenIDLogin").click(function(){
		ThemeClass.LogedWihtOpenID = function() {
		};
		ThemeClass.LoadJS(JSCatalog + "js/SingIn.js", function() {
			ThemeClass.LogedWihtOpenID()
		});
		return false;
	});

});
$(document).keyup(function(a) {
	switch(a.keyCode) {
	case 46:
		ThemeClass.DeleteBind();
		break;
	};
});
ThemeClass.ValidateUser = function(a) {
	$.getJSON(URLS.Script + "receiver/IssetUser?User=" + encodeURIComponent($(a).val()), function(b) {
		b.Isset == true ? $(a).css({background:"url(" + URLS.Theme + "img/error.png) #EF7777 no-repeat top right", border:"1px solid #FF0000"}) : $(a).css({background:"url(" + URLS.Theme + "img/validate.png) #BEEF77 no-repeat top right", border:"1px solid #7BBF17"})
	});
};
function empty(a) {
	return typeof a == "undefined" ? true : false
}
ThemeClass.Refresh = function() {
	location.href = location.href
};

$(function(){
	$(".xv-tab").click(function(){
		$(this).attr('rel');
		$(".xv-tab").each(function(index) {
			$("#"+$(this).attr('rel')).hide();
			$(this).parent().removeClass("ui-state-active").addClass("ui-state-default");
		});
		$("#"+$(this).attr('rel')).show();
		$(this).parent().removeClass("ui-state-default").addClass("ui-state-active");
		return false;
	});
	$(".xv-tab:first").click();
	$(".xv-tab").hover(function () {
		if(!$(this).hasClass("ui-state-active"))
		$(this).parent().addClass("ui-state-hover");
		
	}, 
	function () {
		$(this).parent().removeClass("ui-state-hover")
	}
	);	
})