<table class="visualizar medium">
	<tr>
		<td class="label">Nome:</td>
		<td><?= $produto[ 'Produto' ][ 'nome' ] ?></td>
	</tr>
	<tr class="altrow">
		<td class="label">Valor:</td>
		<td><?= $this->Number->format( $produto[ 'Produto' ][ 'valor' ], array( 'decimals' => ',', 'thousands' => '.', 'before' => 'R$ ' ) ) ?></td>
	</tr>
	<tr>
		<td class="label">Quantidade em estoque:</td>
		<td><?= $produto[ 'Produto' ][ 'quantidade_estoque' ] ?></td>
	</tr>
	<tr class="altrow">
		<td class="label">Descrição:</td>
		<td><?php $produto[ 'Produto' ][ 'descricao' ] ? print $produto[ 'Produto' ][ 'descricao' ] : print '--'; ?></td>
	</tr>
	<tr>
		<td class="label">Observação:</td>
		<td><?php $produto[ 'Produto' ][ 'observacao' ] ? print $produto[ 'Produto' ][ 'observacao' ] : print '--'; ?></td>
	</tr>
</table>

<div class="buttons">
<?php
	print $this->Html->link( "Editar", "/produtos/edit/view/{$produto['Produto']['id']}", array( 'class' => 'button icon edit round' ) );
	print $this->Html->link( "Excluir", "/produtos/delete/{$produto['Produto']['id']}", array( 'class' => 'button icon delete2 round' ), "Tem certeza de que deseja excluir este Produto?" );
?>
</div>