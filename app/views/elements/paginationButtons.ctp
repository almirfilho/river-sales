<?php if( $mode == "table" ){ ?>
	
	<tr class="footer">
		<td colspan="<?= $size-1 ?>">
			<div class="pagination">
			<?php
	
				print $this->Paginator->prev( "anterior", array( 'class' => 'prev-enabled' ), "anterior", array( 'class' => 'prev-disabled' ) );
	
				print $this->Paginator->counter( array( "format" => "<div>p&aacute;gina %page% de %pages%</div>" ) );
	
				print $this->Paginator->next( "pr&oacute;ximo", array( 'class' => 'next-enabled', 'escape' => false ), "pr&oacute;ximo", array( 'class' => 'next-disabled', 'escape' => false ) );
	
			?>
			</div>
		</td>
		<td class="right"><?= $this->Paginator->counter( "%count% registro(s) encontrado(s)" ) ?></td>
	</tr>
	
<?php } else { ?>

	<div class="pagination">

		<div class="buttons">
	
			<?php
	
			print $this->Paginator->prev( $this->Html->image( "sistema.nucleo/prev.png" ), array( "escape" => false ), $this->Html->image( "sistema.nucleo/disabled_prev.png" ), array( "escape" => false ) );
	
			print $this->Paginator->counter( array( "format" => "<div>página %page% de %pages%</div>" ) );
	
			print $this->Paginator->next( $this->Html->image( "sistema.nucleo/next.png" ), array( "escape" => false ), $this->Html->image( "sistema.nucleo/disabled_next.png" ), array( "escape" => false ) );
	
			?>
		
		</div>
	
		<div class="counter">
		
			<?php print $this->Paginator->counter( "%count% registro(s) encontrado(s)" ); ?>
		
		</div>
	
	</div>
	
<?php } ?>