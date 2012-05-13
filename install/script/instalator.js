$(document).ready(init);

function init() {
	/* ========== DRAWING THE PATH AND INITIATING THE PLUGIN ============= */

	$.fn.scrollPath("getPath")
		// Move to 'start' element
		.moveTo(400, 50, {name: "start"})
		// Line to 'license' element
		.lineTo(400, 800, {name: "license"})
		/*
		// Continue line to 'scrollbar'
	
		// Line to 'rotations'
		.lineTo(2400, 750, {
			name: "rotations"
		})
		// Rotate in place
		.rotate(3*Math.PI/2, {
			name: "rotations-rotated"
		})
		// Continue upwards to 'source'
		.lineTo(2400, -700, {
			name: "source"
		})
		// Small arc downwards
		.arc(2250, -700, 150, 0, -Math.PI/2, true)

		//Line to 'follow'
		.lineTo(1350, -850, {
			name: "follow"
		})*/
		// Arc and rotate back to the beginning.
	//.arc(1300, 50, 900, -Math.PI/2, -Math.PI, true, {rotate: Math.PI*2, name: "end"});

	// We're done with the path, let's initate the plugin on our wrapper element
	$(".wrapper").scrollPath({drawPath: true, wrapAround: false});


	$('.yes-no a:first').one("click", function(){
		$(this).replaceWith('YES');
		$('.yes-no a:last').hide("slow");
		$.fn.scrollPath("getPath")
		.lineTo(600, 1600, {
			callback: function() {
				
			},
			name: "db-server"
		});
		$('.db-server').show('slow');
		$.fn.scrollPath("scrollTo", "db-server", 1000, "easeInOutSine");
	});
	
	$(".db-server a").one("click", function(){
		$.fn.scrollPath("getPath").lineTo(600, 2300, {
			callback: function() {
			
			},
			name: "db-name"
		});
		$('.db-name').show('slow');
		$.fn.scrollPath("scrollTo", "db-name", 1000, "easeInOutSine");
	});		
	
	$(".db-name a").one("click", function(){
		$.fn.scrollPath("getPath").lineTo(1750, 1600, {
			callback: function() {
			
			},
			name: "db-user"
		});
		$('.db-user').show('slow');
		$.fn.scrollPath("scrollTo", "db-user", 1000, "easeInOutSine");
	});	
	
	$(".db-user a").one("click", function(){
		$.fn.scrollPath("getPath").lineTo(2400, 750, {
			name: "db-password"
		});
		$('.db-password').show('slow');
		$.fn.scrollPath("scrollTo", "db-password", 1000, "easeInOutSine");
	});	
	$(".db-password a").one("click", function(){
		$.fn.scrollPath("getPath").lineTo(2400, -700, {
			name: "db-prefix"
		});
		$('.db-prefix').show('slow');
		$.fn.scrollPath("scrollTo", "db-prefix", 1000, "easeInOutSine");
	});	
	$(".db-prefix a").one("click", function(){
		$.fn.scrollPath("getPath").lineTo(1250, -850, {
			name: "mail"
		});
		$('.mail').show('slow');
		$.fn.scrollPath("scrollTo", "mail", 1000, "easeInOutSine");
	});	
	$(".mail a").one("click", function(){
		$.fn.scrollPath("getPath").lineTo(250, -850, {
			name: "install"
		});
		$('.install').show('slow');
		$.fn.scrollPath("scrollTo", "install", 1000, "easeInOutSine");
	});
	$(".install a").bind("click", function(){
		instalator_get_status();
		$.post("install_script.php", $("#xv-install-form").serialize());
		$.fn.scrollPath("getPath").lineTo(-1100, -150, {
			name: "status"
		});
		$('.status').show('slow');
		$.fn.scrollPath("scrollTo", "status", 1000, "easeInOutSine");
	});
	
	var instalator_get_status = function(){
		$.get('status.txt?rand='+Math.random(), function(data) {
			  $('#xv-install-status').val(data);
				if(data.search("--END--") < 1){
					setTimeout(instalator_get_status,500);
				};
			});
	};
};

