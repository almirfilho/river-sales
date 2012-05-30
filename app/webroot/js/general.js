$(document).ready( function(){
	
	$('.round, input.submit').corner('6px');
	
	$('input.cancel').click( function( event ){
		
		event.preventDefault();
		
		if( $(this).attr('alt') != "" )
			window.location = $(this).attr('alt');
	});
	
	$('form.form').submit( function(event){
		
		$('input:submit').attr( 'disabled', 'disabled' ).addClass( 'disabled' );
		var w = $(this).find('input.spinner').css('width');
		$(this).find('input.spinner').val('').addClass('on').css( 'width', w );
	});
});