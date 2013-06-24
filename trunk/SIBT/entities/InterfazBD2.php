<?php
class InterfazBD2{
    private $conexion;
    private $manejador;
    //"host=localhost port=5432 dbname=li307179654 user=lamb password=bar";
    const CONSTRING = "host=localhost port=5432 dbname= user= password=";
    private $resultado;

    /**
    *@params string:manejador
    *Si no se le pasa ningun parametro asume que es postgreSQL
    */
    function __construct($manejador = NULL) {

            $this->manejador = manejador;

            switch($this->manejador){

                    case 'mysql':
                    break;

                    case 'oracle':
                    break;

                    default:
                    $this->conexion =  pg_pconnect(self::CONSTRING);
                    break;
            }
    }

 
    
    
    /**
     * Ejecuta cualquier query INSERT,SELECT,DELETE
     *@paramas string:query
     *@return boolean
     **/
    function ejecutarQuery($query = NULL){
    	$this->resultado = false;
    	if($query != NULL && $this->conexion != NULL){
    
    		switch($this->manejador){
    
    			case 'mysql':
    				break;
    
    
    			case 'oracle':
    				break;
    
    			default:
    				$this->resultado = pg_query($this->conexion,$query);
    			break;
    		}
    	}
    	return is_resource ($this->resultado);
    }

    /**
     * Ejecuta una consulta y regresa los resultados como un array asociativo
    *@paramas string:query
    *@return array[string][mixed]:resultado array asociativo[nombre_campo] => valor
    **/
    function consultar($query = NULL){
            $this->resultado = false;
            if($query != NULL && $this->conexion != NULL){

                            switch($this->manejador){

                            case 'mysql':
                            break;


                            case 'oracle':
                            break;


                            default:
                                    $res = pg_query($this->conexion,$query);
                                    if($res != false){
                                            while($fila = pg_fetch_assoc($res)){
                                                    $this->resultado[] = $fila;
                                            }
                                    }else{
                                            $this->resultado = false;
                                    }
                            break;
                    }
            }
            return $this->resultado;
    }

    /**
    *Cierra una conexion a la DB 
    *@return bool
    **/
    function cerrarConexion(){
            return pg_close ($this->conexion);
    }
    
    /**
     *Funcion para insertar unicamente
     *@author peter la anguila 22/06/2013
     *@param string:query la cadena de insert
     *@param string:col_id nombre de la primary key
     *@return int:id el id del registro que se acaba de insertar
     *regresa 0 u falso si no se pudo insertar
     *(php evalua el 0 como falso)
     **/
    function insertar($query = NULL,$col_id = NULL){
    	$this->resultado = false;
    	if($query != NULL && $col_id != NULL && $this->conexion != NULL){
    
    		switch($this->manejador){
    
    			case 'mysql':
    				break;
    
    
    			case 'oracle':
    				break;
    
    			default:
    				$this->resultado = pg_query($this->conexion,$query.' returning '.$col_id);
    				if(is_resource ($this->resultado) == false){
    					$this->resultado = false;
    				}else{
    					$this->resultado = pg_fetch_result($this->resultado,0,0);
    				}
    				break;
    
    		}
    	}
    	return $this->resultado;
    	 
    }
    
    /**
     * @author 22/06/2013
     * @param string:nombre_tabla
     * @return array[int][string]:catalogo regresa los valores de un catalogo
     * como un arreglo id=>valor
     * regresa un arreglo nulo si no hay datos o si la tabla no es un catalogo 
     */
    function toCatalogo($nombre_tabla = NULL){
    	$resultado = array();
    	if($nombre_tabla != NULL &&  $nombre_tabla != ''){
    		$tmp_res = $this->consultar('SELECT * from '.$nombre_tabla);
    		if($tmp_res != false && empty($tmp_res) != true && (count($tmp_res[0]) == 2)){
    			
    			/*Asumimos que la llave primaria tiene el subfijo id y la buscamos*/
    				$nombre_columnas =  array_keys($tmp_res[0]);
    				
    				$nom_col_id = '';
    				$nom_otra_col = '';
    				
    				foreach($nombre_columnas as $columna){
    					
    					if(preg_match('/.*id$/',$columna)){
    						$nom_col_id = $columna;
    					}else{
    						$nom_otra_col = $columna;
    					}
    				}
    				
    				if($nom_col_id != '' && $nom_otra_col != ''){
    					
    					foreach($tmp_res as $fila){
    						$resultado[$fila[$nom_col_id]]	= $fila[$nom_otra_col];
    					}
    				
    				}
    		}
    	}
    	return $resultado;
    	
    }
    
