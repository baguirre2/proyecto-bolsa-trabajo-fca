<?php
/**
 * Autor: Eduardo García Solis
 */
class ListaInfoLaboral {

    function __construct($lista, $mensaje = NULL) {
        
        echo ( $mensaje == NULL ? "" : "<div class=\"inner-heading\">
						   <div class=\"container\">
						       <div class=\"row\">
						           <div class=\"span12\">
						               <h1 class=\"animated fadeInDown delay1\">$mensaje</h1>
						           </div>
						       </div>
						   </div>
						</div>" );
        
        ?>
<div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Mi Información Laboral</h1>
	                <p class="animated fadeInDown delay2"></p>
	            </div>
	        </div>
	    </div>
</div>
<input type="button" value="Agregar Información Laboral" onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'inLabFrmRegistrar', 'vacio', 'contenido')" />        
<table class="tablas_sort">
            <thead>
                <th>Empresa</th>
                <th>Puesto</th>
                <th>Meses</th>
                <th>Opciones</th>
            </thead>
            <tbody>
            <?php
            foreach ($lista as $row) {
                echo "<tr>";

                echo "<td>$row[inla_empresa]</td>";
                echo "<td>$row[inla_puesto]</td>";
                echo "<td>$row[inla_anios_estancia]</td>";

                //Ponemos un boton que aparte de la URL, la opción, el form y el DIV, envía el ID de la infoLaboral que se quiere editar
                    //Adicionalmente ponemos el DIV donde se mostraran los datos de la infoLaboral para que puedan ser en futuro modificados 
                //Muestra en todo el contenido los datos para modificar
                echo "<td><a href=\"#\">
<i onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'inLabFrmEditar', 'vacio', 'contenido', $row[inla_id])\" class=\"fontawesome-icon button circle-button green icon-edit\">
</i>
</a> </td>";
                
                /*Muestra en la misma lista los datos para modificar
                echo "<td><input type=\"button\" value=\"Editar\" onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'inLabFrmEditar', 'vacio', 'infoLab$row[inla_id]', $row[inla_id])\" /></td></tr>
                <tr><td colspan='3'>
                    <div id='infoLab$row[inla_id]'></div>
                </td></tr>";*/

                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
        <?php
    }
}
?>