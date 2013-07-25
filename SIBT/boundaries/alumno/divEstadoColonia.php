<?php

class DivEstadoColonia{
    function __construct($arr_datos){
        if($arr_datos['estado'] == false){
            echo "<tr><td><etiqueta class='error'>Por favor introduzca un C.P. v&aacutelido.</etiqueta></td></tr>\n";
        }else{
        	echo "<tr><td>Estado:</td>\n"
                    ."<td><input type='text' name='es_nombre' id='es_nombre' value='".$arr_datos['estado'][0]['nombre']."' readonly />\n"
                    ."<input type='hidden' name='es_id' id='es_id' value='".$arr_datos['estado'][0]['id']."' />\n"
                    ."</td></tr>\n";
        	
        	echo "<tr><td>Delegaci&oacute/Municipio:</td>\n"
                    ."<td><input type='text' name='demu_nombre' id='demu_nombre' value='".$arr_datos['delegacion'][0]['nombre']."' readonly />\n"
                    ."<input type='hidden' name='es_id' id='es_id' value='".$arr_datos['delegacion'][0]['id']."' />\n"
                    ."</td></tr>";
            
            echo '<tr><td>Colonia:</td><td><select id="co_id" name="co_id">';
                    foreach($arr_datos['colonias'] as $col){
                        echo '<option value="'.$col['id'].'">'.$col['nombre'].'</option>';
                    }
            echo '</select></td></tr>';
        }
    }
    
}
?>