    /**
     * @author 23/06/2013
     * @param string:nombre_tabla
     * @return array[int][string]:catalogo regresa los valores de un catalogo
     * como un arreglo id=>valor
     * regresa un arreglo nulo si no hay datos o si la tabla no es un catalogo
     */
    function toCatalogoConsulta($query = NULL){
    	$resultado = array();
    	if($query != NULL &&  $query != ''){
    		$tmp_res = $this->consultar($query);
    		if($tmp_res != false && empty($tmp_res) != true && (count($tmp_res[0]) == 2)){
    			 
    			/*Asumimos que la llave primaria tiene el subfijo id y la buscamos*/
    			$nombre_columnas =  array_keys($tmp_res[0]);
    
    			$nom_col_id = '';
    			$nom_otra_col = '';
    
    			foreach($nombre_columnas as $columna){
    					
    				if(preg_match('/.*id$/',$columna)){
    					$nom_col_id = $columna;
    				}else{
    					$nom_otra_col = $columna;
    				}
    			}
    
    			if($nom_col_id != '' && $nom_otra_col != ''){
    					
    				foreach($tmp_res as $fila){
    					$resultado[$fila[$nom_col_id]]	= $fila[$nom_otra_col];
    				}
    
    			}
    		}
    	}
    	return $resultado;
    	 
    }
    
    /**
     * @author 22/06/2013
     * Arma el query del INSERT y lo ejecuta
     * @param string:nombre_tabla el nombre de la tabla
     * @param array[string][mixed]:campos_valores array asociativo[nombre_campo] => valor
     * @param string:col_id nombre de la primary key
     * @return int:id el id del registro que se acaba de insertar
     *regresa 0 u falso si no se pudo insertar
     *(php evalua el 0 como falso)
     *Nota: No comprueba que se cuenten con los todos los campos obligatorios
     *Nota: No inserta cadenas vacías ni NULL
     */
    function ejecutarInsert($nombre_tabla = NULL, $campos_valores = NULL,$col_id = NULL){
    	
    	if(($nombre_tabla != NULL && $nombre_tabla != '') 
    			&& ($campos_valores != NULL && empty($campos_valores) != true)
    			&& ($col_id != NULL && $col_id != '')){
    		
			    	$campos_valores = $this->preprocesar($campos_valores);
			    	$str_campos = '';
			    	$str_values = '';
			    	
			    	foreach($campos_valores as $clave => $valor){
			    	
			    		/**
			    		 * Comprueba que no se trate de una cadena vacía o un NULL
			    		 * */
			    		if($valor != '' && $valor != NULL){
				    		if($str_campos != ''){
				    			$str_campos .= ',';
				    			$str_values .= ',';
				    		}
			    		
				    		$str_campos .= $clave;
				    		$str_values .= $valor;
			    		}
			    			
    				}/*Fin foreach*/
    	
    				if($str_campos != '' && $str_values != '' ){
			    		$str_insert = "INSERT INTO $nombre_tabla($str_campos) VALUES($str_values)";
			    		
			    		return $this->insertar($str_insert,$col_id);
    				}else{
    					return false;
    				}
		}else{
			    		
    		return false;
    	}
    	
    }
    
    
    /**
     * @author 22/06/2013
     * Arma el query de UPDATE y lo ejecuta
     * @param string:nombre_tabla el nombre de la tabla
     * @param array[string][mixed]:campos_valores array asociativo[nombre_campo] => valor
     * @param string:clausula clausula WHERE
     * @return bool: true si se ejecuto false de lo contrario
     *Nota: No inserta cadenas vacías ni NULL
     */
    function ejecutarUpdate($nombre_tabla = NULL, $campos_valores = NULL,$clausula = NULL){
    	if(($nombre_tabla != NULL && $nombre_tabla != '')
    			&& ($campos_valores != NULL && empty($campos_valores) != true)
    			&& ($clausula != NULL && $clausula != '')){
    		
    		$campos_valores = $this->preprocesar($campos_valores);
    		$str_campos = "";
    		
    		/**
    		 * Comprueba que no se trate de una cadena vacía o un NULL
    		 * */
    		foreach($campos_valores as $clave => $valor){
    			if($valor != '' && $valor != NULL){
    				if($str_campos != ""){
    					$str_campos += ",";
    				}
    			 
    				$str_campos .=	$clave."=".$valor;
    			}
    	
    		}/*Fin foreach*/
    		
    		if($str_campos != "" ){
	    		$str_update = "UPDATE $nombre_tabla SET $str_campos ".$clausula;
	    		
	    		return $this->ejecutarQuery($str_update);
    		}else{
    			return false;
    		}
    		
    	}else{
    		 
    		return false;
    	}
    }
    
    /**
     * Agrega comillas a los datos que lo necesitan
     * en una cadena insert (varchar || char, time || date)
     * @param array[string][mixed]:datos array asociativo[nombre_campo] => valor
     * Cambio: 24/06/2013
     * */
    function preprocesar($datos){
    	foreach($datos as $clave => $valor){
    		if(is_numeric($valor) == false){
    			
    			if($valor == NULL){
    				$valor = 'NULL';
    			}else{
    					$datos[$clave] = "'".utf8_encode($valor)."'";
    			}
    		}
    	}
    	
    	return $datos;
    }
}
?>
