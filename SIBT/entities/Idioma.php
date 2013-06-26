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
	
	/**
	 * 
	 * Enter description here ...
	 * @param $idAlumno
	 */
	function obtener ($idAlumno)  {
		$conn = new InterfazBD2();
		$query = "SELECT * FROM ingsw.idioma AS id JOIN ingsw.idioma_alumno AS alid ON (id.id_idioma = alid.id_id) AND alid.al_id = $idAlumno;";
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