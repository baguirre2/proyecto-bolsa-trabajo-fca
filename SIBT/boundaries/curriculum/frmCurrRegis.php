<div id="resFrmRegis"></div>
<form id="frmRegis">
    <?php
    $id_infoAcademica = $_GET['id_infoAca'];
    echo $id_infoAcademica;

    $registro = "";

    $infoAc_id = $resultados[0]['inac_id'];
    $universidad = $resultados[0]['inac_universidad'];
    $escuela = $resultados[0]['inac_escuela'];
    $promedio = $resultados[0]['inac_promedio'];
    $fecha_inicio = $resultados[0]['inac_fecha_inicio'];
    $fecha_termino = $resultados[0]['inac_fecha_termino'];
    ?>
    <table>
        <tbody>
            <tr>
                <td>Nivel educativo: </td>
                <td><input name="btnNivel" type="radio" value="Licenciatura" onchange="ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'llenarListaEstudios', 'vacio', 'listaNombres', 1)" />Licenciatura</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input name="btnNivel" type="radio" value="Especializacion" onchange="ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'llenarListaEstudios', 'vacio', 'listaNombres', 2)"/>Especializaci&oacute;n</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input name="btnNivel" type="radio" value="Maestria" onchange="ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'llenarListaEstudios', 'vacio', 'listaNombres', 3)" />Maestr&iacute;a</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input name="btnNivel" type="radio" value="Doctorado" onchange="ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'llenarListaEstudios', 'vacio', 'listaNombres', 4)" />Doctorado</td>
            </tr>
            <!-- <tr>
                    <td >Nombre del t&iacute;tulo o grado: </td>
                    <td ><input name="txtNombreGrado" type="text" id="txtNombreGrado" value=""/> </td>
            </tr> -->
            <tr>
                <td>Nombre del t&iacute;tulo o grado:</td>
                <td>

                    <div id="listaNombres">				
                        <?php
                        /* $resultados = $this->listarEstudiosFCA();						
                          for ($i=0; $i <= count($resultados)-1; $i++) {
                          echo "<option value=\"";
                          echo $resultados[$i]['esfc_descripcion'];
                          echo "\">";
                          echo $resultados[$i]['esfc_descripcion'];
                          echo "</option>";
                          } */
                        ?>  
                    </div>  				
                </td>

            </tr>
            <tr>
                <td>Universidad:</td>
                <td><input name="txtUniversidad" type="text" id="txtUniversidad" value="<?php echo $universidad; ?>" /> </td>
            </tr>
            <tr>
                <td>Escuela:</td>
                <td><input name="txtEscuela" type="text" id="txtEscuela" value="<?php echo $escuela; ?>" /> </td>
            </tr>			
            <tr>
                <td>Fecha de inicio (aaaa-mm-dd): </td>
                <td><input name="txtFechaInicio" type="text" id="txtFechaInicio" value="<?php echo $fecha_inicio; ?>"/></td>
            </tr>
            <tr>
                <td>Fecha de t&eacute;rmino (aaaa-mm-dd): </td>
                <td><input name="txtFechaTermino" type="text" id="txtFechaTermino" value="<?php echo $fecha_termino; ?>"/></td>
            </tr>			
            <tr>
                <td>Estado:</td>
                <td><select name="lstEstado">
                        <option value="En curso">En curso</option>
                        <option value="Truncado">Trunco</option>
                        <option value="Terminado">Terminado</option>
                        <option value="Titulado">Titulado</option>
                        <option value="Graduado">Graduado</option>
                    </select></td>
            </tr> 
            <tr>
                <td>Promedio: </td>
                <td><input name="txtPromedio" type="text" id="txtPromedio" value="<?php echo $promedio; ?>"/></td>
            </tr>
            <tr>
                <td> <?php
                        $accion = ($id_infoAcademica != 0) ? "actualizar" : "registrar";
                        //echo $accion;
                        ?>
                <td><input name="btnAccion" type="button" value="<?php echo $accion; ?>" onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', '<?php echo $accion; ?>', 'frmRegis', 'resFrmRegis')"/></td>
                <td><input name="btnCancelar" type="submit" id="btnCancelar" value="Cancelar" onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'infoAcademica', 'vacio', 'contenido')"/></td>
            </tr>
        </tbody>
    </table>


    <!--
    <table>
    <tbody>
        <tr>
            <td>Nombre Alumno: </td>
            <td><input type="text" name="nomAlum" value="" placeholder="Nombre"/></td>
        </tr>
        <tr>
            <td>Dirección</td>
            <td><input type="text" name="dirAlum" value="" placeholder="Dirección"/></td>
        </tr>
        <tr>
            <td>Telefono</td>
            <td><input type="text" name="telAlum" value="" placeholder="Telefono"/></td>
        </tr>
        <tr>
            <td colspan="2"><input type="button" value="Registrar" onclick="ajax('controllers/gestionarCurriculum/CtlCurric.php', 'registrar', 'frmRegis', 'resFrmRegis')"/></td>
        </tr>
    </tbody>
</table>
    -->
</form>