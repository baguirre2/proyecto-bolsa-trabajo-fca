<?php
/**
* Autor: Eduardo García Solis
*/
class FormularioInfoLaboral {

    function __construct($infoLab = NULL) {
        ?>
        <h1><?echo ( $infoLab == NULL ? "Registrar" : "Modificar" )?> Información Laboral</h1>
        <form id="frmRegis">
            <table>
                <tbody>
                    <tr>
                        <td>Empresa*</td>
                        <td><input type="text" class="required" name="nomEmp" value="<?echo ( $infoLab == NULL ? "" : $infoLab['inla_empresa'] )?>" placeholder="Nombre"/></td>
                    </tr>
                    <tr>
                        <td>Puesto*</td>
                        <td><input type="text" name="puesto" class="required" value="<?echo ( $infoLab == NULL ? "" : $infoLab['inla_puesto'] )?>" placeholder="Puesto"/></td>
                    </tr>
                    <tr>
                        <td>Jefe</td>
                        <td><input type="text" name="jefe" value="<?echo ( $infoLab == NULL ? "" : $infoLab['inla_jefe_inmediato'] )?>" placeholder="Jefe"/></td>
                    </tr>
                    <tr>
                        <td>Actividades*</td>
                        <td><input type="text" name="descAct" class="required" value="<?echo ( $infoLab == NULL ? "" : $infoLab['inla_descripcion_actividades'] )?>" placeholder="Actividades"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><textarea name="logros"><?echo ( $infoLab == NULL ? "Logros" : $infoLab['inla_logros'] )?></textarea></td>
                    </tr>
                    <tr>
                        <td>Meses*</td>
                        <td><input class="required numeric" type="number" name="anios" value="<?echo ( $infoLab == NULL ? "" : $infoLab['inla_anios_estancia'] )?>" placeholder="Meses"/></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="button" value="<?echo ( $infoLab == NULL ? "Registrar" : "Modificar" )?>" onclick="ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', '<?echo ( $infoLab == NULL ? "inLabRegistrar" : "inLabModificar" )?>', 'frmRegis', 'contenido', <?echo ( $infoLab == NULL ? "0" : $infoLab['inla_id'] )?>)"/></td>
                        <td><input type="button" value="Cancelar" onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'inLabListar', 'vacio', 'contenido')"></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <?php
    }
}
?>