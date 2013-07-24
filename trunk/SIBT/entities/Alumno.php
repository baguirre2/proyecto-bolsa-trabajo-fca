<?php 

/*
 * Archivo: Class Alumno
 * Autor:	Emmanuel Garcï¿½a C.
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
		if($nivel == 0 ){	//OpciÃ³n default del select superior
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
			echo "<option value=\"Seleccionar\">Selecciona una opci&oacuten</option>";
			for ($i = 0; $i <= count($resultados) - 1; $i++) {
				echo "<option value=\"".$resultados[$i]['esfc_id']."\">";
				echo $resultados[$i]['esfc_descripcion']."</option>";
			}
			echo "</select>";
			$conexion->cerrarConexion();
		}
	}
	
	public function listarEstadosAcademicos($nivel){
		if($nivel == 0){	//OpciÃ³n default del select superior
			echo "";
		}else{
			$conexion = new InterfazBD2();
			$query = "SELECT * FROM ingsw.estado_academico";
			$resultados = $conexion->consultar($query);
			echo "<select class=\"required\" name=\"esac_id\">";
			echo "<option value=\"Seleccionar\">Selecciona una opci&oacuten</option>";
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
	
	
		$query_verificar = "SELECT * FROM ingsw.alumno WHERE al_num_cuenta = '".$GET['al_num_cuenta']."'";
		if(!$conexion->consultar($query_verificar)){
	
			$query_persona = "INSERT INTO ingsw.persona (pe_nombre, pe_apellido_paterno, pe_apellido_materno)
	    			 		  VALUES ('".$GET['pe_nombre']."','".$GET['pe_apellido_paterno']."','".$GET['pe_apellido_materno']."')";
			$id_persona = $conexion->insertar($query_persona, 'pe_id');
			//echo "ID Persona = ";	var_dump($id_persona);
	
			if($id_persona != false){
				$query_correo = "INSERT INTO ingsw.correo_electronico (pe_id, coel_correo)
	    			 		     VALUES ('".$id_persona."','".$GET['coel_correo']."')";
	
				if($conexion->ejecutarQuery($query_correo) != false){
					$query_alumno = "INSERT INTO ingsw.alumno (do_id, pe_id, al_num_cuenta, al_fecha_nacimiento, al_nacionalidad, al_curriculum_visible, esfc_id)
	    			 		  		 VALUES ('1','".$id_persona."','".$GET['al_num_cuenta']."','".$GET['al_fecha_nacimiento']."','".$GET['al_nacionalidad']."','1','".$GET['esfc_id']."')";
					$id_alumno = $conexion->insertar($query_alumno, 'al_id');
	
					/*
					 if($id_alumno != false){
	
					//AQUI INSERTARA EN ESTUDIO_FCA EN VEZ DE INFO_ACADEMICA
					$query_info_aca = "INSERT INTO ingsw.informacion_academica (al_id, esac_id, esot_id, esfc_id, esau_id, inac_universidad, inac_escuela, inac_fecha_inicio)
					VALUES ('".$id_alumno."','".$GET['esac_id']."',null,'".$GET['esfc_id']."','1','0','0','01/01/1900')";
	
					if($conexion->ejecutarQuery($query_info_aca) != false){
					$estado = true;
					}
					}
					*/
	
					if($id_alumno != false){
	
						$pass = hash('ripemd160', microtime());
						$pass = substr($pass, 0, 8);
	
						$query_usuario = "INSERT INTO ingsw.usuario (pe_id, us_nombre, us_contrasenia)
	    			 		  		 	   VALUES ('".$id_persona."','".$GET['al_num_cuenta']."','".$pass."')";
	
						if($conexion->ejecutarQuery($query_usuario) != false){
							$estado = "El alumno se ha agregado con &eacutexito";
						}
	
						//ENVIAR CORREO A ALUMNO CON SU USER Y PASS
						$nombre = $GET['pe_nombre']." ".$GET['pe_apellido_paterno']." ".$GET['pe_apellido_materno'];
	
						if(!$this->enviarCorreo($GET['coel_correo'], $nombre, $GET['al_num_cuenta'], $pass)){
							$estado = "No se pud&oacute mandar el correo";
						}
					}
				}
			}
		}else{	//Alumno ya registrado
			$estado = "Alumno ya registrado";
		}
	
		$conexion->cerrarConexion();
		return $estado;
	}
	
	/*
	 * Función: EnviarCorreo
	* Para envíar el correo de registro del alumno
	* incluyendo sus datos de acceso como usuario.
	* CONFIGURACIONES: Sobre php.ini
	
	windows
	[mail function]
	; Setup for Windows systems
	SMTP = smtp.my.isp.net
	sendmail_from = me@myserver.com
	
	And here is how it might look on a Linux server with sendmail:
	
	[mail function]
	; Setup for Linux systems
	;http://www.w3schools.com/php/php_ref_mail.asp Para referencia
	sendmail_path = /usr/sbin/sendmail -t
	sendmail_from = me@myserver.com
	*/
	public function enviarCorreo($correo, $nombre, $no_cta, $password) {
		/*
			$mensaje = "	<h2>UNIVERSIDAD NACIONAL AUTON&OacuteMA DE M&EacuteXICO</h2><br/>";
		$mensaje .= "	<h3>Facultad de Contadur&iacutea y Administraci&oacuten</h3><br/>";
		$mensaje .= "	Departamento de Bolsa de Trabajo<br/><br/>";
		$mensaje .= "	Estimado alumno ".$nombre." <br/>";
		$mensaje .= "	Se te notifica que tus datos de acceso son los siguientes:<br/>";
		$mensaje .= "	Usuario ".$no_cta." <br/>";
		$mensaje .= "	Contraseña ".$password." <br/><br/>";
		$mensaje .= "	Sin m&aacutes por el momento quedamos a tus &oacuterdenes.<br/>";
		$mensaje .= "	Departamento de bolsa de Trabajo FCA - UNAM<br/>";
		$mensaje .= "	http://cetus.fca.unam.mx/sibt/ <br/>";
		*/
		//$mensaje = wordwrap($mensaje, 70, "\r\n");
	
		if(mail($correo, 'Datos de acceso SIBT', "UNIVERSIDAD NACIONAL AUTONÓMA DE MÉXICO
				Facultad de Contaduría y Administración
				Departamento de Bolsa de Trabajo
	
				Estimado alumno $nombre has sido registraro en la bolsa de trabajo de la FCA
				Se te notifica que tus datos de acceso son los siguientes:
				Usuario $no_cta
				Contraseña $password
	
				Sin más por el momento quedamos a tus órdenes.
	
				Departamento de bolsa de Trabajo FCA – UNAM
				http://cetus.fca.unam.mx/sibt/")){
				return true;
		}else{
				return false;
		}
	
	}
	
	public function checarCorreo($correo){
		$conexion = new InterfazBD2();
		$query_verificar = "SELECT * FROM ingsw.correo_electronico WHERE coel_correo = '".$correo."'";
	
		if(!$conexion->consultar($query_verificar)){
			return true;	//No hay algún correo así
		}else{
			return false;	//Ya existe ese correo
		}
	}
	
	public function buscarAlumno($GET){
		$conexion = new InterfazBD2();		//Iniciamos conexiï¿½n.
		
		$cuenta = isset($GET['no_cuenta'])? $GET['no_cuenta'] :NULL;
		$nombre = isset($GET['nombre_al'])? $GET['nombre_al'] :NULL;
		$ap_pat = isset($GET['ap_pat_al'])? $GET['ap_pat_al'] :NULL;
		$ap_mat = isset($GET['ap_mat_al'])? $GET['ap_mat_al'] :NULL;
		
		//Query
		$query_alumno = "SELECT * FROM ingsw.alumno AS al" 
						."JOIN ingsw.persona AS pe ON (pe.pe_id = al.pe_id)"
						."WHERE pe_nombre = '".$nombre."'" 
						."OR pe_apellido_paterno = '".$ap_pat."' OR" 
						."pe_apellido_materno = '".$ap_mat."' OR" 
						."al_num_cuenta = '".$cuenta."';";
		
		$res_alumnos = $conexion->consultar($query_alumno);
		
		$conexion->cerrarConexion();
       	return $res_alumnos;	//Retornamos resultado.
	}

	/**
	 * @author BenjamÃ­n Aguirre GarcÃ­a
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
		$strInfoAlumno = "<tr> <th> InformaciÃ³n Personal </th> </tr> <input type='hidden' name='idAlumno' value='$datos[al_id]'>
				<tr> <td> $datos[pe_nombre] $datos[pe_apellido_paterno] $datos[pe_apellido_materno]</td></td>
				<tr> <td> Nacionalidad $datos[al_nacionalidad]</td></tr>
				<tr> <td> Direccion: $datos[do_calle] N. $datos[do_num_exterior], $datos[co_nombre] CP. $datos[co_codigo_postal], $datos[demu_nombre], $datos[es_nombre].</td></tr>   
				<tr> <td> Correo ElectrÃ³nico: $correoE[coel_correo]</td></tr>
				<tr> <th> Telefonos </td></tr>
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
                
                if ( (count($conexion->consultar("SELECT * FROM ingsw.correo_electronico WHERE coel_correo='$correo'")) < 1) && (count($conexion->consultar("SELECT * FROM ingsw.usuario WHERE us_nombre='$noCta'")) < 1) ) {
		
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

                        //Se toma la hora del servidor en microsegundos, se le aplica un hash con el algoritmo ripemd160 y se extraen los primeros 8 caractares para la contrseÃ±a
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

                                                                                        Sin mÃ¡s por el momento quedamos a tus Órdenes.

                                                                                        Departamento de bolsa de Trabajo FCA  UNAM
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
                } else {
                    return false;
                }
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
		$strInfoAlumno = "
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
		$query = "SELECT AL.al_num_cuenta, AL.al_fecha_nacimiento, AL.al_nacionalidad,  P.pe_id, P.pe_nombre, P.pe_apellido_paterno, P.pe_apellido_materno, CE.coel_correo, EF.esfc_id, EF.esfc_descripcion, U.us_contrasenia, U.us_id FROM INGSW.PERSONA P INNER JOIN INGSW.ALUMNO AL ON(P.pe_id=AL.pe_id) INNER JOIN INGSW.CORREO_ELECTRONICO CE ON(P.pe_id=CE.pe_id) INNER JOIN INGSW.USUARIO U ON(P.pe_id=U.pe_id) INNER JOIN INGSW.ESTUDIO_FCA EF ON(EF.esfc_id=AL.esfc_id) WHERE '".$id."' = U.us_id ;";
	
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
		$query = "SELECT esfc_id, esfc_descripcion FROM INGSW.ESTUDIO_FCA WHERE esfc_descripcion LIKE 'Licenciatura%';";
	
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
			$al_fecha_nacimiento =  isset($GET['al_fecha_nacimiento']) ? $GET['al_fecha_nacimiento'] : "";
			$al_nacionalidad =  isset($GET['al_nacionalidad']) ? $GET['al_nacionalidad'] : "";
			$pe_id =  isset($GET['pe_id']) ? $GET['pe_id'] : "";
				
			//echo "$numCuenta , $nombre, $aPaterno, $aMaterno, $carrera, $correo , $pe_id";
				
			$query = "UPDATE INGSW.PERSONA SET pe_nombre ='".$nombre."', pe_apellido_paterno='".$aPaterno."',pe_apellido_materno='".$aMaterno."'
	WHERE pe_id ='".$pe_id."'; UPDATE INGSW.ALUMNO SET al_num_cuenta='".$numCuenta."', al_fecha_nacimiento = '".$al_fecha_nacimiento."', al_nacionalidad ='".$al_nacionalidad."', esfc_id='".$carrera."' WHERE pe_id ='".$pe_id."'; ";
				
				
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
	
	public function actualizarDireccion($direccion){
		$bd = new InterfazBD2();
		$domicilio = $direccion[do_id];
		$cp = $direccion[co_codigo_postal];
		$estado = $direccion[es_id]; 
		$demu = $direccion[demu_id];
		$colonia = $direccion[co_id];
		$calle = $direccion[do_calle];
		$noExt = $direccion[do_num_exterior];
		$noInt = $direccion[do_num_interior];
		$query = "UPDATE ingsw.domicilio SET co_id = $colonia, do_calle = $calle, do_num_exterior = $noExt, do_num_interior = $noInt WHERE do_id = $domicilio";
		
	}
	// fin Actualizar Alumno
	
	
	public function obtenerCatalogoDir(){
		$bd = InterfazBD2();
		$cat_dir = array();
		$cat_dir['estados']= $bd->toCatalogo("ingsw.estado ");
		$cat_dir['delegaciones'] = $db->toCatalogo("ingsw.delegacion_municipio");
		$cat_dir['colonias'] = $bd->toCatalogo("ingsw.colonia");
		
		return $cat_dir;
	}
	
	public function obtenerMiDireccion($alumno_id){
		$bd = new InterfazBD2();
		$salida = $bd->consultar("SELECT * FROM ingsw.alumno AS alum JOIN ingsw.domicilio AS dom ON alum.do_id = dom.do_id JOIN ingsw.colonia AS col ON dom.co_id = col.co_id JOIN ingsw.delegacion_municipio AS del_mun ON col.demu_id = del_mun.demu_id JOIN ingsw.estado AS edo ON del_mun.es_id = edo.es_id WHERE al_id = $alumno_id");
		$bd->cerrarConexion();
		return $salida[0];
	}
	
	public function obtenerDeMu($es_id){
		$bd = new InterfazBD2();
		$salida = $bd->consultar("SELECT * FROM delegacion_municipio WHERE es_id =$es_id");
		$bd->cerrarConexion();
		return $salida;
	}
	
	public function obtenerColonia($demu_id){
		$bd = new InterfazBD2();
		$salida = $bd->consultar("SELECT * FROM colonia WHERE demu_id =$demu_id");
		$bd->cerrarConexion();
		return $salida;
	}
        
        //Autor: García Solis Eduardo
        //Param: idConstancia
        //Retorna los datos del alumno
    public function getIdByIdConstac ($idConsta, $tipoCosnt) {
        $conn = new InterfazBD();
        
        switch ($tipoCosnt) {
            case 'cert';
                
                $sql = "SELECT al.al_id 
                        FROM ingsw.certificacion AS cer 
                        JOIN ingsw.alumno AS al ON (cer.al_id=al.al_id) JOIN ingsw.persona AS pe ON (al.pe_id=pe.pe_id) 
                        JOIN ingsw.correo_electronico AS co ON (pe.pe_id=co.pe_id) 
                        WHERE cer.ce_id=";
                break;
            
            case 'infoLab';
                
                $sql = "SELECT al.al_id FROM ingsw.informacion_academica AS ia 
                        JOIN ingsw.alumno AS al ON (ia.inac_id=al.al_id) JOIN ingsw.persona AS pe ON (al.pe_id=pe.pe_id) 
                        JOIN ingsw.correo_electronico AS co ON (pe.pe_id=co.pe_id) 
                        WHERE ia.inac_id=";
                break;
            
            case 'curs';
                
                $sql = "SELECT al.al_id FROM ingsw.curso AS cu JOIN ingsw.alumno AS al ON (cu.al_id=al.al_id) 
                        JOIN ingsw.persona AS pe ON (al.pe_id=pe.pe_id) JOIN ingsw.correo_electronico AS co ON (pe.pe_id=co.pe_id) 
                        WHERE cu.cu_id=";
                break;
            
            case 'idio';
                $sql = "SELECT al.al_id 
                            FROM ingsw.idioma_alumno AS idal 
                                    JOIN ingsw.alumno AS al ON (idal.al_id=al.al_id) 
                                    JOIN ingsw.nivel_idioma AS niid ON (idal.niid_id=niid.niid_id) 
                                    JOIN ingsw.idioma AS idio ON (niid.id_id=idio.id_id)
                                    JOIN ingsw.persona AS pe ON (al.pe_id=pe.pe_id) 
                                    JOIN ingsw.correo_electronico AS co ON (pe.pe_id=co.pe_id) 
                                    WHERE idal.idal_id=";
                break;
        }
        
        $alum = $conn->consultar($sql.$idConsta);
        
        $conn->cerrarConexion();
        
        return $alum[0]['al_id'];
    }
	
	
	
	public function registrarTelefonoAlumno($GET, $idUsuario){
	
		$conexion = new InterfazBD2();
		$estado = false;
	
		$query_persona = "SELECT pe_id FROM ingsw.usuario where us_id=$idUsuario";
		$resultados_persona = $conexion->consultar($query_persona);
			
		$id_persona = $resultados_persona[0]['pe_id'];
	
		$query_telefono = "INSERT INTO ingsw.telefono (tite_id, pe_id, te_telefono)
    			 		  VALUES (".$GET['lst_tipo_tel'].",$id_persona,'".$GET['txt_telefono']."')";
		$id_tel = $conexion->insertar($query_telefono, 'te_id');
			
		if($id_tel != false){
			$estado = true;
		}
		$conexion->cerrarConexion();
		return $estado;
	}
	
	public function borrarTelefonoAlumno($GET, $tipoUsuario, $idUsuario, $id_tel){
		$conexion = new InterfazBD2();
		if ($tipoUsuario == 5){
				
			$query_persona = "SELECT pe_id FROM ingsw.usuario where us_id=$idUsuario";
			$resultados_persona = $conexion->consultar($query_persona);
	
			$id_persona = $resultados_persona[0]['pe_id'];
				
			//echo "$id_tel , $id_persona";
	
			$query = "DELETE FROM ingsw.telefono WHERE pe_id=".$id_persona." AND te_id=".$id_tel.";";
	
			if ($conexion->ejecutarQuery($query)){
				echo "
				<table>
				  <tr>
					<td>Se ha borrado el tel&eacute;fono correctamente</td>
				  </tr>
				  <tr>
					<td><input type='button' value='Aceptar' onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumno', 'vacio', 'contenido');\"/>
					</td>
				  </tr>
				</table>
			";
					
			} else {
				echo "ERROR al borrar los datos";
			}
		}
		$conexion->cerrarConexion();
	}
	
	public function borrarCorreoAlumno($GET, $tipoUsuario, $idUsuario, $id_correo){
		$conexion = new InterfazBD2();
		if ($tipoUsuario == 5){
	
			$query_persona = "SELECT pe_id FROM ingsw.usuario where us_id=$idUsuario";
			$resultados_persona = $conexion->consultar($query_persona);
	
			$id_persona = $resultados_persona[0]['pe_id'];
	
			echo "$id_correo, $id_persona";
	
			$query = "DELETE FROM ingsw.correo_electronico WHERE pe_id=".$id_persona." AND coel_id=".$id_correo.";";
	
			if ($conexion->ejecutarQuery($query)){
			echo "
			<table>
				  <tr>
					<td>Se ha borrado el correo electr&oacute;nico correctamente</td>
				  </tr>
				  <tr>
					<td><input type='button' value='Aceptar' onclick=\"ajax('controllers/gestionarAlumno/CtlAlumno.php', 'actAlumno', 'vacio', 'contenido');\"/>
					</td>
				  </tr>
				</table>
			";
			
			} else {
			echo "ERROR al borrar los datos";
			}
		}
			$conexion->cerrarConexion();
	}
	
	public function registrarCorreoAlumno($GET, $idUsuario){
	
		$conexion = new InterfazBD2();
		$estado = false;
		
		$query_persona = "SELECT pe_id FROM ingsw.usuario where us_id=$idUsuario";
		$resultados_persona = $conexion->consultar($query_persona);
			
		$id_persona = $resultados_persona[0]['pe_id'];
		
		$query_correo = "INSERT INTO ingsw.correo_electronico(pe_id, coel_correo)
		VALUES ($id_persona,'".$GET['txt_correo']."')";
		$id_correo = $conexion->insertar($query_correo, 'coel_id');
			
		if($id_correo != false){
		$estado = true;
		}
		$conexion->cerrarConexion();
			return $estado;
	}
	
	
	
}

?>