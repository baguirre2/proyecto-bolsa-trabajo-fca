<?php
/**
 * Autor: Eduardo García Solis
 */
class ListaInfoLaboral {

    function __construct($lista, $mensaje = NULL) {
        
        echo ( $mensaje == NULL ? "" : "<h1>$mensaje</h1>" );
        
        ?>
<div class=\"inner-heading\">
						   <div class=\"container\">
						       <div class=\"row\">
						           <div class=\"span12\">
						               <h1 class=\"animated fadeInDown delay1\">Mi información Laboral</h1>
						           </div>
						       </div>
						   </div>
						</div>
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
                echo "<td><input type=\"button\" value=\"Editar\" onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'inLabFrmEditar', 'vacio', 'contenido', $row[inla_id])\" /></td>";
                
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
        <table>
            <tr>
                <td>
                    <td><input type="button" value="Agregar Información Laboral" onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'inLabFrmRegistrar', 'vacio', 'contenido')" /></td>
                </td>
                <td>
                    <!-- <td><input type="button" value="Regresar" onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 1, 'vacio', 'contenido')" /></td>-->
                </td>
            </tr>
</table>
        <?php
    }
}
?>