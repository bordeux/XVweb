function isset() {
	var a = arguments,
	l = a.length,
	i = 0,
	undef;
	
	if (l === 0) {
		throw new Error('Empty isset');
	}
	while (i !== l) {
		if (a[i] === undef || a[i] === null) {
			return false;
		}
		i++;
	}
	return true;
}

function ifsetor(l, s) {
	if (!isset(l)) {
		return s;
	};
	return l;
}

ThemeClass = {};
function print_r(x, max, sep, l) {
	l = l || 0;
	max = max || 10;
	sep = sep || ' ';
	if (l > max) {
		return "[WARNING: Too much recursion]\n";
	}
	var
	i,
	r = '',
	t = typeof x,
	tab = '';
	if (x === null) {
		r += "(null)\n";
	} else if (t == 'object') {
		l++;
		for (i = 0; i < l; i++) {
			tab += sep;
		}
		if (x && x.length) {
			t = 'array';
		}
		r += '(' + t + ") :\n";
		for (i in x) {
			try {
				r += tab + '[' + i + '] : ' + print_r(x[i], max, sep, (l + 1));
			} catch (e) {
				return "[ERROR: " + e + "]\n";
			}
		}
	} else {
		if (t == 'string') {
			if (x == '') {
				x = '(empty)';
			}
		}
		r += '(' + t + ') ' + x + "\n";
	}
	return r;
};
var_dump = print_r;

(function ($) {
   $.fn.liveDraggable = function (opts) {
      this.live("mouseover", function() {
         if (!$(this).data("init")) {
            $(this).data("init", true).draggable(opts);
         }
      });
   };
}(jQuery));

