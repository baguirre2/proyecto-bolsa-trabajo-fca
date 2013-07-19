<?php 
/**
 *@Author Karla Paulina Florentino Vaca
 *@Date 21/06/2013
 **/
include('InterfazBD2.php');

class OfertaTrabajo{
	
	
	/**
	 * Construye una instruccion de insert y la ejecuta
	 * */
	function insert($tabla,$datos,$col_id){
		$db = new InterfazBD2();
		$campos_valores = $datos;
		$str_campos = '';
		$str_values = '';
		
			
		foreach($campos_valores as $clave => $valor){
				
			/**
			 * Comprueba que no se trate de una cadena vac�a o un NULL
			 * */
			if($valor != '' && $valor != NULL){
				if($str_campos != ''){
					$str_campos .= ',';
					$str_values .= ',';
				}
				 
				$str_campos .= $clave;
				
				$valor = trim($valor);
				if(is_integer($valor) === false){
					
					if($valor == NULL){
						$str_values .= 'NULL';
					}else if($valor === true){
						$str_values .= 'true';
					}else if($valor === false){
						$str_values .=  'false';
					}else{
						$str_values .=  "'".$valor."'";
					}
				}else{
					$str_values .= $valor;
				}
			}else{
				
			}
		
		}/*Fin foreach*/
		 
		if($str_campos != '' && $str_values != '' ){
			$str_insert = "INSERT INTO ingsw.$tabla($str_campos) VALUES($str_values)";
			
			
		
			$tmp = $db->insertar($str_insert,$col_id);
			
		}
			
		$db->cerrarConexion();
		return $tmp;
	}
	
	function obtenerDatosTabla($final_query = NULL){
		$db = new InterfazBD2();
		$resultado = $db->consultar('SELECT * FROM ingsw.oferta_trabajo  JOIN ingsw.estado_autorizacion ON ingsw.estado_autorizacion.esau_id = ingsw.oferta_trabajo.esau_id  JOIN ingsw.perfil_aspirante ON ingsw.perfil_aspirante.peas_id = ingsw.oferta_trabajo.peas_id  JOIN ingsw.estudio_fca ON ingsw.perfil_aspirante.esfc_id = ingsw.estudio_fca.esfc_id'.$final_query);
		foreach($resultado as $numFila=>$fila){
				foreach($fila as $clave=>$valor){
					if(preg_match('/.*fecha.*/',$clave)){
						$tmp_fec = explode("-",$valor);
						$resultado[$numFila][$clave] = $tmp_fec[2]."-".$tmp_fec[1]."-".$tmp_fec[0];
					}
				}
		}
		$db->cerrarConexion();
		return $resultado;
	}
	
	function ordenarPorCampo($campo){
		$db = new InterfazBD2();
		$resultado = $db->consultar('SELECT * FROM ingsw.oferta_trabajo ORDER BY '.$campo);
		$db->cerrarConexion();
		return $resultado;
	}
	
	function obtenerCatalogosRelacionados(){
		$db = new InterfazBD2();
		$catalogos = array();
		$catalogos['tipo_contrato'] = $db->toCatalogo('ingsw.tipo_contrato');
		$catalogos['turno'] = $db->toCatalogo('ingsw.turno');
		$catalogos['tiempo_contrato'] = $db->toCatalogo('ingsw.tiempo_contrato');
		$catalogos['estado'] = $db->toCatalogo('ingsw.estado');
		$catalogos['delegacion'] = $db->toCatalogoConsulta('Select demu_id, demu_nombre FROM ingsw.delegacion_municipio WHERE es_id = 1;');
		$catalogos['colonia'] = $db->toCatalogoConsulta('Select co_id, co_nombre FROM ingsw.colonia WHERE co_id = 1;');
		$catalogos['nivel_estudio'] = $db->toCatalogo('ingsw.nivel_estudio');
                $catalogos['licenciatura'] = $db->toCatalogoConsulta('Select esfc_id,esfc_descripcion FROM ingsw.estudio_fca WHERE nies_id = 1');
		$catalogos['semestres'] = $this->obtenerSemestres(1);
		$catalogos['idiomas'] = $db->toCatalogoConsulta('Select id_id AS id, id_nombre FROM ingsw.idioma');
		$db->cerrarConexion();
		return $catalogos;
	}
	
	function obtenerSemestres($esfc_id){
		$db = new InterfazBD2();
		$tmp = $db->consultar('SELECT esfc_num_semestres FROM ingsw.estudio_fca WHERE esfc_id='.$esfc_id);
		$db->cerrarConexion();
		return $tmp[0]['esfc_num_semestres'];
	}
	
