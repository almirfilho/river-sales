<?php
/**
 * *Upload* class file.
 *
 * @Autor Tulio Faria
 * @Contribuição Helio Ricardo, Vinicius Cruz, Caio Gondim
 * @Link http://www.tuliofaria.net
 * @Licença MIT
 * @Versão x.x $Data: xx-xx-2007
 */
class UploadComponent extends Object{

    var $controller = true;
    
    var $path = "";
    //	Tamanho Máximo Permitido
    var $maxSize; 
    //	Arquivos Permitidos
    var $allowedExtensions = array( "jpg", "jpeg", "gif", "png" );
    //	Log de Erro
    var $logErro = "";
    
    var $source;
    
    var $name;
    
    var $newName;
    
    var $cod;
    
    var $uploaded = false;
    
    var $thumbnailScale = 220;
    
    var $thumbnailPath = "";

    function startup( &$controller ){

        $this->path    			= APP . WEBROOT_DIR . DS;
		$this->thumbnailPath	= APP . WEBROOT_DIR . DS;
        $this->maxSize 			= 10*1024*1024; // 10MB
        
    }
    
    function setPath( $p ){
    
        if( $p != NULL ){
        
            $this->path = $this->path . $p;
            $this->path = eregi_replace( "/", DS, $this->path );
            $this->path = eregi_replace( "\\\\", DS, $this->path );
            
            if( $this->verifyDir( $this->path ) === FALSE )
            	$this->setLog( "->  Erro ao tentar criar o diretório {$this->path}" );
            
            return TRUE;
        }
    }
    
	function setThumbnailPath( $p ){
    
        if( $p != NULL ){
        
            $this->thumbnailPath = $this->thumbnailPath . $p;
            $this->thumbnailPath = eregi_replace( "/", DS, $this->thumbnailPath );
            $this->thumbnailPath = eregi_replace( "\\\\", DS, $this->thumbnailPath );
            
            if( $this->verifyDir( $this->thumbnailPath ) === FALSE )
            	$this->setLog( "->  Erro ao tentar criar o diretório {$this->thumbnailPath}" );
            
            return TRUE;
        }
    }
    
    function setExtensions( $array ){
    	
    	if( is_array( $array ) )
    		$this->allowedExtensions = $array;
    	
    }
    
    /*
     * Retorna caminho completo para o arquivo.
     */
    function completePath(){
    	return $this->path . $this->name;
    }
    
    /*
     * Retorna caminho relativo ao WEB_ROOT para o arquivo.
     * Caso seja uma imagem, o caminho será relativo a WEBROOT_DIR/img 
     */
    function relativePath(){
    	
    	$relativePath = $this->CompletePath();
    	
    	if( in_array( $this->getExt( $this->name ), array( "jpg", "jpeg", "png", "gif" ) ) ){
    		
    		return str_replace( APP . WEBROOT_DIR . DS . "img/", "", $relativePath );
    		
    	}else{
    		
    		return str_replace( APP, "", $relativePath );
    	
    	}
    }
    
    //	Verifica se o caminho pasado existe, caso não exista a pasta é criada
    function verifyDir( $dir ){
    	//print $dir ."<br />";
    	if( !is_dir( $dir ) ){
    		return mkdir( $dir );
    	}
    }
    
    //	Seta novo tamanho máximo
    function setMaxFileSize( $size ){
        $this->maxSize = $size;
    }
    
    //	Adiciona nova extensão no array
    function addAllowedExt( $ext ){
    
        if ( is_array( $ext ) ){
        
            $this->allowedExtensions = array_merge($this->allowedExtensions, $ext);

        } else {
            array_push($this->allowedExtensions, $ext);
        }
    }
    
    //	Retorna extensão de arquivo
    function getExt( $file ){
        $p = explode( ".", $file );
        return strtolower( $p[ count( $p ) - 1 ] );
    }
    
    //	Exibe lista de extensões em array
    function viewExt(){
    
        $list_tmp = "";
        
        for( $a=0 ; $a < count( $this->allowedExtensions ) ; $a++ ){
            $list_tmp.= $this->allowedExtensions[ $a ] . ", ";
        }
        
        return strtolower( substr( $list_tmp, 0, -2 ) );
    }
    
