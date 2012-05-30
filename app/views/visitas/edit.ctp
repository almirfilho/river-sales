<?php
	$this->Html->css( array( 'jquery.datepicker' ), null, array( 'inline' => false ) );
	$this->Html->script( array( 'jquery.ui.datepicker.min', 'jquery.maskedinput.min' ), false );
	print $this->Form->create( "Visita", array( 'url' => array( 'controller' => 'visitas', "action" => "edit" ), "class" => "form" ) );
	print $this->Form->hidden( "Visita.id" );
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
	
});
-->
</script>

<table class="visualizar medium">
	<tr>
		<td class="label small">Vendedor:</td>
		<td><?= $visita[ 'Vendedor' ][ 'nome' ] ?></td>
	</tr>
	<tr class="altrow">
		<td class="label small">Estabelecimento:</td>
		<td><?= $visita[ 'Estabelecimento' ][ 'nome' ] ?></td>
	</tr>
</table>
<div class="div medium"></div>

<table class="visualizar auto">
	
	<tr>
		<td class="label small"><?= $this->Form->label( "Visita.data", "Data:" ) ?></td>
		<td class="input"><?= $this->Form->input( "Visita.data", array( 'label' => false, 'class' => 'text', 'escape' => false, 'type' => 'text' ) ) ?></td>
		<td class="label small right"><?= $this->Form->label( "Visita.hora", "Hora:" ) ?></td>
		<td class="input small"><?= $this->Form->input( "Visita.hora", array( 'label' => false, 'type' => 'text', 'escape' => false, 'class' => 'text small' ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "Visita.observacao", "Observação:" ) ?></td>
		<td><?= $this->Form->input( "Visita.observacao", array( 'label' => false, 'class' => 'textarea', 'escape' => false ) ) ?></td>
		<td class="label small right"><?= $this->Form->label( "Visita.realizada", "Realizada:" ) ?></td>
		<td><?= $this->Form->input( "Visita.realizada", array( 'label' => false, 'class' => 'select small', 'escape' => false, 'type' => 'select', 'options' => array( '0' => 'Não', '1' => 'Sim' ) ) ) ?></td>
	</tr>
	<tr>
		<td colspan="2"><?= $this->element( "submit", array( 'cancel' => '/visitas' ) ) ?></td>
	</tr>
</table>

<?= $this->Form->end() ?>