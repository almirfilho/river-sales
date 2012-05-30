<?php

class PointBehavior extends ModelBehavior {
	
	/*----------------------------------------
	 * Attributes
	 ----------------------------------------*/
	
	public $model;
	
	private $point;
	
	private $srid = '900913';
	
	/*----------------------------------------
	 * Callbacks
	 ----------------------------------------*/
	
	public function setup( &$model, $settings = array() ){
		
		$this->model = $model;
	}
	
	public function beforeSave( &$model ){

		if( !empty( $model->data[ $model->name ][ 'localizacao' ] ) ){
			
			$this->point = $model->data[ $model->name ][ 'localizacao' ];
			unset( $model->data[ $model->name ][ 'localizacao' ] );
		}

		return true;
	}
	
	public function afterSave( &$model, $created ){

		if( !empty( $this->point ) ){
			
			$this->point = explode( ',', $this->point );
			$model->query( "UPDATE {$model->table} SET \"localizacao\" = ST_GeomFromText('POINT({$this->point[0]} {$this->point[1]})',{$this->srid}) WHERE id = {$model->id}" );
		}
	}
	
	public function beforeFind( &$model, $queryData ){
		
		$model->virtualFields = array( 'localizacao' => 'ST_AsText(localizacao)' );
	}
	
	public function afterFind( &$model, $results, $primary ){
		
		foreach( $results as $i => $estabelecimento )
			if( !empty( $estabelecimento[ $model->name ][ 'localizacao' ] ) )
				$results[ $i ][ $model->name ][ 'localizacao' ] = str_replace( array( 'POINT(', ' ', ')' ), array( '', ',', '' ), $estabelecimento[ $model->name ][ 'localizacao' ] );
		
		return $results;
	}
	
}

?>