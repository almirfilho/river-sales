<?= $this->Form->create( "Produto", array( "action" => "stock", "class" => "form" ) ) ?>

<table class="visualizar auto">
	<tr>
		<td class="label small"><?= $this->Form->label( "Produto.id", "Produto:" ) ?></td>
		<td class="input"><?= $this->Form->input( "Produto.id", array( 'label' => false, 'class' => 'select', 'options' => $produtos, 'empty' => '--', 'escape' => false ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "Produto.qnt", "Quantidade:" ) ?></td>
		<td><?= $this->Form->input( "Produto.qnt", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
	</tr>
	<tr>
		<td colspan="2"><?= $this->element( "submit", array( 'cancel' => '/produtos' ) ) ?></td>
	</tr>
</table>

<?= $this->Form->end() ?>