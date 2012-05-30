<table class="list medium">
	
<tr class="head">
	<th></th>
	<th><?= $this->Paginator->sort( "Nome", "nome" ) ?></th>
	<th><?= $this->Paginator->sort( "Tipo", "tipo" ) ?></th>
	<th class="actions">A&ccedil;&otilde;es</th>
</tr>

<?php if( empty( $estabelecimentos ) ){ ?>
	
<tr><td></td><td colspan="5" class="bold">N&atilde;o h&aacute; Estabelecimentos cadastrados ainda.</td></tr>

<?php } else { foreach( $estabelecimentos as $i => $estabelecimento ): $i % 2 ? $class = null : $class = ' class="altrow"'; ?>

<tr<?= $class ?>>
	<td class="pic Estabelecimentos"></td>
	<td><?= $estabelecimento[ 'Estabelecimento' ][ 'nome' ] ?></td>
	<td><?= $tipo[ $estabelecimento[ 'Estabelecimento' ][ 'tipo' ] ] ?></td>
	<td>
	<?php
		print $this->Html->link( "Visualizar", "/estabelecimentos/view/{$estabelecimento['Estabelecimento']['id']}", array( 'class' => 'icon view' ) );
		print $this->Html->link( "Editar", "/estabelecimentos/edit/index/{$estabelecimento['Estabelecimento']['id']}", array( 'class' => 'icon edit' ) );
		print $this->Html->link( "Excluir", "/estabelecimentos/delete/{$estabelecimento['Estabelecimento']['id']}", array( 'class' => 'icon delete' ), "Tem certeza de que deseja excluir este Estabelecimento?" );
	?>
	</td>
</tr>
	
<?php endforeach; print $this->element( "paginationButtons", array( 'mode' => 'table', 'size' => 4 ) ); } ?>

</table>