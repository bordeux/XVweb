var ThemeClass = {};
function addParameterToURL(urlScr, param) {
	_url = urlScr;
	_url += (_url.split('?')[1] ? '&' : '?') + param;
	return _url;
}

$(function () {
		ThemeClass.dialog = {
			create : function (options) {
				options = jQuery.extend({
							content : "",
							onClose : function (a, b, c) {
								console.log(a);
								return true;
							}
							
						}, options);
				$(".xv-dialog").remove();
				boxHandle = $(".xvlogin").addClass("xvlogin-fixed");
				toSetContent = $("<div>").attr({
							"class" : "xv-dialog",
						}).css({
							"display" : "none"
						}).html(options.content);
				
				boxHandle.find(".xvlogin-boxes").append(toSetContent);
				toSetContent.show("slow");
				
				boxHandle.find(".xvshow").click(function () {
						if (options.onClose(this, boxHandle, toSetContent)) {
							ThemeClass.dialog.close();
						};
						return true;
					});
				
				return {
					hantle : toSetContent,
					close : function () {
						ThemeClass.dialog.close();
						return true;
					}
				};
			},
			confirm : function (coptions) {
				coptions = jQuery.extend({
							q : "?????",
							yes : function () {
								return false;
							},
							no : function () {
								return false;
							},
							labelYes : "Tak",
							labelNo : "Nie"
							
						}, coptions);
				
				ctemplate = $('<div class="xv-dialog-confirm" style="padding-top:10px; padding-bottom:10px; width: 600px; margin:auto;">'
						 + '<div class="ui-state-highlight ui-corner-all" style="padding: 5px;"> '
						 + '<div style="text-align:center;"><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>'
						 + '<span class="xv-confirm-question">Sample question</span></div>'
						 + '<div style="text-align:center; padding-top:10px;"><input type="submit" name="yes" value="' + coptions.labelYes + '" style="margin-right:10px;"  class="xv-confirm-yes"/> <input type="submit" name="no" value="' + coptions.labelNo + '" style="margin-left:10px;" class="xv-confirm-no" /> </div>'
						 + '</div>'
						 + '</div>');
				
				ctemplate.find(".xv-confirm-question").html(coptions.q);
				ctemplate.find(".xv-confirm-form").submit(function () {
						return false;
					});
				ctemplate.find(".xv-confirm-yes").click(function (event) {
						resiltGet = coptions.yes();
						if (resiltGet === false) {
							confirmr.close();
						} else {
							$('.xv-dialog-confirm').html(resiltGet);
						}
						return false;
					});
				ctemplate.find(".xv-confirm-no").click(function (event) {
						resiltGet = coptions.no();
						if (resiltGet === false) {
							confirmr.close();
						} else {
							$('.xv-dialog-confirm').html(resiltGet);
						}
						//$('.xv-dialog-confirm').fadeTo(350, 0.1, function () {
						//	$(this).fadeTo(350, 1).html(coptions.no());
						//});
						return false;
					});
				
				var confirmr = ThemeClass.dialog.create({
							content : ctemplate
						});
				
			},
			close : function () {
				$(".xv-dialog").hide("slow", function () {
						$(this).remove();
					});
			}
			
		};
		
		$("h1").click(function () {
				//	test = ThemeClass.dialog.confirm({
				//		//content : "asdas"
				//	});
				//alert(test.close());
				//	return false;
			});
		
		ThemeClass.ValidateUser = function (a) {
			$.getJSON(URLS.Script + "receiver/IssetUser?User=" + encodeURIComponent($(a).val()), function (b) {
					b.Isset == true ? $(a).css({
							background : "url(" + URLS.Theme + "img/error.png) #EF7777 no-repeat top right",
							border : "1px solid #FF0000"
						}) : $(a).css({
							background : "url(" + URLS.Theme + "img/validate.png) #BEEF77 no-repeat top right",
							border : "1px solid #7BBF17"
						})
				});
		};
		function isset(a) {
			return typeof a == "undefined" ? false : true
		}
		ThemeClass.LoadLang = function (a, b) {
			ThemeClass.LoadJS(URLS.Script + "receiver/language.js?include=" + a, b)
		};
		ThemeClass.LoadJS = function (a, b) {
			$("#progressID").html("<img src='" + URLS.Theme + "img/progress.gif' alt='Progress' /> " + Language.Loading + ": " + a);
			$("#progressID").show();
			$.getScript(a, function () {
					b();
					$("#progressID").hide("slow");
					$("#progressID").text("")
				})
		};
		
		$(".xvshow").live("click", function () {
				var XVHideSpeed = 500;
				var talias = this;
				if (isset($(talias).attr('data-tohide')))
					$($(talias).attr('data-tohide')).hide(XVHideSpeed);
				else {
					$($(talias).attr('data-toshow')).show('slow');
					return false;
				}
				
				if (isset($(talias).attr('data-toshow')))
					setTimeout(function () {
							$($(talias).attr('data-toshow')).show('slow');
						}, (XVHideSpeed + 1));
				return false;
			});
		$(".xv-tab").live("click", function () {
				$(this).attr('rel');
				$(".xv-tab").each(function (index) {
						$("#" + $(this).attr('rel')).hide();
						$(this).parent().removeClass("ui-state-active").addClass("ui-state-default");
					});
				$("#" + $(this).attr('rel')).show();
				$(this).parent().removeClass("ui-state-default").addClass("ui-state-active");
				
			}).hover(function () {
				if (!$(this).hasClass("ui-state-active"))
					$(this).parent().addClass("ui-state-hover");
				
			},
			function () {
				$(this).parent().removeClass("ui-state-hover")
			});
		$(".xv-tab:first").click();
		
		$('.xvlogin-register-captcha-refresh').click(function () {
				$($(this).attr('data-captcha')).attr('src', $($(this).attr('data-captcha')).attr('src') + '1');
				return false;
			});
		$('.xvlogin-register-form').submit(function () {
				$.ajax({
						url : addParameterToURL($(this).attr('action'), 'ajax=true'),
						dataType : 'script',
						type : "POST",
						data : $(this).serialize(),
						cache : false,
						success : function () {
							//alert("ok");
						}
					});
				return false;
			});
		$('#EditPanel ul li a').click(function () {
				$('#EditPanel ul li a').removeClass('selected');
				$(this).addClass("selected");
				return true;
			});
		$(document).keyup(function (a) {
				switch (a.keyCode) {
				case 46:
					ThemeClass.DeleteBind();
					break;
				};
			});
		var IDCheckbox = 0;
		$(".xv-checkbox").each(function () { // kurwa chujstwo jebane nie chce za chuja dzialac!
				tHandle = this;
				$(tHandle).attr("id", "xv-checkbox-" + IDCheckbox); // tutaj bugg!
				IDCheckbox += 1;
				$(tHandle).after(function () {
						var ToResult = $("<div>").attr("class", "iswitch").append(
								$("<label>").attr({
										"for" : $(tHandle).attr("id"),
										"class" : "cb-enable"
									}).html("<span>" + Language.Yes + "</span>")).append(
								$("<label>").attr({
										"for" : $(tHandle).attr("id"),
										"class" : "cb-disable"
									}).html("<span>" + Language.No + "</span>"));
						if ($(tHandle).is(':checked')) {
							$(ToResult).find('.cb-enable').addClass("selected");
						} else {
							$(ToResult).find('.cb-disable').addClass("selected");
						}
						$(tHandle).hide();
						return ToResult;
					});
			});
		
		$(".cb-enable, .cb-disable").click(function () {
				ChHantle = $("#" + $(this).attr("for"));
				
				if ($(this).is('.cb-enable')) {
					if(ChHantle.is(":checked")){
						$(this).parent().find(".selected").removeClass("selected");
						$(this).addClass("selected");
						return false	
					}else{
							$(this).parent().find(".selected").removeClass("selected");
							$(this).addClass("selected");
					}
				} else {
					if(!ChHantle.is(":checked")){
						return false;
					}else{
							$(this).parent().find(".selected").removeClass("selected");
							$(this).addClass("selected");
					}
				}
				
				return true;
			});
		$('.xv-form').live("submit", function () {
				var TFHandle = this;
				$.ajax({
						type : $(TFHandle).attr('method').toUpperCase(),
						url : $(TFHandle).attr('action'),
						data : $(TFHandle).serialize(),
						success : function (data) {
							$($(TFHandle).data('xv-result')).html(data);
						}
					});
				return false;
			});
		
		$(".xv-confirm-link").click(function () {
				thandle = this;
				test = ThemeClass.dialog.confirm({
							q : $(thandle).data("xv-question"),
							yes : function () {
								location.href = $(thandle).attr("href");
								return true;
							}
						});
				return false;
			});
		//xv-logout
		
		spamBotSecruity = function () {
			$(".xv-comment-spambot-field").val($(".xv-comment-spambot-key").first().text());
			$(document.body).unbind('click', spamBotSecruity);
			$(".xv-comment-spambot").hide();
		};
		$(document.body).bind('click', spamBotSecruity);
		
		$(document.body).ajaxError(function (event, request, settings) {
		if(request.status == 200)
			return true;
				ThemeClass.dialog.create({
						content : "<div class='error'> Error requesting page " + settings.url + " , status: <b>" + request.status + "</b></div>"
					});
			});
			
		
			if(typeof _gaq != "undefined"){
				$("a").live("click", function(){
				
			var ParentMap = $(this).parents().map(function () { 
                  return this.tagName+"["+$(this).attr("class")+"]"; 
                }).get().join(">");
			
					_gaq.push(['_trackEvent', 'Clicks', 'Anchors', location.href + " - "+ $(this).attr("href")+" - "+ParentMap]);
				});
				
				$('img').error(function() {
					_gaq.push(['_trackEvent', 'Images', 'unLoad', location.href +" - "+$(this).attr("src")]);
				  });
				 window.onerror = function(msg, url, line){
					_gaq.push(['_trackEvent', 'Window', 'domError', ("MGS: "+msg+" - Line: "+line +" , URL: "+ url)]);
				};
			};
	});
 