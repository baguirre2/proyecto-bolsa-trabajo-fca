<?php

/**
 * @author lalo
 * Muestra la lista de todas las constancias, pendientes de validar
 */
class ListaConstancias {

    public function __construct($listCerts, $listInfoAca, $listIdio, $listCurs) {
        ?>
        
        <? if ($listCerts != FALSE) {
        ?>
<div class=\"inner-heading\">
						   <div class=\"container\">
						       <div class=\"row\">
						           <div class=\"span12\">
						               <h1 class=\"animated fadeInDown delay1\">Constancias</h1>
						           </div>
						       </div>
						   </div>
						</div>
<form id="frmCert" name="frmCert">
    <input type="hidden" name="tipo" id="tipo" value="cert"/>
        <table class="tablas_sort">
            <thead>
                <tr>
                    <th colspan="4">Constancias de Certificaciones</th>
                </tr>
                <tr>
                    <th>Alumno</th>
                    <th>Certificación</th>
                    <th>Empresa</th>
                    <th>Opción</th>
                </tr>
            </thead>
            <tbody>
                <?                        
                foreach ($listCerts as $row) {
                    echo "<tr>
                            <td>$row[pe_nombre] $row[pe_apellido_paterno] $row[pe_apellido_materno]</td>
                            <td>$row[ce_nombre]</td>
                            <td>$row[ce_empresa]</td>
                            <td><input type='button' value='Ver' onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'valiEstMostrar', 'frmCert', 'contenido', $row[ce_id])\"/></td>
                        </tr>";
                }
                ?>
            </tbody>
        </table></form><br>
        <? }
        ?>

        <? if ($listInfoAca != FALSE) {
        ?>
<form id="frmInfoLab" name="frmInfoLab">
    <input type="hidden" name="tipo" id="tipo" value="infoLab"/>
        <table class="tablas_sort">
            <thead>
                <tr>
                    <th colspan="4">Constancias de Información Académica</th>
                </tr>
                <tr>
                    <th>Alumno</th>
                    <th>Certificación</th>
                    <th>Empresa</th>
                    <th>Opción</th>
                </tr>
            </thead>
            <tbody>
                <?                        
                foreach ($listInfoAca as $row) {
                    echo "<tr>
                            <td>$row[pe_nombre] $row[pe_apellido_paterno] $row[pe_apellido_materno]</td>
                            <td>$row[inac_universidad]</td>
                            <td>$row[inac_escuela]</td>
                            <td><input type='button' value='Ver' onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'valiEstMostrar', 'frmInfoLab', 'contenido', $row[inac_id])\"/></td>
                        </tr>";
                }
                ?>
            </tbody>
        </table></form><br>
        <? }
        ?>

        <? if ($listCurs != FALSE) {
        ?>
<form id="frmCurs" name="frmCurs">
    <input type="hidden" name="tipo" id="tipo" value="curs"/>
        <table class="tablas_sort">
            <thead>
                <tr>
                    <th colspan="3">Constancias de Cursos</th>
                </tr>
                <tr>
                    <th>Alumno</th>
                    <th>Nombre del Curso</th>
                    <th>Opción</th>
                </tr>
            </thead>
            <tbody>
                <?                        
                foreach ($listCurs as $row) {
                    echo "<tr>
                            <td>$row[pe_nombre] $row[pe_apellido_paterno] $row[pe_apellido_materno]</td>
                            <td>$row[cu_nombre]</td>
                            <td><input type='button' value='Ver' onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'valiEstMostrar', 'frmCurs', 'contenido', $row[cu_id])\"/></td>
                        </tr>";
                }
                ?>
            </tbody>
        </table></form><br>
        <? }
        ?>
        
        <? if ($listIdio != FALSE) {
        ?>
<form id="frmIdio" name="frmIdio">
    <input type="hidden" name="tipo" id="tipo" value="idio"/>
        <table class="tablas_sort">
            <thead>
                <tr>
                    <th colspan="6">Constancias de Idiomas</th>
                </tr>
                <tr>
                    <th>Alumno</th>
                    <th>Idioma</th>
                    <th>Oral</th>
                    <th>Escrito</th>
                    <th>Lectura</th>
                    <th>Opción</th>
                </tr>
            </thead>
            <tbody>
                <?                        
                foreach ($listIdio as $row) {
                    echo "<tr>
                            <td>$row[pe_nombre] $row[pe_apellido_paterno] $row[pe_apellido_materno]</td>
                            <td>$row[id_nombre]</td>
                            <td>$row[niid_nivel_oral]</td>
                            <td>$row[niid_nivel_escrito]</td>
                            <td>$row[niid_nivel_lectura]</td>
                            <td><input type='button' value='Ver' onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'valiEstMostrar', 'frmIdio', 'contenido', $row[idal_id])\"/></td>
                        </tr>";
                }
                ?>
            </tbody>
        </table></form>
        <? }
        ?>
        
        <?
    }
}
?>