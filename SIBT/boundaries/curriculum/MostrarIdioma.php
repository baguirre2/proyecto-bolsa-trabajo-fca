<?php

class MostrarIdioma {

    public function __construct($idioma) {
        
        ?>
<form id="frmCons">
    <input type="hidden" name="tipo" id="tipo" value="idio"/>
        <table>
            <thead>
                <tr>
                    <th colspan="2">Datos del Idioma</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Idioma: </td>
                    <td><? echo ($idioma['id_nombre']) ?></td>
                </tr>
                <tr>
                    <td>Institución: </td>
                    <td><? echo ($idioma['idal_institucion']) ?></td>
                </tr>
                <tr>
                    <td>Año: </td>
                    <td><? echo ($idioma['idal_anio']) ?></td>
                </tr>
                    <thead>
                    <tr>
                        <th colspan="2">Niveles</th>
                    </tr>
                </thead>
                <tr>
                    <td >Oral: </td>
                    <td ><? echo ($idioma['niid_nivel_oral']) ?></td>
                </tr>
                <tr>
                    <td >Escrito: </td>
                    <td ><? echo ($idioma['niid_nivel_escrito']) ?></td>
                </tr>
                <tr>
                    <td >Lectura: </td>
                    <td ><? echo ($idioma['niid_nivel_lectura']) ?></td>
                </tr>
                <tr>
                    <td colspan="2"><img src="constancias/idiomas/<? echo ($idioma['idal_ruta_constancia']) ?>" width="550"/></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="button" value="Regresar" onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'valiConst', 'vacio', 'contenido')"/>
                        <input type="button" value="Rechazar" onclick="ajaxConId('', 'valEstaRechazar', 'frmCons', 'contenido', <? echo ($idioma['idal_id']) ?>)"/>
                        <input type="button" value="Validar" onclick="ajaxConId('', 'valEstaValidar', 'frmCons', 'contenido', <? echo ($idioma['idal_id']) ?>)"/>
                    </td>
                </tr>
            </tbody>
        </table>
</form>
        <?
    }
}

?>