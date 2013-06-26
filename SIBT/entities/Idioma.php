<?php
/**
 * Entity Idioma.
 *  
 * @author: Benjamín Aguirre García
 * Fecha de Creación: 22 de Junio de 2013
 * Ultima actualización: 22 de Junio de 2013
 * 
 */

include_once 'InterfazBD2.php';

class Idioma {
	
	/**
	 * Guarda el Idioma con función al Alumno
	 * 
	 * @author Benjamín Aguirre García
	 * @param $idAlumno id del Alumno al cual se añade el  
	 * @param $idioma Nombre del Idioma. Ej: Inglés
	 * @param $nivelOral Nivel de capacidad para hablar el idioma. Ej: 80
	 * @param $nivelEscrito Nivel de Capacidad Escrita
	 * @param $nivelLectura Nivel de Capacidad
	 * @return $guardado Regresa verdadero o falso, si fue almacenado en la Base de Datos regresa Verdadero (true) si no regresa Falso (false). 
	 */
	
	function guardarIdiomaAlumno($idAlumno, $idioma, $nivelOral, $nivelEscrito, $nivelLectura, $rutaImg, $institucion, $anio) {
		$conn = new InterfazBD2();
		$insert = Array();
		$insert['id_idioma'] = $idioma;
		$insert['id_nivel_oral'] = $nivelOral;
		$insert['id_nivel_escrito'] = $nivelEscrito;
		$insert['id_nivel_lectura'] = $nivelLectura;
		$res = $conn->ejecutarInsert("ingsw.nivel_idioma", $insert, "id_id");
		if ($res == null) {
			$conn->cerrarConexion();
			return false;
		} else {
			$insert = Array();
			$insert['id_id'] = $res;
			$insert['al_id'] = $idAlumno;
			$insert['esau_id'] = 3;
			$insert['idal_ruta_constancia'] = $rutaImg;
			$insert['idal_institucion'] = $institucion;
			$insert['idal_anio'] = $anio;
			$res = $conn->ejecutarInsert("ingsw.idioma_alumno", $insert, "idal_id");
			if ($res == null) {
				$conn->cerrarConexion();
				return false;
			}
		}
		$conn->cerrarConexion();
		return true;
	}
	
	/**
	 * 
	 * Obtiene el nombre
	 * @param $idAlumno
	 */
	function obtener ($idAlumno)  {
		$conn = new InterfazBD2();
		$query = "SELECT idal_id, id_nombre, id_nivel_oral, id_nivel_escrito, id_nivel_lectura FROM ingsw.idioma AS id JOIN ingsw.nivel_idioma AS niid ON (id.id_idioma = niid.id_idioma) JOIN ingsw.idioma_alumno AS alid ON (niid.id_id = alid.id_id) AND alid.al_id = $idAlumno;";
		$res = $conn->consultar($query);
		$conn->cerrarConexion();
		return $res;
	}
	
	function obtenerIdiomas () {
		$conn = new InterfazBD2();
		$query = "SELECT * FROM ingsw.idioma;";
		$res = $conn->consultar($query);	
		$conn->cerrarConexion();
		return $res;
	}

	
	
	function actualizar($idioma, $nivelOral, $nivelEscrito, $nivelLectura, $idiomaAlumno, $institucion, $anio, $rutaImg) {
		$conn = new InterfazBD2();
		$query = "SELECT id_id FROM ingsw.idioma_alumno WHERE idal_id = $idiomaAlumno;";
		$nivelIdioma = $conn->consultar($query);		
		$update = "UPDATE ingsw.idioma_alumno SET idal_ruta_constancia = '$rutaImg', idal_institucion='$institucion', idal_anio=$anio WHERE idal_id = $idiomaAlumno;";
//		echo $update;
		$res = $conn->ejecutarQuery($update);
		if (!$res) {
			$conn->cerrarConexion();
			return false;
		} else {
			$nivelIdioma = $nivelIdioma[0][id_id];
			$update = "UPDATE ingsw.nivel_idioma SET id_idioma = $idioma, id_nivel_oral = $nivelOral, id_nivel_escrito = $nivelEscrito, id_nivel_lectura = $nivelLectura WHERE id_id = $nivelIdioma;";
			$res = $conn->ejecutarQuery($update);
			if (!$res) {
				$conn->cerrarConexion();
				return false;
			}
		}
		$conn->cerrarConexion();		
		return true;
		
	}
	
	function obtenerDatosIdioma ($alumnoIdioma) {
		$conn = new InterfazBD2();
		$query = "SELECT * FROM ingsw.idioma AS id JOIN ingsw.nivel_idioma AS niid ON (id.id_idioma = niid.id_idioma) JOIN ingsw.idioma_alumno AS alid ON (niid.id_id = alid.id_id) AND alid.idal_id = $alumnoIdioma;";
		$res = $conn->consultar($query);
		$conn->cerrarConexion();
		return $res;		
	}

        
    //Autor: Eduardo García Solis
    //Obtienes todas los idiomas de acuerdo a su estado de validación
    public function listarPorEstado($idEstado) {

        $conn = new InterfazBD();

        $res = $conn->consultar("SELECT  
                                    idal_id,
                                    persona.pe_nombre, 
                                    persona.pe_apellido_paterno,
                                    persona.pe_apellido_materno,
                                    id_nombre,
                                    id_nivel_oral,
                                    id_nivel_escrito,
                                    id_nivel_lectura
                                FROM 
                                    ingsw.idioma_alumno JOIN  
                                    ingsw.alumno ON (alumno.al_id = idioma_alumno.al_id) 
                                    JOIN ingsw.persona ON (alumno.pe_id = persona.pe_id) 
                                    JOIN ingsw.estado_autorizacion ON (idioma_alumno.esau_id = estado_autorizacion.esau_id) 
                                    JOIN ingsw.nivel_idioma ON (idioma_alumno.id_id=nivel_idioma.id_id) 
                                    JOIN ingsw.idioma ON (idioma.id_idioma=nivel_idioma.id_id)
                                WHERE 
                                    idioma_alumno.esau_id=$idEstado");

        $conn->cerrarConexion();

        return $res;
    }

}