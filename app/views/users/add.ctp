<?= $this->Form->create( "User", array( "action" => "add", "class" => "form" ) ) ?>

<table class="visualizar auto">
	<tr>
		<td class="label"><?= $this->Form->label( "User.name", "Nome:" ) ?></td>
		<td class="input"><?= $this->Form->input( "User.name", array( 'label' => false, 'class' => 'text' ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "User.email", "Email:" ) ?></td>
		<td><?= $this->Form->input( "User.email", array( 'label' => false, 'class' => 'text' ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "User.username", "Login (nome de usu&aacute;rio):" ) ?></td>
		<td><?= $this->Form->input( "User.username", array( 'label' => false, 'class' => 'text' ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "User.profile_id", "Perfil:" ) ?></td>
		<td><?= $this->Form->input( "User.profile_id", array( 'label' => false, 'type' => 'select', 'escape' => false, 'class' => 'select', 'empty' => '--' ) ) ?></td>
		<td><?= $this->Html->link( "Adicionar Perfil", "/profiles/add/userAdd", array( 'class' => 'icon add' ) ) ?></td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td colspan="2">Por padr&atilde;o, a senha para o novo usu&aacute;rio ser&aacute; "123456".<br />Cada Usu&aacute;rio deve mudar sua pr&oacute;pria senha ao logar no sistema.</td>
	</tr>
	<tr>
		<td colspan="2"><?= $this->element( "submit" ) ?></td>
	</tr>
</table>

<?= $this->Form->end() ?>