<?php

App::import( "Sanitize" );

class VisitasController extends AppController {

	/*----------------------------------------
	 * Atributtes
	 ----------------------------------------*/
	
	public $name	= "Visitas";
	
	public $submenu	= array( 
		
		'Visitas' => array( 'add' )
	);
	
	/*----------------------------------------
	 * Actions de Visitas
	 ----------------------------------------*/
	
	public function index(){
	
		$this->checkAccess( $this->name, __FUNCTION__ );

		if( !empty( $this->data ) ){

			$this->Visita->create( Sanitize::clean( $this->data ) );

			if( $this->Visita->validates() ){

				$visitas = $this->Visita->findPeriodo( $this->Visita->data[ 'Visita' ][ 'vendedor_id' ] );
				$this->set( 'visitas', $visitas );
				$this->set( 'estabelecimentosCoords', $this->Visita->coords( $visitas ) );
				
				$this->Visita->Vendedor->id = $this->Visita->data[ 'Visita' ][ 'vendedor_id' ];
				$this->set( 'vendedorLocalizacao', $this->Visita->Vendedor->field( 'localizacao' ) );

			} else
				$this->Session->setFlash( "Preencha todos os campos abaixo corretamente e tente novamente.", "default", array( 'class' => 'error' ) );
		}
		
		$this->set( 'vendedores', $this->Visita->Vendedor->find( 'list', array( 'order' => 'nome ASC' ) ) );
	}
	
	public function view( $id = null ){
		
		if( !(int)$id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, "index" );

		$this->Visita->contain( array(
			'Venda' => array(
				'order' => 'created ASC',
				'fields' => array( 'id', 'quantidade', 'valor_total' ),
				'Produto' => array(
					'fields' => array( 'nome' )
		) ) ) );
		$visita = $this->Visita->findById( $id );
		
		$this->set( 'visita', $visita );
		$this->set( 'estabelecimento', $this->Visita->Estabelecimento->find( 'first', array(
			'conditions' => array( 'id' => $visita[ 'Visita' ][ 'estabelecimento_id' ] ),
			'fields' => array( 'nome', 'localizacao' ),
			'contain' => false
		) ) );
		$this->set( 'vendedor', $this->Visita->Vendedor->find( 'first', array(
			'conditions' => array( 'id' => $visita[ 'Visita' ][ 'vendedor_id' ] ),
			'fields' => array( 'nome', 'localizacao' ),
			'contain' => false
		) ) );
	}
	
