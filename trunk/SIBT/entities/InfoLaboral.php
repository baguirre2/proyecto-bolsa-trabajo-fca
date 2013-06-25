<?php
/** Autor: Eduardo García
 */

include_once 'InterfazBD.php';

class InfoLaboral {
    private $empresa;
    private $puesto; 
    private $jefe;
    private $descripcion;
    private $logros;
    private $constnacias;
    private $anios;
    
    //Reigstra en la BD una nueva InfoLaboral
    public function guardar ($idAlum, $nomEmp, $puesto, $jefe, $descr, $logros, $anios) {
        $conn = new InterfazBD();
        
        $res = $conn->insertar("INSERT INTO ingsw.informacion_laboral 
                        (al_id, inla_empresa, inla_puesto, inla_jefe_inmediato, inla_descripcion_actividades, inla_logros, inla_anios_estancia) 
                        VALUES ($idAlum, '$nomEmp', '$puesto', '$jefe', '$descr', '$logros', '$anios')");
        
        $conn->cerrarConexion();
        
        return $res;        
    }
    
    //Recibe el ID de la infoLaboral que se va a modificar, y los nuevos valores que tomara
    public function modificar ($idInfoLab, $nomEmp, $puesto, $jefe, $descr, $logros, $anios) {
        $conn = new InterfazBD();
        
        $res = $conn->insertar("UPDATE ingsw.informacion_laboral 
                                    SET inla_empresa='$nomEmp', inla_puesto='$puesto', inla_jefe_inmediato='$jefe', 
                                    inla_descripcion_actividades='$descr', inla_logros='$logros', inla_anios_estancia='$anios' 
                                    WHERE inla_id=$idInfoLab");
        
        $conn->cerrarConexion();
        
        return $res;        
    }
    
    //Recibe el ID de la infoLaboral y recupera todos sus datos
    public function obtener ($idInfoLab) {
        $conn = new InterfazBD();
        
        $res = $conn->consultar("SELECT * FROM ingsw.informacion_laboral WHERE inla_id=$idInfoLab");
        
        $conn->cerrarConexion();
        
        return $res;
    }
    
    //Recibe el ID de la infoLaboral y la elimina de la BD
    public function Eliminar () {
        
    }
    
    //Recupera todas las infoLabora del alumno cuyo ID se recibe como parametro
    public function listar ($idAlumno) {
        
        $conn = new InterfazBD();
        
        $res = $conn->consultar("SELECT inlab.inla_id, inLab.inla_empresa, inlab.inla_puesto, inlab.inla_anios_estancia 
                                    FROM ingsw.informacion_laboral AS inLab JOIN ingsw.alumno AS alu ON (inLab.al_id=alu.al_id) 
                                        WHERE alu.al_id=$idAlumno");
        
        $conn->cerrarConexion();
        
        return $res;
    }
}
?>