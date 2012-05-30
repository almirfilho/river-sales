<table class="visualizar medium">
	
	<tr>
		<td class="label">Nome:</td>
		<td><?= $user[ 'User' ][ 'name' ] ?></td>
	</tr>
	<tr class="altrow">
		<td class="label">Email:</td>
		<td><?= $user[ 'User' ][ 'email' ] ?></td>
	</tr>
	<tr>
		<td class="label">Perfil:</td>
		<td><?= $user[ 'Profile' ][ 'name' ] ?></td>
	</tr>
	<tr class="altrow">
		<td class="label">Login (nome de usu&aacute;rio):</td>
		<td><?= $user[ 'User' ][ 'username' ] ?></td>
	</tr>
	<tr>
		<td class="label">&Uacute;ltimo login:</td>
		<td><?= $this->Time->format( "d/m/Y - H:i:s", $user[ 'User' ][ 'last_login' ] ) ?></td>
	</tr>
	
</table>

<div class="buttons">
<?php
	print $this->Html->link( "Editar", "/users/edit/view/{$user['User']['id']}", array( 'class' => 'button icon edit round' ) );
	print $this->Html->link( "Excluir", "/users/delete/{$user['User']['id']}", array( 'class' => 'button icon delete2 round' ) );
?>
</div>