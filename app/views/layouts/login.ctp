<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex, nofollow" />
<title><?= $title_for_layout ?> :: Login</title>

<?php
	print $this->Html->css( "kernel.login" );
	print $this->Html->script( "jquery.min" );
?>

<script type="text/javascript">
<!--
$(document).ready( function(){
	$('#UserUsername').focus();
});
-->
</script>

</head>

<body>

<div id="general">

	<div id="login">
    
    	<div class="top">
			<h3>ENTRAR NO SISTEMA</h3>
		</div>
		
		<div class="base">
			
			<!-- <p class="img">< $this->Html->image( 'sistema/logo.png' ) ?></p> -->
			
			<div class="form">
			<?php
				print $this->element( "messages" );
				print $content_for_layout;
			?>
			</div>
		
		</div>
    
    </div>

</div>

</body>
</html>