    //	Verifica se arquivo pode ser feito *upload*
    function verifyUpload( $file ){
        $passed = false; //	Variável de controle
        if( is_uploaded_file( $file[ "tmp_name" ] ) ){
                $ext = $this->getExt( $file[ "name" ] );
            if( ( count( $this->allowedExtensions ) == 0 ) || ( in_array( $ext, $this->allowedExtensions ) ) ){
                $passed = true;
            }
        }
        return $passed;
    }
    
    //	Copia arquivo para destino
    function copyUploadedFile( $source, $destination = "", $thumbnail = false, $resizeScale = null ){
    	
    	$this->source 	= $source;
//    	$this->name		= str_replace( " ", "_", $source[ "name" ] ); //	substituindo os espacos em branco.
//    	$this->name		= htmlentities( $this->name );
		$this->name		= $this->renameFile( $source[ 'name' ] );
    	$this->newName	= $this->name;
    	
    	//	Destino completo
        $this->path 			= $this->path . $destination . DS;
        $this->thumbnailPath	= $this->thumbnailPath . $destination . DS;
        
        //	Verifica se arquivo é permitido
        if( $this->verifyUpload( $source ) ){
            
        	$filename = $this->verifyFileExists( $this->name );
        	
	        if( move_uploaded_file( $source[ "tmp_name" ], $this->path . $filename ) ){
				
	        	$this->setLog();
	        	
	        	if( $thumbnail )
	        		$this->createThumbnail();
	        	
	        	if( $resizeScale )
	        		$this->resizeImage( $filename, $resizeScale );
	        		
	        	$this->uploaded = true;
	        
	        	return true;
	        	
	        } else {
	        
	            $this->setLog(); 
	        	$this->setLog( "-> Erro ao enviar arquivo<br />" );
	            $this->setLog( "   Obs.: " . $this->getErrorUpload( $source[ "error" ] ) . "<br />" );
	
	            return false;
	        }
	        
        } else {
        	
        	$this->setLog();
            $this->setLog( "-> O arquivo que você está tentando enviar não é permitido pelo administrador<br />" );
            $this->setLog( "   Obs.: Apenas as extensões " . $this->viewExt() . " são permitidas.<br />" );

            return false;
        }
    }
    
    function deleteUploadedFile( $file = null, $hasThumbnail = false ){
    	
    	if( $file ){
    	
	    	unlink( $this->path .DS. $file );
	    	
	    	if( $hasThumbnail )
	    		unlink( $this->thumbnailPath .DS. $file );
			
    	} else {
    		
    		if( !$this->uploaded ) return;
    		
			unlink( $this->path .DS. $this->newName );
			
			if( $this->thumbnailPath != "" )
				unlink( $this->thumbnailPath .DS. $this->newName );
			
    	}
    	
    }

    //	Gerencia log de erro
    function setLog( $msg = NULL )
    {
        if( $msg == NULL ){
    		$this->logErro = 
<<<EOT
        =============== *UPLOAD* LOG =============== <br />
        Pasta destino: $this->path <br />
       	Nome do arquivo: {$this->source[ "name" ]} <br />
        Tamanho do arquivo: {$this->source[ "size" ]} bytes<br />
        Tipo de arquivo: {$this->source[ "type" ]} <br />
		---------------------------------------------------------------<br /><br />
EOT;
        }else{
    		$this->logErro .= $msg;
        }
    }
    
    function getLog()
    {
        return $this->logErro;
    }
    
    function getErrorUpload( $cod = "" )
    {
    	if( $cod != "" )
    		$this->cod = $cod;
    	
         switch( $this->cod )
         {
            case 1:
                return "Arquivo com tamanho maior que definido no servidor.";
            break;
            
            case 2:
            	return "Arquivo com tamanho maior que definido no formulário de envio.";
            break;
            
            case 3:
            	return "Arquivo enviado parcialmente.";
            break;
            
            case 4:
                return "Não foi possível realizar *upload*do arquivo.";
            break;
            
            case 5:
            	return "The servers temporary folder is missing.";
            break;
            
            case 6:
                return "Failed to write to the temporary folder.";
            break;
         }
    }
    
    //	Checa se arquivo já existe no servidor, e renomea
    function verifyFileExists( $file )
    {
        if( !file_exists( $this->path . $file ) ){
            return $file;
        } else {
            $this->newName = $this->renameFile( $file );
            return $this->newName;
        }
    }
    
