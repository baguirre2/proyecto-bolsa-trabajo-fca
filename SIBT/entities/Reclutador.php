<?php
/**
 * 
 * Entity para Reclutador
 * @author Benjamín Aguirre García
 *
 */

include_once 'InterfazBD2.php';

class Reclutador {
	
	
	/**
	 * 
	 * Extrae los Curriculum de un Reclutador
	 * @author Benjamín Aguirre García
	 */
	public function obtenerFavoritos($idReclutador) {
		$conn = new InterfazBD2();
//		$select = 
		
		
	}

	/**
	 * 
	 * Agrega un Curriculum a Favoritos del Reclutador
	 * @author Benjamín Aguirre García
	 * @param $idReclutador Id del Reclutador
	 * @param $idAlumno id del Alumno 
	 */
	public function agregarFavorito($idReclutador, $idAlumno) {
		$conn = new InterfazBD2();
		$insert = Array();
		$insert['re_id'] = $idReclutador;
		$insert['al_id'] = $idAlumno;
		$res = $conn->ejecutarInsert("ingsw.favoritos_reclutador_alumno", $insert, "fareal_id");
		if (!$res) {
			return false;
		} else {
			return true;
		}
		
	}
	
	
	/**
	 * 
	 * Elimina un Curriculum de Favoritos
	 * @author Benjamín Aguirre García
	 * @param $idReclutador Id del Reclutador
	 * @param $idAlumno id del Alumno 
	 */	
	public function eliminarFavorito($idReclutador, $idAlumno) {
		$conn = new InterfazBD2();
		$query = "DELETE FROM ingsw.favoritos_reclutador_alumno WHERE re_id=$idReclutador AND al_id=$idAlumno;";
		$res = $conn->ejecutarQuery($query);
//		print_r($res);
		if ($res) {
			return true;
		} else {
			return false;
		}
	}
	
	public function consultaFavorito($idReclutador, $idAlumno) {
		$conn = new InterfazBD2();
		$query = "SELECT * FROM ingsw.favoritos_reclutador_alumno WHERE re_id=$idReclutador AND al_id=$idAlumno;";
		$res = $conn->consultar($query);
		if ($res == null) {
			return false;
		} else {
			return true;
		}
	}
	
	
	
	
}


?>