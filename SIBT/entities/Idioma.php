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
	
	function guardarAlumno($idAlumno, $idioma, $nivelOral, $nivelEscrito, $nivelLectura) {
		
	}
	
	function obtener ($idAlumno)  {
		$conn = new InterfazBD2();
		$query = "SELECT * FROM ingsw.idioma AS id JOIN ingsw.idioma_alumno AS alid ON (id.id_id = alid.id_id) AND alid.al_id = $idAlumno;";
		echo $query;
		$res = $conn->consultar($query);
		$conn->cerrarConexion();
		return $res;	
	}
	
}