$(function(){

	$('.column').sortable({
		connectWith: '.column',
		handle: '.movebutton',
		cursor: 'move',
		placeholder: 'placeholder',
		forcePlaceholderSize: true,
		opacity: 0.4,
		stop: function(event, ui){
			$(ui.item).find('h2').click();
			var sortorder='';
			$('.column').each(function(){
				var itemorder=$(this).sortable('toArray');
				var columnId=$(this).attr('id');
				sortorder+=columnId+'='+itemorder.toString()+'&';
			});
			alert('SortOrder: '+sortorder);
			/*Pass sortorder variable to server using ajax to save state*/
		}
	})
	.disableSelection();

});