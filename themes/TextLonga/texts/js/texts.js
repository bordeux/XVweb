var xv_texts = {};
xv_texts.load_list = function(l_parent){
	$.post(URLS.Script+'api/texts/texts/json', { "get_categories": '["'+(l_parent)+'"]' },
			 function(data) {
				$(".xv-texts-category-list").html('');
				$(".xv-texts-category-list").append($("<a>").attr("href", '/').text('.'));
				$(".xv-text-selected-category").text(l_parent);
				$(".xv-texts-category-form-category").val(l_parent);
				$.each(data.get_categories.result, function(key, val){
					$(".xv-texts-category-list").append($("<a>").attr("href", val.URL).text(val.Title));
				});
			 });
};
$(function(){
	$(".xv-texts-category-list a").live("click", function(){
			xv_texts.load_list($(this).attr("href"));
		return false;
	});

	xv_texts.load_list($(".xv-text-selected-category").text());
	$(".xv-texts-title-input").change(function(){
		$.post(URLS.Script+'api/texts/texts/json', { "convert_title_to_url": '["'+($(this).val())+'"]' },
			 function(data) {
			  $(".xv-texts-url span").text(data.convert_title_to_url.result);

			 });
	
	}).change();
});