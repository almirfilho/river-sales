<?php
	$this->Html->css( array( 'jquery.datepicker', 'openlayers', 'openlayers.google' ), null, array( 'inline' => false ) );
	$this->Html->script( array( 'jquery.ui.datepicker.min', 'jquery.maskedinput.min', 'http://maps.google.com/maps/api/js?sensor=false', 'openlayers/lib/OpenLayers', 'map.saoluis' ), false );
	if( empty( $this->passedArgs[0] ) ) $this->passedArgs[0] = null;
	print $this->Form->create( "Visita", array( 'url' => array( 'controller' => 'visitas', "action" => "add", $this->passedArgs[0] ), "class" => "form" ) );
?>

<script type="text/javascript">
<!--
$(document).ready( function(){
	
	$('#VisitaHora').mask('99:99', { placeholder: '0' });
	
	$('#VisitaData').datepicker({
		dateFormat: 'dd/mm/yy', 
		dayNamesMin: [ 'Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'S&aacute;b' ],
		monthNames: [ 'Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro' ]
	});
		
	$('#mapa').initMap( true, 'Vendedor' );
	
	// marcacao de vendedor ---------------------------------------------------------------------------------
	
	var vendedorId = "<?= $this->passedArgs[0] ?>";
	var markVendedor;
	
	if( vendedorId != '' ){
		
		var vendedor = <?php empty( $vendedor[ 'Vendedor' ][ 'localizacao' ] ) ? print "''" : print "'{$vendedor['Vendedor']['localizacao']}'"; ?>;
		vendedor = vendedor.split(',');
		vendedor[0] = parseFloat( vendedor[0] );
		vendedor[1] = parseFloat( vendedor[1] )
		markers.addMarker( new OpenLayers.Marker( new OpenLayers.LonLat( vendedor[0], vendedor[1] ), icon ) );
		
	} else {
		
		$('#VisitaVendedorId').change( function( event ){

			if( $(this).val() != '' ){

				// recupera localizacao do estabelecimento selecionado e
				// adiciona marcador do estabelecimento selecionado
				$.ajax({
					url: <?= '"'.$this->Html->url( "/vendedores/getLocation/", true ).'"' ?> + $(this).val(),
					type: 'GET',
					dataType: "json",
					success: function( data, textStatus, XMLHttpRequest ){

						var coords = data.split(',');
						coords[0] = parseFloat( coords[0] );
						coords[1] = parseFloat( coords[1] )
						markVendedor = new OpenLayers.Marker( new OpenLayers.LonLat( coords[0], coords[1] ), icon );
						markers.addMarker( markVendedor );
					},
					error: function( XMLHttpRequest, textStatus ){

						alert("erro");
						alert( XMLHttpRequest.responseText );
					}
				});

			} else {

				// remove marcador
				markers.removeMarker( markVendedor );
			}
		});
	}
	
	// marcacao de estabelecimento --------------------------------------------------------------------------
	
	var markEstabelecimento;
	var estabelecimentos = new OpenLayers.Layer.Markers( "Estabelecimento" );
	map.addLayer( estabelecimentos );
	
	var iconEstabelecimento = new OpenLayers.Icon(
		'http://localhost/rivervendas/sistema/img/sistema.custom/marker_estabelecimento.png',
		new OpenLayers.Size( 39, 32 ),
		new OpenLayers.Pixel( -16, -36 )
	);
	
	$('#VisitaEstabelecimentoId').change( function( event ){
		
		if( $(this).val() != '' ){
			
			// recupera localizacao do estabelecimento selecionado e
			// adiciona marcador do estabelecimento selecionado
			$.ajax({
				url: <?= '"'.$this->Html->url( "/estabelecimentos/getLocation/", true ).'"' ?> + $(this).val(),
				type: 'GET',
				dataType: "json",
				success: function( data, textStatus, XMLHttpRequest ){
					
					var coords = data.split(',');
					coords[0] = parseFloat( coords[0] );
					coords[1] = parseFloat( coords[1] )
					markEstabelecimento = new OpenLayers.Marker( new OpenLayers.LonLat( coords[0], coords[1] ), iconEstabelecimento );
					estabelecimentos.addMarker( markEstabelecimento );
				},
				error: function( XMLHttpRequest, textStatus ){
					
					alert("erro");
					alert( XMLHttpRequest.responseText );
				}
			});
						
		} else {
			
			// remove marcador
			estabelecimentos.removeMarker( markEstabelecimento );
		}
	});
	
});
-->
</script>

<?php if( !empty( $this->passedArgs[0] ) ): ?>

<table class="visualizar medium">
	<tr>
		<td class="label small">Vendedor:</td>
		<td>
		<?php
			print $vendedor[ 'Vendedor' ][ 'nome' ];
			print $this->Form->hidden( "Visita.vendedor_id", array( 'value' => $this->passedArgs[0] ) );
		?>
		</td>
	</tr>
	<tr class="altrow">
		<td class="label small">CPF:</td>
		<td><?= $vendedor[ 'Vendedor' ][ 'cpf' ] ?></td>
	</tr>
</table>
<div class="div medium"></div>

<?php endif; ?>

<table class="visualizar auto">
	
	<?php if( empty( $this->passedArgs[0] ) ): ?>
		
		<tr>
			<td><?= $this->Form->label( "Visita.vendedor_id", "Vendedor:" ) ?></td>
			<td><?= $this->Form->input( "Visita.vendedor_id", array( 'label' => false, 'class' => 'select', 'escape' => false, 'type' => 'select', 'options' => $vendedores, 'empty' => '--' ) ) ?></td>
		</tr>			
		
	<?php endif; ?>
	
	<tr>
		<td><?= $this->Form->label( "Visita.estabelecimento_id", "Estabelecimento:" ) ?></td>
		<td><?= $this->Form->input( "Visita.estabelecimento_id", array( 'label' => false, 'class' => 'select', 'escape' => false, 'type' => 'select', 'options' => $estabelecimentos, 'empty' => '--' ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "Visita.data", "Data:" ) ?></td>
		<td><?= $this->Form->input( "Visita.data", array( 'label' => false, 'class' => 'text', 'escape' => false, 'type' => 'text' ) ) ?></td>
		<td class="label small right"><?= $this->Form->label( "Visita.hora", "Hora:" ) ?></td>
		<td class="input small"><?= $this->Form->input( "Visita.hora", array( 'label' => false, 'type' => 'text', 'escape' => false, 'class' => 'text small' ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "Visita.observacao", "Observação:" ) ?></td>
		<td><?= $this->Form->input( "Visita.observacao", array( 'label' => false, 'class' => 'textarea', 'escape' => false ) ) ?></td>
	</tr>
</table>
<div class="div medium"></div>
<table class="visualizar auto">
	<tr>
		<td class="label small">No Mapa:</td>
		<td class="input">
			<div id="mapa" class="mapa-small"></div>
		</td>
	</tr>
	<tr>
		<td colspan="2"><?= $this->element( "submit", array( 'cancel' => '/visitas' ) ) ?></td>
	</tr>
</table>


<?= $this->Form->end() ?>