<?php
	$this->Html->css( array( 'openlayers', 'openlayers.google' ), null, array( 'inline' => false ) );
	$this->Html->script( array( 'jquery.maskedinput.min', 'http://maps.google.com/maps/api/js?sensor=false', 'openlayers/lib/OpenLayers', 'map.saoluis' ), false );
	print $this->Form->create( "Vendedor", array( 'url' => array( 'controller' => 'vendedores', "action" => "edit/{$this->passedArgs[0]}" ), "class" => "form" ) );
	print $this->Form->hidden( "Vendedor.id" );
	print $this->Form->hidden( "Vendedor.localizacao" );
?>

<script type="text/javascript">
<!--
$(document).ready( function(){
	
	$('#VendedorCpf').mask('999.999.999-99');
	$('#VendedorCep').mask('99999-999');
	$('#VendedorTelefone').mask('(99)9999-9999');
	$('#VendedorCelular').mask('(99)9999-9999');
	
	$('#mapa').initMap( true, 'Vendedor' ).setLocation( $('#VendedorLocalizacao').val() );
});
-->
</script>

<table class="visualizar auto">
	<tr>
		<td class="label small"><?= $this->Form->label( "Vendedor.nome", "Nome:" ) ?></td>
		<td class="input"><?= $this->Form->input( "Vendedor.nome", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
	</tr>
	<tr>
		<td class="label small"><?= $this->Form->label( "Vendedor.cpf", "CPF:" ) ?></td>
		<td class="input"><?= $this->Form->input( "Vendedor.cpf", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
	</tr>
</table>
<div class="div medium"></div>
<table class="visualizar auto">
	<tr>
		<td class="label small"><?= $this->Form->label( "Vendedor.endereco", "Endereço:" ) ?></td>
		<td class="input"><?= $this->Form->input( "Vendedor.endereco", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "Vendedor.bairro", "Bairro:" ) ?></td>
		<td><?= $this->Form->input( "Vendedor.bairro", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
		<td class="label small right"><?= $this->Form->label( "Vendedor.estado", "Estado:" ) ?></td>
		<td class="input small"><?= $this->Form->input( "Vendedor.estado", array( 'label' => false, 'type' => 'select', 'escape' => false, 'class' => 'select small', 'empty' => '--', 'options' => $estado ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "Vendedor.cidade", "Cidade:" ) ?></td>
		<td><?= $this->Form->input( "Vendedor.cidade", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
		<td class="label small right"><?= $this->Form->label( "Vendedor.cep", "CEP:" ) ?></td>
		<td><?= $this->Form->input( "Vendedor.cep", array( 'label' => false, 'class' => 'text small', 'escape' => false ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "Vendedor.telefone", "Telefone:" ) ?></td>
		<td><?= $this->Form->input( "Vendedor.telefone", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "Vendedor.celular", "Celular:" ) ?></td>
		<td><?= $this->Form->input( "Vendedor.celular", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
	</tr>
</table>
<div class="div medium"></div>
<table class="visualizar auto">
	<tr>
		<td class="label small">Localiza&ccedil;&atilde;o:</td>
		<td class="input">
			<div id="mapa" class="mapa-small"></div>
			<?php if( !empty( $this->validationErrors[ 'Vendedor' ][ 'localizacao' ] ) ): ?>
				<p class="error-message"><?= $this->validationErrors[ 'Vendedor' ][ 'localizacao' ] ?></p>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td colspan="2"><?= $this->element( "submit", array( 
			'cancelRedirect' => $this->passedArgs[0],
			'cancel' => array(
				'index' => '/vendedores',
				'view' => "/vendedores/view/{$this->passedArgs[1]}"
		) ) ) ?></td>
	</tr>
</table>


<?= $this->Form->end() ?>