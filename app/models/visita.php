<?php

class Visita extends AppModel {
	
	/*----------------------------------------
	 * Atributtes
	 ----------------------------------------*/
	
	public $name		=	'Visita';
	
	public $editing		=	false;
	
	/*----------------------------------------
	 * Associations
	 ----------------------------------------*/
	
	public $belongsTo	=	array( 'Estabelecimento', 'Vendedor' );
	
	public $hasMany		=	array( 'Venda' => array( 'dependent' => true ) );
	
	/*----------------------------------------
	 * Validation
	 ----------------------------------------*/
	
	public $validate	=	array(
		
		'vendedor_id' 	=> array(
			
			'rule'		=> 'notEmpty',
			'message'	=> 'Selecione um Vendedor.'
		),
		
		'estabelecimento_id' 	=> array(
			
			'rule'		=> 'notEmpty',
			'message'	=> 'Selecione um Estabelecimento.'
		),
		
		'data' => array(
			
			'date' 	=> array(
				'rule'		=> array( 'date', 'dmy' ),
				'message'	=> 'Data inválida.'
			),
			
			'notEmpty' 	=> array(
				'rule'		=> 'notEmpty',
				'message'	=> 'Preencha Data.'
			)
		),
		
		'hora' => array(
			
			'time' 	=> array(
				'rule'		=> 'time',
				'message'	=> 'Hora inválida.'
			),
			
			'notEmpty' 	=> array(
				'rule'		=> 'notEmpty',
				'message'	=> 'Preencha Hora.'
			)
		),
		
		'data_ini' 	=> array(
			'rule'		=> array( 'date', 'dmy' ),
			'message'	=> 'Data inválida.',
			'allowEmpty' => true
		),
		
		'data_fim' 	=> array(
			'rule'		=> array( 'date', 'dmy' ),
			'message'	=> 'Data inválida.',
			'allowEmpty' => true
		)
	);
	
	/*----------------------------------------
	 * Callbacks
	 ----------------------------------------*/
	
	public function beforeValidate(){
		
		if( !empty( $this->data[ $this->name ][ 'data_ini' ] ) )
			if( $this->data[ $this->name ][ 'data_ini' ] == 'Data inicial' )
				$this->data[ $this->name ][ 'data_ini' ] = null;
				
		if( !empty( $this->data[ $this->name ][ 'data_fim' ] ) )
			if( $this->data[ $this->name ][ 'data_fim' ] == 'Data final' )
				$this->data[ $this->name ][ 'data_fim' ] = null;
		
		return true;
	}
	
	public function beforeSave(){
		
		// formata data
		$this->formatDate( 'data' );
		
		// formata texto
		$this->fixNewLine( 'observacao', '<br />' );
		
		return true;
	}
	
	public function afterFind( $results ){

		if( $this->editing ){
			
			if( !empty( $results[0][ $this->name ][ 'data' ] ) )
				$results[0][ $this->name ][ 'data' ] = date( 'd/m/Y', strtotime( $results[0][ $this->name ][ 'data' ] ) );
				
			if( !empty( $results[0][ $this->name ][ 'observacao' ] ) )
				$results[0][ $this->name ][ 'observacao' ] = str_replace( '<br />', "\n", $results[0][ $this->name ][ 'observacao' ] );
		}

		return $results;
	}
	
	/*----------------------------------------
	 * Methods
	 ----------------------------------------*/
	
	public function findPeriodo( $vendedor_id ){

		$conditions = array( 'vendedor_id' => $vendedor_id );
		
		if( $this->data[ $this->name ][ 'data_ini' ] && $this->data[ $this->name ][ 'data_fim' ] ){
			
			$this->formatDate( 'data_ini' );
			$this->formatDate( 'data_fim' );
			
			$conditions[ 'AND' ] = array( 
				'data >=' => $this->data[ $this->name ][ 'data_ini' ],
				'data <=' => $this->data[ $this->name ][ 'data_fim' ]
			);
			
		} else {
		
			if( $this->data[ $this->name ][ 'data_ini' ] ){
			
				$this->formatDate( 'data_ini' );
				$conditions[ 'data >=' ] = $this->data[ $this->name ][ 'data_ini' ];
			}
			
			if( $this->data[ $this->name ][ 'data_fim' ] ){
				
				$this->formatDate( 'data_fim' );
				$conditions[ 'data <=' ] = $this->data[ $this->name ][ 'data_fim' ];
			}
		}
		
		$visitas = $this->find( 'all', array( 
			'conditions' => $conditions,
			'fields' => array( 'id', 'data', 'hora', 'realizada' ),
			'order' => 'data ASC, hora ASC',
			'contain' => array(
				'Estabelecimento' => array(
					'fields' => array( 'id', 'nome' )
		) ) ) );
		
		foreach( $visitas as $i => $visita ){
			
			$this->Estabelecimento->id = $visitas[ $i ][ 'Estabelecimento' ][ 'id' ];
			$visitas[ $i ][ 'Estabelecimento' ][ 'localizacao' ] = str_replace( array( 'POINT(', ' ', ')' ), array( '', ',', '' ), $this->Estabelecimento->field( 'ST_AsText(localizacao)' ) );
		}
		
		return $visitas;
	}
	
	public function coords( $visitas ){
		
		$coords = '[';
		$array = array();
		
		foreach( $visitas as $visita )
			$array[] = "'{$visita['Estabelecimento']['localizacao']}'";
			
		$coords .= implode( ',', $array );
		$coords .= ']';
		
		return $coords;
	}
}

?>