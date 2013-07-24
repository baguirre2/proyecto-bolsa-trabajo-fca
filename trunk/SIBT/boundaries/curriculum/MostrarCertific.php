<?php

include_once '../../entities/Alumno.php';

class MostrarCertific {
    
    public function __construct($certificado, $idAlumno) {
        
        $alumno = new Alumno();
        $alumno = $alumno->obtenerInfoPersonal($idAlumno);
        $alumno = $alumno[0];        
        
        ?>
<div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Constancia de certificación</h1>
	                <p class="animated fadeInDown delay2"></p>
	            </div>
	        </div>
	    </div>
</div>
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
                    <td>Nombre: <? echo ($alumno['pe_nombre']." ".$alumno['pe_apellido_paterno']." ".$alumno['pe_apellido_materno']) ?></td>
                </tr>
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
                    <td colspan="2"><img src="constancias/certs/<? echo ($certificado['ce_ruta_constancia']) ?>" width="550"/></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="button" value="Regresar" onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'valiConst', 'vacio', 'contenido')"/>
                        <input type="button" value="Rechazar" onclick="ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'valEstaRechazar', 'frmCons', 'contenido', <? echo ($certificado['ce_id']) ?>)"/>
                        <input type="button" value="Validar" onclick="ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'valEstaValidar', 'frmCons', 'contenido', <? echo ($certificado['ce_id']) ?>)"/>
                    </td>
                </tr>
            </tbody>
        </table>
</form>
        <?
    }
}

?>