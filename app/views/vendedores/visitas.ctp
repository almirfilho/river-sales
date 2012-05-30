<?php
	$this->Html->css( 'jquery.datepicker', null, array( 'inline' => false ) );
	$this->Html->script( 'jquery.ui.datepicker.min', false );
	print $this->Form->create( 'Visita', array( 'url' => array( 'controller' => 'vendedores', 'action' => 'visitas', $this->passedArgs[0] ), 'class' => 'form' ) );
?>

<script type="text/javascript">
<!--
$(document).ready( function(){
	
	$('#VisitaDataIni, #VisitaDataFim').datepicker({
		dateFormat: 'dd/mm/yy', 
		dayNamesMin: [ 'Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'S&aacute;b' ],
		monthNames: [ 'Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro' ]
	});
	
	$('#VisitaDataIni, #VisitaDataFim').focus( function(){
	
		if( $(this).val() == $(this).attr('title') )
			$(this).val('');	
	});
	
	$('#VisitaDataIni, #VisitaDataFim').blur( function(){
		
		if( $(this).val() == '' )
			$(this).val( $(this).attr('title') );
	});

});
-->
</script>

<table class="visualizar medium">
	<tr>
		<td class="label small">Vendedor:</td>
		<td><?= $vendedor[ 'Vendedor' ][ 'nome' ] ?></td>
		<td><?= $this->Html->link( "Adicionar Visita", "/visitas/add/{$vendedor['Vendedor']['id']}", array( 'class' => 'button icon add round' ) ) ?></td>
	</tr>
</table>

<div class="div medium"></div>

<table class="visualizar auto">
	<tr>
		<td class="label small">Período:</td>
		<td><?= $this->Form->input( "Visita.data_ini", array( 'label' => false, 'class' => 'text small', 'default' => 'Data inicial', 'title' => 'Data inicial', 'escape' => false, 'type' => 'text' ) ) ?></td>
		<td>-</td>
		<td><?= $this->Form->input( "Visita.data_fim", array( 'label' => false, 'class' => 'text small', 'default' => 'Data final', 'title' => 'Data final', 'escape' => false, 'type' => 'text' ) ) ?></td>
		<td><?= $this->Form->submit( 'PESQUISAR', array( 'class' => 'submit search' ) ) ?></td>
	</tr>
</table>

<div class="div medium"></div>

<?= $this->Form->end() ?>

<?php if( isset( $visitas ) ): ?>
	
	<?php if( empty( $visitas ) ){ ?>
		
		<p class="bold">Não foram encontradas visitas nestas datas</p>
		
	<?php } else { ?>
		
		<table class="list">

		<tr class="head">
			<th></th>
			<th>Data / Hora</th>
			<th>Estabelecimento</th>
			<th>Realizada?</th>
			<th class="actions">A&ccedil;&otilde;es</th>
		</tr>

		<?php foreach( $visitas as $i => $visita ): 
			$i % 2 ? $class = null : $class = ' class="altrow"';
			$visita[ 'Visita' ][ 'realizada' ] ? $realizada = 'checked' : $realizada = 'unchecked';
		?>

		<tr<?= $class ?>>
			<td class="pic Visitas"></td>
			<td><?= $this->Time->format( 'd/m/Y', $visita[ 'Visita' ][ 'data' ] ) .' - '. $this->Time->format( 'H:i', $visita[ 'Visita' ][ 'hora' ] ) ?></td>
			<td><?= $visita[ 'Estabelecimento' ][ 'nome' ] ?></td>
			<td class="<?= $realizada ?>"></td>
			<td><?= $this->Html->link( "Visualizar", "/visitas/view/{$visita['Visita']['id']}", array( 'class' => 'icon view' ) ) ?></td>
		</tr>

		<?php endforeach; ?>
		
		<tr class="footer">
			<td colspan="4"></td>
			<td class="right"><?= sizeof( $visitas ) ?> visita(s) encontrada(s)</td>
		</tr>

		</table>
		
		<?php
			$this->Html->css( array( 'openlayers', 'openlayers.google' ), null, array( 'inline' => false ) );
			$this->Html->script( array( 'http://maps.google.com/maps/api/js?sensor=false', 'openlayers/lib/OpenLayers', 'map.saoluis' ), false );
		?>
		
		<script type="text/javascript">
		<!--
		$(document).ready( function(){
		
			$('#mapa').initMap( false, 'Estabelecimento' );
			
			var estabelecimentosCoords = <?= $estabelecimentosCoords ?>;
			
			for( var i in estabelecimentosCoords )
				$('#mapa').addMarker( estabelecimentosCoords[i] );
			
			var vendedorLayer = new OpenLayers.Layer.Markers( "Vendedor" );
			var vendedorIcon = new OpenLayers.Icon(
				'http://localhost/rivervendas/sistema/img/sistema.custom/marker_vendedor.png',
				new OpenLayers.Size( 39, 32 ),
				new OpenLayers.Pixel( -16, -36 )
			);
			
			map.addLayer( vendedorLayer );
			
			var vendedorLocation = "<?= $vendedor['Vendedor']['localizacao'] ?>";
			vendedorLocation = vendedorLocation.split(',');
			vendedorLayer.addMarker( new OpenLayers.Marker( new OpenLayers.LonLat( parseFloat( vendedorLocation[0] ), parseFloat( vendedorLocation[1] ) ), vendedorIcon ) );
			
		});
		-->
		</script>
		
		<div id="mapa" class="mapa-medium"></div>
		
	<?php } ?>
	
<?php endif; ?>