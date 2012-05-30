<?php
	print $this->Form->create( "Profile", array( "action" => "edit/{$redirect}", "class" => "form" ) );
	print $this->Form->hidden( "Profile.id" );
?>

<table class="visualizar auto">
	<tr>
		<td class="label"><?= $this->Form->label( "Profile.name", "Nome:" ) ?></td>
		<td class="input"><?= $this->Form->input( "Profile.name", array( 'label' => false, 'class' => 'text', 'escape' => false ) ) ?></td>
	</tr>
	<tr>
		<td><?= $this->Form->label( "Area", "&Aacute;reas de Acesso:" ) ?></td>
		<td class="areas"><?= $this->Form->input( "Area",  array( "label" => false, "multiple" => "checkbox" ) ) ?></td>
	</tr>
	<tr>
		<td colspan="2"><?= $this->element( "submit" ) ?></td>
	</tr>
</table>

<?= $this->Form->end() ?>