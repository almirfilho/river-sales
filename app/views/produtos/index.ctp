<table class="list medium">
	
<tr class="head">
	<th></th>
	<th><?= $this->Paginator->sort( "Nome", "nome" ) ?></th>
	<th><?= $this->Paginator->sort( "Em estoque", "quantidade_estoque" ) ?></th>
	<th class="actions">A&ccedil;&otilde;es</th>
</tr>

<?php if( empty( $produtos ) ){ ?>
	
<tr><td></td><td colspan="5" class="bold">N&atilde;o h&aacute; Produtos cadastrados ainda.</td></tr>

<?php } else { foreach( $produtos as $i => $produto ): $i % 2 ? $class = null : $class = ' class="altrow"'; ?>

<tr<?= $class ?>>
	<td class="pic Produtos"></td>
	<td><?= $produto[ 'Produto' ][ 'nome' ] ?></td>
	<td><?= $produto[ 'Produto' ][ 'quantidade_estoque' ] ?></td>
	<td>
	<?php
		print $this->Html->link( "Visualizar", "/produtos/view/{$produto['Produto']['id']}", array( 'class' => 'icon view' ) );
		print $this->Html->link( "Editar", "/produtos/edit/index/{$produto['Produto']['id']}", array( 'class' => 'icon edit' ) );
		print $this->Html->link( "Excluir", "/produtos/delete/{$produto['Produto']['id']}", array( 'class' => 'icon delete' ), "Tem certeza de que deseja excluir este Produto?" );
	?>
	</td>
</tr>
	
<?php endforeach; print $this->element( "paginationButtons", array( 'mode' => 'table', 'size' => 4 ) ); } ?>

</table>