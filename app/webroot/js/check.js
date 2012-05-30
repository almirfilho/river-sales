$(document).ready( function(){
	
	$('form.actions input.all').change( function(){
		
		$(this).parents('form.actions').find('input:checkbox').attr( 'checked', $(this).attr( 'checked' ) );
	});
});