<?php

class DivEstudio{
    
    function getDeMu($arr_datos){
        echo "<select name='direccion[demu_id]' id='demu_id' class='required' onchange='obtenerColonia();return false;'>";
			
				foreach($arr_datos as $clave => $valor){
					echo "<option value='$clave'>$valor</option>";
				}
			
		echo 	'</select>';
    }
    
    function getColonia($colonia){
       echo "<select name='direccion[co_id]' id='co_id' >";
			
				for($i = 1;$i <= $colonia ;$i++){
					echo "<option value='$i'>$i</option>";
				}
			
		echo 	'</select>';
    }
}
?>
