<?php

class Vendedor extends AppModel {
	
	/*----------------------------------------
	 * Atributtes
	 ----------------------------------------*/ 
	
	public $name 			=	'Vendedor';
	
	public $useTable		=	'vendedores';
	
	public $displayField	=	'nome';
	
	public $actsAs			=	array( 'Point' );
	
	/*----------------------------------------
	 * Associations
	 ----------------------------------------*/ 
	
	public $hasMany			=	array( 'Visita' => array( 'dependent' => true ) );
	
	/*----------------------------------------
	 * Validation
	 ----------------------------------------*/
	
	public $validate 		= 	array(
		
		'nome' 	=> array(
			
			'rule'		=> 'notEmpty',
			'message'	=> 'Preencha Nome.'
		),
		
		'cpf' => array(
			
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Este CPF já está cadastrado!'
			),
			
			'cpf' 	=> array(	
				'rule'		=> 'cpf',
				'message'	=> 'CPF inválido.'
			),
		
			'notEmpty' 	=> array(
				'rule'		=> 'notEmpty',
				'message'	=> 'Preencha CPF.'
			)
		),
		
		'endereco' 	=> array(
			
			'rule'		=> 'notEmpty',
			'message'	=> 'Preencha Endereço.'
		),
		
		'bairro' 	=> array(
			
			'rule'		=> 'notEmpty',
			'message'	=> 'Preencha Bairro.'
		),
		
		'cidade' 	=> array(
			
			'rule'		=> 'notEmpty',
			'message'	=> 'Preencha Cidade.'
		),
		
		'estado' 	=> array(
			
			'rule'		=> 'notEmpty',
			'message'	=> 'Selecione um Estado.'
		),
		
		'cep' => array(
			
			'cep' 	=> array(
				'rule'		=> 'cep',
				'message'	=> 'CEP inválido.'
			),
			
			'notEmpty' 	=> array(
				'rule'		=> 'notEmpty',
				'message'	=> 'Preencha CEP.'
			)
		),
		
		'telefone' 	=> array(
			
			'rule'		=> 'phone',
			'message'	=> 'Telefone inválido.',
			'allowEmpty' => true
		),
		
		'celular' => array(
			
			'phone' 	=> array(
				'rule'		=> 'phone',
				'message'	=> 'Telefone inválido.'
			),
			
			'notEmpty' 	=> array(
				'rule'		=> 'notEmpty',
				'message'	=> 'Preencha telefone celular.'
			)
		),
		
		'localizacao' 	=> array(
			
			'rule'		=> 'notEmpty',
			'message'	=> 'Indique a localização.',
		)
	);
		
}

?>