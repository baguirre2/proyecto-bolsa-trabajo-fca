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

	/**
	 * @author Benjamín Aguirre García
	 * @param $idAlumno Id del Alumno
	 */        
    public function toString($idAlumno) {
        $conn = new InterfazBD();
        $query = "SELECT * FROM ingsw.informacion_laboral WHERE al_id=$idAlumno";
        $res = $conn->consultar($query);
        $conn->cerrarConexion();
        if ($res == null) {
        	return "";
        }
    		$strInfoLaboral = "
				<tr> <th colspan='4'>  Informacion Laboral </th> </tr> ";
		foreach ($res as $datos) {
			$strInfoLaboral .= "
				<tr> <td> Empresa: $datos[inla_empresa] 
				<tr> <td> Puesto: $datos[inla_puesto]
				<tr> <td> Jefe Inmediato: $datos[inla_jefe_inmediato]
				<tr> <td> Actividades: $datos[inla_descripcion_actividades]
				<tr> <td> Logros: $datos[inla_logros]
				<tr> <td> Tiempo (meses): $datos[inla_anios_estancia]
			";
		}
		return $strInfoLaboral; 	
    }
}
?>