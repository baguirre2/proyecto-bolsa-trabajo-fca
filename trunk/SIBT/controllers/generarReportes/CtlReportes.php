<?php

include '../../entities/Reporte.php';

class CtlOferta {
    function __construct($GET) {
        
        $opc = $GET['opc'];
        
        switch ($opc) {
            
            //Reporte 
            case 1; 
                include '../../boundaries/reportes/reporte.php';
                $reporte = new Reporte();
                $datos_tabla = $reporte->obtenerDatosReporte();
                new FrmReporte($datos_tabla);
            break;
            
            //Gráficas
            case 2;
                include '../../boundaries/reportes/graficas.php';
                new FrmGraficas($datos_tabla);
            break;
        
            //Datos para las gráficas
            case 3:
                $reporte = new Reporte();
                $datos_tabla = $reporte->obtenerDatosReporte();
                //Creamos el formato que pide el API de google
                $arr_datos = array();
                $arr_datos['cols'] = array(
                        array("id"=>"", "label"=>"Oferta", "pattern"=>"", "type"=>"string"),
                        array("id"=>"", "label"=>"Vacantes ocupadas", "pattern"=>"", "type"=>"number"),
                        array("id"=>"", "label"=>"Consultas", "pattern"=>"", "type"=>"number"));
                $arr_tmp = array();
               foreach($datos_tabla as $fila){
                
                    $arr_tmp[]['c'] = array(array("v"=>$fila['em_nombre'].':'.$fila['oftr_nombre']),
                        array("v"=>$fila['vacantes_ocupadas']),array("v"=>$fila['oftr_num_consultas']));
                }
                $arr_datos['rows'] = $arr_tmp;
                        
                
                echo json_encode($arr_datos);
            break;
            
        }
    }
    
    
}

new CtlOferta($_GET);

?>