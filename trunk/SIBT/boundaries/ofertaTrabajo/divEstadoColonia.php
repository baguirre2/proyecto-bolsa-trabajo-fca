<?php

class DivEstadoColonia{
    function __construct($arr_datos){
        if($arr_datos['estado'] == false){
            echo '<tr><td><etiqueta class="error">Por favor introduzca un C.P. válido.</etiqueta></td></tr>';
        }else{
            echo '<tr><td>Estado:</td><td>'.$arr_datos['estado'][0]['nombre'].'</td></tr>';
            echo '<tr><td>Delegación/municipio:</td><td>'.$arr_datos['delegacion'][0]['nombre'].'</td></tr>';
            echo '<tr><td>Colonia:</td><td><select id="select_col" name="domicilio[co_id]">';
                    foreach($arr_datos['colonias'] as $col){
                        echo '<option value="'.$col['id'].'">'.$col['nombre'].'</option>';
                    }
            echo '</select></td></tr>';
        }
    }
    
}
?>
