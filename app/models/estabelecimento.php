<?php

class Estabelecimento extends AppModel {
	
	/*----------------------------------------
	 * Atributtes
	 ----------------------------------------*/ 
	
	public $name 			=	'Estabelecimento';
	
	public $displayField	=	'nome';
	
	public $actsAs			=	array( 'Point' );
	
	public $tipo			=	array(
		
		'M' => 'Mercadinho',
		'S' => 'Supermercado',
		'B' => 'Bar',
		'L' => 'Lanchonete',
		'R' => 'Restaurante',
		'D' => 'Distribuidora',
		'O' => 'Outro'
	);
	
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
		
		'tipo' 	=> array(
			
			'rule'		=> 'notEmpty',
			'message'	=> 'Selecione um Tipo.'
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
		
		'cep' 	=> array(
			
			'rule'		=> 'notEmpty',
			'message'	=> 'Preencha CEP.'
		),
		
		'telefone' 	=> array(
			
			'rule'		=> 'phone',
			'message'	=> 'Telefone inválido.',
			'allowEmpty' => true
		),
		
		'localizacao' 	=> array(
			
			'rule'		=> 'notEmpty',
			'message'	=> 'Indique a localização.',
		)
	);
		
}

?>