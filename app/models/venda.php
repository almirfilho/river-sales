<?php

class Venda extends AppModel {
	
	/*----------------------------------------
	 * Atributtes
	 ----------------------------------------*/
	
	public $name		=	"Venda";
	
	/*----------------------------------------
	 * Associations
	 ----------------------------------------*/
	
	public $belongsTo	=	array( 'Visita', 'Produto' );
	
	/*----------------------------------------
	 * Validation
	 ----------------------------------------*/
	
	public $validate	=	array(
		
		'produto_id' => array(
			
			'rule' => 'notEmpty',
			'message' => 'Selecione um produto.'
		),
		
		'quantidade' => array(
			
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Número inválido.'
			),
			
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Preencha Quantidade.'
			)
		)
	);
	
	/*----------------------------------------
	 * Callbacks
	 ----------------------------------------*/
	
	public function beforeSave(){
		
		if( !$this->id ){ // se estiver adicionando apenas
			
			$this->Visita->id = $this->data[ $this->name ][ 'visita_id' ];
			$this->data[ $this->name ][ 'vendedor_id' ] = $this->Visita->field( 'vendedor_id' );
		}
		
		$this->Produto->id = $this->data[ $this->name ][ 'produto_id' ];
		$this->data[ $this->name ][ 'valor_total' ] = $this->data[ $this->name ][ 'quantidade' ] * $this->Produto->field( 'valor' );
		
		return true;
	}
	
}

?>