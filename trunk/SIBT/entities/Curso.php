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
			$query = "SELECT * FROM ingsw.curso WHERE al_id = $idAlumno AND NOT esau_id = 1;";
			$res = $conn->consultar($query);
			$conn->cerrarConexion();
			return $res;
		}

		function guardar ($idAlumno, $nombre, $fechaConclusion, $rutaImagen) {
			$conn = new InterfazBD2();
			$insertquery = "INSERT INTO ingsw.curso (al_id, esau_id, cu_nombre, cu_fecha_conclusion, cu_ruta_constancia) VALUES ($idAlumno, '$nombre', '$fechaConclusion', '$rutaImagen')";
			echo $insertquery;
			$insert = Array();
			$insert['al_id'] = $idAlumno;
			$insert['esau_id'] = 2;
			$insert['cu_nombre'] = $nombre;
			$insert['cu_fecha_conclusion'] = $fechaConclusion;
			$insert['cu_ruta_constancia'] = $rutaImagen;
			$res = $conn->ejecutarInsert("ingsw.curso", $insert, "cu_id");
			$conn->cerrarConexion();
			if ($res == null) {
				return false;
			} else {
				return true;
			}
		}
		
		function obtenerCurso ($idCurso) {
			$conn = new InterfazBD2();
			$query = "SELECT * FROM ingsw.curso WHERE cu_id = $idCurso;";
			$res = $conn->consultar($query);
			$conn->cerrarConexion();
			return $res;			
		}
		
		function actualizar ($idCurso, $nombre, $fechaConclusion, $rutaImagen) {
			$conn = new InterfazBD2();
			$update = "UPDATE ingsw.curso SET cu_nombre = '$nombre', cu_fecha_conclusion = '$fechaConclusion', cu_ruta_constancia = '$rutaImagen' WHERE cu_id = $idCurso;";
//			echo $update;
//			$update = Array();
//			$update['cu_nombre'] = $nombre;
//			$update['cu_fecha_conclusion'] = $fechaConclusion;
//			$update['cu_ruta_constancia'] = $rutaImagen;
//			
			if ($conn->ejecutarQuery($update)) {
				return true;	
			} else {
				return false;
			}
		}
} 
	
?>