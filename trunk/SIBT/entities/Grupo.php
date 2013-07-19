<?php 
include('InterfazBD2.php');
class Grupo{
	
	public $atributos = array();
	private $opcionales = array();
	
	function __construct(){
		
		$this->crearEstructura();
		
	}
	function crearEstructura(){
		$this->atributos['gr_id'] =  NULL;
		$this->atributos['pr_id'] =  NULL;
		$this->atributos['ta_id'] =  NULL;
		$this->atributos['au_id'] =  NULL;
		$this->atributos['gr_nombre'] =  NULL;
		$this->atributos['gr_estado_aprobacion'] =  NULL;
		$this->atributos['gr_fecha_inicio'] =  NULL;
		$this->atributos['gr_fecha_fin'] =  NULL;
		
	}	
	
	//jesus
	function obtenerDatosActualizacion($grupo_id){
		$db = new InterfazBD2();
		$resultado["grupo"]=$db->consultar("SELECT gr_nombre from ingsw.grupo where gr_id=".$grupo_id);
		$resultado["taller"]=$db->consultar("SELECT ta_nombre FROM ingsw.taller WHERE ta_id=(SELECT ta_id FROM ingsw.grupo WHERE gr_id=".$grupo_id.")" );
		$resultado["aula"]=$db->consultar("SELECT au_lugar FROM ingsw.aula WHERE au_id=(SELECT au_id FROM ingsw.grupo WHERE gr_id=".$grupo_id.")");
		$resultado["profesor"]=$db->consultar("SELECT persona.pe_nombre From ingsw.persona join  ingsw.profesor on(ingsw.persona.pe_id=ingsw.profesor.pe_id) JOIN ingsw.grupo ON(ingsw.profesor.pr_id=ingsw.grupo.pr_id)  where ingsw.grupo.gr_id=".$grupo_id);
		$resultado["fechaInicio"]=$db->consultar("SELECT gr_fecha_inicio from ingsw.grupo  WHERE gr_id=".$grupo_id);
		$resultado["fechaFin"]=$db->consultar("SELECT gr_fecha_fin from ingsw.grupo  WHERE gr_id=".$grupo_id);
		
		
		//$resultado=$db->consultar("SELECT g.gr_id, g.gr_nombre, t.ta_nombre,per.pe_nombre,a.au_lugar,g.gr_fecha_inicio,g.gr_fecha_fin FROM ingsw.grupo as g JOIN ingsw.taller as t ON (g.ta_id=t.ta_id) JOIN ingsw.aula as a ON(g.au_id=a.au_id) JOIN ingsw.profesor as p ON(g.pr_id=p.pr_id) JOIN ingsw.persona as per ON(p.pe_id=per.pe_id) where g.gr_id=".$grupo_id);
		$db->cerrarConexion();
		return $resultado;
	}
	//jesus
	function obtenerDatosGrupo($final_query = NULL){
			$db = new InterfazBD2();
			$resultado["taller"] = $db->toCatalogoConsulta("SELECT ta_id, ta_nombre FROM ingsw.taller");
			$resultado["aula"]=$db->toCatalogoConsulta("SELECT au_id,au_lugar FROM ingsw.aula");
			$resultado["profesor"]=$db->toCatalogoConsulta("SELECT profesor.pr_id,persona.pe_nombre from ingsw.profesor join ingsw.persona on(ingsw.profesor.pe_id=ingsw.persona.pe_id)");
			$db->cerrarConexion();
			return $resultado;
	}
	
	function obtenerDatosTabla($final_query = NULL){
		$db = new InterfazBD2();
		$resultado=$db->consultar("SELECT g.gr_id, g.gr_nombre, t.ta_nombre,per.pe_nombre,a.au_lugar,g.gr_fecha_inicio,g.gr_fecha_fin FROM ingsw.grupo as g JOIN ingsw.taller as t ON (g.ta_id=t.ta_id) JOIN ingsw.aula as a ON(g.au_id=a.au_id) JOIN ingsw.profesor as p ON(g.pr_id=p.pr_id) JOIN ingsw.persona as per ON(p.pe_id=per.pe_id)");
		$db->cerrarConexion();
		return $resultado;	
	}
		
