<?= $this->Form->create( "Produto", array( "action" => "add", "class" => "form" ) ) ?>

<table class="visualizar auto">
	<tr>
		<td class="label small"><?= $this->Form->label( "Produto.nome", "Nome:" ) ?></td>
		<td class="input"><?= $this->Form->input( "Produto.nome", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "Produto.valor", "Valor (R$):" ) ?></td>
		<td><?= $this->Form->input( "Produto.valor", array( 'label' => false, 'escape' => false, 'class' => 'text' ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "Produto.descricao", "Descrição:" ) ?></td>
		<td><?= $this->Form->input( "Produto.descricao", array( 'label' => false, 'class' => 'textarea', 'escape' => false ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "Produto.observacao", "Observação:" ) ?></td>
		<td><?= $this->Form->input( "Produto.observacao", array( 'label' => false, 'class' => 'textarea', 'escape' => false ) ) ?></td>
	</tr>
	<tr>
		<td colspan="2"><?= $this->element( "submit", array( 'cancel' => '/produtos' ) ) ?></td>
	</tr>
</table>

<?= $this->Form->end() ?>