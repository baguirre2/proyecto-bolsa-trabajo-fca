<?php
/*
 * @author: Alejandro Vargas
 * @date: 25/06/2013
 */
class FrmInscribirGrupo{ 
    
    function __construct($datos,$campos) {
        

?> 

<div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Inscripción <span>grupos de taller.</span></h1> <!--El span sirve para colocar una palabra a resaltar en negritas--> 
	                <p class="animated fadeInDown delay2">Grupos de taller disponibles.</p>
	            </div>
	        </div>
	    </div>
	</div>
 <table class="tablas_sort">
        <form id="formConsultar" action="#">
            <!-- <pre>
            <?php 
                //var_dump($datos); 
            ?>
            </pre> -->
            
            
            
            <thead>
		
                <th>Grupo</th>
                <th>Taller</th>
                <th>Exponente</th>
                <th>Fecha de inicio</th>
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
<div id="mensajes"></div>



<?php
    }
static function crearFilasTabla($campos = NULL, $datos_tabla = NULL){
	if($datos_tabla == NULL){
            echo "<th>No hay grupos disponibles</th>";
        }else{
		
		foreach($datos_tabla as $fila){
			echo '<tr>'; 
				/*echo 	"<input type='hidden' id='opc' value='3'>";
				echo	"<input type='hidden' id='gr_id' value=".$fila['gr_id']."/>";
            	echo	"<input type='hidden' id='al_id' value=".$fila['al_id']." />";*/
				echo "<td>".$fila['gr_nombre']."</td>";
				echo "<td>". $fila['ta_nombre']."</td>";
				echo "<td>".$fila['pe_nombre'].' '.$fila['pe_apellido_materno'].' '.$fila['pe_apellido_paterno']."</td>";
				echo "<td>".$fila['gr_fecha_inicio']."</td>";
				echo "<td>".$fila['ho_hora_inicio'].' - '.$fila['ho_hora_fin']."</td>";
                                echo "<td><input type='button' id=".$fila['gr_nombre']." class='btnAltaGrupo' value ='Inscribir' name=".$fila['gr_id']." /></td>";
			echo '</tr>';
	
                }	       
            return $cadenaFilas;
	}
      }
}
?>	
<script>

$('.btnAltaGrupo').bind('click',function(){
            var grup_id = $(this).attr("name");
            var grup_name = $(this).attr("id");
		
		
		/*Serialize toma todos los datos del formulario**/
			$.get('controllers/gestionarInscripcionAGrupo/CtlInsGrupo.php',{'opc':3,'gr_id':grup_id,'al_id':1},function(data){
				/**Data es el string que nos manda de respuesta el metodo**/
					console.log(data+"hola");
					$('#mensajes').empty();
					$('#mensajes').text('Te has inscrito al grupo: '+ grup_name );
					$('#mensajes').dialog("open");
					ajax('controllers/gestionarInscripcionAGrupo/CtlInsGrupo.php',1,'vacio','contenido');
			});
	});	
$(document).ready(function(){
	$('#mensajes').dialog({
			autoOpen: false,
			modal: true});
        

	
});	
</script>

<?php 

?>





