<?php
class FrmMiDireccion{
    
    function __construct($catalogos,$datos_dir, $alumno_id){
?>
<form id="frmMiDireccion">
    <input type="hidden" value="<?php echo $datos_dir['do_id'];?>" name="do_id" id="do_id" /><!-- Opci�n del Controller -->
    <input type="hidden" value="<?php echo $alumno_id ?>" name="id" id="id" /><!-- ID del alumno-->

        <table>
            <tr>
                <th>Actualizar mi direcci&oacuten</th>
            </tr>
            <tr>
                <td>C.P.</td>
                <td><input type="text" name="co_codigo_postal" id="co_codigo_postal" value="<?php echo $datos_dir['co_codigo_postal']?>" class="required" maxlength="5" onchange="obtenerDatosCp()"/></td>
            </tr>
            <tr>
                <td>Calle</td>
                <td><input type="text" name="do_calle" id="do_calle" value="<?php echo $datos_dir['do_calle']?>" class="required" /></td>
            </tr>
            <tr>
                <td>N&uacutemero Ext.:</td>
                <td><input type="text" name="do_num_exterior" id="do_num_exterior" value="<?php echo $datos_dir['do_num_exterior']?>" class="required"/></td>
            </tr>
            <tr>
                <td>N&uacutemero Int.:</td>
                <td><input type="text" name="do_num_interior" id="do_num_interior" value="<?php echo $datos_dir['do_num_interior']?>"/></td>
            </tr>
        </table>
        
        <table class="tab_form" id="datos_cp">
	        <tr>
                <td>Entidad Federativa:</td>
                <td><input type="text" name="es_nombre" id="direccion[es_nombre]" value="<?php echo $datos_dir['es_nombre']; ?>" readonly />
                	<input type="hidden" name="es_id" id="es_id" value="<?php echo $datos_dir['es_id']?>" />
                </td>
            </tr>
            <tr>
                <td>Delegaci&oacuten/Municipio:</td>
                <td><input type="text" name="demu_nombre" id="demu_nombre" value="<?php echo $datos_dir['demu_nombre'];?>" readonly />
                	<input type="hidden" name="demu_id" id="demu_id" value="<?php echo $datos_dir['demu_id']?>" />
                </td>
            </tr>
            <tr>
                <td>Colonia:</td>
                <td><select name="co_id" id="co_id">
                        <?php
                            foreach($catalogos['colonias'] as $clave=> $valor ){
                                if($datos_dir['co_id'] == $valor['co_id']){
                                    echo "<option value='".$valor['co_id']."' selected>".$valor['co_nombre']."</option>\n";
                                }else{
                                    echo "<option value='".$valor['co_id']."'>".$valor['co_nombre']."</option>\n";
                                }
                            }
                        ?>
                    </select>
                </td>
            </tr>
            
        </table>
        
        <table>
            <tr>
                <td><input type="button" value="Registrar" onclick="ajax('./controllers/gestionarAlumno/CtlAlumno.php','actMiDireccion','frmMiDireccion','contenido');"/></td>
                <td><input type="button" value="Regresar" onclick="ajax('./controllers/gestionarAlumno/CtlAlumno.php','actAlumno','vacio','contenido');"/></td>
            </tr>
        </table>

</form>
<script src="./webroot/js/frmMiDirAlumno.js"></script>
<?php   
    }
}
?>