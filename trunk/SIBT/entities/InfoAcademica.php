<?php
/*
 * Autor: García Solis Eduardo 
 */
class InfoAcademica {
    
    private $universidad;
    private $escuela;
    private $promedio;
    private $fechaIni;
    private $fechaTerm;
    private $rutaConsta;
    
    public function __construct() {
        ;
    }

        //Autor: Eduardo García Solis
    //Obtienes toda la información de acuerdo a su estado de validación
    public function listarPorEstado($idEstado) {

        $conn = new InterfazBD();

        $res = $conn->consultar("SELECT 
                                    inac_id, 
                                    inac_universidad, 
                                    inac_escuela, 
                                    persona.pe_nombre, 
                                    persona.pe_apellido_paterno,
                                    persona.pe_apellido_materno 
                                FROM 
                                    ingsw.informacion_academica AS infoAca 
                                    JOIN ingsw.alumno ON (infoAca.al_id=alumno.al_id) 
                                    JOIN ingsw.persona ON (persona.pe_id=alumno.pe_id) 
                                WHERE 
                                    esau_id=$idEstado");

        $conn->cerrarConexion();

        return $res;
    }
    
    /**
     * 
     * Extrae toda la información academica relacionada con el alumno.
     * @author Benjamín Aguirre García 
     * @param $idAlumno Id del Alumno
     */
    public function obtener ($idAlumno) {
    	$conn = new InterfazBD2();
    	$query = "SELECT * FROM ingsw.informacion_academica AS inac 
					JOIN ingsw.estudio_otro AS esot ON (inac.esot_id = esot.esot_id) 
					JOIN ingsw.estudio_fca AS esfc ON (inac.esfc_id = esfc.esfc_id)
					JOIN ingsw.nivel_estudio AS nies ON (esot.nies_id = nies.nies_id OR esfc.nies_id = nies.nies_id)
					WHERE inac.al_id = $idAlumno;";
    	$res = $conn->ejecutarQuery($query);
    	$conn->cerrarConexion();
    	return $res; 
    }
    
    //Métovo para cambiar el campo esau_id al ID de autoriazo
    public function cambiarEstado ($idInfoAcade, $idEstado) {
        $conn = new InterfazBD();
        
        $res = $conn->insertar("UPDATE ingsw.informacion_academica SET esau_id=$idEstado WHERE inac_id=$idInfoAcade");
        
        $conn->cerrarConexion();
        
        return $res;        
    }
}
?>