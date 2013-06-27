<?php 

/*
 * Archivo: Class Alumno
 * Autor:	Emmanuel García C.
 * Fecha:	Martes 25/Junio/2013
 * Modificaciones: 
 * -
 * -
 */

class Alumno{

	function __construct() {
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
		if($nivel == 0 ){	//Opción default del select superior
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
			echo "<option value=\"Seleccionar\">Selecciona una opción</option>";
			for ($i = 0; $i <= count($resultados) - 1; $i++) {
				echo "<option value=\"".$resultados[$i]['esfc_id']."\">";
				echo $resultados[$i]['esfc_descripcion']."</option>";
			}
			echo "</select>";
			$conexion->cerrarConexion();
		}
	}
	
	public function listarEstadosAcademicos($nivel){
		if($nivel == 0){	//Opción default del select superior
			echo "";
		}else{
			$conexion = new InterfazBD2();
			$query = "SELECT * FROM ingsw.estado_academico";
			$resultados = $conexion->consultar($query);
			echo "<select class=\"required\" name=\"esac_id\">";
			echo "<option value=\"Seleccionar\">Selecciona una opción</option>";
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
}

?>
