<?php

if( $this->Session->check( "Message.flash" ) )
	print $this->Session->flash();
	
else if( $this->Session->check( "Message.auth" ) )
	print $this->Session->flash( "auth" );

?>