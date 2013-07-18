<?php
class frmResultadoAlumnos{
	function __construct($datos_alumnos){

    if($datos_alumnos == false){
    	echo"<tr><td><h1>No se encontraron registro que coincidan con los datos</h1></td></tr>";
    }else{		
?>
<table class="table_sort">
	<thead>
		<tr>
        <th>No. de Cuenta</th>
        <th>Apellido Paterno</th>
        <th>Apellido Materno</th>
		<th>Nombre</th>
		<th>Carrera</th>
		<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
    
<?php 
	foreach($datos_alumnos AS $alumno){
			echo 	"		<tr>\n"
					."			<td>".$alumno['al_num_cuenta']."</td>\n"
					."			<td>".$alumno['pe_apellido_paterno']."</td>\n"
					."			<td>".$alumno['pe_apellido_materno']."</td>\n"
					."			<td>".$alumno['pe_nombre']."</td>\n"
					."			<td>".$alumno['']."</td>\n"
					."			<td>ACCIONES</td>\n"
					."		</tr>\n";
        }
    }
	?>			
	</tbody>
</table>
	
<?php
	}
}
?>