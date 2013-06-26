<?php

/**
 * @author lalo
 * Muestra la lista de todas las constancias, pendientes de validar
 */
class ListaConstancias {

    public function __construct($listCerts, $listInfoAca, $listIdio, $listCurs) {
        ?>
        
        <? if (count($listCerts) != 0) {
        ?>
        <table>
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
                            <td><input type='button' value='Ver' onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'valiEstCerti', 'vacio', 'contenido', $row[ce_id])\"/></td>
                        </tr>";
                }
                ?>
            </tbody>
        </table><br>
        <? }
        ?>

        <? if (count($listInfoAca) != 0) {
        ?>
        <table>
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
                            <td><input type='button' value='Ver' onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'valiEstCerti', 'vacio', 'contenido', $row[inac_id])\"/></td>
                        </tr>";
                }
                ?>
            </tbody>
        </table><br>
        <? }
        ?>

        <? if (count($listCurs) != 0) {
        ?>
        <table>
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
                            <td><input type='button' value='Ver' onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'valiEstCerti', 'vacio', 'contenido', $row[cu_id])\"/></td>
                        </tr>";
                }
                ?>
            </tbody>
        </table><br>
        <? }
        ?>
        
        <? if (count($listIdio) != 0) {
        ?>
        <table>
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
                            <td>$row[id_nivel_oral]</td>
                            <td>$row[id_nivel_escrito]</td>
                            <td>$row[id_nivel_lectura]</td>
                            <td><input type='button' value='Ver' onclick=\"ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'valiEstCerti', 'vacio', 'contenido', $row[idal_id])\"/></td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
        <? }
        ?>
        
        <?
    }
}
?>