$(function(){
	$("input[name='xv_register[password]']").pwdstr('.xv-register-time');
	$('input[name="xv_register[rpassword]"]').bind('keyup', function() {
		if($("input[name='xv_register[password]']").val() === $(this).val()){
			$(this).css("border-color", "#00B303");
		}else{
			$(this).css("border-color", "#BF0202");
		}
	} );
});