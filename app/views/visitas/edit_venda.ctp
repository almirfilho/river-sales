<?php
	print $this->Form->create( "Venda", array( 'url' => array( 'controller' => 'visitas', "action" => "editVenda", $this->passedArgs[0] ), "class" => "form" ) );
	print $this->Form->hidden( "Venda.id" );
?>

<table class="visualizar auto">
	<tr>
		<td><?= $this->Form->label( "Venda.produto_id", "Produto:" ) ?></td>
		<td><?= $this->Form->input( "Venda.produto_id", array( 'label' => false, 'escape' => false, 'class' => 'select', 'type' => 'select', 'options' => $produtos, 'empty' => '--' ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "Venda.quantidade", "Quantidade:" ) ?></td>
		<td><?= $this->Form->input( "Venda.quantidade", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
	</tr>
	<tr>
		<td colspan="2"><?= $this->element( "submit", array( 'cancel' => '/produtos' ) ) ?></td>
	</tr>
</table>

<?= $this->Form->end() ?>