<?php
	$this->Html->css( array( 'openlayers', 'openlayers.google' ), null, array( 'inline' => false ) );
	$this->Html->script( array( 'http://maps.google.com/maps/api/js?sensor=false', 'openlayers/lib/OpenLayers', 'map.saoluis' ), false );
?>

<script type="text/javascript">
<!--
$(document).ready( function(){
	
	$('#mapa').initMap( false, 'Estabelecimento' ).setLocation( "<?= $estabelecimento['Estabelecimento']['localizacao'] ?>" );
});
-->
</script>

<table class="visualizar medium">
	<tr>
		<td class="label small">Nome:</td>
		<td><?= $estabelecimento[ 'Estabelecimento' ][ 'nome' ] ?></td>
	</tr>
	<tr class="altrow">
		<td class="label small">Tipo:</td>
		<td><?= $tipo[ $estabelecimento[ 'Estabelecimento' ][ 'tipo' ] ] ?></td>
	</tr>
</table>
<div class="div auto"></div>
<table class="visualizar medium">
	<tr>
		<td class="label small">Endereço:</td>
		<td><?= $estabelecimento[ 'Estabelecimento' ][ 'endereco' ] ?></td>
	</tr>
	<tr class="altrow">
		<td class="label small">Bairro:</td>
		<td><?= $estabelecimento[ 'Estabelecimento' ][ 'bairro' ] ?></td>
	</tr>
	<tr>
		<td class="label small">Cidade:</td>
		<td><?= $estabelecimento[ 'Estabelecimento' ][ 'cidade' ] ?></td>
	</tr>
	<tr class="altrow">
		<td class="label small">Estado:</td>
		<td><?= $estado[ $estabelecimento[ 'Estabelecimento' ][ 'estado' ] ] ?></td>
	</tr>
	<tr>
		<td class="label small">CEP:</td>
		<td><?= $estabelecimento[ 'Estabelecimento' ][ 'cep' ] ?></td>
	</tr>
	<tr class="altrow">
		<td class="label small">Telefone:</td>
		<td><?php ctype_space( $estabelecimento[ 'Estabelecimento' ][ 'telefone' ] ) ? print '--' : print $estabelecimento[ 'Estabelecimento' ][ 'telefone' ]; ?></td>
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
	print $this->Html->link( "Editar", "/estabelecimentos/edit/view/{$estabelecimento['Estabelecimento']['id']}", array( 'class' => 'button icon edit round' ) );
	print $this->Html->link( "Excluir", "/estabelecimentos/delete/{$estabelecimento['Estabelecimento']['id']}", array( 'class' => 'button icon delete2 round' ), "Tem certeza de que deseja excluir este Estabelecimento?" );
?>
</div>