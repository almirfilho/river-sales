<?php
	$this->Html->css( array( 'openlayers', 'openlayers.google' ), null, array( 'inline' => false ) );
	$this->Html->script( array( 'jquery.maskedinput.min', 'http://maps.google.com/maps/api/js?sensor=false', 'openlayers/lib/OpenLayers', 'map.saoluis' ), false );
	print $this->Form->create( "Estabelecimento", array( "action" => "edit/{$this->passedArgs[0]}", "class" => "form" ) );
	print $this->Form->hidden( "Estabelecimento.id" );
	print $this->Form->hidden( "Estabelecimento.localizacao" );
?>

<script type="text/javascript">
<!--
$(document).ready( function(){
	
	$('#EstabelecimentoCep').mask('99999-999');
	$('#EstabelecimentoTelefone').mask('(99)9999-9999');
	
	$('#mapa').initMap( true, 'Estabelecimento' ).setLocation( $('#EstabelecimentoLocalizacao').val() );
});
-->
</script>

<table class="visualizar auto">
	<tr>
		<td><?= $this->Form->label( "Estabelecimento.tipo", "Tipo:" ) ?></td>
		<td><?= $this->Form->input( "Estabelecimento.tipo", array( 'label' => false, 'type' => 'select', 'escape' => false, 'class' => 'select', 'empty' => '--', 'options' => $tipo ) ) ?></td>
	</tr>
	<tr>
		<td class="label small"><?= $this->Form->label( "Estabelecimento.nome", "Nome:" ) ?></td>
		<td class="input"><?= $this->Form->input( "Estabelecimento.nome", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
	</tr>
</table>
<div class="div medium"></div>
<table class="visualizar auto">
	<tr>
		<td class="label small"><?= $this->Form->label( "Estabelecimento.endereco", "Endereço:" ) ?></td>
		<td class="input"><?= $this->Form->input( "Estabelecimento.endereco", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "Estabelecimento.bairro", "Bairro:" ) ?></td>
		<td><?= $this->Form->input( "Estabelecimento.bairro", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
		<td class="label small right"><?= $this->Form->label( "Estabelecimento.estado", "Estado:" ) ?></td>
		<td class="input small"><?= $this->Form->input( "Estabelecimento.estado", array( 'label' => false, 'type' => 'select', 'escape' => false, 'class' => 'select small', 'empty' => '--', 'options' => $estado, 'default' => 'MA' ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "Estabelecimento.cidade", "Cidade:" ) ?></td>
		<td><?= $this->Form->input( "Estabelecimento.cidade", array( 'label' => false, 'class' => 'text', 'default' => 'São Luís', 'escape' => false ) ) ?></td>
		<td class="label small right"><?= $this->Form->label( "Estabelecimento.cep", "CEP:" ) ?></td>
		<td><?= $this->Form->input( "Estabelecimento.cep", array( 'label' => false, 'class' => 'text small', 'escape' => false ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "Estabelecimento.telefone", "Telefone:" ) ?></td>
		<td><?= $this->Form->input( "Estabelecimento.telefone", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
	</tr>
</table>
<div class="div medium"></div>
<table class="visualizar auto">
	<tr>
		<td class="label small">Localiza&ccedil;&atilde;o:</td>
		<td class="input">
			<div id="mapa" class="mapa-small"></div>
			<?php if( !empty( $this->validationErrors[ 'Estabelecimento' ][ 'localizacao' ] ) ): ?>
				<p class="error-message"><?= $this->validationErrors[ 'Estabelecimento' ][ 'localizacao' ] ?></p>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td colspan="2"><?= $this->element( "submit", array( 
			'cancelRedirect' => $this->passedArgs[0],
			'cancel' => array(
				'index' => '/estabelecimentos',
				'view' => "/estabelecimentos/view/{$this->passedArgs[1]}"
		) ) ) ?></td>
	</tr>
</table>

<?= $this->Form->end() ?>