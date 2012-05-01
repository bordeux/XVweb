$(function(){
	function handleFileSelect(evt) {
		var files = evt.target.files; // FileList object
		var f = files[0];
		if (!f.type.match('image.*')){
			alert("Invalid file type");
			return;
		}
		
			var reader = new FileReader();
			reader.onload = (function(theFile) {
				return function(e) {
					$(".xv-user-avatar-worker").html('<table><tr><td class="xv-user-avatar-orginal"></td><td>Preview:<br /><canvas id="xv-user-avatar-preview"></canvas></td><td><input type="submit" value="Save" /></td></tr></table>');
				
					$("<img/>") // Make in memory copy of image to avoid css issues
						.attr("src", e.target.result).attr("id" , "xv-user-avatar-orginal-img").bind("load", function () {
							$(this).width(this.width);
							$(this).height(this.height);
							
							if(this.width > 605){
								var r_canvas = document.createElement('canvas');
								var r_context = r_canvas.getContext("2d");
								var scale_x = 600/this.width;
								r_canvas.height=this.height*scale_x;
								r_canvas.width=this.width*scale_x;
								r_context.drawImage(this, 0, 0, this.width, this.height, 0, 0, r_canvas.width, r_canvas.height);
								
								$(this).attr("src", r_canvas.toDataURL("image/png"));
								
								return true;
							}
							
						$(this).appendTo(".xv-user-avatar-orginal");
						var updatePreview = function (c) {
							if(parseInt(c.w) > 0) {
								var img_obj2 = $("#xv-user-avatar-orginal-img");
								var imageObj = img_obj2[0];
								var canvas = $("#xv-user-avatar-preview")[0];
								canvas.width = canvas.width;
								var context = canvas.getContext("2d");
								context.drawImage(imageObj, c.x, c.y, c.w, c.h, 0, 0, canvas.width, canvas.height);
							}
						};

						$('#xv-user-avatar-orginal-img').Jcrop({
							onChange : updatePreview,
							onSelect : updatePreview,
							aspectRatio : 1
						});
						

					});;
						
						
					
						
	
				};
			  })(f);
			  
			reader.readAsDataURL(f);
			
	
		/*// files is a FileList of File objects. List some properties.
		var output = [];
		for (var i = 0, f; f = files[i]; i++) {
		  output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ') - ',
					  f.size, ' bytes, last modified: ',
					  f.lastModifiedDate ? f.lastModifiedDate.toLocaleDateString() : 'n/a',
					  '</li>');
		}
    document.getElementById('list').innerHTML = '<ul>' + output.join('') + '</ul>';*/
  }
  document.getElementById('xv-users-avatar').addEventListener('change', handleFileSelect, false);
$(".xv-user-avatar-form").submit(function(){
	var canvas = $("#xv-user-avatar-preview")[0];
	
	$(".xv-user-avatar-worker").append("<input type='hidden' name='xv_user_avatar_data' value='"+canvas.toDataURL("image/png")+"' />")
	return true;
});
});