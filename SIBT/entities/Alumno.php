<?php 

/*
 * Archivo: Class Alumno
 * Autor:	Emmanuel Garc�a C.
 * Fecha:	Martes 25/Junio/2013
 * Modificaciones: 
 * -
 * -
 */

include_once'InterfazBD2.php';

class Alumno{

	function __construct() {
	}
	
	public function obtenerInfoPersonal($idAlumno) {
		$conn = new InterfazBD2();
		$select = "SELECT * FROM ingsw.alumno AS al 
					JOIN ingsw.domicilio AS dom ON (al.do_id = dom.do_id)
					JOIN ingsw.colonia AS co ON (dom.co_id = co.co_id)
					JOIN ingsw.delegacion_municipio AS demu ON (demu.demu_id = co.demu_id) 
					JOIN ingsw.estado AS es ON (es.es_id = demu.es_id)
					JOIN ingsw.persona AS pe ON (pe.pe_id = al.pe_id)
					WHERE al_id = $idAlumno;";
//		echo $query;
		$res = $conn->consultar($select);
		$conn->cerrarConexion();
		return  $res;
	}
	
	public function listarNivelesEstudio() {
		$conexion = new InterfazBD2();
		$query = "SELECT * FROM ingsw.nivel_estudio;";
		$niveles = $conexion->consultar($query);
		if( $niveles != false){
			$conexion->cerrarConexion();
			return $niveles;
		}else{
			$conexion->cerrarConexion();
			return false;
		}
	}
	
	public function listarEstudiosFCA($nivel) {
		if($nivel == 0 ){	//Opci�n default del select superior
			echo "";
		}else if($nivel == 5){
			echo "<select name=\"esfc_id\" onchange=\"ajaxConId('controllers/gestionarAlumno/CtlAlumno.php', 'llenarListaEstadosAcademicos', 'vacio', 'estadosAcademicos', this.value);\">";
			echo "<option value=\"-1'\">No hay opciones disponibles</option>";
			echo "</select>";
		}else{
			$conexion = new InterfazBD2();
			$query = "SELECT * FROM ingsw.estudio_fca WHERE nies_id=$nivel";
			$resultados = $conexion->consultar($query);
			echo "<select name=\"esfc_id\" class=\"required\" onchange=\"ajaxConId('controllers/gestionarAlumno/CtlAlumno.php', 'llenarListaEstadosAcademicos', 'vacio', 'estadosAcademicos', this.value);\">";
			echo "<option value=\"Seleccionar\">Selecciona una opci�n</option>";
			for ($i = 0; $i <= count($resultados) - 1; $i++) {
				echo "<option value=\"".$resultados[$i]['esfc_id']."\">";
				echo $resultados[$i]['esfc_descripcion']."</option>";
			}
			echo "</select>";
			$conexion->cerrarConexion();
		}
	}
	
	public function listarEstadosAcademicos($nivel){
		if($nivel == 0){	//Opci�n default del select superior
			echo "";
		}else{
			$conexion = new InterfazBD2();
			$query = "SELECT * FROM ingsw.estado_academico";
			$resultados = $conexion->consultar($query);
			echo "<select class=\"required\" name=\"esac_id\">";
			echo "<option value=\"Seleccionar\">Selecciona una opci�n</option>";
			for ($i = 0; $i <= count($resultados) - 1; $i++) {
				echo "<option value=\"".$resultados[$i]['esac_id']."\">";
				echo $resultados[$i]['esac_tipo']."</option>";
			}
			echo "</select>";		
			$conexion->cerrarConexion();
		}
	}
	
