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
    			 		  VALUES ('NA','NA','NA')";
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
					$query_usuario_tipo = "INSERT INTO ingsw.usuario_tipo_usuario (tius_id, us_id)
    			 		  		 	   VALUES ('".$id_persona."','".$id_usuario."')";
  VALUES (21, 1, 21);
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
	
}

?>
