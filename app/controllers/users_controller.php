<?php

App::import( "Sanitize" );

class UsersController extends AppController {

	/*----------------------------------------
	 * Atributtes
	 ----------------------------------------*/
	
	public $name	= "Users";
	
	public $submenu	= array( 
		
		'Users' => array( 'add' ),
		'Profiles' => array( 'add' )
	);
	
	/*----------------------------------------
	 * Actions
	 ----------------------------------------*/
	
	public function index(){

		$this->checkAccess( $this->name, __FUNCTION__ );
		$this->paginate[ 'fields' ]		= array( 'id', 'name', 'email' );
		$this->paginate[ 'contain' ]	= array( 'Profile' => array( 'fields' => 'name' ) );
		$this->paginate[ 'order' ]		= "User.created DESC";
		$this->set( "users", $this->paginate( "User" ) );
	}
	
	public function view( $id = null ){
		
		if( !(int)$id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, "index" );
		$this->User->contain( array( 'Profile' => array( 'fields' => array( 'name' ) ) ) );
		$this->set( "user", $this->User->findById( $id ) );
	}
	
	public function add(){
		
		$this->checkAccess( $this->name, __FUNCTION__ );
		
		if( !empty( $this->data ) ){
			
			$this->data[ "User" ][ "password" ] = Security::hash( "123456", "md5", true );
			$this->User->create( Sanitize::clean( $this->data ) );
			
			if( $this->User->validates() ){
				
				if( $this->User->save( null, false ) )
					$this->Session->setFlash( "Usu&aacute;rio salvo com sucesso.", "default", array( 'class' => 'success' ) );	
				else				
					$this->Session->setFlash( "Ocorreu um erro ao tentar salvar Usu&aacute;rio. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
				
				$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
				
			} else {
				
				$this->Session->setFlash( "Preencha todos os campos abaixo corretamente e tente novamente.", "default", array( 'class' => 'error' ) );
			}
		}

		$this->set( "profiles", $this->User->Profile->find( "list" ) );
	}
	
	public function edit( $redirect = null, $id = null ){
		
		if( !$redirect || !(int)$id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, __FUNCTION__ );

		if( $id == 1 ){
			
			$this->Session->setFlash( "Voc&ecirc; n&atilde;o pode editar o Usu&aacute;rio Administrador.", "default", array( 'class' => 'error' ) );
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
		}
			
		if( empty( $this->data ) ){
			
			$this->User->contain();
			$this->data = $this->User->findById( $id );

		} else {
			
			$this->User->create( Sanitize::clean( $this->data ) );
			
			if( $this->User->validates() ){
				
				if( $this->data[ "User" ][ "newPassword" ] != "" )
					$this->data[ "User" ][ "password" ] = Security::hash( $this->data[ "User" ][ "newPassword" ], "md5", true );
						
				if( $this->User->save( $this->data, false ) )
					$this->Session->setFlash( "Usu&aacute;rio editado com sucesso.", "default", array( 'class' => 'success' ) );
				else
					$this->Session->setFlash( "Ocorreu um erro ao tentar editar Usu&aacute;rio. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
				
				if( $redirect == 'index' ) $this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
				elseif( $redirect == 'view' ) $this->redirect( array( 'controller' => $this->name, 'action' => 'view', $id ) );
				
			} else {

				$this->Session->setFlash( "Preencha todos os campos abaixo corretamente e tente novamente.", "default", array( 'class' => 'error' ) );
			}
		}
		
		$this->set( "profiles", $this->User->Profile->find( "list" ) );
		$this->set( "redirect", $redirect );
	}
	
	public function delete( $id = null ){
		
		if( !(int)$id )
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
			
		$this->checkAccess( $this->name, __FUNCTION__ );
		
		$this->User->contain();
		$user = $this->User->findById( $id );
		
		if( $user[ 'User' ][ 'id' ] == $this->Auth->user( "id" ) ){
			
			$this->Session->setFlash( "Voc&ecirc; n&atilde;o pode excluir seu pr&oacute;prio usu&aacute;rio.", "default", array( 'class' => 'error' ) );
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
		}
		
		if( $user[ 'User' ][ 'profile_id' ] == 1 && $user[ 'User' ][ 'id' ] == 1 ){
			
			$this->Session->setFlash( "Voc&ecirc; n&atilde;o pode excluir o Usu&aacute;rio Administrador.", "default", array( 'class' => 'error' ) );
			$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
		}
		
		if( $this->User->delete( $id ) )
			$this->Session->setFlash( "Usu&aacute;rio exclu&iacute;do com sucesso.", "default", array( 'class' => 'success' ) );
		else
			$this->Session->setFlash( "Ocorreu um erro ao tentar excluir Usu&aacute;rio. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
			
		$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
	}
		
	public function login( $data = null ){

		$this->layout = "login";
    }
      
    public function logout(){

    	$this->User->lastLogin( $this->Auth->user( "id" ) );        
		$this->redirect( $this->Auth->logout() );
	}
	
	public function manageAccount(){
		
		if ( empty( $this->data ) ){
			
			//	pegando o user logado no BD
			$this->User->contain();
			$this->data = $this->User->findById( $this->Auth->user( "id" ) );
			$this->data[ "User" ][ "currentPassword" ] = $this->data[ "User" ][ "password" ];
			$this->data[ "User" ][ "password" ] = "";
			
		} else {
			
			if( $this->data[ 'User' ][ 'email' ] == '--' )
				$this->data[ 'User' ][ 'email' ] = '';
			
			$this->User->create( Sanitize::clean( $this->data ) );
			
			if ( $this->User->validates() ){
				
				if( $this->data[ "User" ][ "newPassword" ] != "" )
					$this->data[ "User" ][ "password" ] = Security::hash( $this->data[ "User" ][ "newPassword" ], "md5", true );
					
				if( empty( $this->data[ 'User' ][ 'email' ] ) )
					$this->data[ 'User' ][ 'email' ] = '--';
				
				if( $this->User->save( $this->data, false, array( "name", "email", "password", "modified" ) ) ){
					
					$this->Session->setFlash( "Seus dados foram atualizados com sucesso.", "default", array( 'class' => 'success' ) );
					$this->Session->write( "Auth.User.name", $this->data[ "User" ][ "name" ] );
					
				} else {
				
					$this->Session->setFlash( "Ocorreu um erro ao tentar atualizar seus dados. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
				}
				
				$this->redirect( "/" );
				
			} else {

				$this->Session->setFlash( "Preencha todos os campos abaixo corretamente e tente novamente.", "default", array( 'class' => 'error' ) );
			}
		}
		
		$this->submenu = array();
	}
	
	public function multipleActions( $action = null ){
		
		if( $this->data && $action ){
			
			switch( $action ){
				
				case "delete":
					
					$this->checkAccess( $this->name, $action );
					
					if( $this->User->deleteMultiple( $this->checkList( $this->data[ 'User' ][ 'checks' ] ) ) )
						$this->Session->setFlash( "Usu&aacute;rios exclu&iacute;dos com sucesso.", "default", array( 'class' => 'success' ) );
					else
						$this->Session->setFlash( "Ocorreu um erro ao tentar excluir um ou mais Usu&aacute;rios. Por favor tente novamente.", "default", array( 'class' => 'error' ) );
					
					break;
			}
		}
		
		$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
	}
	
	/*----------------------------------------
	 * Controller Methods
	 ----------------------------------------*/
	
	protected function checkList( $checks ){
		
		$list 	= parent::checkList( $checks );
		$len 	= sizeof( $list );
		$userId	= $this->Auth->user( "id" );
		
		for( $i = 0; $i < $len; $i++ )
			if( $list[ $i ] == 1 || $list[ $i ] == $userId )
				unset( $list[ $i ] );
		
		return $list;
	}
	
}

?>