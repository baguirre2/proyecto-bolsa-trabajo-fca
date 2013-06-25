<?php
/** Creación
 * @author: Benjamín Aguirre García
 * Fecha de Creación: 21 de Junio de 2013
 * Proposito: Se trata de la entity Curso y se encarga de gestionar la conexión a la Base de Datos entre la aplicación y la tabla Curso  
 * 
 * Ultima Actualización
 * Ultima actualización: 24 de Junio de 2013
 * @author Benjamín Aguirre García
 */

include_once 'InterfazBD2.php';
	
class Curso{
		
		private $nombre;
		private $fechaCOnclusion;
		private $estadoAutorizacion;
		private $Constancia; 


		/**
		 * Se obtienen todos los cursos relacionados a un Alumno específicado por su ID. Solo busca aquellos cursos que no tienen el estado de: Aceptado.
		 * @author Benjamín Aguirre García
		 * @param $idAlumno id del Alumno. 
		 * @return $res Arreglo de Cursos.
		 */
		function obtener ($idAlumno) {
			$conn = new InterfazBD2(); 
			$query = "SELECT * FROM ingsw.curso WHERE al_id = $idAlumno AND NOT esau_id = 1;";
			$res = $conn->consultar($query);
			$conn->cerrarConexion();
			return $res;
		}
		
		/**
		 * 
		 * Guarda el curso con el id del Alumno al cual se asocia. Por defecto deja el estado de Autorización en 2, que es Pendiente.
		 * @author Benjamín Aguirre García 
		 * @param $idAlumno id del Alumno
		 * @param $nombre Nombre del Curso
		 * @param $fechaConclusion Fecha de Conclusión del Curso.
		 * @param $rutaImagen Ruta de la imagen de Constancia.
		 * @return true | false Verdadero si se almacenó en la Base de Datos con éxito, Falso si no puso almacenarse en la base de dados.
		 */
		function guardar ($idAlumno, $nombre, $fechaConclusion, $rutaImagen) {
			$conn = new InterfazBD2();
// 			$insertquery = "INSERT INTO ingsw.curso (al_id, esau_id, cu_nombre, cu_fecha_conclusion, cu_ruta_constancia) VALUES ($idAlumno, '$nombre', '$fechaConclusion', '$rutaImagen')";
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
		
		/**
		 * 
		 * Obtiene los datos de un curso en específico a partir del id del Curso.
		 * @param $idCurso id del Curso a obtener.
		 * @return $res Arreglo con los datos del Curso.
		 */
		
		function obtenerCurso ($idCurso) {
			$conn = new InterfazBD2();
			$query = "SELECT * FROM ingsw.curso WHERE cu_id = $idCurso;";
			$res = $conn->consultar($query);
			$conn->cerrarConexion();
			return $res;	
		}
		
		
		/**
		 * 
		 * Actualiza la información de un curso. 
		 * @param $idCurso id del Curso
		 * @param $nombre Nombre del Curso.
		 * @param $fechaConclusion Fecha de Conclusión del Curso
		 * @param $rutaImagen Ruta de la imagen del Curso.
		 */
		function actualizar ($idCurso, $nombre, $fechaConclusion, $rutaImagen) {
			$conn = new InterfazBD2();
			$update = "UPDATE ingsw.curso SET cu_nombre = '$nombre', cu_fecha_conclusion = '$fechaConclusion', cu_ruta_constancia = '$rutaImagen' WHERE cu_id = $idCurso;";			
			$res = $conn->ejecutarQuery($update);
			$conn->cerrarConexion(); 
			if ($res) {
				return true;	
			} else {
				return false;
			}
		}
} 
	
?>