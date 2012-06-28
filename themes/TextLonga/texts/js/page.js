$(function(){
	$(".xv-texts-info-icon").click(function(){
		 $(this).parent().find('.xv-text-info-links').toggle('slow', function() {
			// Animation complete.
		  });
	});	
	$(".xv-texts-cat-caption").click(function(){
		 $(".xv-texts-cat-links").toggle('slow', function() {
			// Animation complete.
		  });
	});

});