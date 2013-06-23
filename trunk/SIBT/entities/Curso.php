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

include "./IntefazBD.php";
	
class Curso{
		
		private $nombre;
		private $fechaCOnclusion;
		private $estadoAutorizacion;
		private $Constancia; 

		function __construct($nombre, $fechaConclusion, $estadoAutorizacion){
				
		}
		
		function obtener ($idAlumno) {
			$conn = new IntefazBD; 
			$query = "SELECT * FROM curso WHERE al_id = " . $idAlumno;
			
			
			
		}
		
		function guardar ($idAlumno, $nombre, $fechaConclusio, $rutaImagen) {
			$Constancia = new Constancia($rutaImagen);
			
			$insert = "INSERT INTO curso (nombreVALUES (";			
			
		}
} 
	
?>