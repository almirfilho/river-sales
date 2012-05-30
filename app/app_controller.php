<?php

class AppController extends Controller {
	
	/*----------------------------------------
	 * Atributtes
	 ----------------------------------------*/
	
	public $title		=	"River Vendas";
	
	public $components	= 	array( 'Auth', 'Session' );
    
    public $helpers		= 	array( 'Form', 'Html', 'Paginator', 'Time', 'Text', 'Menu', 'Number' );
    
    public $paginate	=	array( 'limit' => 20, 'order' => 'created DESC', 'contain' => false );
    
    public $uses		=	array( 'Profile' );

	public $submenu		=	array();
	
	public $subtitle	=	null;
	
	/*----------------------------------------
	 * Callbacks
	 ----------------------------------------*/
	
	public function beforeRender(){

		$this->set( "title_for_layout", $this->title );
		$this->set( "submenu", $this->submenu );
		$this->set( "subtitle", $this->subtitle );
		$this->set( "header", array(
			'controller' => $this->name,
			'action' => $this->action
		) );
	}
	
	public function beforeFilter(){
		
	 	Security::setHash( "md5" );
	    $this->Auth->authorize 	= "controller";
	    $this->Auth->loginError	= "Login ou senha inv&aacute;lida.";
	    $this->Auth->authError	= "Por favor, efetue login para ter acesso a esta &aacute;rea.";
	    $this->getPermissions();
	}
	
	/*----------------------------------------
	 * Controller Methods
	 ----------------------------------------*/
	
	public function search(){
		
		if( !empty( $this->data ) ){
			
			$data = array_pop( $this->data );
			
			if( !empty( $data[ 'word' ] ) && !empty( $data[ 'field' ] ) ){
				
				$word = trim( str_replace( ";", "", Sanitize::escape( $data[ 'word' ] ) ) );
				$field = trim( str_replace( ";", "", Sanitize::escape( $data[ 'field' ] ) ) );
				$query = "w={$word};f={$field}";
				$this->redirect( array( 'controller' => $this->name, 'action' => 'index', $query ) );
			}
		}

		$this->redirect( array( 'controller' => $this->name, 'action' => 'index' ) );
	}
	
	protected function filter( $modelName, $filterFields ){
		
		if( !empty( $this->params[ 'pass' ][0] ) ){
			
			$query = $this->params[ 'pass' ][0];
			
			if( ereg( "^w=(.+);f=(.+)$", $query ) ){
				
				$array = explode( ";", $query );
				$word = substr( $array[0], 2 );
				$field = substr( $array[1], 2 );

				$this->paginate[ 'conditions' ] = array( "{$modelName}.{$field} LIKE" => "%{$word}%" );
			}
		}
		
		$this->set( "filter_fields", $filterFields );
	}
	
	protected function multipleActions( $action = null ){}

	private function getPermissions(){
		
		if( $this->Auth->user() )
			if( !$this->Session->check( "Auth.User.Profile" ) )
				$this->Session->write( "Auth.User.Profile", $this->Profile->getAreas( $this->Auth->user( "profile_id" ) ) );
	}
	
	public function isAuthorized(){
		
		return true;
	}
	
	protected function checkAccess( $controller = null, $action = null ){
		
		if( $controller == null || $action == null ){
			
			$this->Session->setFlash( "Ocorreu um erro de permiss&otilde;es. (erro: falta de parametros)", "default", array( 'class' => 'error' ) );
			$this->redirect( "/" );			
		}
		
		if( !$this->Session->check( "Auth.User" ) ){
			
			$this->Session->setFlash( "Por favor, efetue login para ter acesso a esta &aacute;rea.", "default", array( 'class' => 'error' ) );
			$this->redirect( "/" );	
		}
		
		if( !$this->Session->check( "Auth.User.Profile.$controller" ) ){
			
			$this->Session->setFlash( "Voc&ecirc; n&atilde;o tem acesso a esta &Aacute;rea ({$controller}).", "default", array( 'class' => 'error' ) );
			$this->redirect( "/" );
		}
		
		if( !$this->Session->check( "Auth.User.Profile.$controller.action.$action" ) ){
			
			$this->Session->setFlash( "Voc&ecirc; n&atilde;o tem acesso a esta opera&ccedil;&atilde;o ({$controller}->{$action}).", "default", array( 'class' => 'error' ) );
			$this->redirect( "/" );
		}
	}
	
	protected function checkList( $checks ){
		
		$list 	= array();
		$ids 	= array_keys( $checks );
		
		foreach( $ids as $id )
			if( $checks[ $id ] )
				$list[] = $id;
		
		return $list;
	}
	
}

?>