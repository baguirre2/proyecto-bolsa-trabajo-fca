<?php

class FrmReporte{
    function __construct($datos_tabla){
        
       ?>
<div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Lista de <span>Ofertas de trabajo</span></h1> <!--El span sirve para colocar una palabra a resaltar en negritas--> 
	                <p class="animated fadeInDown delay2">Número de vacantes ocupadas y cantidad de visitas.</p>
	            </div>
	        </div>
	    </div>
</div>           
<table class="tablas_sort">
    <thead>
        <tr>
            <th>Empresa</th>
            <th>Oferta</th>
            <th>Fecha de aprobaci&oacute;n</th>
            <th>Vacantes iniciales </th>
            <th>Vacantes ocupadas</th>
            <th>Consultas</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if($datos_tabla == false){
                echo '<tr><td>No hay datos para generar reporte</td></tr>';
            }else{
                foreach($datos_tabla as $fila){
                    echo '<tr>';
                    echo '<td>'.$fila['em_nombre'].'</td>';
                    echo '<td>'.$fila['oftr_nombre'].'</td>';
                    echo '<td>'.$fila['oftr_fecha_aprobacion'].'</td>';
                    echo '<td>'.$fila['oftr_num_vacantes'].'</td>';
                    echo '<td>'.$fila['vacantes_ocupadas'].'</td>';
                    echo '<td>'.$fila['oftr_num_consultas'].'</td>';
                    echo '</tr>';
                }
            }
        ?>
    </tbody>
</table>
           <?php
        
    }
    
}
?>
