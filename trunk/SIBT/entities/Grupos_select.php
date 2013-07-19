<?php 

include('InterfazBD2.php');


class Grupos{
	
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
	function obtenerDatosGrupo($final_query = NULL){
			$db = new InterfazBD2();
			$resultado["taller"] = $db->toCatalogoConsulta("SELECT ta_id, ta_nombre FROM ingsw.taller");
			$resultado["aula"]=$db->toCatalogoConsulta("SELECT au_id,au_lugar FROM ingsw.aula");
			$resultado["profesor"]=$db->toCatalogoConsulta("SELECT persona.pe_nombre,persona.pe_id from ingsw.profesor join ingsw.persona on(ingsw.profesor.pe_id=ingsw.persona.pe_id)");
			$db->cerrarConexion();
			return $resultado;
	}
	
	//esta es mia no me la quiten cabrones
	function insertarGrupo($datosGrupo){
		$db = new InterfazBD2();
		var_dump($_GET);
				$campos_valores=$_GET;
		$resultado =$db->ejecutarInsert("ingsw.grupo", $campos_valores,"gr_id");
		//$resultado=$db->insertar("INSERT INTO ingsw.grupo values(default, 5,3,5,'Omar','f','2013-07-22','2013-07-29')","gr_id");
		//$resultado=$db->insertar("INSERT INTO ingsw.grupo values(default, 5," . ta_nombre . ",".au_lugar.",".gr_nombre . "'f'" . "," . gr_fecha_inicio . "," . gr_fecha_fin,"gr_id");
						
		if ($resultado!=NULL){
			echo("El registro ha sido insertado correctamente");
		}
		$db->cerrarConexion();
	}
	function obtenerDatosTotales(){
		$db = new InterfazBD2();
		
		$resultado =$db->consultar("SELECT ingsw.grupo.gr_nombre, ingsw.taller.ta_nombre, ingsw.aula.au_lugar, ingsw.persona.pe_nombre, ingsw.persona.pe_apellido_paterno, ingsw.persona.pe_apellido_materno,
ingsw.grupo.gr_fecha_inicio, ingsw.grupo.gr_fecha_fin from ingsw.aula JOIN ingsw.grupo ON(ingsw.aula.au_id = ingsw.grupo.au_id)  JOIN 
ingsw.taller ON (ingsw.taller.ta_id = ingsw.grupo.ta_id) JOIN ingsw.profesor ON(ingsw.grupo.pr_id = ingsw.profesor.pr_id ) JOIN ingsw.persona ON (ingsw.profesor.pe_id = 
ingsw.persona.pe_id)");
		//$resultado=$db->insertar("INSERT INTO ingsw.grupo values(default, 5,3,5,'Omar','f','2013-07-22','2013-07-29')","gr_id");
		//$resultado=$db->insertar("INSERT INTO ingsw.grupo values(default, 5," . ta_nombre . ",".au_lugar.",".gr_nombre . "'f'" . "," . gr_fecha_inicio . "," . gr_fecha_fin,"gr_id");
	
		$db->cerrarConexion();
		return $resultado;
	}
	
}


?>