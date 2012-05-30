<?php
	$this->Html->css( array( 'openlayers', 'openlayers.google' ), null, array( 'inline' => false ) );
	$this->Html->script( array( 'http://maps.google.com/maps/api/js?sensor=false', 'openlayers/lib/OpenLayers', 'map.saoluis' ), false );
?>

<script type="text/javascript">
<!--
$(document).ready( function(){
	
	$('#mapa').initMap( false, 'Vendedor' ).setLocation( "<?= $vendedor['Vendedor']['localizacao'] ?>" );
});
-->
</script>

<p><?= $this->Html->link( "Visualizar Visitas", "/vendedores/visitas/{$vendedor['Vendedor']['id']}", array( 'class' => 'button icon Visitas round' ) ) ?></p>

<div class="div auto"></div>
<table class="visualizar medium">
	<tr>
		<td class="label small">Nome:</td>
		<td><?= $vendedor[ 'Vendedor' ][ 'nome' ] ?></td>
	</tr>
	<tr class="altrow">
		<td class="label small">CPF:</td>
		<td><?= $vendedor[ 'Vendedor' ][ 'cpf' ] ?></td>
	</tr>
</table>
<div class="div auto"></div>
<table class="visualizar medium">
	<tr>
		<td class="label small">Endereço:</td>
		<td><?= $vendedor[ 'Vendedor' ][ 'endereco' ] ?></td>
	</tr>
	<tr class="altrow">
		<td class="label small">Bairro:</td>
		<td><?= $vendedor[ 'Vendedor' ][ 'bairro' ] ?></td>
	</tr>
	<tr>
		<td class="label small">Cidade:</td>
		<td><?= $vendedor[ 'Vendedor' ][ 'cidade' ] ?></td>
	</tr>
	<tr class="altrow">
		<td class="label small">Estado:</td>
		<td><?= $estado[ $vendedor[ 'Vendedor' ][ 'estado' ] ] ?></td>
	</tr>
	<tr>
		<td class="label small">CEP:</td>
		<td><?= $vendedor[ 'Vendedor' ][ 'cep' ] ?></td>
	</tr>
	<tr class="altrow">
		<td class="label small">Telefone:</td>
		<td><?php ctype_space( $vendedor[ 'Vendedor' ][ 'telefone' ] ) ? print '--' : print $vendedor[ 'Vendedor' ][ 'telefone' ]; ?></td>
	</tr>
	<tr>
		<td class="label small">Celular:</td>
		<td><?= $vendedor[ 'Vendedor' ][ 'celular' ] ?></td>
	</tr>
</table>
<div class="div auto"></div>
<table class="visualizar medium">
	<tr>
		<td class="label small">Localização:</td>
		<td><div id="mapa" class="mapa-small"></div></td>
	</tr>
</table>

<div class="buttons">
<?php
	print $this->Html->link( "Editar", "/vendedores/edit/view/{$vendedor['Vendedor']['id']}", array( 'class' => 'button icon edit round' ) );
	print $this->Html->link( "Excluir", "/vendedores/delete/{$vendedor['Vendedor']['id']}", array( 'class' => 'button icon delete2 round' ), "Tem certeza de que deseja excluir este Vendedor?" );
?>
</div>