    //	Renomea Arquivo, para evitar sobescrever
    function renameFile( $file )
    {
        $ext = $this->getExt( $file ); //	Retorna extensão do arquivo
        $file_tmp = explode( ".", $file ); //	Nome do arquivo, sem extensao
        $file_tmp = array_slice( $file_tmp, 0, sizeof( $file_tmp ) - 1 );
        $file_tmp = implode( ".", $file_tmp );
		$file_tmp = substr( $file_tmp, 0, 15 );

        do {
        	
            $file_tmp = str_replace( array( '=', '+', '/', '*' ), "", base64_encode( date( "Hisu" ) . $file_tmp ) );
//            print $file_tmp . "<br />";
            
        } while( file_exists( $this->path . $file_tmp . "." . $ext ) );
        
        $this->name = $file_tmp . "." . $ext;
        //	atualiza o nome no LOG
        $this->source[ "name" ] = $this->name;
        
        return $this->name;
    }
    
    function createThumbnail( $filename = null ){

		if( $filename )
			$this->newName = $filename;
			
		$filetype 		= strtolower( $this->getExt( $this->newName ) );		
		$sourcePath 	= $this->path . DS . $this->newName;
		$destinyPath	= $this->thumbnailPath . DS . $this->newName;
		$imgSource 		= null;
   
		if( $filetype == "jpg" || $filetype == "jpeg" )			  
			$imgSource = imagecreatefromjpeg( $sourcePath );
			
		elseif( $filetype == "gif" )
			$imgSource = imagecreatefromgif( $sourcePath );
				
		elseif( $filetype == "png" )
			$imgSource = imagecreatefrompng( $sourcePath );
			
		else
			return;
		
		$trueWidth 	= imagesx( $imgSource );
		$trueHeight = imagesy( $imgSource );
		$width		= null;
		$height		= null;
		   
		if( $trueWidth >= $trueHeight ){
			  
			$width	= $this->thumbnailScale;
			$height = ($width/$trueWidth) * $trueHeight;
		  
		} else {
		
			$height	= $this->thumbnailScale;
			$width  = ($height/$trueHeight) * $trueWidth;
			  
		}
		
		$imgDestiny = imagecreatetruecolor( $width, $height );
		imagecopyresampled( $imgDestiny, $imgSource, 0, 0, 0, 0, $width, $height, $trueWidth, $trueHeight );
		
		// Save the resized image
		if( $filetype == "jpg" || $filetype == "jpeg" )
			imagejpeg( $imgDestiny, $destinyPath, 80 );
		
		elseif( $filetype == "gif" )
			imagegif( $imgDestiny, $destinyPath );
		
		elseif( $filetype == "png" )
			imagepng( $imgDestiny, $destinyPath );

	}

	function resizeImage( $fileName, $scale, $path = null ){
		
		$filetype 		= strtolower( $this->getExt( $fileName ) );
		$sourcePath		= null;
		$imgSource 		= null;
		
		if( $path )
			$sourcePath = $path . DS. $fileName;
		else
			$sourcePath = $this->path . DS . $fileName;
		
   
		if( $filetype == "jpg" || $filetype == "jpeg" )
			$imgSource = imagecreatefromjpeg( $sourcePath );
			
		elseif( $filetype == "gif" )
			$imgSource = imagecreatefromgif( $sourcePath );
				
		elseif( $filetype == "png" )
			$imgSource = imagecreatefrompng( $sourcePath );
			
		else
			return;
		
		$trueWidth 	= imagesx( $imgSource );
		$trueHeight = imagesy( $imgSource );
		$width		= $trueWidth;
		$height		= $trueHeight;
		   
		if( $trueWidth >= $trueHeight ){
			
			if( $trueWidth > $scale ){
				$width	= $scale;
				$height = ($width/$trueWidth) * $trueHeight;
			}
		  
		} else {
		
			if( $trueHeight > $scale ){
				$height	= $scale;
				$width  = ($height/$trueHeight) * $trueWidth;
			}
		
		}
		
		$imgDestiny = imagecreatetruecolor( $width, $height );
		imagecopyresampled( $imgDestiny, $imgSource, 0, 0, 0, 0, $width, $height, $trueWidth, $trueHeight );
		
		// Save the resized image
		if( $filetype == "jpg" || $filetype == "jpeg" )
			imagejpeg( $imgDestiny, $sourcePath, 80 );
		
		elseif( $filetype == "gif" )
			imagegif( $imgDestiny, $sourcePath );
		
		elseif( $filetype == "png" )
			imagepng( $imgDestiny, $sourcePath );
			
	}
	
}

?>