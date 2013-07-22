<?php
class FrmMiDireccion{
	
	function __construct($catalogos,$datos_dir){
?>
<form id="mi_direccion" action="#">
	<input type="hidden" value="" name="opc" />		<!-- Opción del Controller -->
	<input type="hidden" value="<?php echo $id_alumno ?>" name="direccion[id_alumno]" />
	
	<fieldset>
		<table>
			<tr>
				<td>C.P.</td>
				<td><input type="text" name="direccion[co_codigo_postal]" id="co_codigo_postal" value="<?php echo $datos_dir['co_codigo_postal']?>" required="numeric"/></td>
			</tr>
			<tr>
				<th>Actualizar mi dirección</th>
			</tr>
			<tr>
				<td>Entidad Federativa:</td>
				<td ><select name="direccion[es_id]" id="es_id" onchange="obtenerDeMu();return false;">
						<?php
							foreach($catalogos['estados'] as $clave=> $valor ){
								if($datos_dir['es_id'] == $clave){
									echo "<option value='".$clave."' selected>".$valor."</option>\n";
								}else{
									echo "<option value='".$clave."'>".$valor."</option>\n";
								}
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Delegación/Municipio:</td>
				<td id="td_demu_id"><select name="direccion[demu_id]" id="demu_id" onchange="obtenerColonia();return false;">
						<?php
							foreach($catalogos['delegaciones'] as $clave=> $valor ){
								if($datos_dir['demu_id'] == $clave){
									echo "<option value='".$clave."' selected>".$valor."</option>\n";
								}else{
									echo "<option value='".$clave."'>".$valor."</option>\n";
								}
							}
						?>
					</select>				
				</td>
			</tr>
			<tr>
				<td>Colonia:</td>
				<td id="td_co_id"><select name="direccion[co_id]" id="co_id">
						<?php
							foreach($catalogos['colonias'] as $clave=> $valor ){
								if($datos_dir['co_id'] == $clave){
									echo "<option value='".$clave."' selected>".$valor."</option>\n";
								}else{
									echo "<option value='".$clave."'>".$valor."</option>\n";
								}
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Calle</td>
				<td><input type="text" name="direccion[do_calle]" id="do_calle" value="<?php echo $datos_dir['do_calle']?>"/></td>
			</tr>
			<tr>
				<td>Número Ext.:</td>
				<td><input type="text" name="direccion[do_num_exterior]" id="do_num_exterior" value="<?php echo $datos_dir['do_num_exterior']?>" required="numeric"/></td>
			</tr>
			<tr>
				<td>Número Int.:</td>
				<td><input type="text" name="direccion[do_num_interior]" id="do_num_interior" value="<?php echo $datos_dir['do_num_interior']?>" required="numeric"/></td>
			</tr>
		</table>
		
		<table>
			<tr>
				<td><input type="button" value="Registrar" onclick="frmModDireccionEnviar();return false;"/></td>
				<td><input type="button" value="Regresar" onclick=""/></td>
			</tr>
		</table>
	</fieldset>
</form>
<?php	
	}
}
?>