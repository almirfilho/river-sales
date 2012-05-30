<?php

App::import( "Sanitize" );

class VendedoresController extends AppController {

	/*----------------------------------------
	 * Atributtes
	 ----------------------------------------*/
	
	public $name		=	"Vendedores";
	
	public $uses		=	array( 'Vendedor' );
	
	public $components	=	array( 'RequestHandler' );
	
	public $submenu		=	array( 
		
		'Vendedores' => array( 'add', 'map' )
	);
	
	/*----------------------------------------
	 * Actions
	 ----------------------------------------*/
	
	public function index(){

		$this->checkAccess( $this->name, __FUNCTION__ );
		$this->paginate[ 'fields' ]	= array( 'id', 'nome', 'cpf' );
		$this->paginate[ 'order' ]	= "Vendedor.nome ASC";
		$this->set( "vendedores", $this->paginate( "Vendedor" ) );
	}
	
	public function view( $id = null ){
		
		if( !(int)$id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, "index" );
		$this->Vendedor->contain();
		$this->set( "vendedor", $this->Vendedor->findById( $id ) );
		$this->setValues();
	}
	
	public function map(){
		
		$this->checkAccess( $this->name, __FUNCTION__ );
	}
	
	public function add(){
		
		$this->checkAccess( $this->name, __FUNCTION__ );
		
		if( !empty( $this->data ) ){
			
			$this->Vendedor->create( Sanitize::clean( $this->data ) );
			
			if( $this->Vendedor->validates() ){
				
				if( $this->Vendedor->save( null, false ) ){
					
					$this->Session->setFlash( "Vendedor salvo com sucesso.", "default", array( 'class' => 'success' ) );	
					$this->redirect( array( 'controller' => $this->name, 'action' => 'view', $this->Vendedor->id ) );
					
				} else				
					$this->Session->setFlash( "Ocorreu um erro ao tentar salvar Vendedor. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
			} else				
				$this->Session->setFlash( "Preencha todos os campos abaixo corretamente e tente novamente.", "default", array( 'class' => 'error' ) );
		}
		
		$this->setValues();
	}
	
	public function edit( $redirect = null, $id = null ){
		
		if( !$redirect || !(int)$id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, __FUNCTION__ );
			
		if( empty( $this->data ) ){
			
			$this->Vendedor->contain();
			$this->data = $this->Vendedor->findById( $id );

		} else {
			
			$this->Vendedor->create( Sanitize::clean( $this->data ) );
			
			if( $this->Vendedor->validates() ){
					
				if( $this->Vendedor->save( $this->data, false ) ){
					
					$this->Session->setFlash( "Vendedor editado com sucesso.", "default", array( 'class' => 'success' ) );
					if( $redirect == 'index' ) $this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
					elseif( $redirect == 'view' ) $this->redirect( array( 'controller' => $this->name, 'action' => 'view', $id ) );
					
				} else
					$this->Session->setFlash( "Ocorreu um erro ao tentar editar Vendedor. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
			} else
				$this->Session->setFlash( "Preencha todos os campos abaixo corretamente e tente novamente.", "default", array( 'class' => 'error' ) );
		}
		
		$this->setValues();
	}
	
	public function delete( $id = null ){
		
		if( !(int)$id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, __FUNCTION__ );
		
		if( $this->Vendedor->delete( $id ) )
			$this->Session->setFlash( "Vendedor exclu&iacute;do com sucesso.", "default", array( 'class' => 'success' ) );
		else
			$this->Session->setFlash( "Ocorreu um erro ao tentar excluir Vendedor. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
			
		$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
	}
	
	public function visitas( $id = null ){
		
		if( !(int)$id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
		
		$this->checkAccess( $this->name, 'index' );
		
		if( !empty( $this->data ) ){
			
			$this->Vendedor->Visita->create( Sanitize::clean( $this->data ) );
			
			if( $this->Vendedor->Visita->validates() ){
				
				$visitas = $this->Vendedor->Visita->findPeriodo( $id );
				$this->set( 'visitas', $visitas );
				$this->set( 'estabelecimentosCoords', $this->Vendedor->Visita->coords( $visitas ) );
				
			} else
				$this->Session->setFlash( "Preencha todos os campos abaixo corretamente e tente novamente.", "default", array( 'class' => 'error' ) );
		}
		
		$this->subtitle = 'Visualizar Visitas';
		$this->set( 'vendedor', $this->Vendedor->find( 'first', array( 
			'conditions' => array( 'Vendedor.id' => $id ),
			'fields' => array( 'id', 'nome', 'localizacao' ),
			'contain' => false
		) ) );
	}
	
	public function getLocation( $id = null ){
		
		if( !$this->RequestHandler->isAjax() )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		if( !$id ){
			
			$this->set( "data", "Erro de parametros" );
			
		} else {
			
			$this->checkAccess( $this->name, "index" );
			Configure::write('debug', 0);
			$this->layout = "ajax";
			$vendedor = $this->Vendedor->find( 'first', array(
				'conditions' => array( 'id' => $id ),
				'fields' => array( 'localizacao' ),
				'contain' => false
			) );
			
			if( empty( $vendedor ) ){
				
				$this->set( "data", "Não existe vendedor com este ID!" );
				
			} else {
				
				$this->RequestHandler->setContent('json', 'application/json');
				$this->set( "data", json_encode( $vendedor[ 'Vendedor' ][ 'localizacao' ] ) );
			}
		}
	}
	
	/*----------------------------------------
	 * Controller Methods
	 ----------------------------------------*/
	
	private function setValues(){
		
		$this->set( 'estado', $this->Vendedor->estado );
	}
	
}

?>