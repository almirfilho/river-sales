<?php

class MenuHelper extends AppHelper {
	
	public $helpers = array( 'Html', 'Session' );
	
	public function getMenu(){
		
		$string			= '<ul id="menu">';
		$areas			= $this->Session->read( "Auth.User.Profile" );
		$controllers	= array_keys( $areas );
		
		foreach( $controllers as $controller ){
				
			$actions = array_keys( $areas[ $controller ][ 'action' ] );
			
			foreach( $actions as $action )
				if( $areas[ $controller ][ 'action' ][ $action ] )
					$string .= "<li>".$this->Html->link( $areas[ $controller ][ 'controller_label' ], array( 'controller' => $controller, 'action' => $action ), array( 'escape' => false, 'class' => 'round' ) )."</li>\n";
		}
			
		$string .= '</ul>';
				
		return $this->output( $string );
	}
	
	public function getSubMenu( $submenu ){
		
		if( !empty( $submenu ) ){
		
			$string			= "<ul>";
			$permissions	= $this->Session->read( "Auth.User.Profile" );
			// debug($permissions);
			foreach( $submenu as $controller => $actions ){
			
				if( !empty( $permissions[ $controller ] ) ){
				
					$string .= "<li>". $this->Html->link( $permissions[ $controller ][ 'controller_label' ], "/{$controller}", array( 'class' => "icon {$controller}", 'escape' => false ) );
					$string .= "<ul>";
					foreach( $actions as $action ){
						
						if( array_key_exists( $action, $permissions[ $controller ][ 'action' ] ) )
							$string .= "<li>". $this->Html->link( $permissions[ $controller ][ 'actions_labels' ][ $action ], "/{$controller}/{$action}", array( 'class' => "icon {$action}", 'escape' => false ) ) ."</li>";
					}
					
					$string .= "</ul></li>";
				}
			}
			
			$string .= "</ul>";
		
			return $this->output( $string );
			
		} else {
			
			return $this->output( null );
		}
	}
	
	public function getHeader( $header, $subtitle = null ){
		
		if( array_key_exists( $header[ 'controller' ], $this->Session->read( "Auth.User.Profile" ) ) ){
			
			$string = $this->Html->link( $this->Session->read( "Auth.User.Profile.{$header['controller']}.controller_label" ), "/{$header['controller']}", array( 'escape' => false ) );
			
			if( $header[ 'action' ] != "index" ){
				
				if( $header[ 'action' ] == 'view' )
					$header[ 'action' ] = "index";
					
				$word = $this->Session->read( "Auth.User.Profile.{$header['controller']}.actions_labels.{$header['action']}" );

				if( !$word )
					$word = $subtitle;

				$string .= '<span class="next">'. $word .'</span>';
			}
			
			return $this->output( $string );
			
		} else
			return $this->output( $subtitle );
	}
	
}

?>