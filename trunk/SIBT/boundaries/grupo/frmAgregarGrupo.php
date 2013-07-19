<?php 
class FrmAgregarGrupo{

	function __construct($datos_formulario = NULL){
		
		/*echo "<pre>";
		var_dump($datos_formulario);
		echo "</pre>";*/
?>

<div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Agregar <span>Grupo</span></h1> <!--El span sirve para colocar una palabra a resaltar en negritas--> 
	                <p class="animated fadeInDown delay2"></p>
	            </div>
	        </div>
	    </div>
</div>
<form id="form_grupo" action="#">
	<input type="hidden" name="opc" value="2"/>  <!-- La opcion del controlador a la que se va a llamar  -->
	 <input type="hidden" name="gr_estado_aprobacion" value="f" /> 
		<fieldset>
	
	<table>
            <th>Datos del Grupo</th>
		<tr>
			<td>Clave del grupo<span>*</span></td>
			<td><input type="text" name="gr_nombre" id="gr_nombre" class="required"></td>
		</tr>
		<tr>
			<td>Taller<span>*</span></td>
			<td><select name='ta_id' id="ta_id" class="required">
				<?php 
						foreach($datos_formulario["taller"] as $id_taller=>$valor){
							echo "<option value='$id_taller'>".$valor."</option>";
						}
					?>
			</select></td>
			<td>Aulas</td>
			<td><select name='au_id' id="au_id">
				<?php 
						foreach($datos_formulario['aula'] as $id_aula => $valor){
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
							echo "<option value='$id_profesor'>$valor</option>";
						}
					?>
			</select></td>
		</tr>
		<tr>
		<td align="center" >Fecha inicio</td>
            <td><input type="text" id="gr_fecha_inicio" name="gr_fecha_inicio" class="required cal" value="" /></td>
		</tr>
		<tr>
		<td align="center" >Fecha fin</td>
            <td><input type="text" id="gr_fecha_fin" name="gr_fecha_fin" class="required cal" value="" /></td>
		</tr>
			</table>
		<table class="tab_form">
		<tr>&nbsp;</tr>
		<tr><td>Los campos marcados con (<span>*</span>) son obligatorios</td></tr>
		<tr>
		<td>
					<input type="button" value="Agregar" id="btn_enviarForm"/>
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
	$('#btn_enviarForm').click(function(){
		if(validar('form_grupo') == true){
			/*Serialize toma todos los datos del formulario**/
			$.get('controllers/gestionarGrupo/CtlGrupo.php',$('#form_grupo').serialize(),function(data){
				/**Data es el string que nos manda de respuesta el metodo**/
					$('#mensajes').append(data);
					$('#mensajes').dialog("open");
				});//fin get
		}
	});

}); 
</script>

<?php 
	}
}
?>


