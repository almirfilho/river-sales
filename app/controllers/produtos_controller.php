<?php

App::import( "Sanitize" );

class ProdutosController extends AppController {

	/*----------------------------------------
	 * Atributtes
	 ----------------------------------------*/
	
	public $name	= "Produtos";
	
	public $submenu	= array( 
		
		'Produtos' => array( 'add', 'stock' )
	);
	
	/*----------------------------------------
	 * Actions
	 ----------------------------------------*/
	
	public function index(){

		$this->checkAccess( $this->name, __FUNCTION__ );
		$this->paginate[ 'fields' ]	= array( 'id', 'nome', 'quantidade_estoque' );
		$this->paginate[ 'order' ]	= "Produto.nome ASC";
		$this->set( "produtos", $this->paginate( "Produto" ) );
	}
	
	public function view( $id = null ){
		
		if( !(int)$id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, "index" );
		$this->Produto->contain();
		$this->set( "produto", $this->Produto->findById( $id ) );
	}
	
	public function add(){
		
		$this->checkAccess( $this->name, __FUNCTION__ );
		
		if( !empty( $this->data ) ){
			
			$this->Produto->create( Sanitize::clean( $this->data ) );
			
			if( $this->Produto->validates() ){
				
				if( $this->Produto->save( null, false ) ){
					
					$this->Session->setFlash( "Produto salvo com sucesso.", "default", array( 'class' => 'success' ) );	
					$this->redirect( array( 'controller' => $this->name, 'action' => 'view', $this->Produto->id ) );
					
				} else				
					$this->Session->setFlash( "Ocorreu um erro ao tentar salvar Produto. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
			} else				
				$this->Session->setFlash( "Preencha todos os campos abaixo corretamente e tente novamente.", "default", array( 'class' => 'error' ) );
		}
	}
	
	public function edit( $redirect = null, $id = null ){
		
		if( !$redirect || !(int)$id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, __FUNCTION__ );
			
		if( empty( $this->data ) ){
			
			$this->Produto->editing = true;
			$this->Produto->contain();
			$this->data = $this->Produto->findById( $id );

		} else {
			
			$this->Produto->create( Sanitize::clean( $this->data ) );
			
			if( $this->Produto->validates() ){
					
				if( $this->Produto->save( $this->data, false ) ){
					
					$this->Session->setFlash( "Produto editado com sucesso.", "default", array( 'class' => 'success' ) );
					if( $redirect == 'index' ) $this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
					elseif( $redirect == 'view' ) $this->redirect( array( 'controller' => $this->name, 'action' => 'view', $id ) );
					
				} else
					$this->Session->setFlash( "Ocorreu um erro ao tentar editar Produto. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
			} else
				$this->Session->setFlash( "Preencha todos os campos abaixo corretamente e tente novamente.", "default", array( 'class' => 'error' ) );
		}
	}
	
	public function delete( $id = null ){
		
		if( !(int)$id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, __FUNCTION__ );
		
		if( $this->Produto->delete( $id ) )
			$this->Session->setFlash( "Produto exclu&iacute;do com sucesso.", "default", array( 'class' => 'success' ) );
		else
			$this->Session->setFlash( "Ocorreu um erro ao tentar excluir Produto. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
			
		$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
	}
	
	public function stock(){
		
		$this->checkAccess( $this->name, __FUNCTION__ );
		
		if( !empty( $this->data ) ){
			
			$this->Produto->create( Sanitize::clean( $this->data ) );
			
			if( $this->Produto->validates() ){
				
				if( $this->Produto->stock() ){
					
					$this->Session->setFlash( "Entrada de estoque realizada com sucesso.", "default", array( 'class' => 'success' ) );	
					$this->redirect( array( 'controller' => $this->name, 'action' => 'view', $this->Produto->id ) );
					
				} else				
					$this->Session->setFlash( "Ocorreu um erro ao tentar realizar entrada de estoque. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
			} else				
				$this->Session->setFlash( "Preencha todos os campos abaixo corretamente e tente novamente.", "default", array( 'class' => 'error' ) );
		}
		
		$this->set( 'produtos', $this->Produto->find( 'list', array( 'order' => 'nome ASC' ) ) );
	}
	
	/*----------------------------------------
	 * Controller Methods
	 ----------------------------------------*/
	
}

?>