	public function registrarAlumno($GET){
		$conexion = new InterfazBD2();
		$estado = false;
		
		$query_persona = "INSERT INTO ingsw.persona (pe_nombre, pe_apellido_paterno, pe_apellido_materno)
    			 		  VALUES ('".$GET['pe_nombre']."','".$GET['pe_apellido_paterno']."','".$GET['pe_apellido_materno']."')";
		$id_persona = $conexion->insertar($query_persona, 'pe_id');
		//echo "ID Persona = ";	var_dump($id_persona);
		
		if($id_persona != false){
			$query_correo = "INSERT INTO ingsw.correo_electronico (pe_id, coel_correo)
    			 		     VALUES ('".$id_persona."','".$GET['coel_correo']."')";
			
			if($conexion->ejecutarQuery($query_correo) != false){
				$query_alumno = "INSERT INTO ingsw.alumno (do_id, pe_id, al_num_cuenta, al_fecha_nacimiento, al_nacionalidad, al_curriculum_visible)
    			 		  		 VALUES ('1','".$id_persona."','".$GET['al_num_cuenta']."','01/01/1900','0','1')";
				$id_alumno = $conexion->insertar($query_alumno, 'al_id');
				
				if($id_alumno != false){
					$query_info_aca = "INSERT INTO ingsw.informacion_academica (al_id, esac_id, esot_id, esfc_id, esau_id, inac_universidad, inac_escuela, inac_fecha_inicio)
    			 		  		 	   VALUES ('".$id_alumno."','".$GET['esac_id']."',null,'".$GET['esfc_id']."','1','0','0','01/01/1900')";

					if($conexion->ejecutarQuery($query_info_aca) != false){
						$estado = true;
					}
				}
			}
		}
		$conexion->cerrarConexion();
		return $estado;
	}

	/**
	 * @author Benjamín Aguirre García
	 * @param $idAlumno Id del Alumno
	 */    	
	public function toString ($idAlumno) {
		$datos = $this->obtenerInfoPersonal($idAlumno);
		$datos = $datos[0];
		$conn = new InterfazBD2();
		$query  = "SELECT coel_correo FROM ingsw.persona AS pe JOIN ingsw.correo_electronico AS coel ON (coel.pe_id = pe.pe_id) WHERE pe.pe_id=$datos[pe_id]";
		$correoE = $conn->consultar($query);
		$correoE = $correoE[0];
		$query = "SELECT  tite_descripcion, te_telefono, te_extension FROM ingsw.persona AS pe 
					JOIN ingsw.telefono AS te ON (te.pe_id = pe.pe_id)
					JOIN ingsw.tipo_telefono AS tite ON (tite.tite_id = te.tite_id) WHERE te.pe_id = $datos[pe_id]";
		$telefonos = $conn->consultar($query);
		$conn->cerrarConexion();
		$strInfoAlumno = "<tr> <th> Información Personal </th> </tr> <input type='hidden' name='idAlumno' value='$datos[al_id]'>
				<tr> <td> $datos[pe_nombre] $datos[pe_apellido_paterno] $datos[pe_apellido_materno]
				<tr> <td> Nacionalidad $datos[al_nacionalidad]
				<tr> <td> Direccion: $datos[do_calle] N. $datos[do_num_exterior], $datos[co_nombre] CP. $datos[co_codigo_postal], $datos[demu_nombre], $datos[es_nombre].   
				<tr> <td> Correo Electrónico: $correoE[coel_correo]
				<tr> <th> Telefonos 
		";
		foreach ($telefonos AS $telefono) {
			$strInfoAlumno .= "<tr> <td> $telefono[tite_descripcion]: $telefono[te_telefono]";
			if ($telefono['te_extension'] != null) {
				$strInfoAlumno .= " Ext. $telefono[te_extension]";
			}	
		}
		$strInfoAlumno .= "<tr> <th> Objetivos Profesionales <tr> <td> $datos[al_objetivos_profesionales]";
		return $strInfoAlumno;
	}
        
