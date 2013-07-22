<?php

class MiDireccion{
    
    function getDeMu($arr_datos){
        echo "<select name='direccion[demu_id]' id='demu_id' class='required' onchange='obtenerColonia();return false;'>";
			
				foreach($arr_datos as $clave => $valor){
					echo "<option value='$clave'>$valor</option>";
				}
			
		echo '</select>';
    }
    
    function getColonia($arr_datos){
       echo "<select name='direccion[co_id]' id='co_id' >";
			
				foreach($arr_datos as $clave => $valor){
					echo "<option value='$clave'>$valor</option>";
				}
			
		echo 	'</select>';
    }
}
?>
