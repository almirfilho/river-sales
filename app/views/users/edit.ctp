<?php
 	print $this->Form->create( "User", array( "action" => "edit/{$redirect}", 'class' => 'form' ) );
	print $this->Form->hidden( "User.id" );
	print $this->Form->hidden( "User.password" );
?>

<table class="visualizar auto">
	<tr>
		<td class="label"><?= $this->Form->label( "User.name", "Nome:" ) ?></td>
		<td class="input"><?= $this->Form->input( "User.name", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "User.email", "Email:" ) ?></td>
		<td><?= $this->Form->input( "User.email", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "User.username", "Login (nome de usu&aacute;rio):" ) ?></td>
		<td><?= $this->Form->input( "User.username", array( 'label' => false, 'class' => 'text', 'disabled' => 'disabled' ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "User.profile_id", "Perfil:" ) ?></td>
		<td><?= $this->Form->input( "User.profile_id", array( 'label' => false, 'type' => 'select', 'escape' => false, 'class' => 'select', 'empty' => '--' ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "User.newPassword", "Senha: <span class=\"desc\">(Apenas preencha se desejar mudar a senha atual)</span>" ) ?></td>
		<td><?= $this->Form->input( "User.newPassword", array( 'label' => false, 'class' => 'text', 'type' => 'password' ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "User.newPasswordConfirmation", "Confirme a senha: <span class=\"desc\">(Apenas preencha se desejar mudar a senha atual)</span>" ) ?></td>
		<td><?= $this->Form->input( "User.newPasswordConfirmation", array( 'label' => false, 'class' => 'text', 'type' => 'password' ) ) ?></td>
	</tr>
	<tr>
		<td colspan="2"><?= $this->element( "submit" ) ?></td>
	</tr>
</table>

<?= $this->Form->end() ?>