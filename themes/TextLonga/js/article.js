ThemeClass.Wykop = function () {
	var wykop_url = encodeURIComponent(location.href);
	var wykop_title=encodeURIComponent(document.title);
	var wykop_desc = encodeURIComponent('Przykładowy opis');
	var widget_bg = 'DAD9D9';
	var widget_type = 'compact';
	var widget_bold = true;
	var widget_url = 'http://www.wykop.pl/widget.php?url=' + (wykop_url) + '&title=' + (wykop_title) + '&desc=' + (wykop_desc) + '&bg=' + (widget_bg) + '&type=' + (widget_type) + '&bold=' + (widget_bold);
	return('<iframe src="' + widget_url + '" style="border:none;width:70px;height:20px;overflow:hidden;margin:0;padding:0;" frameborder="0" border="0"></iframe>');
};
ThemeClass.DeleteBind = function () {
	$('[href=#DeleteArticle]').click();
};

$(document).ready(function () {
		
		$(".vote").click(function () {
				var DivVote = this;
				$.getJSON($(this).attr("href") + "&json=true", {
						ajaxmethod : true
					}, function (data) {
						var ToAdd = data.modified;
						if (data.result) {
							$(DivVote).parent("div").find(".Votes").html(($(DivVote).hasClass('voteup') ? eval($(DivVote).parent("div").find(".Votes").text() + "+" + ToAdd) : eval($(DivVote).parent("div").find(".Votes").text() + "-" + ToAdd)));
							$(DivVote).fadeTo('slow', 0.3, function () {
									$(this).attr("href", "#").unbind("click").click(function () {
											return false;
										});
								});
						} else {
							alert(data.message) 
						}
					});
				return false;
			});
		
		if ($(".setvideo").size()) 
			ThemeClass.LoadJS(JSCatalog + "js/JSbinder.php?Load=swfobject:video");
		
	});
//********************* NEW ***************/

$(function () {
		$(".xv-article-addons").append(ThemeClass.Wykop());
		$(".WykopButton").html(ThemeClass.Wykop());
		
		$(".xv-delete-article").click(function () {
				thandle = this;
				test = ThemeClass.dialog.confirm({
						q : "Czy napewno chcesz usunąć artykuł pernamentnie?", 
						yes : function () {
							
							return $.ajax({
									dataType : "text", 
									data : "ajax=true", 
									url : $(thandle).attr("href"), 
									async : false
								}).responseText;
						}
					});
				//alert(test.close());
				return false;
			});
		
		$(".xv-delete-article-version").click(function () {
				thandle = this;
				test = ThemeClass.dialog.confirm({
						q : "Czy napewno chcesz usunąć ostatnią wersję artykułu?", 
						yes : function () {
							
							return $.ajax({
									dataType : "text", 
									data : "ajax=true", 
									url : $(thandle).attr("href"), 
									async : false
								}).responseText;
						}
					});
				//alert(test.close());
				return false;
			});
			
			$(".xv-delete-comment").live("click", function () {
				thandle = this;
				test = ThemeClass.dialog.confirm({
						q : "Czy napewno chcesz usunąć komentarz?", 
						yes : function () {
							
							return $.ajax({
									dataType : "text", 
									data : "ajax=true", 
									url : $(thandle).attr("href"), 
									async : false
								}).responseText;
						}
					});
				return false;
			});
		$(".xv-zoom").click(function () {
				//$(".xv-text-content *").css("font-size", $(this).data("xv-zoom")) wtf?
			});
		
		$(".xv-article-report").click(function () {
				ContantForm = $.ajax({
						dataType : "text", 
						data : "view=true", 
						url : $(this).attr("href"), 
						async : false
					}).responseText;
				
				var confirmr = ThemeClass.dialog.create({
						content : "<div style='width: 710px; margin:auto; padding-bottom: 30px;'>" + ContantForm + "</div>"
					});
				return false;
			});
			
			$(".xv-comment-form").submit(function(){
					$.ajax({
						url : addParameterToURL($(this).attr('action'), 'ajax=true') ,
						dataType : 'text', 
						type : "POST", 
						data : $(this).serialize(), 
						cache : false, 
						success : function (data) {
							$(".xv-comment-area").prepend(data);
							$(".xv-comment-form textarea").val("");
						}
					});
				return false;
			});
			$(".xv-edit-comment").live("click", function(){
					$.ajax({
						url : URLS.Script+"receiver/EC",
						dataType : 'text', 
						type : "GET", 
						data : "ajax=true&id="+$(this).data("xv-comment-id"), 
						cache : false, 
						success : function (data) {
							$(document.body).append(data);
						}
					});
				return false;
			})

		$(".xv-print-page").click(function(){
				window.open($(this).attr("href"), "PrintWindow", "width=400,height=500,resizable=0,scrollbars=yes,menubar=no").window.print()
			return false;
		});
		
	});

 