	public function add( $vendedor_id = null ){
		
		$this->checkAccess( $this->name, __FUNCTION__ );
		
		if( !empty( $this->data ) ){
			
			$this->Visita->create( Sanitize::clean( $this->data ) );
			
			if( $this->Visita->validates() ){
				
				if( $this->Visita->save( null, false ) ){
					
					$this->Session->setFlash( "Visita salva com sucesso.", "default", array( 'class' => 'success' ) );	
					
					if( $vendedor_id ) $this->redirect( array( 'controller' => 'vendedores', 'action' => 'view', $vendedor_id ) );
					else $this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
					
				} else				
					$this->Session->setFlash( "Ocorreu um erro ao tentar salvar Visita. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
			} else				
				$this->Session->setFlash( "Preencha todos os campos abaixo corretamente e tente novamente.", "default", array( 'class' => 'error' ) );
		}
		
		if( $vendedor_id )
			$this->set( 'vendedor', $this->Visita->Vendedor->find( 'first', array(
				'conditions' => array( 'id' => $vendedor_id ),
				'fields' => array( 'id', 'nome', 'cpf', 'localizacao' ),
				'contain' => false
			) ) );
		else
			$this->set( 'vendedores', $this->Visita->Vendedor->find( 'list', array(
				'order' => 'nome ASC',
				'contain' => false
			) ) );
			
		$this->set( 'estabelecimentos', $this->Visita->Estabelecimento->find( 'list', array( 'order' => 'nome ASC' ) ) );
	}
	
	public function edit( $id = null ){
		
		if( !(int)$id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, __FUNCTION__ );
			
		if( empty( $this->data ) ){
			
			$this->Visita->editing = true;
			$this->Visita->contain();
			$this->data = $this->Visita->findById( $id );
	
		} else {
			
			$this->Visita->create( Sanitize::clean( $this->data ) );
			
			if( $this->Visita->validates() ){
					
				if( $this->Visita->save( $this->data, false ) ){
					
					$this->Session->setFlash( "Visita editada com sucesso.", "default", array( 'class' => 'success' ) );
					$this->redirect( array( 'controller' => $this->name, 'action' => 'view', $id ) );
					
				} else
					$this->Session->setFlash( "Ocorreu um erro ao tentar editar Visita. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
			} else
				$this->Session->setFlash( "Preencha todos os campos abaixo corretamente e tente novamente.", "default", array( 'class' => 'error' ) );
		}
		
		$this->set( 'visita', $this->Visita->find( 'first', array(
			'conditions' => array( 'Visita.id' => $id ),
			'fields' => array( 'id' ),
			'contain' => array(
				'Estabelecimento' => array(
					'fields' => array( 'nome' ) ),
				'Vendedor' => array(
					'fields' => array( 'nome' ) )
		) ) ) );
	}
	
	public function delete( $visita_id = null, $vendedor_id = null ){
		
		if( !(int)$visita_id || !(int)$vendedor_id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, __FUNCTION__ );
		
		if( $this->Visita->delete( $visita_id ) )
			$this->Session->setFlash( "Visita exclu&iacute;da com sucesso.", "default", array( 'class' => 'success' ) );
		else
			$this->Session->setFlash( "Ocorreu um erro ao tentar excluir Visita. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
			
		$this->redirect( array( 'controller' => 'vendedores', 'action' => 'visitas', $vendedor_id ) );
	}
	
	/*----------------------------------------
	 * Actions de Vendas
	 ----------------------------------------*/
	
	public function addVenda( $visita_id = null ){
		
		if( !(int)$visita_id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, "edit" );
		
		if( !empty( $this->data ) ){
			
			$this->Visita->Venda->create( Sanitize::clean( $this->data ) );
			
			if( $this->Visita->Venda->validates() ){
				
				$this->Visita->Venda->data[ 'Venda' ][ 'visita_id' ] = $visita_id;
				
				if( $this->Visita->Venda->save( null, false ) ){
					
					$this->Session->setFlash( "Venda salva com sucesso.", "default", array( 'class' => 'success' ) );	
					$this->redirect( array( 'controller' => $this->name, 'action' => 'view', $visita_id ) );
					
				} else				
					$this->Session->setFlash( "Ocorreu um erro ao tentar salvar Venda. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
			} else				
				$this->Session->setFlash( "Preencha todos os campos abaixo corretamente e tente novamente.", "default", array( 'class' => 'error' ) );
		}
		
		$this->subtitle = 'Adicionar Venda';
		$this->set( 'produtos', $this->Visita->Venda->Produto->find( 'list', array( 'order' => 'nome ASC' ) ) );
	}
	
	public function editVenda( $visita_id = null, $venda_id = null ){
		
		if( !(int)$visita_id || !(int)$venda_id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, "edit" );
			
		if( empty( $this->data ) ){
			
			$this->Visita->Venda->contain();
			$this->data = $this->Visita->Venda->findById( $venda_id );
	
		} else {
			
			$this->Visita->Venda->create( Sanitize::clean( $this->data ) );
			
			if( $this->Visita->Venda->validates() ){
					
				if( $this->Visita->Venda->save( null, false ) ){
					
					$this->Session->setFlash( "Venda editada com sucesso.", "default", array( 'class' => 'success' ) );
					$this->redirect( array( 'controller' => $this->name, 'action' => 'view', $visita_id ) );
					
				} else
					$this->Session->setFlash( "Ocorreu um erro ao tentar editar Venda. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
			} else
				$this->Session->setFlash( "Preencha todos os campos abaixo corretamente e tente novamente.", "default", array( 'class' => 'error' ) );
		}
		
		$this->subtitle = 'Editar Venda';
		$this->set( 'produtos', $this->Visita->Venda->Produto->find( 'list', array( 'order' => 'nome ASC' ) ) );
	}
	
	public function deleteVenda( $visita_id = null, $venda_id = null ){
		
		if( !(int)$visita_id || !(int)$venda_id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, "edit" );
		
		if( $this->Visita->Venda->delete( $venda_id ) )
			$this->Session->setFlash( "Venda exclu&iacute;da com sucesso.", "default", array( 'class' => 'success' ) );
		else
			$this->Session->setFlash( "Ocorreu um erro ao tentar excluir Venda. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
			
		$this->redirect( array( 'controller' => $this->name, 'action' => 'view', $visita_id ) );
	}
	
}

?>