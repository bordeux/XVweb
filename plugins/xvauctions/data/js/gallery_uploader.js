/***************************************************************************
****************   xvAuctions Project              *************************
****************   LICENSE IS HERE                 *************************
****************   http://xvauctions.bordeux.net/  *************************
****************   THIS IS NON-FREE aplication!    *************************
****************   Author  : Krzysztof Bednarczyk  *************************
****************   All rights reserved             *************************
***************************************************************************/

  $(function(){
	var actaul_files_count = 0;
		$(".xva-gallery-drop").html5_uploader().bind("html5_uploader.dragenter", function(){
			$(this).addClass("xva-gallery-drop-hover");
		}).bind("html5_uploader.dragleave html5_uploader.drop", function(){
			$(this).removeClass("xva-gallery-drop-hover");
		}).bind("html5_uploader.drop", function(evt, files, files_count){
				var $gallery_list_parent = $(this).parents(".xvauction-add-item");
				actaul_files_count = $gallery_list_parent.find(".xvauction-gallery-list .xvauction-gallery-file").length;
				var $gallery_template = $gallery_list_parent.find(".xvauction-gallery-list-template .xvauction-gallery-file").clone();
				$.each(files, function(index, value){
					//console.log(value.getAsFile());
					var $gallery_file = $gallery_template.clone();
					$gallery_file.find(".xvauction-gallery-file-details h1").text(value.name);
					$gallery_file.find(".xvauction-gallery-file-details-filesize").text(Math.round(value.size/1024));
					$gallery_file.find(".xvauction-gallery-file-details-type").text(value.type);
					$gallery_file.find( ".xvauction-gallery-file-progress div" ).progressbar({
						value: 0
					});
					var reader = new FileReader();
						  reader.onload = (function(theFile) {
							return function(e) {
							var $gallery_image = $gallery_file.find( ".xvauction-gallery-file-img img");
							$gallery_image.attr("src", e.target.result).attr("title", escape(theFile.name));
							
							$gallery_image[0].onload = function(){
								var canvas = document.createElement('canvas');
								canvas.width = 100;
								canvas.height = 100;

								var ctx = canvas.getContext("2d");
								ctx.drawImage(this, 0, 0, 100, 100);
								
								this.src= canvas.toDataURL(theFile.type);
							};
							 
							};
						  })(value);
						  reader.readAsDataURL(value);
    
					$gallery_list_parent.find(".xvauction-gallery-list").append($gallery_file);
					
				});
			$(this).trigger('html5_uploader.send', [{
				url : $(this).data("upload-url")
			}]);
			
		}).bind("html5_uploader.start", function(evnt, files_count){
			//$(".log").prepend("<div>Event: start , Start upload "+files_count+" files</div>");
		}).bind("html5_uploader.finish", function(evnt, files_count){
			//$(".log").prepend("<div>Finished upload</div>");
		}).bind("html5_uploader.start_one", function(evnt, file_name, file_number, total){
			//$(".log").prepend("<div class='progres-bar'><div></div></div><div>Event: start_one, Start upload file "+file_name+" with no. "+file_number+", total "+total+"</div>");
		}).bind("html5_uploader.finish_one", function(evnt, response_server, file_name, file_number, total){
			var $gallery_list_parent = $(this).parents(".xvauction-add-item");
			$gallery_list_parent.find(".xvauction-gallery-list .xvauction-gallery-file:eq("+(file_number+actaul_files_count)+") .xvauction-gallery-file-progress" ).replaceWith(response_server);
		//$(".log").prepend("<div>Event: finish_one, Finished upload file "+file_name+" with no. "+file_number+", total "+total+", server response "+response_server+"</div>");
		}).bind("html5_uploader.error", function(evnt,  file_name, e){
			//$(".log").prepend("<div>Event: error, Error file "+file_name+" , error detail "+e+"</div>");
		}).bind("html5_uploader.old_browser", function(evnt){
		//$(".log").prepend("<div>Event: old_browser, You have old browser</div>");
		}).bind("html5_uploader.abort", function(evnt){
			//$(".log").prepend("<div>Event: abort</div>");
		}).bind("html5_uploader.progress", function(evnt, uploaded, fileSize, fileName, number, total){
			var $gallery_list_parent = $(this).parents(".xvauction-add-item");
			$gallery_list_parent.find(".xvauction-gallery-list .xvauction-gallery-file:eq("+(number+actaul_files_count)+") .xvauction-gallery-file-progress div" ).progressbar( "option", "value", Math.round((uploaded/fileSize)*100) );
		});
		$(".xvauction-gallery-file-delete").live("click", function(){
			$.get($(this).attr('href'));
			$(this).parents(".xvauction-gallery-file").hide("slow", function(){
				$(this).remove();
			})
			return false;
		});

	});