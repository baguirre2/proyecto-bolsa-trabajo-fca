<?php
/**
 * Entity Idioma.
 *  
 * @author: Benjamín Aguirre García
 * Fecha de Creación: 22 de Junio de 2013
 * Ultima actualización: 22 de Junio de 2013
 * 
 */

include './InterfazBD.php';

class Idioma {
	private $idIdioma;
	private $idioma;
	private $nivelOral;
	private $nivelEscrito;
	private $nivelLectura; 
	
	/**
	 * Constructor de Clase 
	 * @author Benjamín Aguirre García
	 */	
	function __construct() {
		
	}
	
	
	
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
		$conn = new InterfazBD(); 
		
	}
	
	function obtener ($idAlumno)  {
		
	}
	
}