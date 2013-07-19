<?php 
class FrmConsultarPerfil{
	
	function __construct($datos_formulario = NULL,$perfil = NULL){
		var_dump($perfil);
?>
<form id="form_oferta" action="#">
	<input type="hidden" name="opc" value="31"/><!-- La opcion del controlador a la que se va a llamar -->
	<input type="hidden" name="oferta[re_id]" value="<?php echo $id_reclutador; ?>"/>
	<fieldset>

<table>
		<th>Perfil requerido del aspirante.</th>
		
		<tr>
                <td>Nivel de estudios:<span>*<span></td>
		<td><select name="nies_id" id="nies_id" class="required" onchange="obtenerDatosEstudios();return false;">
			<?php 
				foreach($datos_formulario['nivel_estudio'] as $clave => $valor){
                                        if($perfil['nies_id'] == $clave){
                                            echo "<option selected value='$clave'>$valor</option>";
                                        }else{
                                            echo "<option value='$clave'>$valor</option>";
                                        }
				}
			?>
			</select></td>
		</tr>
		<td>Estudios.<span>*<span></td>
		<td id="td_esfc_id"><select name="perfil[esfc_id]" id="esfc_id" class="required" onchange="obtenerSemestre();return false;">
			<?php 
				foreach($datos_formulario['licenciatura'] as $clave => $valor){
					 if($perfil['esfc_id'] == $clave){
                                            echo "<option selected value='$clave'>$valor</option>";
                                        }else{
                                            echo "<option value='$clave'>$valor</option>";
                                        }
				}
			?>
			</select></td>
		</tr>
		<tr>
		<td>Semestre cursado</td>
		<td id="td_peas_semestre"><select name="perfil[peas_semestre]" id="peas_semestre" class="numeric">
			<?php 
				for($i = 1;$i <= $datos_formulario['semestres'] ;$i++){
					echo "<option value='$i'>$i</option>";
				}
			?>
			</select></td>
		</tr>
		<tr>
		<td>Edad m&iacute;nima</td> 
		<td><input type="text" name="perfil[peas_edad_minima]" id="peas_edad_minima" value="<?php echo $perfil[peas_edad_minima];?>"/></td>
		</tr>
		<tr>
		<td>Edad m&aacute;xima</td>
		<td><input type="text" name="perfil[peas_edad_maxima]" id="peas_edad_maxima" required="numeric" value="<?php echo $perfil[peas_edad_maxima];?>"/></td>
		</tr>
		<tr>
		<td>Experiencia requerida para el puesto</td>
		<td><input type="text" name="perfil[peas_experiencia_meses]" id="peas_experiencia_meses" placeholder="12" value="<?php echo $perfil[peas_experiencia_meses];?>" />meses</td>
		</tr>
		<tr>
		<td>Habilidades requeridas para el puesto<span>*</span></td>
		<td><textarea columns="50" rows="2" class="required" name="perfil[peas_habilidades]" id="peas_habilidades"> <?php echo $perfil[peas_habilidades];?></textarea></td>
		</tr>
		<tr>
		<td>Conocimientos obligatorios<span>*</span></td>
		<td><textarea columns="50" rows="2" class="required" name="perfil[peas_conocimientos_obligatorios]" id="oftr_conocimientos_obligatorios"><?php echo $perfil[peas_conocimientos_obligatorios]; ?></textarea></td>
		</tr>
		<tr>
		<td>Conocimientos deseables</td>
		<td><textarea columns="50" rows="2" name="perfil[peas_conocimientos_deseables]" id="oftr_conocimientos_desaeables"><?php echo $perfil[peas_conocimientos_deseables];?></textarea></td>
		
		</tr>
	</table>
        <table>
            <tr>
                            <td><input type="button" value="Guardar" onclick="frmModPerfilEnviar();return false;"/></td>
                            <td><input type="button" value="Cancelar" id="cancelar_guardar" onclick="vaciarFrmOferta();return false;"/></td>
                        </tr>
            
        </table>    
</fieldset>
</form>

<?php 
	}
}
?>