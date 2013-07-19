<?php

class FrmConsultarGrupo{ 
    
    function __construct($datos=NULL,$campos=NULL) {
?> 
<div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Lista de <span>Grupos.</span></h1> <!--El span sirve para colocar una palabra a resaltar en negritas--> 
	                <p class="animated fadeInDown delay2">Grupos actualmente disponibles.</p>
	            </div>
	        </div>
	    </div>
</div>
<div id="resFrmConsultarGrupo">
    <table class="tablas_sort">
        <form id="formConsultar">
        <input type="hidden" name="opc" value="5"/>  <!-- La opcion del controlador a la que se va a llamar  -->
            <!--  <pre>z
            <?php 
                var_dump($datos);
            ?>
            </pre>-->
            <thead>
          	<th>ID</th>
                <th>Grupo</th>
                <th>Taller</th>
                <th>Exponente</th>
                <th>Lugar</th>
                <th>Fecha de inicio</th>
                <th>Fecha de fin</th>
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



<?php
    }
static function crearFilasTabla($campos = NULL, $datos_tabla = NULL){
		
		foreach($datos_tabla as $fila){
			$dato=$fila['gr_id'];
			echo '<tr>';
				echo "<td>".$fila['gr_id']."</td>";
				echo "<td>".$fila['gr_nombre']."</td>";
				echo "<td>".$fila['ta_nombre']."</td>";
				echo "<td>".$fila['pe_nombre']."</td>";
				echo "<td>".$fila['au_lugar']."</td>";			
				echo "<td>".$fila['gr_fecha_inicio']."</td>";
				echo "<td>".$fila['gr_fecha_fin']."</td>";
				echo "<td><input type='button' id='btnBajaGrupo'      class='btnBajaGrupo'      value ='Eliminar'   name=".$fila['gr_id']."></input>";
				//echo "<td><input type='button' id='btnModificarGrupo'  class='btnModificarGrupo' value ='Modificar'  name=".$fila['gr_id']."></input></td>";
				echo "<a href='#' id='btnModificarGrupo' class='btnModificarGrupo' name=".$fila['gr_id']."><i class='fontawesome-icon button circle-button green icon-edit'></i></a></td>";
				//echo "<td><a href='#' id='btnBajaGrupo' class='btnBajaGrupo' name=".$fila['gr_id']."><img src='webroot/images/icono_modificar.gif'/></a></td>";
                //echo '<td><input type="button" value ="Modificar" onclick="ajax(\'controllers/gestionarGrupo/CtlGrupo.php\', 5,\'vacio\',\'contenido\')"</input></td>';
			echo '</tr>';
		   
        }	       
       // return $cadenaFilas;
	}
}
?>

<script>

$(document).ready(function(){
	$('#mensajes').dialog({
		autoOpen: false,
		modal: true});
	
	$('.btnBajaGrupo').click(function(){
            var grup_id = $(this).attr("name");
            //alert(grup_id);
		/*Serialize toma todos los datos del formulario**/		
			
			$.get('controllers/gestionarGrupo/CtlGrupo.php',{'opc':4,'gr_id':grup_id},function(data){
				/**Data es el string que nos manda de respuesta el metodo**/
					//$('#mensajes').text('El grupo ha sido eliminado correctamente');
					$('#mensajes').empty();
					$('#mensajes').append(data);
                                        $('#mensajes').dialog("open");
					//actualizamos los datos mostrados
					ajax('controllers/gestionarGrupo/CtlGrupo.php', 3, 'vacio', 'contenido');
					
			});
	});
        
        //METODO PARA EVENTO DE ACTUALIZAR GRUPO
        $('.btnModificarGrupo').click(function(){
            var grup_id = $(this).attr("name");
            //alert(grup_id);
            
		/*Serialize toma todos los datos del formulario**/
		
					/*ajax('controllers/gestionarGrupo/CtlGrupo.php',5,39,'contenido');
					console.log("hola");*/
					
		$.get('controllers/gestionarGrupo/CtlGrupo.php',{'opc':5,'gr_id':grup_id},function(data){			
			$('#mensajes').empty();
                        $('#mensajes').append(data);
			$('#mensajes').dialog("open");		
					//actualizamos los datos mostrados
					//ajax('controllers/gestionarGrupo/CtlGrupo.php', 5, 'grup_id',"contenido");				
			});//fin get
	});	
	
});	


	
</script>

<?php 
    

?>


