<?php
/**
 * @author lalo
 */
class MostrarCurso {
    
    public function __construct($curso) {
        
        ?>
<form id="frmCons">
    <input type="hidden" name="tipo" id="tipo" value="curs"/>
        <table>
            <thead>
                <tr>
                    <th colspan="2">Datos del Curso</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nombre: </td>
                    <td><? echo ($curso['cu_nombre']) ?></td>
                </tr>
                <tr>
                    <td>Fecha de Conclusión: </td>
                    <td><? echo ($curso['cu_fecha_conclusion']) ?></td>
                </tr>
                <tr>
                    <td colspan="2"><img src="constancias/cursos/<? echo ($curso['cu_ruta_constancia']) ?>" width="550"/></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="button" value="Regresar" onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'valiConst', 'vacio', 'contenido')"/>
                        <input type="button" value="Rechazar" onclick="ajaxConId('', 'valEstaRechazar', 'frmCons', 'contenido', <? echo ($curso['cu_id']) ?>)"/>
                        <input type="button" value="Validar" onclick="ajaxConId('', 'valEstaValidar', 'frmCons', 'contenido', <? echo ($curso['cu_id']) ?>)"/>
                    </td>
                </tr>
            </tbody>
        </table>
</form>
        <?
    }
}
?>