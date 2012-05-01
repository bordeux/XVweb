 $(function(){
		$(".xv-plugin-uploader").html5_uploader().bind("html5_uploader.dragenter", function(){
		
			$(this).addClass("xv-plugin-uploader-hover");
			
		}).bind("html5_uploader.dragleave html5_uploader.drop", function(){
		
			$(this).removeClass("xv-plugin-uploader-hover");
			
		}).bind("html5_uploader.drop", function(evt, files, files_count){
		
			$(this).trigger('html5_uploader.send', [{
				url : URLS['Site']+"Administration/get/Plugins/Upload/?xv-sid="+SIDUser
			}]);
			
		}).bind("html5_uploader.start", function(evnt, files_count){
	
			$(".xv-plugin-uploader-result").css("overflow-y", "scroll").prepend("<div class='success'>Start upload "+files_count+" files</div>");
			
		}).bind("html5_uploader.finish", function(evnt, files_count){
		
			$(".xv-plugin-uploader-result").prepend("<div class='success'>Uploading finished</div>");
			
		}).bind("html5_uploader.start_one", function(evnt, file_name, file_number, total){
		
			$(".log").prepend("<div class='progres-bar'><div></div></div><div>Event: start_one, Start upload file "+file_name+" with no. "+file_number+", total "+total+"</div>");
			
		}).bind("html5_uploader.finish_one", function(evnt, response_server, file_name, file_number, total){
			
			$(".xv-plugin-uploader-result").prepend(response_server);
			
		}).bind("html5_uploader.error", function(evnt,  file_name, e){
			$(".xv-plugin-uploader-result").prepend("<div class='error'>Event: error, Error file "+file_name+" , error detail "+e+"</div>");

		}).bind("html5_uploader.old_browser", function(evnt){
			$(".xv-plugin-uploader-result").prepend("<div class='error'>Event: old_browser, You have old browser</div>");
		}).bind("html5_uploader.abort", function(evnt){
			$(".xv-plugin-uploader-result").prepend("<div class='error'>Event: abort</div>");
		}).bind("html5_uploader.progress", function(evnt, uploaded, fileSize, fileName, number, total){
		
			$(".log .progres-bar div").css("width",Math.round((uploaded/fileSize)*100)+"%" ).text("Progress "+ uploaded +" / "+ fileSize +"  - "+Math.round((uploaded/fileSize)*100)+"%");
			
		});
	});