	//jesus
	function insertarGrupo($id_profesor, $id_taller, $id_aula, $nombre_grupo, $estado_aprobacion, $fecha_inicio, $fecha_fin){
		$db = new InterfazBD2();
		//var_dump($_GET);		
		//echo "INSERT INTO ingsw.grupo values(default," .$id_profesor . "," . $id_taller. "," . $id_aula . ",'" . $nombre_grupo . "'," . "'" . $estado_aprobacion . "',"  . "'" . $fecha_inicio . "'," . "'". $fecha_fin ."')";
		//$resultado =$db->ejecutarInsert("ingsw.grupo", $campos_valores,"gr_id");
		//$resultado=$db->insertar("INSERT INTO ingsw.grupo values(default, 5,3,5,'Omar','f','2013-07-22','2013-07-29')","gr_id");
		$resultado=$db->insertar("INSERT INTO ingsw.grupo values(default," .$id_profesor . "," . $id_taller. "," . $id_aula . ",'" . $nombre_grupo . "'," . "'" . $estado_aprobacion . "',"  . "'" . $fecha_inicio . "'," . "'". $fecha_fin ."')" ,"gr_id");
						
		if ($resultado!=NULL){
			echo("El registro ha sido insertado correctamente");
		}
		$db->cerrarConexion();
	}
	
	//jesus
	function actualizarGrupo($id_grupo,$id_profesor, $id_taller, $id_aula, $nombre_grupo, $estado_aprobacion, $fecha_inicio, $fecha_fin){
		$db = new InterfazBD2();
		$resultado=$db->ejecutarQuery("UPDATE ingsw.grupo    
				SET pr_id=" . $id_profesor  . ", 
				ta_id=" .$id_taller .  ", 
				au_id=" .$id_aula . ", 
				gr_nombre=" . "'" . $nombre_grupo . "'" . ", 
				gr_estado_aprobacion=" . "'" . $estado_aprobacion . "'" . ", 
				gr_fecha_inicio=" . "'" . $fecha_inicio . "'" . ", 
				gr_fecha_fin=" . "'" . $fecha_fin . "'" . " 	WHERE gr_id=" .$id_grupo);
		if ($resultado!=NULL){
			echo("El Grupo ha sido actualizado correctamente");
		}
		$db->cerrarConexion();
	}
	
	
	//jesus
	function borraGrupo($grupo_id){
		$db = new InterfazBD2();
		$str_deleteHorario = "DELETE FROM ingsw.horario where gr_id=".$grupo_id;
		$delete1 = $db->ejecutarQuery($str_deleteHorario);
			
		//para borrar una inscripcion primero debo borrar una asistencia, ya que hay dependencia.
		$str_deleteAsistencia = "DELETE FROM ingsw.asistencia where in_id IN (select in_id from ingsw.inscripcion where gr_id=".$grupo_id.")";
		$delete2 = $db->ejecutarQuery($str_deleteAsistencia);
		
		$str_deleteInscripcion = "DELETE FROM ingsw.inscripcion where gr_id=".$grupo_id;
		$delete3 = $db->ejecutarQuery($str_deleteInscripcion);
		
		$str_deleteGrupo = "DELETE FROM ingsw.grupo where gr_id=".$grupo_id;
		$delete4 = $db->ejecutarQuery($str_deleteGrupo);
		/*if($delete!=NULL){
			echo "El registro ha sido eliminado correctamente";
		}*/		
		echo "<script languaje='javascript'>alert('Grupo eliminado correctamente')</script>";
		$db->cerrarConexion();		
	}	
//banda machos
	function obtenerGruposAlumno($final_query = NULL){
		$db = new InterfazBD2();
		$resultado = $db->consultar('SELECT gr_id, ta_id, pr_id, gr_nombre, gr_fecha_inicio, gr_fecha_fin, ta_nombre, au_lugar,ho_hora_inicio, ho_hora_fin, pe_nombre, pe_apellido_materno, pe_apellido_paterno  FROM ingsw.inscripcion NATURAL LEFT JOIN ingsw.grupo NATURAL LEFT JOIN ingsw.taller NATURAL LEFT JOIN ingsw.aula NATURAL LEFT JOIN ingsw.horario NATURAL LEFT JOIN ingsw.profesor NATURAL LEFT JOIN ingsw.persona WHERE al_id = 1;'.$final_query);
		$db->cerrarConexion();
		return $resultado;
	}
	//este metodo fue renombrado por que presentaba conflictos con la banda machos
	function obtenerDatosGrupo2($final_query = NULL){
		$db = new InterfazBD2();
		$resultado = $db->consultar('SELECT gr_id, ta_id, pr_id, gr_nombre, gr_fecha_inicio, gr_fecha_fin, ta_nombre, au_lugar,ho_hora_inicio, ho_hora_fin, pe_nombre, pe_apellido_materno, pe_apellido_paterno  FROM ingsw.grupo NATURAL LEFT JOIN ingsw.taller NATURAL LEFT JOIN ingsw.aula NATURAL LEFT JOIN ingsw.horario NATURAL LEFT JOIN ingsw.profesor NATURAL LEFT JOIN ingsw.persona WHERE gr_id NOT IN(SELECT gr_id FROM ingsw.inscripcion WHERE al_id = 1);'.$final_query);
		$db->cerrarConexion();
		return $resultado;
	}
}


?>