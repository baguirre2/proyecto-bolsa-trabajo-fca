<?php

class MostrarInfoAcademica {
    
    public function __construct($infoAcademica) {
        
        ?>
<form id="frmCons">
    <input type="hidden" name="tipo" id="tipo" value="cert"/>
        <table>
            <thead>
                <tr>
                    <th colspan="2">Datos de la información académica</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Universidad: </td>
                    <td><? echo ($infoAcademica['ce_nombre']) ?></td>
                </tr>
                <tr>
                    <td>Escuela: </td>
                    <td><? echo ($infoAcademica['ce_empresa']) ?></td>
                </tr>
                <? if ($infoAcademica['ce_descripcion'] != "") {
                    echo "<tr>
                        <td>Descripción: </td> 
                        <td>$infoAcademica[ce_descripcion]</td>
                    </tr>";
                }
                ?>
                <tr>
                    <td>Duración: </td>
                    <td><? echo ($infoAcademica['ce_duracion']) ?></td>
                </tr>
                <tr>
                    <td>Año de Certificación: </td>
                    <td><? echo ($infoAcademica['ce_anio']) ?></td>
                </tr>
                <tr>
                    <td colspan="2"><img src="constancias/certs/cert<? echo ($infoAcademica['ce_ruta_constancia']) ?>" width="550"/></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="button" value="Regresar" onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'valiConst', 'vacio', 'contenido')"/>
                        <input type="button" value="Rechazar" onclick="ajaxConId('', 'valEstaRechazar', 'frmCons', 'contenido', <? echo ($infoAcademica['ce_id']) ?>)"/>
                        <input type="button" value="Validar" onclick="ajaxConId('', 'valEstaValidar', 'frmCons', 'contenido', <? echo ($infoAcademica['ce_id']) ?>)"/>
                    </td>
                </tr>
            </tbody>
        </table>
</form>
        <?
    }
}

?>