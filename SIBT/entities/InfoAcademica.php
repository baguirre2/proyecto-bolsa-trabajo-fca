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
    	$conn = InterfazBD2();
    	
    	
    	
    }
}
?>