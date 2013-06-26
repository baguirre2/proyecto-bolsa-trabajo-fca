<?php

class MostrarCertific {
    
    public function __construct($certificado) {
        
        ?>
<form id="frmCons">
    <input type="hidden" name="tipo" id="tipo" value="cert"/>
        <table>
            <thead>
                <tr>
                    <th colspan="2">Datos de la Certificación</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nombre de la certificación: </td>
                    <td><? echo ($certificado['ce_nombre']) ?></td>
                </tr>
                <tr>
                    <td>Empresa/Institución: </td>
                    <td><? echo ($certificado['ce_empresa']) ?></td>
                </tr>
                <? if ($certificado['ce_descripcion'] != "") {
                    echo "<tr>
                        <td>Descripción: </td> 
                        <td>$certificado[ce_descripcion]</td>
                    </tr>";
                }
                ?>
                <tr>
                    <td>Duración: </td>
                    <td><? echo ($certificado['ce_duracion']) ?></td>
                </tr>
                <tr>
                    <td>Año de Certificación: </td>
                    <td><? echo ($certificado['ce_anio']) ?></td>
                </tr>
                <tr>
                    <td colspan="2"><img src="constancias/certs/cert<? echo ($certificado['ce_ruta_constancia']) ?>" width="550"/></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="button" value="Regresar" onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'valiConst', 'vacio', 'contenido')"/>
                        <input type="button" value="Rechazar" onclick="ajaxConId('', 'valEstaRechazar', 'frmCons', 'contenido', <? echo ($certificado['ce_id']) ?>)"/>
                        <input type="button" value="Validar" onclick="ajaxConId('', 'valEstaValidar', 'frmCons', 'contenido', <? echo ($certificado['ce_id']) ?>)"/>
                    </td>
                </tr>
            </tbody>
        </table>
</form>
        <?
    }
}

?>