        public function registrarAlumnoPorArchivo($nom, $apePat, $apeMat, $correo, $noCta, $nacio, $fecNac, $idCarrera){
		$conexion = new InterfazBD2();
		$estado = false;
		
		$query_persona = "INSERT INTO ingsw.persona (pe_nombre, pe_apellido_paterno, pe_apellido_materno)
    			 		  VALUES ('".$nom."','".$apePat."','".$apeMat."')";
		$id_persona = $conexion->insertar($query_persona, 'pe_id');
		//echo "ID Persona = ";	var_dump($id_persona);
		
		if($id_persona != false){
			$query_correo = "INSERT INTO ingsw.correo_electronico (pe_id, coel_correo)
    			 		     VALUES ('".$id_persona."','".$correo."')";
			
                    if($conexion->ejecutarQuery($query_correo) != false){
                        $query_alumno = "INSERT INTO ingsw.alumno (do_id, pe_id, al_num_cuenta, al_fecha_nacimiento, al_nacionalidad, al_curriculum_visible, esfc_id) 
                                                    VALUES ('1','".$id_persona."','".$noCta."','".$fecNac."','".$nacio."','1', $idCarrera)";
                        $conexion->insertar($query_alumno, 'al_id');

                        //Se toma la hora del servidor en microsegundos, se le aplica un hash con el algoritmo ripemd160 y se extraen los primeros 8 caractares para la contrseña
                        $pass = substr(hash('ripemd160', microtime()), 0, 8);

                        $query_usuario = "INSERT INTO ingsw.usuario (pe_id, us_nombre, us_contrasenia) VALUES ('".$id_persona."','".$noCta."', '$pass')";
                        $id_usuario = $conexion->insertar($query_usuario, 'us_id');
                        
                        //Con esto se envia el correo al alumno con sus datos de usuario
                        mail ("$correo", "Registro Bolsa en la bolsa de trabajo", "UNIVERSIDAD NACIONAL AUTONÓMA DE MÉXICO
                                                                                        Facultad de Contaduría y Administración<br>
                                                                                        Departamento de Bolsa de Trabajo<br>

                                                                                        Estimado alumno $nom $apePat $apeMat has sido registraro en la bolsa de trabajo de la FCA<br>
                                                                                        Se te notifica que tus datos de acceso son los siguientes:
                                                                                        Usuario $noCta
                                                                                        Contraseña $pass

                                                                                        Sin más por el momento quedamos a tus órdenes.

                                                                                        Departamento de bolsa de Trabajo FCA – UNAM
                                                                                        http://cetus.fca.unam.mx/sibt/");
                        
                        if($id_usuario != false){

                            $query_usuario_tipo = "INSERT INTO ingsw.usuario_tipo_usuario (tius_id, us_id) VALUES ('5','".$id_usuario."')";

                            if($conexion->ejecutarQuery($query_usuario_tipo) != false){
                                $estado = true;
                            }
                        }
                    }
		}
		$conexion->cerrarConexion();
		return $estado;
	}
	
	public function toStringContacto($idAlumno) {
		$datos = $this->obtenerInfoPersonal($idAlumno);
		$datos = $datos[0];
		$conn = new InterfazBD2();
		$query  = "SELECT coel_correo FROM ingsw.persona AS pe JOIN ingsw.correo_electronico AS coel ON (coel.pe_id = pe.pe_id) WHERE pe.pe_id=$datos[pe_id]";
		$correoE = $conn->consultar($query);
		$correoE = $correoE[0];
		$query = "SELECT  tite_descripcion, te_telefono, te_extension FROM ingsw.persona AS pe 
					JOIN ingsw.telefono AS te ON (te.pe_id = pe.pe_id)
					JOIN ingsw.tipo_telefono AS tite ON (tite.tite_id = te.tite_id) WHERE te.pe_id = $datos[pe_id]";
		$telefonos = $conn->consultar($query);
		$query = "SELECT esfc_descripcion FROM ingsw.estudio_fca AS esfc 
					JOIN ingsw.informacion_academica AS inac ON (esfc.esfc_id=inac.esfc_id)
					WHERE inac.al_id=$idAlumno";
		$Acad = $conn->consultar($query);
		$Acad = $Acad[0];
		$conn->cerrarConexion();
		$strInfoAlumno = "<tr> <th> Nombre <th> Correo Electrónico <th> Carrera / Posgrado <th> Telefonos
				<tr> <td> $datos[pe_nombre] $datos[pe_apellido_paterno] $datos[pe_apellido_materno]
					 <td> $correoE[coel_correo]
					 <td> $Acad[esfc_descripcion]
					 <td> 
		";
		foreach ($telefonos AS $telefono) {
			$strInfoAlumno .= "$telefono[tite_descripcion]: $telefono[te_telefono]";
			if ($telefono['te_extension'] != null) {
				$strInfoAlumno .= " Ext. $telefono[te_extension]";
			}
			$strInfoAlumno .= "<br>";
		}
		return $strInfoAlumno;
	}	
	
	// inicia Actualizar alumno
	public function recuperarAlumnos($GET) {
		$conexion = new InterfazBD2();
	
		$numCuenta = isset($GET['al_num_cuenta']) ? $GET['al_num_cuenta'] : "";
		$nombre = isset($GET['pe_nombre']) ? $GET['pe_nombre'] : "";
		$aPaterno = isset($GET['pe_apellido_paterno']) ? $GET['pe_apellido_paterno'] : "";
		$aMaterno =  isset($GET['pe_apellido_materno']) ? $GET['pe_apellido_materno'] : "";
	
		$query = "SELECT AL.al_num_cuenta, P.pe_nombre, P.pe_apellido_paterno, P.pe_apellido_materno, CE.coel_correo, EF.esfc_descripcion, U.us_contrasenia, U.us_id FROM INGSW.PERSONA P INNER JOIN INGSW.ALUMNO AL ON(P.pe_id=AL.pe_id) INNER JOIN INGSW.CORREO_ELECTRONICO CE ON(P.pe_id=CE.pe_id) INNER JOIN INGSW.USUARIO U ON(P.pe_id=U.pe_id) LEFT JOIN INGSW.ESTUDIO_FCA EF ON(EF.esfc_id=AL.esfc_id) WHERE AL.al_num_cuenta = '".$numCuenta."' OR P.pe_nombre = '".$nombre."' OR P.pe_apellido_paterno = '".$aPaterno."' OR P.pe_apellido_materno ='".$aMaterno."';";
	
		$alumnos = $conexion->consultar($query);
	
		if( $alumnos != false){
			$conexion->cerrarConexion();
			return $alumnos;
		}else{
			echo"
				<table>
				  <tr>
					<td><h2>No hay alumnos con los criterios de busqueda proporcionados</h2></td>
				  </tr>
				</table>
				<table>
					<tr>
						<td><center><input type='button' value='Aceptar' onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumno', 'vacio', 'contenido');\"/></center>
						</td>
				  	</tr>
				</table>
		
			";
			$conexion->cerrarConexion();
			return false;
		}
	}
	
	public function recuperarDatosAlumno($id) {
		$conexion = new InterfazBD2();
		$query = "SELECT AL.al_num_cuenta, P.pe_id, P.pe_nombre, P.pe_apellido_paterno, P.pe_apellido_materno, CE.coel_correo, EF.esfc_id, EF.esfc_descripcion, U.us_contrasenia, U.us_id FROM INGSW.PERSONA P INNER JOIN INGSW.ALUMNO AL ON(P.pe_id=AL.pe_id) INNER JOIN INGSW.CORREO_ELECTRONICO CE ON(P.pe_id=CE.pe_id) INNER JOIN INGSW.USUARIO U ON(P.pe_id=U.pe_id) INNER JOIN INGSW.ESTUDIO_FCA EF ON(EF.esfc_id=AL.esfc_id) WHERE '".$id."' = U.us_id ;";
	
		$datos = $conexion->consultar($query);
		if($datos){
			$conexion->cerrarConexion();
			return $datos = $datos[0];
		}else{
			$conexion->cerrarConexion();
			return false;
		}
	}
	public function recuperarCarreras() {
		$conexion = new InterfazBD2();
		$query = "SELECT esfc_id, esfc_descripcion FROM INGSW.ESTUDIO_FCA WHERE esfc_descripcion LIKE 'Administraci_n' OR esfc_descripcion LIKE 'Contadur_a' OR esfc_descripcion LIKE 'Inform_tica';";
	
		$carreras = $conexion->consultar($query);
		if($carreras){
			$conexion->cerrarConexion();
			return $carreras;
		}else{
			$conexion->cerrarConexion();
			return false;
		}
	}
	
	public function actualizarAlumno($GET, $tipoUsuario){
		$conexion = new InterfazBD2();
		if ($tipoUsuario == 2){
				
			$numCuenta = isset($GET['al_num_cuenta']) ? $GET['al_num_cuenta'] : "";
			$nombre = isset($GET['pe_nombre']) ? $GET['pe_nombre'] : "";
			$aPaterno = isset($GET['pe_apellido_paterno']) ? $GET['pe_apellido_paterno'] : "";
			$aMaterno =  isset($GET['pe_apellido_materno']) ? $GET['pe_apellido_materno'] : "";
			$carrera = isset($GET['esfc_descripcion']) ? $GET['esfc_descripcion'] : "";
			$correo =  isset($GET['coel_correo']) ? $GET['coel_correo'] : "";
			$pe_id =  isset($GET['pe_id']) ? $GET['pe_id'] : "";
				
			//echo "$numCuenta , $nombre, $aPaterno, $aMaterno, $carrera, $correo , $pe_id";
				
			$query = "UPDATE INGSW.PERSONA SET pe_nombre ='".$nombre."', pe_apellido_paterno='".$aPaterno."',pe_apellido_materno='".$aMaterno."'
	WHERE pe_id ='".$pe_id."'; UPDATE INGSW.ALUMNO SET al_num_cuenta='".$numCuenta."', esfc_id='".$carrera."' WHERE pe_id ='".$pe_id."'; UPDATE INGSW.CORREO_ELECTRONICO SET coel_correo='".$correo."' WHERE pe_id ='".$pe_id."';";
				
				
			if ($conexion->ejecutarQuery($query)){
				echo "
				<table>
				  <tr>
					<td>Se han actualizado los datos correctamente</td>
				  </tr>
				  <tr>
					<td><input type='button' value='Aceptar' onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumno', 'vacio', 'contenido');\"/>
					</td>
				  </tr>
				</table>
			";
					
			} else {
				echo "ERROR al actualizar los datos";
			}
		} else if ($tipoUsuario == 5){
			$correo =  isset($GET['coel_correo']) ? $GET['coel_correo'] : "";
			$us_contrasenia = isset($GET['us_contrasenia']) ? $GET['us_contrasenia'] : "";
			$pe_id = isset($GET['pe_id']) ? $GET['pe_id'] : "";
			//echo "$correo , $us_contrasenia, $pe_id";
				
			$query = "UPDATE INGSW.CORREO_ELECTRONICO SET coel_correo='".$correo."' WHERE pe_id ='".$pe_id."'; UPDATE INGSW.USUARIO SET us_contrasenia='".$us_contrasenia."' WHERE pe_id ='".$pe_id."';";
				
				
			if ($conexion->ejecutarQuery($query)){
				echo "
				<table>
				  <tr>
					<td>Se han actualizado los datos correctamente</td>
				  </tr>
				  <tr>
					<td><input type='button' value='Aceptar' onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumno', 'vacio', 'contenido');\"/>
					</td>
				  </tr>
				</table>
			";
					
			} else {
				echo "ERROR al actualizar los datos";
			}
		}
		$conexion->cerrarConexion();
	}
	
	// fin Actualizar Alumno

}

?>
