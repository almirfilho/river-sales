<?php
	$this->Html->css( array( 'openlayers', 'openlayers.google' ), null, array( 'inline' => false ) );
	$this->Html->script( array( 'http://maps.google.com/maps/api/js?sensor=false', 'openlayers/lib/OpenLayers', 'map.saoluis' ), false );
?>

<script type="text/javascript">
<!--
$(document).ready( function(){
	
	$('#mapa').initMap( false, '' ).displayData([
		{name: 'Estabelecimentos', layer: 'estabelecimentos'},
		{name: 'Vendedores', layer: 'vendedores', visible: false}
	]);

});
-->
</script>

<div id="mapa" class="mapa-medium"></div>