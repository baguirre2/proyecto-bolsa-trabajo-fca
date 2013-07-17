<?php 

/*
 * Archivo: Class Usuario
 * Autor:	Victor M. Morales Reyes
 * Fecha:	Martes 27/Junio/2013
 * Modificaciones: 
 * -
 * -
 */

class Usuario{

	function __construct() {
		
	}
	// Obtener Tipo
	public function obtenerTipoUsuario() {
		$interfazBD = new InterfazBD2();
		$query = "SELECT * FROM ingsw.tipo_usuario;";
		$tipoUsuario = $interfazBD->consultar($query);
		if($tipoUsuario){
			$interfazBD->cerrarConexion();
			return $tipoUsuario;
		}else{
			$interfazBD->cerrarConexion();
			return false;
		}
	}
	// Fin Obtener Tipo
	
	// Registrar Usuario
	public function registrarUsuario($GET){
		$interfazBD = new InterfazBD2();
		$estado = false;
		
		$query_persona = "INSERT INTO ingsw.persona (pe_nombre, pe_apellido_paterno, pe_apellido_materno)
    			 		  VALUES ('".$GET['rfc']."','NA','NA')";
		$id_persona = $interfazBD->insertar($query_persona, 'pe_id');
		/*echo "ID Persona = ";	var_dump($id_persona);
		echo "query = $query_persona";
		echo"$id_persona";*/
		if($id_persona != false){
			
			$query_correo = "INSERT INTO ingsw.correo_electronico (pe_id, coel_correo)
    			 		     VALUES ('".$id_persona."','".$GET['eMail']."')";
			
			if($interfazBD->ejecutarQuery($query_correo) != false){
				
				$query_usuario = "INSERT INTO ingsw.usuario (pe_id, us_nombre, us_contrasenia) VALUES ('".$id_persona."','".$GET['rfc']."', 'xxxxxxxx')";
				$id_usuario = $interfazBD->insertar($query_usuario, 'us_id');
				if($id_usuario != false){
					$query_usuario_tipo = "INSERT INTO ingsw.usuario_tipo_usuario (tius_id, us_id) VALUES ('".$GET['tipoUsuario']."','".$id_usuario."')";
					if($interfazBD->ejecutarQuery($query_usuario_tipo) != false){
						$estado = true;
					}
				}
			}
		}
		$interfazBD->cerrarConexion();
		return $estado;
	}
	// Fin Registrar Usuario	
	
	//Inicio consultar usuario
	
	public function obtenerUsuariosCoordDirAsis() {
		$interfazBD = new InterfazBD2();
		$query = "SELECT TU.tius_descripcion, U.us_id, U.us_nombre FROM INGSW.USUARIO_TIPO_USUARIO UTU INNER JOIN INGSW.USUARIO U ON(U.us_id=UTU.us_id) INNER JOIN INGSW.TIPO_USUARIO TU ON(TU.tius_id=UTU.tius_id) INNER JOIN INGSW.PERSONA P ON(P.pe_id=U.pe_id);";
		$usuarios = $interfazBD->consultar($query);
		if($usuarios){
			$interfazBD->cerrarConexion();
			return $usuarios;
		}else{
			$interfazBD->cerrarConexion();
			return false;
		}
	}
	
	public function obtenerDatosUsuario($id) {
		$interfazBD = new InterfazBD2();
		$query = "SELECT P.pe_id, U.us_id, TU.tius_id, TU.tius_descripcion, U.us_nombre,  CE.coel_correo FROM INGSW.USUARIO_TIPO_USUARIO UTU INNER JOIN INGSW.USUARIO U ON(U.us_id=UTU.us_id) INNER JOIN INGSW.TIPO_USUARIO TU ON(TU.tius_id=UTU.tius_id) INNER JOIN INGSW.PERSONA P ON(P.pe_id=U.pe_id) INNER JOIN INGSW.CORREO_ELECTRONICO CE ON(P.pe_id=CE.pe_id) WHERE ".$id." =  U.us_id;";
		$datos = $interfazBD->consultar($query);
		if($datos){
			$interfazBD->cerrarConexion();
			return $datos = $datos[0];
		}else{
			$interfazBD->cerrarConexion();
			return false;
		}
	}
	
	public function modificarUsuario($GET){
		$conexion = new InterfazBD2();
	
		$usuario = $GET['usuario'];
		$tius_id = $GET['tipoUsuario'];
		$eMail = $GET['eMail'];
		$pe_id =  isset($GET['pe_id']) ? $GET['pe_id'] : "";
		$us_id =  isset($GET['us_id']) ? $GET['us_id'] : "";
	
		// echo "Datos2: $usuario, $tius_id, $eMail, $pe_id, $us_id";
	
		$query = "UPDATE INGSW.USUARIO SET us_nombre='".$usuario."' WHERE pe_id = '".$pe_id."'; UPDATE INGSW.USUARIO_TIPO_USUARIO SET tius_id='".$tius_id."' WHERE us_id='".$us_id."'; UPDATE INGSW.CORREO_ELECTRONICO SET coel_correo= '".$eMail."' WHERE pe_id='".$pe_id."';
" ;
		if ($conexion->ejecutarQuery($query)){
			echo"
			<table>
			  <tr>
				<td colspan=\"2\">Se ha modificado la información exitosamente</td>
			  </tr>
			  <tr>
				<td colspan=\"2\">
				<input type= 'button' value='Aceptar' onclick=\"ajax('controllers/gestionarUsuario/CtlUsuario.php', 'consUsuario', 'vacio', 'contenido'); \" />
				</td>
			  </tr>
			</table>
		";
				
	
		} else {
			echo "ERROR al actualizar los datos";
		}
		$conexion->cerrarConexion();
	
	}
	
	
	public function bajaUsuario($GET){
		$conexion = new InterfazBD2();
	
		$pe_id =  isset($GET['pe_id']) ? $GET['pe_id'] : "";
		$us_id =  isset($GET['us_id']) ? $GET['us_id'] : "";
	
		//echo "$pe_id, $us_id";
	
		$query = "DELETE FROM INGSW.USUARIO WHERE pe_id='".$pe_id."'; DELETE FROM INGSW.CORREO_ELECTRONICO WHERE pe_id='".$us_id."';" ;
		if ($conexion->ejecutarQuery($query)){
			echo"
			<table>
			  <tr>
				<td colspan=\"2\">El usuario ha sido dado de baja satistactoriamente</td>
			  </tr>
			  <tr>
				<td colspan=\"2\">
				<input type= 'button' value='Aceptar' onclick=\"ajax('controllers/gestionarUsuario/CtlUsuario.php', 'consUsuario', 'vacio', 'contenido'); \" />
				</td>
			  </tr>
			</table>
		";
				
	
		} else {
			echo "ERROR al actualizar los datos";
		}
		$conexion->cerrarConexion();
	}
	
	// Fin consultar usuario
}

?>
