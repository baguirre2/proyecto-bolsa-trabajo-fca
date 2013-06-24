<?php
/** Creación
 * @author: Benjamín Aguirre García
 * Fecha de Creación: 21 de Junio de 2013
 * Proposito: Se trata de la entity Curso y se encarga de gestionar la conexión a la Base de Datos entre la aplicación y la tabla Curso  
 * 
 * Ultima Actualización
 * Ultima actualización: 21 de Junio de 2013
 * @author Benjamín Aguirre García
 */

include 'InterfazBD2.php';
	
class Curso{
		
		private $nombre;
		private $fechaCOnclusion;
		private $estadoAutorizacion;
		private $Constancia; 

		function __construct(){
				
		}
		
		
		function obtener ($idAlumno) {
			$conn = new InterfazBD2(); 
			$query = "SELECT * FROM curso WHERE al_id = $idAlumno";
			return $conn->consultar($query);
		}

		function guardar ($idAlumno, $nombre, $fechaConclusion, $rutaImagen) {

		}
		
		function actualizar ($idAlumno, $nombre, $fechaConclusion, $rutaImagen) {
			
		}
} 
	
?>