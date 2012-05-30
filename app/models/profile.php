<?php

class Profile extends AppModel {
	
	/*----------------------------------------
	 * Atributtes
	 ----------------------------------------*/ 

	public $name 				= "Profile";
	
	/*----------------------------------------
	 * Associations
	 ----------------------------------------*/ 
	
	public $hasAndBelongsToMany = array( 'Area' );
	
	public $hasMany 			 = array( 'User' => array( 'dependent' => true ) );
	
	/*----------------------------------------
	 * Validation
	 ----------------------------------------*/
	
	public $validate = array(
	
		"name" => array(
			
			"rule"		=> array( 'between', 3, 50 ),
			"message"	=> "Nome deve conter entre 3 e 50 caracteres."
		)
	);
	
	/*----------------------------------------
	 * Methods
	 ----------------------------------------*/
		
	public function getAreas( $id ){

		$profile = $this->find( "first", array( 
			'conditions' => array( 'Profile.id' => $id ), 
			'fields' => 'Profile.modified',
			'contain' => array( 
				'Area' => array(
					'order' => 'controller_label ASC'
		) ) ) );
		
		$areas = array();
		
		foreach( $profile[ 'Area' ] as $area ){
			
			if( !isset( $areas[ $area[ 'controller' ] ] ) )
				$areas[ $area[ 'controller' ] ] = array( 'controller_label' => $area[ 'controller_label' ], 'action' => array(), 'actions_labels' => array() );
				
			$areas[ $area[ 'controller' ] ][ 'action' ][ $area[ 'action' ] ] = $area[ 'appear' ];
			$areas[ $area[ 'controller' ] ][ 'actions_labels' ][ $area[ 'action' ] ] = $area[ 'action_label' ];
		}
		
		return $areas;
	}
	
}

?>