var AdminLink = (URLS['Script'] + 'Administration/');
$(function () {

		ThemeClass.history = function (windowid, url, title, state) {
			if (typeof history.pushState === 'undefined') {
				//state.className = 'fail';
			} else {
				if (!isset(state)) {
					state = $(windowid).data("xv-state");
					title = $(windowid).data("xv-statetitle");
				} else {
					$(windowid).data("xv-state", state);
					$(windowid).data("xv-statetitle", title);
				}
				history.pushState(state, title, url);
			}
		};
		
		$(".xv-get-window").live('click', function () {
				ThemeClass.GetWindow($(this).attr("href").substr(AdminLink.length));
				return false;
			});
		
		$(".xv-window-close").live('click', function () {
				$(this).parents('.app-window').hide("fold", function () {
						$(this).remove();
						ThemeClass.history("#none", URLS['Script'] + "Administration/" + $(this).data("xv-url"), "XVweb::Backstage", {
								foo : "bar"
							});
						ThemeClass.RefreshDock();
					}, 1000);
				return false;
			});
		
		$(".xv-window-minimalize").live('click', function () {
				$(this).parents('.app-window').hide("fold", {}, 1000);
				ThemeClass.RefreshDock();
				return false;
			});
		
		$('.xv-return-false').live('click', function () {
				return false;
			});
		
		var ResizeHistory = new Array()
			$(".xv-window-resize").live('click', function () {
					if (window.innerWidth + 'px' == $(this).parents('.app-window').css('width')) {
						var TMpVAR = ResizeHistory[$(this).parents('.app-window').attr('id')];
						$(this).parents('.app-window').animate({
								width : TMpVAR[0],
								height : TMpVAR[1],
								top : TMpVAR[2],
								left : TMpVAR[3]
							}, 800, function () {
								// Animation complete.
							});
						
						return false;
					}
					ResizeHistory[$(this).parents('.app-window').attr('id')] = new Array($(this).parents('.app-window').css('width'), $(this).parents('.app-window').css('height'), $(this).parents('.app-window').css('top'), $(this).parents('.app-window').css('left'));
					$(this).parents('.app-window').animate({
							width : window.innerWidth,
							height : window.innerHeight - 20,
							top : 0,
							left : 0
						}, 800, function () {
							// Animation complete.
						});
					return false;
				});
		
		/* AjaxPager */
		$(".xv-pager a").live('click', function () {
				var TTHandle = this;
				$(TTHandle).parents(".app-window .content *").css("opacity", 0.8);
				var jqxhr = $.getJSON(AdminLink + 'get/' + $(TTHandle).parents(".app-window").data("xv-url") + $(TTHandle).attr('href'), function (json) {
							if (json.error) {
								alert("Error with " + command);
							} else {
								$(TTHandle).parents(".content").html(json.content);
								if (typeof history.pushState === 'undefined') {
									//state.className = 'fail';
								} else {
									var stateObj = {
										foo : "bar"
									};
									history.pushState(stateObj, $(TTHandle).parents(".app-window").find(".xv-title").text(), $(TTHandle).attr('href'));
								}
								ThemeClass.RefreshWindows();
							}
						}).error(function (data, textStatus) {
							alert("error : " + print_r(textStatus));
						});
				return false;
			});
		/* /AjaxPager */
		$('.xv-form').live('submit', function () {
				var TFHandle = this;
				$.ajax({
						type : $(TFHandle).attr('method').toUpperCase(),
						url : $(TFHandle).attr('action'),
						dataType : "text",
						data : $(TFHandle).serialize(),
						success : function (data) {
							$(TFHandle).parents(".app-window").find($(TFHandle).data('xv-result')).html(data);
						}
					});
				return false;
			});
			
		$(".xv-toggle").live("click", function(){
			$($(this).data("xv-toggle")).toggle('slow');
		});
		
		$(".xv-close-all-windows").live('click', function () {
				$('.app-window').hide("fold", function () {
						$(this).remove();
						ThemeClass.RefreshDock();
					}, 1000);
				return false;
			});
		$(".app-window").live('click', function () {
				if($(this).data("xv-w-selected") != "true"){
				$(".app-window").data("xv-w-selected", "false");
				$(this).data("xv-w-selected", "true");
				ThemeClass.history(this, URLS['Script'] + "Administration/" + $(this).data("xv-url"));
				$("title").html($(this).find(".xv-title").text());
				$(".dock .reflection").removeClass("dock-selected");
				$(".dock #dock-" + $(this).attr("id") + " .reflection").css("opacity", "1").addClass("dock-selected");
				$(".app-window").css("z-index", 10);
				$(this).css("z-index", 40);
				}
			});
		
		
		$('.datepicker').live('click', function() {
			$(this).datepicker({showOn:'focus', dateFormat : "yy-mm-dd 00:00:00"}).focus();
		});

		$('.app-window').liveDraggable({
				handle : ".titlebar",
				start : function (event, ui) {
					$(this).click();
				}
			});
		

	
		ThemeClass.RefreshWindows = function () {
			$(".app-window").resizable("destroy").resizable({
					ghost : true
				});
			ThemeClass.RefreshDock();
		};
		ThemeClass.RefreshDock = function () {
			$(".dock ul li").remove();
			$(".app-window").each(function () {
					var THandle = this;
					$(".dock ul").append($('<li class="app" id="dock-' + $(this).attr("id") + '" data-window-id="' + $(this).attr("id") + '">'
							 + '<a href="#dock-addressbook" onclick="return false;">'
							 + '<div class="icon">'
							 + '<div class="label">'
							 + '<em>' + $(this).find('.xv-title').text() + '</em>'
							 + '<span class="pointer"></span>'
							 + '</div>'
							 + '<img src="' + $(this).data("icon") + '" alt="' + $(this).find('.xv-title').text() + '">'
							 + '</div>'
							 + '<div class="indicator"></div>'
							 + '</a>'
							 + '<div class="reflection">'
							 + '<img src="' + $(this).data("icon") + '">'
							 + '</div>'
							 + '</li>').click(function () {
								if ($("#" + $(this).data("window-id")).is(':hidden')) {
									$(".app-window").css("z-index", 10);
									$("#" + $(this).data("window-id")).css("z-index", 20).show("fold", {}, 1000);
								} else {
									$("#" + $(this).data("window-id")).hide("fold", {}, 1000);
								}
								//	$("#"+$(this).data("window-id")).click().effect("shake", { times:3 }, 100);
								
								//$(this).effect("shake", { times:3 }, 1000);
							}));
				});
		};
		
		ThemeClass.GetWindow = function (command) {
			
			var jqxhr = $.getJSON(AdminLink + 'get/' + command, {
						random : Math.round(new Date().getTime())
					}, function (json) {
						if (json.error) {
							alert("Error with " + command);
						} else {
							if ($("#" + json.id).length) {
								$("#" + json.id).click().effect("shake", {
										times : 3
									}, 100);
							} else {
								var Window = $('<div id="' + ifsetor(json.id, "") + '" class="app-window ' + ifsetor(json.addClass, "") + '" data-xv-url="' + ifsetor(json.URL, "") + '" ' + ifsetor(json.attributes, "") + ' style="' + ifsetor(json.style, "") + '" data-icon="' + ifsetor(json.icon, "") + '"> '
										 + '<div class="titlebar">'
										 + '<span class="xv-title">' + ifsetor(json.title, "") + '</span>'
										 + '<div style="float:right; margin-right:10px;" class="ui-state-default ui-corner-all ui-state-hover">'
										 + '<a href="#minimalize" class="ui-icon ui-icon-extlink xv-window-resize" style="float:left"></a>'
										 + '<a href="#minimalize" class="ui-icon ui-icon-circle-minus xv-window-minimalize" style="float:left"></a>'
										 + '<a href="#close" class="ui-icon ui-icon-circle-close xv-window-close" style="float:left"></a>'
										 + '</div>'
										 + '</div> '
										 + '<div class="content ' + ifsetor(json.contentAddClass, "") + '" style="' + ifsetor(json.contentStyle, "") + '" ' + ifsetor(json.contentAttributes, "") + '> '
										+ifsetor(json.content, "")
										 + '</div> '
										 + '<div style="clear:both;"></div>'
										 + '</div> ');
								
								$("#xv-windows").prepend(Window);
								ThemeClass.RefreshWindows();
								$("#" + json.id).click();
							}
						}
					}).error(function (data, textStatus) {
						alert("error : " + print_r(textStatus));
					});
		};
		ThemeClass.RefreshWindows();
		
		$('.xv-minimalize-all').live("click", function () {
				$('.xv-window-minimalize').click();
				return false;
			});
		
		ThemeClass.SetUserConfig = function (json) {
			$.ajax({
					url : AdminLink + 'Get/Options/SetConfig/?xv-sid='+SIDUser,
					dataType : 'json',
					type : "POST",
					data : json,
					success : function (data) {
						UserConfig = data.result;
					},
					error : function () {
						alert("Error!");
					}
				});
			return true;
		};
		if (typeof UserConfig['administration']['background'] === 'undefined')
			$("html").css("background-image", 'url(' + URLS['Theme'] + 'backgrounds/dark.png)');
		else
			$("html").css("background-image", UserConfig.administration.background);
		
		$(".xv-status").bind("ajaxSend", function (a, b, c) {
			
			
				$(this).find(".xv-status-text").html("Loading...  " + c.url);
				if(c.url.indexOf("xv-hide") < 1) {
					$(this).show("slow");
				}
			}).bind("ajaxComplete", function () {
				$(this).hide("slow");
			});
		
		if ((location.href.substr(AdminLink.length)).length > 1)
			ThemeClass.GetWindow(location.href.substr(AdminLink.length));
		
		window.addEventListener("popstate", function callback1(event) {
				var currentState = history.state;
				//  alert(print_r(currentState));
			}, true);
			
			$(".xv-enlarge").click(function(){
					  var obecnyRozmiar = $('html').css('font-size');
					var obecnyRozmiarNum = parseFloat(obecnyRozmiar, 10);
					var nowyRozmiar = obecnyRozmiarNum+1;
					$('html').css('font-size', nowyRozmiar);
			});	
			$(".xv-reduce").click(function(){ // optimize with ^^ .. todo
					  var obecnyRozmiar = $('html').css('font-size');
					var obecnyRozmiarNum = parseFloat(obecnyRozmiar, 10);
					var nowyRozmiar = obecnyRozmiarNum-1;;
					$('html').css('font-size', nowyRozmiar);
			});
	});
 