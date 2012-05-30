<table class="list medium">
	
<tr class="head">
	<th></th>
	<th><?= $this->Paginator->sort( "Nome", "nome" ) ?></th>
	<th><?= $this->Paginator->sort( "CPF", "cpf" ) ?></th>
	<th class="actions">A&ccedil;&otilde;es</th>
</tr>

<?php if( empty( $vendedores ) ){ ?>
	
<tr><td></td><td colspan="5" class="bold">N&atilde;o h&aacute; Vendedores cadastrados ainda.</td></tr>

<?php } else { foreach( $vendedores as $i => $vendedor ): $i % 2 ? $class = null : $class = ' class="altrow"'; ?>

<tr<?= $class ?>>
	<td class="pic Vendedores"></td>
	<td><?= $vendedor[ 'Vendedor' ][ 'nome' ] ?></td>
	<td><?= $vendedor[ 'Vendedor' ][ 'cpf' ] ?></td>
	<td>
	<?php
		print $this->Html->link( "Visualizar", "/vendedores/view/{$vendedor['Vendedor']['id']}", array( 'class' => 'icon view' ) );
		print $this->Html->link( "Editar", "/vendedores/edit/index/{$vendedor['Vendedor']['id']}", array( 'class' => 'icon edit' ) );
		print $this->Html->link( "Excluir", "/vendedores/delete/{$vendedor['Vendedor']['id']}", array( 'class' => 'icon delete' ), "Tem certeza de que deseja excluir este Vendedor?" );
	?>
	</td>
</tr>
	
<?php endforeach; print $this->element( "paginationButtons", array( 'mode' => 'table', 'size' => 4 ) ); } ?>

</table>