	function obtenerDelegaciones($es_id){
		$db = new InterfazBD2();
		$tmp = $db->toCatalogoConsulta('Select demu_id, demu_nombre FROM ingsw.delegacion_municipio WHERE es_id ='.$es_id);
		$db->cerrarConexion();
		return $tmp;
	}
	
	function obtenerColonias($demu_id){
		$db = new InterfazBD2();
		$tmp = $db->toCatalogoConsulta('Select co_id, co_nombre FROM ingsw.colonia WHERE demu_id ='.$demu_id);
		$db->cerrarConexion();
		return $tmp;
	}
	
	function obtenerFecha($dias = NULL){
		$db = new InterfazBD2();
		$tmp = $db->Consultar('Select current_date '.$dias);
		$db->cerrarConexion();
		return $tmp[0]['date'];
	}
	
	function obtenerCatBuscarReclutador(){
		$db = new InterfazBD2();
		$tmp['estado'] = $db->toCatalogo('estado_autorizacion');
		$tmp['carrera'] = $db->toCatalogoConsulta('Select esfc_id,esfc_descripcion FROM ingsw.estudio_fca WHERE esfc_id = 1');
		$db->cerrarConexion();
		return $tmp;
		
	}
	
	function validarPalabras($arreglo_palabras){
		$db = new InterfazBD2();
		$str_where = "";
		foreach($arreglo_palabras as $palabra){
			if($str_where != ""){
				$str_where .= " OR ";
			}
			$str_where .= "paal_palabra LIKE '%".$palabra."%'";
		}
		$str_where .= " AND paal_estado = true";
		$str_consulta = "SELECT COUNT(*) FROM ingsw.palabras_altisonantes WHERE ".$str_where;

		$tmp = $db->consultar($str_consulta);
		$db->cerrarConexion();
		if($tmp[0]['count'] > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	function obtenerOferta($oftr_id){
		$db = new InterfazBD2();
		$tmp = $db->consultar('SELECT * FROM ingsw.oferta_trabajo NATURAL JOIN ingsw.tipo_contrato NATURAL JOIN ingsw.tiempo_contrato NATURAL JOIN ingsw.turno WHERE oftr_id='.$oftr_id);
		$resultado['oferta'] = $tmp[0];
		$tmp = $db->consultar('SELECT ingsw.perfil_aspirante.*, ingsw.nivel_estudio.*,ingsw.estudio_fca.* FROM ingsw.perfil_aspirante NATURAL JOIN ingsw.estudio_fca NATURAL JOIN ingsw.nivel_estudio  RIGHT JOIN ingsw.oferta_trabajo ON ingsw.perfil_aspirante.peas_id = ingsw.oferta_trabajo.peas_id WHERE ingsw.oferta_trabajo.oftr_id ='.$oftr_id);
		$resultado['perfil'] = $tmp[0];
		$tmp = $db->consultar('SELECT ingsw.domicilio.*,ingsw.colonia.*,ingsw.delegacion_municipio.*,ingsw.estado.* FROM ingsw.domicilio JOIN ingsw.oferta_trabajo ON ingsw.domicilio.do_id = ingsw.oferta_trabajo.do_id NATURAL JOIN ingsw.colonia NATURAL JOIN ingsw.delegacion_municipio NATURAL JOIN ingsw.estado WHERE ingsw.oferta_trabajo.oftr_id ='.$oftr_id);
		$resultado['domicilio'] = $tmp[0];
		$tmp = $db->consultar('SELECT ingsw.nivel_idioma.*,ingsw.idioma.* FROM ingsw.nivel_idioma JOIN ingsw.perfil_aspirante_idioma  ON ingsw.perfil_aspirante_idioma.niid_id = ingsw.nivel_idioma.niid_id JOIN ingsw.perfil_aspirante ON ingsw.perfil_aspirante_idioma.peas_id = ingsw.perfil_aspirante.peas_id JOIN ingsw.oferta_trabajo ON ingsw.perfil_aspirante.peas_id = ingsw.oferta_trabajo.peas_id NATURAL JOIN ingsw.idioma WHERE ingsw.oferta_trabajo.oftr_id ='.$oftr_id);
		$resultado['idiomas'] = $tmp;
		$db->cerrarConexion();
		return $resultado;
	}  
	
	
	function obtenerOfertaGenerales($oftr_id){
		
		$db = new InterfazBD2();
		$tmp = $db->consultar('SELECT * FROM ingsw.oferta_trabajo WHERE oftr_id='.$oftr_id);
		$oferta['oferta'] = $tmp[0];
		$db->cerrarConexion();
		return $oferta;
	}
	/**
	 * Agrega comillas a los datos que lo necesitan
	 * en una cadena insert (varchar || char, time || date)
	 * @param array[string][mixed]:datos array asociativo[nombre_campo] => valor
	 * Cambio: 24/06/2013
	 * */
	function preprocesar($datos){
		foreach($datos as $clave => $valor){
			if(is_integer($valor) == false){
			
				if($valor == NULL){
					$valor = 'NULL';
				}else if($valor == true){ 
					$valor = 'true';
				}else if($valor == false){
					$valor = 'false';
				}else{
					$datos[$clave] = "\'".$valor."\'";
				}
			}
		}
		 
		return $datos;
	}
	
	function update($tabla,$datos,$col_id,$id){
		$db = new InterfazBD2();
		$campos_valores = $datos;
		$str_query = '';
		
	
			
		foreach($campos_valores as $clave => $valor){
				
			/**
			 * Comprueba que no se trate de una cadena vac�a o un NULL
			 * */
			if($valor !== ''){
				if($str_query != ''){
					$str_query .= ',';
					}
					
				$str_query .= $clave."=";
	
				$valor = trim($valor);
				if(is_integer($valor) === false){
						
					if($valor == NULL){
						$str_query .= 'NULL';
					}else if($valor === true){
						$str_query .= 'true';
					}else if($valor === false){
						$str_query .=  'false';
					}else{
						$str_query .=  "'".$valor."'";
					}
				}else{
					$str_query .= $valor;
				}
			}
	
		}/*Fin foreach*/
			
		if($str_query != '' ){
			$str_update = "UPDATE ingsw.$tabla SET $str_query WHERE $col_id=$id";
				
				echo $str_update;
	
			 $db->ejecutarQuery($str_update);
				
		}
			
		$db->cerrarConexion();
	
	}
	
	
	function obtenerOfertaIdiomas($oftr_id){
		$db = new InterfazBD2();
		$tmp = $db->consultar('SELECT ingsw.nivel_idioma.*,ingsw.idioma.* FROM ingsw.nivel_idioma JOIN ingsw.perfil_aspirante_idioma  ON ingsw.perfil_aspirante_idioma.niid_id = ingsw.nivel_idioma.niid_id JOIN ingsw.perfil_aspirante ON ingsw.perfil_aspirante_idioma.peas_id = ingsw.perfil_aspirante.peas_id JOIN ingsw.oferta_trabajo ON ingsw.perfil_aspirante.peas_id = ingsw.oferta_trabajo.peas_id NATURAL JOIN ingsw.idioma WHERE ingsw.oferta_trabajo.oftr_id ='.$oftr_id);
		$db->cerrarConexion();
		return $tmp;
	}
	
	function obtenerDomicilio($oftr_id){
		$db = new InterfazBD2();
		$tmp = $db->consultar('SELECT ingsw.domicilio.*,ingsw.colonia.*,ingsw.delegacion_municipio.*,ingsw.estado.* FROM ingsw.domicilio JOIN ingsw.oferta_trabajo ON ingsw.domicilio.do_id = ingsw.oferta_trabajo.do_id NATURAL JOIN ingsw.colonia NATURAL JOIN ingsw.delegacion_municipio NATURAL JOIN ingsw.estado WHERE ingsw.oferta_trabajo.oftr_id ='.$oftr_id);
		$db->cerrarConexion();
		return $tmp[0];
	}
	
	function obtenerPerfil($oftr_id){
		$db = new InterfazBD2();
		$tmp = $db->consultar('SELECT ingsw.perfil_aspirante.*, ingsw.nivel_estudio.*,ingsw.estudio_fca.* FROM ingsw.perfil_aspirante NATURAL JOIN ingsw.estudio_fca NATURAL JOIN ingsw.nivel_estudio  RIGHT JOIN ingsw.oferta_trabajo ON ingsw.perfil_aspirante.peas_id = ingsw.oferta_trabajo.peas_id WHERE ingsw.oferta_trabajo.oftr_id ='.$oftr_id);
		$db->cerrarConexion();
		return $tmp[0];
	}
	
	function obtenerObservaciones($oftr_id){
		$db = new InterfazBD2();
		$tmp = $db->consultar('SELECT oftr_observaciones FROM ingsw.oferta_trabajo WHERE ingsw.oferta_trabajo.oftr_id ='.$oftr_id);
		$db->cerrarConexion();
		return $tmp[0]['oftr_observaciones'];
	}
	
	function obtenerNumVacantes($oftr_id){
		$db = new InterfazBD2();
		$tmp = $db->consultar('SELECT oftr_num_vacantes_disponibles FROM ingsw.oferta_trabajo WHERE ingsw.oferta_trabajo.oftr_id ='.$oftr_id);
		$db->cerrarConexion();
		return $tmp[0]['oftr_num_vacantes_disponibles'];
	}
	
	function setNumVacantesDisponibles($oftr_id,$vacantes){
		$db = new InterfazBD2();
		$tmp = $db->ejecutarQuery("UPDATE ingsw.oferta_trabajo SET oftr_num_vacantes_disponibles=$vacantes WHERE ingsw.oferta_trabajo.oftr_id =".$oftr_id);
		$db->cerrarConexion();
	}
	
	function obtenerPendientes(){
		$db = new InterfazBD2();
		$resultado = $db->consultar("SELECT ingsw.oferta_trabajo.*, ingsw.empresa.em_nombre, ingsw.empresa.em_id, ingsw.estado_autorizacion.esau_nombre  FROM ingsw.oferta_trabajo JOIN ingsw.reclutador ON (ingsw.reclutador.re_id = ingsw.oferta_trabajo.re_id) JOIN ingsw.empresa ON (ingsw.reclutador.em_id = ingsw.empresa.em_id) JOIN ingsw.estado_autorizacion ON (ingsw.oferta_trabajo.esau_id = ingsw.estado_autorizacion.esau_id) WHERE ingsw.estado_autorizacion.esau_nombre = 'Pendiente'");
		foreach($resultado as $numFila=>$fila){
			foreach($fila as $clave=>$valor){
				if(preg_match('/.*fecha.*/',$clave)){
					$tmp_fec = explode("-",$valor);
					$resultado[$numFila][$clave] = $tmp_fec[2]."-".$tmp_fec[1]."-".$tmp_fec[0];
				}
			}
		}
		$db->cerrarConexion();
		return $resultado;
	}
	
	function obtenerPorEmpresa($empresa_id){
		$db = new InterfazBD2();
		$resultado = $db->consultar("WHERE ingsw.empresa.em_id =".$empresa_id);
		foreach($resultado as $numFila=>$fila){
			foreach($fila as $clave=>$valor){
				if(preg_match('/.*fecha.*/',$clave)){
					$tmp_fec = explode("-",$valor);
					$resultado[$numFila][$clave] = $tmp_fec[2]."-".$tmp_fec[1]."-".$tmp_fec[0];
				}
			}
		}
		$db->cerrarConexion();
		return $resultado;
	}
	
	function cambiarEstado($oftr_id, $estado_id){
		$db = new InterfazBD2();
		$tmp = $db->ejecutarQuery("UPDATE ingsw.oferta_trabajo SET esau_id=$estado_id WHERE ingsw.oferta_trabajo.oftr_id =".$oftr_id);
		$db->cerrarConexion();
	}
	
	function obtenerEmpresas(){
		$db = new InterfazBD2();
		$tmp = $db->toCatalogoConsulta("SELECT em_id, em_nombre FROM ingsw.empresa");
		$db->cerrarConexion();
		return $tmp;
	
	}
	
        function obtenerEstadoDelegacionColonia($cp){
                $db = new InterfazBD2();
		$tmp['estado'] = $db->consultar("SELECT es_nombre as nombre FROM ingsw.colonia JOIN ingsw.delegacion_municipio ON (ingsw.colonia.demu_id = ingsw.delegacion_municipio.demu_id) JOIN ingsw.estado ON (ingsw.delegacion_municipio.es_id = ingsw.estado.es_id) WHERE co_codigo_postal='$cp'");
                $tmp['delegacion'] = $db->consultar("SELECT demu_nombre as nombre FROM ingsw.colonia JOIN ingsw.delegacion_municipio ON (ingsw.colonia.demu_id = ingsw.delegacion_municipio.demu_id) WHERE co_codigo_postal='$cp'");
                $tmp['colonias'] =$db->consultar("SELECT co_nombre as nombre,co_id as id FROM ingsw.colonia WHERE co_codigo_postal='$cp'"); 
		$db->cerrarConexion();
		return $tmp;
        }
        
        function obtenerEstudio($id_nivel_estudio = 1){
                $db = new InterfazBD2();
		$tmp =$db->toCatalogoConsulta("SELECT esfc_id as id, esfc_descripcion FROM ingsw.estudio_fca WHERE nies_id=$id_nivel_estudio"); 
		$db->cerrarConexion();
		return $tmp;
        }
        
        function obtenerSemestre($esfc_id = 1){
            
                $db = new InterfazBD2();
		$tmp =$db->consultar("SELECT esfc_num_semestres FROM ingsw.estudio_fca WHERE esfc_id=$esfc_id"); 
		$db->cerrarConexion();
		return $tmp;
        }
        
}

?>