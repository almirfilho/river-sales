<?php

class Produto extends AppModel {
	
	/*----------------------------------------
	 * Atributtes
	 ----------------------------------------*/ 
	
	public $name 			=	'Produto';
	
	public $displayField	=	'nome';
	
	public $editing			=	false;
	
	/*----------------------------------------
	 * Associations
	 ----------------------------------------*/ 
	
	public $hasMany			=	array( 'Venda' => array( 'dependent' => true ) );
	
	/*----------------------------------------
	 * Validation
	 ----------------------------------------*/
	
	public $validate 		= 	array(
		
		'id' 	=> array(
			
			'rule'		=> 'notEmpty',
			'message'	=> 'Selecione um produto.'
		),
		
		'nome' 	=> array(
			
			'rule'		=> 'notEmpty',
			'message'	=> 'Preencha Nome.'
		),
		
		'valor' => array(
			
			'numeric' 	=> array(	
				'rule'		=> 'numeric',
				'message'	=> 'Número inválido.'
			),
		
			'notEmpty' 	=> array(
				'rule'		=> 'notEmpty',
				'message'	=> 'Preencha Valor.'
			)
		),
		
		'qnt' => array(
			
			'numeric' 	=> array(	
				'rule'		=> 'numeric',
				'message'	=> 'Número inválido.'
			),
		
			'notEmpty' 	=> array(
				'rule'		=> 'notEmpty',
				'message'	=> 'Preencha a quantidade a ser adicionada.'
			)
		)
	);
	
	/*----------------------------------------
	 * Callbacks
	 ----------------------------------------*/

	public function beforeValidate(){
		
		// substitui ',' por '.' no valor
		if( array_key_exists( 'valor', $this->data[ $this->name ] ) )
			$this->data[ $this->name ][ 'valor' ] = str_replace( ',', '.', $this->data[ $this->name ][ 'valor' ] );
			
		return true;
	}

	public function beforeSave(){
		
		// substitui ',' por '.' no valor
		if( array_key_exists( 'valor', $this->data[ $this->name ] ) )
			$this->data[ $this->name ][ 'valor' ] = str_replace( ',', '.', $this->data[ $this->name ][ 'valor' ] );

		// substitui '\n' por '<br />' nos textos
		$this->fixNewLine( 'descricao', '<br />' );
		$this->fixNewLine( 'observacao', '<br />' );

		return true;
	}
	
	public function afterFind( $results ){
		
		if( $this->editing ){
			
			foreach( $results as $i => $produto ){
				
				if( !empty( $produto[ $this->name ][ 'descricao' ] ) )
					$results[ $i ][ $this->name ][ 'descricao' ] = str_replace( '<br />', '', $produto[ $this->name ][ 'descricao' ] );
					
				if( !empty( $produto[ $this->name ][ 'observacao' ] ) )
					$results[ $i ][ $this->name ][ 'observacao' ] = str_replace( '<br />', '', $produto[ $this->name ][ 'observacao' ] );
			}
		}
		
		return $results;
	}
	
	/*----------------------------------------
	 * Methods
	 ----------------------------------------*/
	
	public function stock(){
		
		$this->id = $this->data[ $this->name ][ 'id' ];
		$estoque = $this->field( 'quantidade_estoque' );
		
		return $this->saveField( 'quantidade_estoque', $estoque + $this->data[ $this->name ][ 'qnt' ] );
	}
	
}

?>