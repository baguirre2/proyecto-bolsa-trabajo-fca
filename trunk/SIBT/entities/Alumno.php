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
	
	public function toString ($idAlumno) {
		$conn = new InterfazBD2();
		$query = "SELECT * FROM ingsw.alumno AS al 
					JOIN ingsw.domicilio AS dom ON (al.do_id = dom.do_id)
					JOIN ingsw.colonia AS co ON (dom.co_id = co.co_id)
					JOIN ingsw.delegacion_municipio AS demu ON (demu.demu_id = co.demu_id) 
					JOIN ingsw.estado AS es ON (es.es_id = demu.es_id)
					JOIN ingsw.persona AS pe ON (pe.pe_id = al.pe_id)
					WHERE al_id = $idAlumno;";
		$datos = $conn->consultar($query);
		$datos = $datos[0];
		$query  = "SELECT coel_correo FROM ingsw.persona AS pe JOIN ingsw.correo_electronico AS coel ON (coel.pe_id = pe.pe_id) WHERE pe_id= $datos[pe_id]";
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
				<tr> <td> Correo Electrónico: $datos[coel_correo]
				<tr> <th> Telefonos 
		";
		foreach ($telefonos AS $telefono) {
			$strInfoAlumno .= "<tr> <td> $telefono[tite_descripcion]: $telefono[te_telefono]";
			if ($telefono[te_extension] != null) {
				$strInfoAlumno .= " Ext. $telefono[te_extension]";
			}	
		}
		$strInfoAlumno .= "<tr> <th> Objetivos Profesionales <tr> <td> $datos[al_objetivos_profesionales]";
		return $strInfoAlumno;
	
	}
}

?>
