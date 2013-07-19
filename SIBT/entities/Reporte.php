<?php
require_once('InterfazBD2.php');

class Reporte{
    function obtenerDatosReporte(){
        $bd = new InterfazBD2();
        $res = $bd->consultar("SELECT ingsw.empresa.em_nombre, ingsw.oferta_trabajo.oftr_nombre, to_char(ingsw.oferta_trabajo.oftr_fecha_aprobacion,'DD-MM-YYYY') AS oftr_fecha_aprobacion,ingsw.oferta_trabajo.oftr_num_vacantes,(ingsw.oferta_trabajo.oftr_num_vacantes - ingsw.oferta_trabajo.oftr_num_vacantes_disponibles) AS  vacantes_ocupadas, ingsw.oferta_trabajo.oftr_num_consultas 
FROM ingsw.oferta_trabajo JOIN ingsw.reclutador ON (ingsw.oferta_trabajo.re_id = ingsw.reclutador.re_id) JOIN ingsw.empresa ON (ingsw.empresa.em_id = ingsw.reclutador.em_id)
WHERE ingsw.oferta_trabajo.esau_id = 1");
        $bd->cerrarConexion();
        return $res;
    }
    
}
?>