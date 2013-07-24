<?php

include_once '../../entities/Alumno.php';

class MostrarInfoAcademica {
    
    public function __construct($infoAcademica, $idAlumno) {
                
        $alumno = new Alumno();
        $alumno = $alumno->obtenerInfoPersonal($idAlumno);
        $alumno = $alumno[0];
        ?>
<div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Constancia de información académica</h1>
	                <p class="animated fadeInDown delay2"></p>
	            </div>
	        </div>
	    </div>
</div>
<form id="frmCons">
    <input type="hidden" name="tipo" id="tipo" value="infoLab"/>
        <table>
            <thead>
                <tr>
                    <th colspan="2">Datos de la información académica</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nombre: <? echo ($alumno['pe_nombre']." ".$alumno['pe_apellido_paterno']." ".$alumno['pe_apellido_materno']) ?></td>
                </tr>
                <tr>
                    <td>Universidad: </td>
                    <td><? echo ($infoAcademica['inac_universidad']) ?></td>
                </tr>
                <tr>
                    <td>Escuela: </td>
                    <td><? echo ($infoAcademica['inac_escuela']) ?></td>
                </tr>
                <tr>
                    <td>Promedio: </td>
                    <td><? echo ($infoAcademica['inac_promedio']) ?></td>
                </tr>
                <tr>
                    <td colspan="2"><img src="constancias/titulos_grados/<? echo ($infoAcademica['inac_ruta_constancia']) ?>" width="550"/></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="button" value="Regresar" onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'valiConst', 'vacio', 'contenido')"/>
                        <input type="button" value="Rechazar" onclick="ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'valEstaRechazar', 'frmCons', 'contenido', <? echo ($infoLab['inac_id']) ?>)"/>
                        <input type="button" value="Validar" onclick="ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'valEstaValidar', 'frmCons', 'contenido', <? echo ($infoLab['inac_id']) ?>)"/>
                    </td>
                </tr>
            </tbody>
        </table>
</form>
        <?
    }
}

?>