<?php

class DivEstudio{
    
    function getEstudio($arr_datos){
        echo "<select name='perfil[esfc_id]' id='esfc_id' class='required' onchange='obtenerSemestre();return false;'>";
			
				foreach($arr_datos as $clave => $valor){
					echo "<option value='$clave'>$valor</option>";
				}
			
		echo 	'</select>';
    }
    
    function getSemestres($semestres){
       echo "<select name='perfil[peas_semestre]' id='peas_semestre' class='numeric' >";
			
				for($i = 1;$i <= $semestres ;$i++){
					echo "<option value='$i'>$i</option>";
				}
			
		echo 	'</select>';
    }
}
?>
