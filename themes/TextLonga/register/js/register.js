$(function(){
	$("input[name='xv-register[password]']").pwdstr('.xv-register-time');
	$('input[name="xv-register[rpassword]"]').bind('keyup', function() {
		if($("input[name='xv-register[password]']").val() === $(this).val()){
			$(this).css("border-color", "#00B303");
		}else{
			$(this).css("border-color", "#BF0202");
		}
	} );
});