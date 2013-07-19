<?php 
class FrmConsultarPendientesRevisar{
	
	
	function __construct($campos = NULL,$datos_tabla = NULL){
?>

<div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Consultar <span>Ofertas de Trabajo</span></h1> <!--El span sirve para colocar una palabra a resaltar en negritas--> 
	                <p class="animated fadeInDown delay2">Pendientes de revisar.</p>
	            </div>
	        </div>
	    </div>
</div>


	
<table  class="tablas_sort">
        <thead>
            <tr>
            	<th>Nombre</th>
                <th>Puesto</th>
                <th>Fecha de registro</th>
                <th>Empresa</th>
                <th>Estado de autorizaci&oacute;n</th>
                <th>Acciones</th>
            </tr>
        </thead>
      
        <tbody>
        	<?php 
        		echo self::crearFilasTabla($campos, $datos_tabla);
        	?>
        </tbody>
    </table>


<?php 
	}/*Fin del constructor*/
	
	/**
	 * Regresa las filas de una tabla
	 * @param array[] $campos nombre de los campos a mostrar
	 * @param array[][] $datos_tabla datos a mostrar en esos campos
	 * @return string $cadenaFilas
	 */
	static function crearFilasTabla($campos = NULL, $datos_tabla = NULL){
    
    	$cadenaFilas = "";
    	foreach($datos_tabla as $fila){
    		$cadenaFilas .= '<tr>';
    		foreach($campos as $clave ){
    			$cadenaFilas .= '<td>';
    			$cadenaFilas .= $fila[$clave];
    			$cadenaFilas .= '</td>';
    		}
    		$cadenaFilas .= '<td>';
    	
    		
    			$cadenaFilas .= "<a href='#' title='Ver oferta completa' class='accion_link' onclick='verOftrCompleta(".$fila['oftr_id'].");return false;'><img src='webroot/images/ver_completa.png'/></a>";
    		
    		
    		$cadenaFilas .= '</td>';
    
    		$cadenaFilas .= '</tr>';
    
    	}
    
    	return $cadenaFilas;
    
    }
}
?>
		