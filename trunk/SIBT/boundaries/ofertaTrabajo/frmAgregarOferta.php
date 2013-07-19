<?php 
class FrmAgregarOferta{
	
	function __construct($datos_formulario = NULL,$id_reclutador = NULL){
		
?>

<div class="inner-heading">
	    <div class="container">
	        <div class="row">
	            <div class="span12">
	                <h1 class="animated fadeInDown delay1">Registrar <span>Oferta de Trabajo</span></h1> <!--El span sirve para colocar una palabra a resaltar en negritas--> 
	                <p class="animated fadeInDown delay2"></p>
	            </div>
	        </div>
	    </div>
</div>

<form id="form_oferta" action="#">
	<input type="hidden" name="opc" value="2"/><!-- La opcion del controlador a la que se va a llamar -->
	<input type="hidden" name="oferta[re_id]" value="<?php echo $id_reclutador; ?>"/>
	<fieldset>
		<h4>Datos generales.</h4>
		<table class="tab_form">
			<tr>
				<td>Nombre de la vacante<span>*</span></td>
				<td><input type="text" name="oferta[oftr_nombre]" id="oferta[oftr_nombre]" class="required"/></br></td>
			</tr>
			<tr>
				<td>Puesto solicitado<span>*</span></td>
				<td><input type="text" name="oferta[oftr_puesto_solicitado]" id="oferta[oftr_puesto_solicitado]" class="required"/></br></td>
			</tr>
			<tr>
				<td>Tipo de contrato<span>*</span></td>
				<td><select name="oferta[tico_id]" id="oferta[tico_id]" class="required">
					<?php 
						foreach($datos_formulario['tipo_contrato'] as $clave => $valor){
							echo "<option value='$clave'>$valor</option>";
						}
					?>
				</select></td>
			</tr>
			<tr>
			<td>Tiempo de contrato<span>*<span></td>
			<td><select name="oferta[tieco_id]" id="oferta[tieco_id]" class="required">
				<?php 
						foreach($datos_formulario['tiempo_contrato'] as $clave => $valor){
							echo "<option value='$clave'>$valor</option>";
						}
					?>
			</select></td>
			</tr>
			<tr>
			<td></tr><tr><td>Turno<span>*</span></td></td>
			<td><select name="oferta[tu_id]" id="oferta[tu_id]" class="required">
			<?php 
				foreach($datos_formulario['turno'] as $clave => $valor){
					echo "<option value='$clave'>$valor</option>";
				}
			?>
			</select></br></td>
			</tr>
			<tr>
			<td>Hora de entrada </td> 
			<td><input type="text" name="oferta[oftr_horario_entrada]" id="oftr_horario_entrada"/></td>
			</tr>
			<tr>
			<td>Hora de salida </td>
			<td><input type="text" name="oferta[oftr_horario_salida]" id="oftr_horario_salida"/></td>
			</tr>
			<tr>
			<td>Actividades a realizar <span>*</span></td>
			<td><textarea name="oferta[oftr_actividades_realizar]" id="oftr_actividades_realizar" class="required"></textarea></td>
			</tr>
			<tr>
			<td>Sueldo m&iacute;nimo<span>*</span></td>
			<td><input type="text" name="oferta[oftr_sueldo_minimo]" id="oferta[oftr_sueldo_maximo]" class="required numeric" /></tr>
			</tr>
			<tr><td>Sueldo m&aacute;ximo</td>
			<td><input type="text" name="oferta[oftr_sueldo_maximo]" id="oferta[oftr_sueldo_maximo]" class="numeric"/></td>
			</tr>
			<tr>
			<td>Disponibilidad para viajar</td>
			<td><input type="radio" name="oferta[oftr_disponibilidad_viajar]"  value="1" id="disponibilidad_viajar_true" />Si&nbsp;&nbsp;
			<input type="radio" checked name="oferta[oftr_disponibilidad_viajar]" value="0" id="disponibilidad_viajar_false" />No</td>
			
			</tr>
			<tr><td>N&uacute;mero de vacantes <span>*</span></td>
			<td><input type="text" name="oferta[oftr_num_vacantes]" id="oferta[oftr_num_vacantes]" class="required numeric"/></td>
			</tr>
		<tr>
		<td>Tel&eacute;fono de contacto<span>*</span></td>
		<td><input type="text" name="oferta[oftr_telefono]" id="oftr_telefono" class="required"/></td>
		</tr>
		<tr>
		<td>Correo el&eacute;ctronico de contacto<span>*</span></td>
		<td><input type="text" name="oferta[oftr_correo]" id="oftr_correo" class="required"/></td>
		</tr>
		<tr>
		<td>Etiquetas</td>
		<td>
		<input type="text" name="oferta[oftr_etiquetas]" id="oftr_etiquetas" onblur="validarEtiquetas();return false;"/>	
		</td>
		</tr>
	</table>
	<table class="tab_form">
			<h4>Lugar de trabajo</h4>
			<tr>
			<td>C.P<span>*</span></td>
			<td><input id="input_cp" type="text" name="codigo_postal" class="required" maxlength="5" onblur="obtenerDatosCp()"/></td>
			</tr>
			<tr>
			<td>Calle<span>*</span></td>
			<td><input type="text" name="domicilio[do_calle]" class="required"/></td>
			</tr>
			<tr><td>N&uacute;mero exterior<span>*</span></td>
			<td><input type="text" name="domicilio[do_num_exterior]" class="required"/></td>
			</tr>
			<tr><td>N&uacute;mero interior</td>
			<td><input type="text" name="domicilio[do_num_interior]" /></td>
			</tr>
                        
	</table>
        <table class="tab_form" id="datos_cp"></table>
	
	

	<table class="tab_form">
		<th>Perfil requerido del aspirante.</th>
		
		<tr>
                <td>Nivel de estudios:<span>*<span></td>
		<td><select name="nies_id" id="nies_id" class="required" onchange="obtenerDatosEstudios();return false;">
			<?php 
				foreach($datos_formulario['nivel_estudio'] as $clave => $valor){
					echo "<option value='$clave'>$valor</option>";
				}
			?>
			</select></td>
		</tr>
		<td>Estudios.<span>*<span></td>
		<td id="td_esfc_id"><select name="perfil[esfc_id]" id="esfc_id" class="required" onchange="obtenerSemestre();return false;">
			<?php 
				foreach($datos_formulario['licenciatura'] as $clave => $valor){
					echo "<option value='$clave'>$valor</option>";
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
		<td><input type="text" name="perfil[peas_edad_minima]" id="peas_edad_minima" /></td>
		</tr>
		<tr>
		<td>Edad m&aacute;xima</td>
		<td><input type="text" name="perfil[peas_edad_maxima]" id="peas_edad_maxima" required="numeric"/></td>
		</tr>
		<tr>
		<td>Experiencia requerida para el puesto</td>
		<td><input type="text" name="perfil[peas_experiencia_meses]" id="peas_experiencia_meses" placeholder="12"/>meses</td>
		</tr>
		<tr>
		<td>Habilidades requeridas para el puesto<span>*</span></td>
		<td><textarea columns="50" rows="2" class="required" name="perfil[peas_habilidades]" id="peas_habilidades"></textarea></td>
		</tr>
		<tr>
		<td>Conocimientos obligatorios<span>*</span></td>
		<td><textarea columns="50" rows="2" class="required" name="perfil[peas_conocimientos_obligatorios]" id="oftr_conocimientos_obligatorios"></textarea></td>
		</tr>
		<tr>
		<td>Conocimientos deseables</td>
		<td><textarea columns="50" rows="2" name="perfil[peas_conocimientos_deseables]" id="oftr_conocimientos_desaeables"></textarea></td>
		
		</tr>
	</table>
		<div id="idiomas"><input type="hidden" name="num_idioma" id="num_idioma" value="0"/></div>
	
	
	
	</form><!-- termina formulario -->
	
	
	<div id="frm_agregar_idioma">
	<table class="tab_form">
	<h4>Idiomas</h4>
		<thead>
			<th>Idioma <span>*</span></th>
			<th>Nivel oral(%)<span>*</span></th>
			<th>Nivel escrito(%)<span>*</span></th>
			<th>Nivel lectura(%)<span>*</span></th>
			<th></th>
		</thead>
		<tr>
		<td><select  name="tmp_idioma" id="tmp_idioma" >
			<?php foreach($datos_formulario['idiomas'] as $clave=> $valor){
				echo "<option value='$clave'>$valor</option>";
			}?>
		</select></td>
		<td>
		<input type="text" name="tmp_id_nivel_oral" id="tmp_id_nivel_oral" />
		</td>
		<td>
		<input type="text" name="tmp_id_nivel_escrito" id="tmp_id_nivel_escrito" />
		</td><td>
		<input type="text" name="tmp_id_nivel_lectura" id="tmp_id_nivel_lectura" />
		</td>
		<td>
			<input type="button" id="btn_agregar_idioma" value="Agregar idioma" onclick="agregarIdioma();return false;"/>
		</td>
		</tr>
	</table>
	</div><!-- termina agregar idiomas -->
        <div id="error_idiomas"></div>
	<table class="tab_form" id="tab_idiomas"></table>
	
	
	<table class="tab_form">
		<tr>&nbsp;</tr>
		<tr><td>Los campos marcados con (<span>*</span>) son obligatorios</td></tr>
		<tr>
		<td>
			<input type="button" value="Agregar" id="btn_enviar_formulario" onclick="enviarFormulario();return false;"/>
		</td>
		</tr>
	</table>

</fieldset>
<div id="mensajes"></div>




<script type="text/javascript" src="webroot/js/frmOfertaTrabajo.js"></script>
<?php 
	}
}
?>