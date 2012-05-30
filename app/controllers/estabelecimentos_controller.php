<?php

App::import( "Sanitize" );

class EstabelecimentosController extends AppController {

	/*----------------------------------------
	 * Atributtes
	 ----------------------------------------*/
	
	public $name		=	"Estabelecimentos";
	
	public $components	=	array( 'RequestHandler' );
	
	public $submenu		=	array( 
		
		'Estabelecimentos' => array( 'add', 'map' )
	);
	
	/*----------------------------------------
	 * Actions
	 ----------------------------------------*/

	public function index(){

		$this->checkAccess( $this->name, __FUNCTION__ );
		$this->paginate[ 'fields' ]		= array( 'id', 'nome', 'tipo' );
		$this->paginate[ 'order' ]		= "Estabelecimento.nome ASC";
		$this->set( "estabelecimentos", $this->paginate( "Estabelecimento" ) );
		$this->set( 'tipo', $this->Estabelecimento->tipo );
	}
	
	public function view( $id = null ){
		
		if( !(int)$id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, "index" );
		$this->Estabelecimento->contain();
		$this->set( "estabelecimento", $this->Estabelecimento->findById( $id ) );
		$this->setValues();
	}
	
	public function map(){
		
		$this->checkAccess( $this->name, __FUNCTION__ );
	}
	
	public function add(){
		
		$this->checkAccess( $this->name, __FUNCTION__ );
		
		if( !empty( $this->data ) ){
			
			$this->Estabelecimento->create( Sanitize::clean( $this->data ) );
			
			if( $this->Estabelecimento->validates() ){
				
				if( $this->Estabelecimento->save( null, false ) ){
					
					$this->Session->setFlash( "Estabelecimento salvo com sucesso.", "default", array( 'class' => 'success' ) );	
					$this->redirect( array( 'controller' => $this->name, 'action' => 'view', $this->Estabelecimento->id ) );
					
				} else				
					$this->Session->setFlash( "Ocorreu um erro ao tentar salvar Estabelecimento. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
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
			
			$this->Estabelecimento->contain();
			$this->data = $this->Estabelecimento->findById( $id );

		} else {
			
			$this->Estabelecimento->create( Sanitize::clean( $this->data ) );
			
			if( $this->Estabelecimento->validates() ){
					
				if( $this->Estabelecimento->save( $this->data, false ) ){
					
					$this->Session->setFlash( "Estabelecimento editado com sucesso.", "default", array( 'class' => 'success' ) );
					if( $redirect == 'index' ) $this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
					elseif( $redirect == 'view' ) $this->redirect( array( 'controller' => $this->name, 'action' => 'view', $id ) );
					
				} else
					$this->Session->setFlash( "Ocorreu um erro ao tentar editar Estabelecimento. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
			} else
				$this->Session->setFlash( "Preencha todos os campos abaixo corretamente e tente novamente.", "default", array( 'class' => 'error' ) );
		}
		
		$this->setValues();
	}
	
	public function delete( $id = null ){
		
		if( !(int)$id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, __FUNCTION__ );
		
		if( $this->Estabelecimento->delete( $id ) )
			$this->Session->setFlash( "Estabelecimento exclu&iacute;do com sucesso.", "default", array( 'class' => 'success' ) );
		else
			$this->Session->setFlash( "Ocorreu um erro ao tentar excluir Estabelecimento. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
			
		$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
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
			$estabelecimento = $this->Estabelecimento->find( 'first', array(
				'conditions' => array( 'id' => $id ),
				'fields' => array( 'localizacao' ),
				'contain' => false
			) );
			
			if( empty( $estabelecimento ) ){
				
				$this->set( "data", "Não existe estabelecimento com este ID!" );
				
			} else {
				
				$this->RequestHandler->setContent('json', 'application/json');
				$this->set( "data", json_encode( $estabelecimento[ 'Estabelecimento' ][ 'localizacao' ] ) );
			}
		}
	}
	
	/*----------------------------------------
	 * Controller Methods
	 ----------------------------------------*/
	
	private function setValues(){
		
		$this->set( 'tipo', $this->Estabelecimento->tipo );
		$this->set( 'estado', $this->Estabelecimento->estado );
	}
	
}

?>