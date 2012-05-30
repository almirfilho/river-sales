<?php
	$this->Html->css( array( 'openlayers', 'openlayers.google' ), null, array( 'inline' => false ) );
	$this->Html->script( array( 'http://maps.google.com/maps/api/js?sensor=false', 'openlayers/lib/OpenLayers', 'map.saoluis' ), false );
?>

<script type="text/javascript">
<!--
$(document).ready( function(){

	$('#mapa').initMap( false, 'Estabelecimento' ).setMarker( "<?= $estabelecimento['Estabelecimento']['localizacao'] ?>" );
	
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

<table class="visualizar medium">
	<tr>
		<td class="label small">Data:</td>
		<td><?= $this->Time->format( 'd/m/Y', $visita[ 'Visita' ][ 'data' ] ) ?></td>
	</tr>
	<tr class="altrow">
		<td class="label small">Hora:</td>
		<td><?= $this->Time->format( 'H:i', $visita[ 'Visita' ][ 'hora' ] ) ?></td>
	</tr>
	<tr>
		<td class="label small">Vendedor:</td>
		<td><?= $vendedor[ 'Vendedor' ][ 'nome' ] ?></td>
	</tr>
	<tr class="altrow">
		<td class="label small">Estabelecimento:</td>
		<td><?= $estabelecimento[ 'Estabelecimento' ][ 'nome' ] ?></td>
	</tr>
	<tr>
		<td class="label small">Observação:</td>
		<td><?php $visita[ 'Visita' ][ 'observacao' ] ? print $visita[ 'Visita' ][ 'observacao' ] : print '--'; ?></td>
	</tr>
	<tr class="altrow">
		<td class="label small">Realizada:</td>
		<td><?php $visita[ 'Visita' ][ 'realizada' ] ? print 'Visita realizada' : print 'Visita não realizada ainda'; ?></td>
	</tr>
</table>

<?php if( $visita[ 'Visita' ][ 'realizada' ] ): ?>
	<br />
	<h2>Vendas desta visita:</h2>

	<table class="list medium">

	<tr class="head">
		<th></th>
		<th>Produto</th>
		<th>Quantidade</th>
		<th>Valor Total</th>
		<th class="actions">A&ccedil;&otilde;es</th>
	</tr>

	<?php if( empty( $visita[ 'Venda' ] ) ){ ?>

	<tr><td></td><td colspan="5" class="bold">N&atilde;o foi feita nenhuma venda nesta visita.</td></tr>

	<?php } else { foreach( $visita[ 'Venda' ] as $i => $venda ): $i % 2 ? $class = null : $class = ' class="altrow"'; ?>

	<tr<?= $class ?>>
		<td class="pic Vendas"></td>
		<td><?= $venda[ 'Produto' ][ 'nome' ] ?></td>
		<td><?= $venda[ 'quantidade' ] ?></td>
		<td><?= $this->Number->format( $venda[ 'valor_total' ], array( 'before' => 'R$ ', 'decimals' => ',', 'thousands' => '.' ) ) ?></td>
		<td>
		<?php
			print $this->Html->link( "Editar", "/visitas/editVenda/{$visita['Visita']['id']}/{$venda['id']}", array( 'class' => 'icon edit' ) );
			print $this->Html->link( "Excluir", "/visitas/deleteVenda/{$visita['Visita']['id']}/{$venda['id']}", array( 'class' => 'icon delete' ), "Tem certeza de que deseja excluir esta Venda?" );
		?>
		</td>
	</tr>

	<?php endforeach; } ?>
	
	<tr class="footer">
		<td colspan="4"></td>
		<td class="right"><?= sizeof( $visita[ 'Venda' ] ) ?> venda(s) encontrada(s)</td>
	</tr>

	</table>
	<br />
	<p><?= $this->Html->link( 'Adicionar Venda', "/visitas/addVenda/{$visita['Visita']['id']}", array( 'class' => 'button icon add round' ) ) ?></p>
	
<?php endif; ?>

<div class="div medium"></div>

<table class="visualizar medium">
	<tr>
		<td class="label small">No Mapa:</td>
		<td><div id="mapa" class="mapa-small"></div></td>
	</tr>
</table>

<div class="buttons">
<?php
	print $this->Html->link( "Editar", "/visitas/edit/{$visita['Visita']['id']}", array( 'class' => 'button icon edit round' ) );
	print $this->Html->link( "Excluir", "/visitas/delete/{$visita['Visita']['id']}/{$visita['Visita']['vendedor_id']}", array( 'class' => 'button icon delete2 round' ), "Tem certeza de que deseja excluir esta Visita?" );
?>
</div>