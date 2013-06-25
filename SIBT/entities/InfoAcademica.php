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
    
    public function listar () {
        $conn = new InterfazBD();
        
        $res = $conn->consultar("SELECT inlab.inla_id, inLab.inla_empresa, inlab.inla_puesto, inlab.inla_anios_estancia 
                                    FROM ingsw.informacion_laboral AS inLab JOIN ingsw.alumno AS alu ON (inLab.al_id=alu.al_id) 
                                        WHERE alu.al_id=$idAlumno");
        
        $conn->cerrarConexion();
        
        return $res;
    }
}
?>