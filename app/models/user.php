<?php

class User extends AppModel {
	
	/*----------------------------------------
	 * Atributtes
	 ----------------------------------------*/ 
	
	public $name 			=	"User";
	
	/*----------------------------------------
	 * Associations
	 ----------------------------------------*/ 
	
	public $belongsTo 		= 	array( "Profile" );
	
	/*----------------------------------------
	 * Validation
	 ----------------------------------------*/
	
	public $validate 		= 	array(
		
		"name" 	=> array(
			
			"rule"		=> array( "between", 3, 100 ),
			"message"	=> "Nome deve conter entre 3 e 100 caracteres."
		),
		
		'email' => array(
		
			'rule' => 'email',
			'message' => 'Email inválido',
			'allowEmpty' => true
		),
		
		"username"	=>	array(
					
			"between" => array(
	
				"rule"	=>	array( "between", 6, 20 ),
				"message"	=>	"Login deve conter entre 6 e 20 caracteres."
			),
			
			"alphanumeric" => array(
	
				"rule"	=>	array( "alphanumeric" ),
				"message"	=>	"Login deve conter letras ou números."
			),
			
			"isUnique" => array(
	
				"rule"	=>	array( "isUnique", "login" ),
				"message"	=>	"Login já existente."
			)
		),
					
		"currentPasswordConfirmation"	=>	array(
				
			"rule"	=>	array( "passwordCompare", "currentPasswordConfirmation", "currentPassword" ),
			"message"	=>	"Senha errada."	
		),
		
		"newPassword" => array(
		
			"alphanumeric" => array(
	
				"rule" => array( "alphanumeric" ),
				"allowEmpty" => true,
				"message" => "A senha deve conter apenas letras e/ou números."
			),
			
			"between" => array(
	
				"rule" => array( "between", 6, 20 ),
				"allowEmpty" => true,
				"message" => "A senha deve conter entre 6 e 20 caracteres."
			)
		),
		
		"newPasswordConfirmation"	=>	array(
				
			"rule"	=>	array( "passwordConfirm", "newPasswordConfirmation", "newPassword" ),
			"message"	=>	"Confirme a Nova Senha corretamente."
		),
		
		'profile_id' => array(
			
			'rule' => 'notEmpty',
			'message' => 'Selecione um perfil.'
		)
	);
	
	/*----------------------------------------
	 * Methods
	 ----------------------------------------*/
		
	public function lastLogin( $user_id ){
		
		$date = date('Y-m-d H:i:s');
		$this->id = $user_id;
		$this->saveField( 'last_login', $date );
	}
	
	public function afterFind( $results ){
		
		foreach( $results as $i => $user )
			if( isset( $user[ $this->name ][ 'email' ] ) )
				if( !$user[ $this->name ][ 'email' ] )
					$results[ $i ][ $this->name ][ 'email' ] = '--';
		
		return $results;
	}
		
}

?>