<?php 
class FrmConsultarDatosGenerales{
	
	function __construct($datos_formulario = NULL,$of = NULL){
	
		
?>
<form id="form_oferta" action="#">
	<input type="hidden" name="opc" value="11"/><!-- La opcion del controlador a la que se va a llamar -->
	<input type="hidden" name="oferta[re_id]" value="<?php echo $of['oferta']['re_id']; ?>"/>
	<input type="hidden" name="oftr_id" value="<?php echo $of['oferta']['oftr_id'];?>"/>
	<fieldset>
		<th>Datos generales.</th>
		<table>
			<tr>
				<td>Nombre de la vacante<span>*</span></td>
				<td><input type="text" name="oferta[oftr_nombre]" id="oferta[oftr_nombre]" class="required" value="<?php echo $of['oferta']['oftr_nombre']; ?>" /></br></td>
			</tr>
			<tr>
				<td>Puesto solicitado<span>*</span></td>
				<td><input type="text" name="oferta[oftr_puesto_solicitado]" value="<?php echo $of['oferta']['oftr_puesto_solicitado']; ?>"id="oferta[oftr_puesto_solicitado]" class="required"/></br></td>
			</tr>
			<tr>
				<td>Tipo de contrato<span>*</span></td>
				<td><select name="oferta[tico_id]"  id="oferta[tico_id]" class="required">
					<?php 
						foreach($datos_formulario['tipo_contrato'] as $clave => $valor){
							$selected = "";
							if($of['oferta']['tico_id'] == $clave){
								$selected = "selected";
							}
							echo "<option $selected value='$clave'>$valor</option>";
						}
					?>
				</select></td>
			</tr>
			<tr>
			<td>Tiempo de contrato<span>*<span></td>
			<td><select name="oferta[tieco_id]" id="oferta[tieco_id]"  class="required">
				<?php 
						foreach($datos_formulario['tiempo_contrato'] as $clave => $valor){
							$selected = "";
							if($of['oferta']['tieco_id'] == $clave){
								$selected = "selected";
							}
							echo "<option $selected value='$clave'>$valor</option>";
						}
					?>
			</select></td>
			</tr>
			<tr>
			<td></tr><tr><td>Turno<span>*</span></td></td>
			<td><select name="oferta[tu_id]" id="oferta[tu_id]"  class="required">
			<?php 
				foreach($datos_formulario['turno'] as $clave => $valor){
					$selected = "";
					if($of['oferta']['tieco_id'] == $clave){
							$selected = "selected";
						}
					echo "<option $selected value='$clave'>$valor</option>";
				}
			?>
			</select></br></td>
			</tr>
			<tr>
			<td>Hora de entrada </td> 
			<td><input type="text"  name="oferta[oftr_horario_entrada]" value="<?php echo $of['oferta']['oftr_horario_entrada']; ?>" id="oftr_horario_entrada"/></td>
			</tr>
			<tr>
			<td>Hora de salida </td>
			<td><input type="text"  name="oferta[oftr_horario_salida]" value="<?php echo $of['oferta']['oftr_horario_salida']; ?>" id="oftr_horario_salida"/></td>
			</tr>
			<tr>
			<td>Actividades a realizar <span>*</span></td>
			<td><textarea name="oferta[oftr_actividades_realizar]" id="oftr_actividades_realizar" class="required"><?php echo $of['oferta']['oftr_actividades_realizar']; ?></textarea></td>
			</tr>
			<tr>
			<td>Sueldo m&iacute;nimo<span>*</span></td>
			<td><input type="text" name="oferta[oftr_sueldo_minimo]" value="<?php echo $of['oferta']['oftr_sueldo_minimo']; ?>"  class="required numeric"/></tr>
			</tr>
			<tr><td>Sueldo m&aacute;ximo</td>
			<td><input type="text" name="oferta[oftr_sueldo_maximo]" value="<?php echo $of['oferta']['oftr_sueldo_maximo']; ?>" class="numeric"/></td>
			</tr>
			<tr>
			<td>Disponibilidad para viajar</td>
			<td><input <?php if($of['oferta']['oftr_disponibilidad_viajar'] == 't'){ echo 'checked';} ?> name="oferta[oftr_disponibilidad_viajar]" type="radio" value="1" />Si&nbsp;&nbsp;
			<input type="radio" <?php if($of['oferta']['oftr_disponibilidad_viajar'] == 'f'){ echo 'checked';} ?>  name="oferta[oftr_disponibilidad_viajar]" value="0" />No</td>
			
			</tr>
			<tr><td>N&uacute;mero de vacantes <span>*</span></td>
			<td><input type="text" name="oferta[oftr_num_vacantes]" value="<?php echo $of['oferta']['oftr_num_vacantes']; ?>" id="oferta[oftr_num_vacantes]" class="required numeric"/></td>
			</tr>
		<tr>
		<td>Tel&eacute;fono de contacto<span>*</span></td>
		<td><input type="text" name="oferta[oftr_telefono]" value="<?php echo $of['oferta']['oftr_telefono']; ?>" id="oftr_telefono" class="required"/></td>
		</tr>
		<tr>
		<td>Correo el&eacute;ctronico de contacto<span>*</span></td>
		<td><input type="text" name="oferta[oftr_correo]" value="<?php echo $of['oferta']['oftr_correo']; ?>" id="oftr_correo" class="required"/></td>
		</tr>
		<tr>
		<td>Etiquetas</td>
		<td>
		<input type="text" name="oferta[oftr_etiquetas]" value="<?php echo $of['oferta']['oftr_etiquetas']; ?>" id="oftr_etiquetas"/>	
		</td>
		</tr>
		<tr>
		<td><input type="button" value="Guardar" onclick="frmModDatosGeneralesEnviar();return false;"/></td>
		<td><input type="button" value="Cancelar" id="cancelar_guardar" onclick="vaciarFrmOferta();return false;"/></td>
		</tr>
	</table>
	
</fieldset>
</form>


<?php 
	}
}
?>