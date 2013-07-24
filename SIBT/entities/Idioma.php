<?php
/**
 * Entity Idioma.
 *  
 * @author: Benjamín Aguirre García
 * Fecha de Creación: 22 de Junio de 2013
 * 
 */

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
	 * @param $rutaImg La ruta de la imagen de la constancia, este dato es clave pues si es nulo, no se agregan los datos de la constancia. 
	 * @param $institucion Nombre de la institución de procedencia de la constancia.
	 * @param $anio Año en que fue obtenida la constancia.
	 * @return true | false  Regresa verdadero o falso, si fue almacenado en la Base de Datos regresa Verdadero (true) si no regresa Falso (false).
	 */	
	function guardarIdiomaAlumno($idAlumno, $idioma, $nivelOral, $nivelEscrito, $nivelLectura, $rutaImg = null, $institucion = null, $anio = null) {
		$conn = new InterfazBD2();
		$insert = Array();
		$insert['id_id'] = $idioma;
		$insert['niid_nivel_oral'] = $nivelOral;
		$insert['niid_nivel_escrito'] = $nivelEscrito;
		$insert['niid_nivel_lectura'] = $nivelLectura;
		$res = $conn->ejecutarInsert("ingsw.nivel_idioma", $insert, "niid_id");
		echo $res;
		if ($res == null) {
			$conn->cerrarConexion();
			return false;
		} else {
			$insert = Array();
			$insert['niid_id'] = $res;
			$insert['al_id'] = $idAlumno;
			if ($rutaImg == null) {
				$insert['esau_id'] = 3;
			} else { 
				$insert['idal_ruta_constancia'] = $rutaImg;
				$insert['idal_institucion'] = $institucion;
				$insert['idal_anio'] = $anio;
				$insert['esau_id'] = 2;
			}
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
	 * Obtiene los Idiomas de un Alumno extrae unicamente los datos:
	 *  -> id de la tabla idioma_alumno 
	 * 	-> Nombre de Idioma
	 *  -> nivel de escritura
	 *  -> nivel de lectura
	 * @author Benjamín Aguirre García
	 * @param $idAlumno Id del alumno del que se desean extraer los datos de Idiomas asociados a el,
	 * @return $res Es el resultado de la consulta.
	 */
	function obtener ($idAlumno)  {
		$conn = new InterfazBD2();
		$query = "SELECT idal_id, id_nombre, niid_nivel_oral, niid_nivel_escrito, niid_nivel_lectura FROM ingsw.idioma AS id JOIN ingsw.nivel_idioma AS niid ON (id.id_id = niid.id_id) JOIN ingsw.idioma_alumno AS idal ON (niid.niid_id = idal.niid_id) AND idal.al_id = $idAlumno;";
//		echo $query;
		$res = $conn->consultar($query);
		$conn->cerrarConexion();
		return $res;
	}
	
	/**
	 * 
	 * Obtiene el nombre de los idiomas disponibles.
	 * @author Benjamín Aguirre García
	 */	
	function obtenerIdiomas () {
		$conn = new InterfazBD2();
		$query = "SELECT * FROM ingsw.idioma;";
		$res = $conn->consultar($query);	
		$conn->cerrarConexion();
		return $res;
	}

	/**
	 * 
	 * Actualiza la información de un Idioma
	 * "@author Benjamín Aguirre 
	 * @param $idioma id del Idioma
	 * @param $nivelOral Nivel oral del Idioma
	 * @param $nivelEscrito Nivel Escrito del Idioma
	 * @param $nivelLectura Nivel de Lectura del Idioma
	 * @param $idiomaAlumno Id de la tabla alumno_idioma
	 * @param $institucion Institución de procedencia de constancia esta variable puede no enviarse.
	 * @param $anio Año de emisión de Constancia esta variable puede no enviarse. 
	 * @param $rutaImg Ruta de la imagen, esta variable puede no enviarse y es clave debido a que si es nulo, no se actualiza nada de la información de Constancia.
	 * @return true | false Verdadero si se realizaron correctamente las actualizaciones, Falso si no se complet[o correctamente.
	 */
	function actualizar($idioma, $nivelOral, $nivelEscrito, $nivelLectura, $idiomaAlumno, $institucion = null, $anio = null, $rutaImg = null) {
		$conn = new InterfazBD2();
		$query = "SELECT niid_id FROM ingsw.idioma_alumno WHERE idal_id = $idiomaAlumno;";
		$nivelIdioma = $conn->consultar($query);
		if ($rutaImg != null) {
			$update = Array();
			$update['idal_ruta_constancia'] = $rutaImg;
			$update['idal_institucion'] = $institucion;
			$update['idal_anio'] = $anio;
			$insert['esau_id'] = 2;
			$res = $conn->ejecutarUpdate("ingsw.idioma_alumno", $update, "WHERE idal_id = $idiomaAlumno");
		} else {
			$res = true;
		}
		if (!$res) {
			$conn->cerrarConexion();
			return false;
		} else {
			$update = Array();
			$update['id_id'] = $idioma;
			$update['niid_nivel_escrito'] = $nivelEscrito;
			$update['niid_nivel_oral'] = $nivelOral;
			$update['niid_nivel_lectura'] = $nivelLectura;
			$nivelIdioma = $nivelIdioma[0]['niid_id'];
			$res = $conn->ejecutarUpdate("ingsw.nivel_idioma", $update, "WHERE niid_id = $nivelIdioma");
			if (!$res) {
				$conn->cerrarConexion();
				return false;
			}
		}
		$conn->cerrarConexion();		
		return true;
	}
	
	/**
	 * 
	 * Obtiene todos los datos de un idioma a partir del id de la tabla alumno_idioma
	 * @author Benjamín Aguirre García
	 * @param $alumnoIdioma id de la tabla alumno_idioma idal_id
	 */
	function obtenerDatosIdioma ($alumnoIdioma) {
		$conn = new InterfazBD2();
		$query = "SELECT * FROM ingsw.idioma AS id JOIN ingsw.nivel_idioma AS niid ON (id.id_id = niid.id_id) JOIN ingsw.idioma_alumno AS idal ON (niid.niid_id = idal.niid_id) AND idal.idal_id = $alumnoIdioma;";
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
                                    niid_nivel_oral,
                                    niid_nivel_escrito,
                                    niid_nivel_lectura
                                FROM 
                                    ingsw.idioma_alumno JOIN  
                                    ingsw.alumno ON (alumno.al_id = idioma_alumno.al_id) 
                                    JOIN ingsw.persona ON (alumno.pe_id = persona.pe_id)  
                                    JOIN ingsw.nivel_idioma ON (idioma_alumno.niid_id=nivel_idioma.niid_id) 
                                    JOIN ingsw.idioma ON (idioma.id_id=nivel_idioma.id_id)
                                WHERE 
                                    idioma_alumno.esau_id=$idEstado");

        $conn->cerrarConexion();

        return $res;
    }
    
    //Métovo para cambiar el campo esau_id
    public function cambiarEstado ($idIdioma, $idEstado) {
        $conn = new InterfazBD();
        
        $res = $conn->insertar("UPDATE ingsw.idioma_alumno SET esau_id=$idEstado WHERE idal_id=$idIdioma");
        
        $conn->cerrarConexion();
        
        return $res;        
    }

	/**
	 * @author Benjamín Aguirre García
	 * @param $idAlumno Id del Alumno
	 */        
    public function toString ($idAlumno) {
    	$idioma = $this->obtener($idAlumno);
    	if ($idioma == null) {
    		return "";
    	}
    	$strIdioma = "<tr> <th> Idioma ";
    	foreach ($idioma AS $datos) {
    		$strIdioma .= "<tr> <td> <b> Idioma: $datos[id_nombre]
    						<tr> <td> Nivel Oral: $datos[niid_nivel_oral]
    						<tr> <td> Nivel Lectura: $datos[niid_nivel_lectura]
    						<tr> <td> Nivel Escritura: $datos[niid_nivel_escrito]
    				";
    	}
    	return $strIdioma;
    }

}