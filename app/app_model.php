<?php

class AppModel extends Model {
	
	/*----------------------------------------
	 * Atributtes
	 ----------------------------------------*/ 
	
	public $actsAs 	= array( 'Containable' );
	
	public $estado	= array(
		
		'AC' => 'Acre',
		'AL' => 'Alagoas',
		'AP' => 'Amap&aacute;',
		'AM' => 'Amazonas',
		'BA' => 'Bahia',
		'CE' => 'Cear&aacute;',
		'DF' => 'Distrito Federal',
		'ES' => 'Esp&iacute;rito Santo',
		'GO' => 'Goi&aacute;s',
		'MA' => 'Maranh&atilde;o',
		'MT' => 'Mato Grosso',
		'MS' => 'Mato Grosso do Sul',
		'MG' => 'Minas Gerais',
		'PA' => 'Par&aacute;',
		'PB' => 'Para&iacute;ba',
		'PR' => 'Paran&aacute;',
		'PE' => 'Pernambuco',
		'PI' => 'Piau&iacute;',
		'RJ' => 'Rio de Janeiro',
		'RN' => 'Rio Grande do Norte',
		'RS' => 'Rio Grande do Sul',
		'RO' => 'Rond&ocirc;nia',
		'RR' => 'Roraima',
		'SC' => 'Santa Catarina',
		'SP' => 'S&atilde;o Paulo',
		'SE' => 'Sergipe',
		'TO' => 'Tocantins'
	);
	
	/*----------------------------------------
	 * Callback Methods
	 ----------------------------------------*/ 
	
	public function beforeValidate(){

        //    Setando timezone por causa do horario de verao
        return date_default_timezone_set( "America/Fortaleza" );
    }
		
	/*----------------------------------------
	 * Model Methods
	 ----------------------------------------*/ 
    
    public function deleteMultiple( $id_list ){
		
		$delete 	= 0;
		$success 	= 0;
		
		foreach( $id_list as $id ){
				
			$delete++;
			if( $this->delete( $id ) ) $success++;
		}
		
		return $success == $delete;
    }
	
	/*----------------------------------------
	 * Validation Methods
	 ----------------------------------------*/ 
	
	public function passwordCompare( $check, $password1, $password2 ){
		
		return Security::hash( $this->data[ $this->name ][ $password1 ], "md5", true ) == $this->data[ $this->name ][ $password2 ];
	}
	
	public function passwordConfirm( $check, $password1, $password2 ){

		return $this->data[ $this->name ][ $password1 ] == $this->data[ $this->name ][ $password2 ];
	}
	
	public function cpf( $check ){
		
		$cpf = html_entity_decode( array_pop( $check ) );
		if( !ereg( "([0-9]{3})[.]([0-9]{3})[.]([0-9]{3})[-]([0-9]{2})", $cpf ) ) return false;
		if( $cpf == "000.000.000-00" ) return false;
		
		$cpf = str_replace( array( ".", "-" ), "", $cpf );
		
		//	pega o digito verificador
		$dv_informado = (int)substr( $cpf, 9, 2 );
		
		//	calcula o valor do 10 digito de verificacao
		$soma = 0;
		for( $i = 0, $posicao = 10 ; $i < 9 ; $i++, $posicao-- )
			$soma += ( (int)$cpf{$i} ) * $posicao;
		
		$d10 = $soma % 11;
		if( $d10 < 2 ) $d10 = 0;
		else $d10 = 11 - $d10;
		
		//	calcula o valor do 11 digito de verificacao
		;
		$soma = 0;
		for( $i = 0, $posicao = 11 ; $i < 10 ; $i++, $posicao-- )
			$soma += ( (int)$cpf{$i} ) * $posicao;
		
		$d11 = $soma % 11;
		if( $d11 < 2 ) $d11 = 0;
		else $d11 = 11 - $d11;
		
		//	verifica se o dv calculado eh igual ao informado
		$dv = $d10 * 10 + $d11;
		
		return ( $dv == $dv_informado );
	}
	
	public function cnpj( $check ){
		
		$cnpj = html_entity_decode( array_pop( $check ) );
		if( !ereg( "([0-9]{2})[.]([0-9]{3})[.]([0-9]{3})[/]([0-9]{4})[-]([0-9]{2})", $cnpj ) ) return false;
		if( $cnpj == "00.000.000/0000-00" ) return false;
		
		$cnpj = str_replace( array( '.', '/', '-' ), "", $cnpj );
		
   		$j = 5;
		$k = 6;
		$soma1 = "";
		$soma2 = "";
		
		for($i = 0; $i < 13; $i++){
			
			$j = $j == 1 ? 9 : $j;
			$k = $k == 1 ? 9 : $k;
			$soma2 += ($cnpj{$i} * $k);
		
			if ($i < 12){
				$soma1 += ($cnpj{$i} * $j);
			}
			
			$k--;
			$j--;
		}
		
		$digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
		$digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;
		
		return (($cnpj{12} == $digito1) and ($cnpj{13} == $digito2));
		
	}
	
	public function cep( $check ){
       
        $string = html_entity_decode( array_pop( $check ) );
        return ereg( "([0-9]{5})[-]([0-9]{3})", $string );
    }
   
    public function phone( $check ){
       
        $string = html_entity_decode( array_pop( $check ) );
        return ereg( "[(]([0-9]{2})[)]([0-9]{4})[-]([0-9]{4})", $string );
    }
    
	public function file( $check ){
       
		$file = array_pop( $check );
        if( $file[ 'error' ] != 0 ) return false;
        else return true;
    }
    
	public function float( $check ){
       
        $string = html_entity_decode( array_pop( $check ) );
        return preg_match( "/(^\d*\,?\d*[1-9]+\d*$)|(^[1-9]+\d*\,\d*$)/", $string );
    }
    
	/*------------------------------------------
     *         Miscellaneous Functions
     *-----------------------------------------*/
   
    protected function deleteFile( $path, $filename ){
              
        $path = APP . substr( $path, 4 );
        $path = str_replace( "/", DS, $path );
        $path = str_replace( "\\\\", DS, $path );
       
        return unlink( $path . DS . $filename );
    }
	
	protected function formatDate( $field ){
		
		if( isset( $this->data[ $this->name ][ $field ] ) )
			$this->data[ $this->name ][ $field ] = substr( $this->data[ $this->name ][ $field ], 6 ) ."-". substr( $this->data[ $this->name ][ $field ], 3, 2 ) ."-". substr( $this->data[ $this->name ][ $field ], 0, 2 );
	}
	
	protected function fixNewLine( $field, $replace = "" ){
		
		if( array_key_exists( $field, $this->data[ $this->name ] ) )
			$this->data[ $this->name ][ $field ] = str_replace( "\n", $replace, $this->data[ $this->name ][ $field ] );
	}
	
}