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

$(document).ready(function () {
		
		if ($(".setvideo").size()) 
			ThemeClass.LoadJS(URLS['JSCatalog'] + "js/JSbinder.php?Load=swfobject:video");
		
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
			

		$(".xv-print-page").click(function(){
				window.open($(this).attr("href"), "PrintWindow", "width=400,height=500,resizable=0,scrollbars=yes,menubar=no").window.print()
			return false;
		});
		
	});

 