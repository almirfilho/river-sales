<?php
	$options = array(
		'class' => 'submit cancel',
		'title' => 'clique para cancelar'
	);
	
	if( !empty( $cancel ) )
		$options[ 'alt' ] = $this->Html->url( $cancel );
	

	if( !empty( $cancelRedirect ) )
		$options[ 'alt' ] = $this->Html->url( $cancel[ $cancelRedirect ] );

 	print $this->Form->submit( "SALVAR", array( 'class' => 'submit spinner' ) );
	print $this->Form->submit( "CANCELAR", $options )
?>