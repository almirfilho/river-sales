<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex, nofollow" />
<title><?= $title_for_layout ?></title>

<?php

print $this->Html->css( array( 'kernel', 'custom' ) );
print $this->Html->script( array( "crossbrowser", 'jquery.min', 'jquery.corner', 'general' ) );
print $scripts_for_layout;

?>

</head>
<body>

<div id="header">
	<div class="top">
		<div class="logo"></div>
		<p>Bem vindo: <span class="admin icon"><?= $this->Session->read( "Auth.User.name" ) ?></span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&Uacute;ltimo login: <span class="date icon"><?php print $this->Time->format( "d/m/Y - H:i:s", $this->Session->read( "Auth.User.last_login" ) ) ?></span> <?= $this->Html->link( "SAIR", "/users/logout", array( 'class' => 'sair icon' ) ) ?></p>
		<?= $this->Menu->getMenu() ?>
		<div class="clear"></div>
	</div>
	<div class="bottom">
		<div class="left">
		<?php
			print $this->Html->link( "HOME", '/', array( 'class' => 'icon home' ) );
			print $this->Html->link( "MEUS DADOS", '/users/manageAccount', array( 'class' => 'icon dados' ) );
		?>
		</div>
		<h1><?= $this->Menu->getHeader( $header, $subtitle ) ?></h1>
	</div>
</div>

<div id="middle">
	<div id="submenu">
		<?= $this->Menu->getSubMenu( $submenu ) ?>
	</div>
	<div id="content">
	<?php
		print $this->element( "messages" );
	 	print $content_for_layout;
	?>
	</div>
	<div class="clear"></div>
</div>

<div id="footer">
	<p><?= $title_for_layout." - ".date( "d/m/Y" ) ?></p>
</div>

<?= $this->element('sql_dump') ?>
</body>
</html>