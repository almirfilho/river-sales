<?php $this->Html->script( array( 'check' ), false ) ?>

<?php
	print $this->Form->create( null, array( 'action' => 'multipleActions/delete', 'onsubmit' => 'return confirm("Tem certeza de que deseja excluir os Usuários selecionados?");', 'class' => 'actions' ) );
	print $this->Form->submit( "Excluir selecionados", array( 'class' => 'submit', 'div' => false ) );
?>

<table class="list medium">
	
<tr class="head">
	<th></th>
	<th class="check"><?= $this->Form->checkbox( "Check.all", array( 'class' => 'all' ) ) ?></th>
	<th><?= $this->Paginator->sort( "Nome", "name" ) ?></th>
	<th><?= $this->Paginator->sort( "Perfil", "Profile.name" ) ?></th>
	<th><?= $this->Paginator->sort( "Email", "email" ) ?></th>
	<th class="actions">A&ccedil;&otilde;es</th>
</tr>

<?php if( empty( $users ) ){ ?>
	
<tr><td></td><td colspan="5" class="bold">N&atilde;o h&aacute; Usu&aacute;rios cadastrados ainda.</td></tr>

<?php } else { foreach( $users as $i => $user ): $i % 2 ? $class = null : $class = ' class="altrow"'; ?>

<tr<?= $class ?>>
	<td class="pic Users"></td>
	<td class="check"><?= $this->Form->checkbox( "User.checks.{$user['User']['id']}", array( 'class' => 'checks' ) ) ?></td>
	<td><?= $user[ 'User' ][ 'name' ] ?></td>
	<td><?= $user[ 'Profile' ][ 'name' ] ?></td>
	<td><?= $user[ 'User' ][ 'email' ] ?></td>
	<td>
	<?php
		print $this->Html->link( "Visualizar", "/users/view/{$user['User']['id']}", array( 'class' => 'icon view' ) );
		print $this->Html->link( "Editar", "/users/edit/index/{$user['User']['id']}", array( 'class' => 'icon edit' ) );
		print $this->Html->link( "Excluir", "/users/delete/{$user['User']['id']}", array( 'class' => 'icon delete' ), "Tem certeza de que deseja excluir este Usuário?" );
	?>
	</td>
</tr>
	
<?php endforeach; print $this->element( "paginationButtons", array( 'mode' => 'table', 'size' => 6 ) ); } ?>

</table>

<?= $this->Form->end() ?>