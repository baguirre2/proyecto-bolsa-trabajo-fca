<?php
/**
 * @author lalo
 */

include_once '../../entities/Alumno.php';

class MostrarCurso {
    
    public function __construct($curso, $idAlumno) {
        
        $alumno = new Alumno();
        $alumno = $alumno->obtenerInfoPersonal($idAlumno);
        $alumno = $alumno[0];        
        
        ?>
<div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Constancia de curso</h1>
	                <p class="animated fadeInDown delay2"></p>
	            </div>
	        </div>
	    </div>
</div>
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
                    <td>Nombre: <? echo ($alumno['pe_nombre']." ".$alumno['pe_apellido_paterno']." ".$alumno['pe_apellido_materno']) ?></td>
                </tr>
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
                        <input type="button" value="Rechazar" onclick="ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'valEstaRechazar', 'frmCons', 'contenido', <? echo ($curso['cu_id']) ?>)"/>
                        <input type="button" value="Validar" onclick="ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'valEstaValidar', 'frmCons', 'contenido', <? echo ($curso['cu_id']) ?>)"/>
                    </td>
                </tr>
            </tbody>
        </table>
</form>
        <?
    }
}
?>