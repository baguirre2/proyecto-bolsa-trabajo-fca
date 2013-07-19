<?php 
class FrmActualizarGrupo{

	function __construct($grupo_id=NULL,$datos_formulario = NULL, $datos_formulario2 = NULL){
		$nombre_grupo=$datos_formulario2["grupo"][0]["gr_nombre"];
		$nombre_taller=$datos_formulario2["taller"][0]["ta_nombre"];
		$nombre_aula=$datos_formulario2["aula"][0]["au_lugar"];
		$nombre_profesor=$datos_formulario2["profesor"][0]["pe_nombre"];
		$nombre_fechaInicio=$datos_formulario2["fechaInicio"][0]["gr_fecha_inicio"];
		$nombre_fechaFin=$datos_formulario2["fechaFin"][0]["gr_fecha_fin"];
		$grupoId=$grupo_id;
		$fechaInicio=date("m/d/Y", strtotime($nombre_fechaInicio) );
		$fechaFin=date("m-d-Y", strtotime($nombre_fechaFin) );
			
		echo $grupoId;
		echo $nombre_grupo;
		echo $nombre_taller;
		echo $nombre_aula;
		echo $nombre_profesor;
		echo $fechaInicio;
		echo $fechaFin;
		/*echo "<pre>";
		var_dump($datos_formulario2);
		echo "</pre>";*/
?>
<form id="form_grupo" action="#">
	<input type="hidden" name="opc" value="6"/>  <!-- La opcion del controlador a la que se va a llamar  -->
	 <input type="hidden" name="gr_estado_aprobacion" value="f" /> 
	 <input type="hidden" name="grupo_id" value="<?php echo $grupoId; ?>"/> 
	 
		<fieldset>
	
	<table>
            <th>Datos del Grupo</th>
		<tr>
			<td>Clave del grupo<span>*</span></td>
			<td><input type="text" name="gr_nombre" id="gr_nombre" class="required" value="<?php echo $nombre_grupo; ?>"></td>
		</tr>
		<tr>
			<td>Taller<span>*</span></td>
			<td><select name='ta_id' id="ta_id" class="required">
				<?php 
						foreach($datos_formulario["taller"] as $id_taller=>$valor){
							if ($valor==$nombre_taller) {
								echo "<option selected='selected' value='$id_taller'>$valor</option>";;
							}else
								echo "<option value='$id_taller'>".$valor."</option>";
						}
					?>
					<!--  <option selected="selected"><?php echo $nombre_taller; ?></option>  -->
			</select></td>
			<td>Aulas</td>
			<td><select name='au_id' id="au_id">	
				<?php 
						foreach($datos_formulario['aula'] as $id_aula => $valor){
							if ($valor==$nombre_aula) {
								echo "<option selected='selected' value='$id_aula'>$valor</option>";;
							}else
								echo "<option value='$id_aula'>$valor</option>";
						}
					?>
					
			</select></td>
			</tr>
			<tr>
			<td>Docente<span>*</span></td>
			<td><select name='pr_id' id="pr_id" class="required">
				<?php 
						foreach($datos_formulario['profesor'] as $id_profesor => $valor){
							if ($valor==$nombre_profesor) {
								echo "<option selected='selected' value='$id_profesor'>$valor</option>";;
							}else 
								echo "<option value='$id_profesor'>$valor</option>";
						}
					?>
					 <!--  <option selected="selected"><?php echo $nombre_profesor; ?></option> -->
			</select></td>
		</tr>
		<tr>
		<td align="center" >Fecha inicio</td>
            <td><input type="text" id="gr_fecha_inicio" name="gr_fecha_inicio" class="required" value="<?php echo $fechaInicio; ?>"></td>
		</tr>
		<tr>
		<td align="center" >Fecha fin</td>
            <td><input type="text" id="gr_fecha_fin" name="gr_fecha_fin" class="required" value="<?php echo $fechaFin; ?>"></td>
		</tr>
			</table>
		<table class="tab_form">
		<tr>&nbsp;</tr>
		<tr><td>Los campos marcados con (<span>*</span>) son obligatorios</td></tr>
		<tr>
		<td>
					<input type="button" value="Actualizar" id="btnActualizarForm"/>
				</td>
		</tr>
	</table>

	</fieldset>
</form>
<div id="mensajes"></div>

<script type="text/javascript" src="./webroot/js/function_calendario.js">
</script>

<script>

//validar campos que no este vacios
function validar(formulario_id){
	$('label.error').remove();
	var valido = true;
	$('#'+formulario_id+' .required').each(function(index,element){	
		if( $(this).val() == null || $(this).val() == ""){
			valido = false;
			$(this).after("<label class='error'>Campo Obligatorio*</label>");
		}
	});
	return valido;
	
}

$(document).ready(function(){
	/*Pantalla para mostrar mensajes a la hora de agregar**/
	$('#mensajes').dialog({
		autoOpen: false,
		modal: true});

//funcion evento onclick de agregar grupo
$('#btnActualizarForm').click(function(){
	if(validar('form_grupo') == true){
		/*Serialize toma todos los datos del formulario**/
		$.get('controllers/gestionarGrupo/CtlGrupo.php',$('#form_grupo').serialize(),function(data){
			/**Data es el string que nos manda de respuesta el metodo**/
				$('#mensajes').append(data);
				//actualizamos los datos mostrados
				ajax('controllers/gestionarGrupo/CtlGrupo.php', 3, 'vacio', 'contenido');
				$('#mensajes').dialog("open");
			});
	}
});

}); 
</script>

<?php 
	}
}
?>


