<?php

print $this->Form->create( "User", array( "action" => "login" ) );

print $this->Form->input( "User.username", array( "label" => "Login:", 'class' => 'text' ) );
	
print $this->Form->input( "User.password", array( "label" => "Senha:", 'class' => 'text' ) );

print $this->Form->end( array( 'label' => 'ENTRAR', 'class' => 'submit' ) );

?>