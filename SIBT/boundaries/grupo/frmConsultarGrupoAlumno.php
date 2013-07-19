<?php
/*
 * @author: Alejandro Vargas
 * @date: 25/06/2013
 */
class FrmConsultarGrupoAlumno{ 
    
    function __construct($datos,$campos) {
        

?>
<div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Lista de <span>Talleres</span></h1> <!--El span sirve para colocar una palabra a resaltar en negritas--> 
	                <p class="animated fadeInDown delay2">Grupos en los que se está inscrito.</p>
	            </div>
	        </div>
	    </div>
</div>
<div id="resFrmConsultarGrupoAlumno">
    <table class="tablas_sort">
        <form id="formConsultar">
          
            
            
            <thead>
                <th>Grupo</th>
                <th>Taller</th>
                <th>Exponente</th>
                <th>Fecha de inicio</a></th>
                <th>Horario</th>
				<th>Acciones</th>
            </thead>
            
            
                <tbody>
                        <?php 
                                echo self::crearFilasTabla($campos, $datos);
                        ?>
                </tbody>
           
        </form>        
    </table>
</div>

<div id="mensajes"></div>

<?php
    }
static function crearFilasTabla($campos = NULL, $datos_tabla = NULL){
	if($datos_tabla == NULL){
            echo "<th>No est�s inscrito en ning�n grupo</th>";
        }else{
		
		foreach($datos_tabla as $fila){
			echo '<tr>';
				echo "<td>".$fila['gr_nombre']."</td>";
				echo "<td>". $fila['ta_nombre']."</td>";
				echo "<td>".$fila['pe_nombre'].' '.$fila['pe_apellido_materno'].' '.$fila['pe_apellido_paterno']."</td>";
				echo "<td>".$fila['gr_fecha_inicio']."</td>";
				echo "<td>".$fila['ho_hora_inicio'].' - '.$fila['ho_hora_fin']."</td>";
				echo "<td><input type='button' id=".$fila['gr_nombre']." class='btnBajaGrupo' value='Dar de baja' name=".$fila['gr_id']."></input></td>";
			echo '</tr>';
	
                }	       
                return $cadenaFilas;
	}
    }
}
?>

<script>
	$('.btnBajaGrupo').bind('click',function(){
            var grup_id = $(this).attr("name");
            var grup_nombre = $(this).attr("id");
		
		
		/*Serialize toma todos los datos del formulario**/
			$.get('controllers/gestionarInscripcionAGrupo/CtlInsGrupo.php',{'opc':4,'gr_id':grup_id,'al_id':1},function(data){
				/**Data es el string que nos manda de respuesta el metodo**/
					console.log(data+"hola");
					$('#mensajes').empty();
					$('#mensajes').text('Te has dado de baja del grupo: ' + grup_nombre);
					$('#mensajes').dialog("open");
                                        ajax('controllers/gestionarInscripcionAGrupo/CtlInsGrupo.php',2,'vacio','contenido');
					
			});
	});
$(document).ready(function(){
	$('#mensajes').dialog({
			autoOpen: false,
			modal: true});
        

	
});	

</script>