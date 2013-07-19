<?php 
class FrmConsultarIdiomas{
	
	function __construct($datos_formulario = NULL,$idiomas = NULL){
		
?>
<form id="form_oferta" action="#">
	<input type="hidden" name="opc" value="13"/><!-- La opcion del controlador a la que se va a llamar -->
	<fieldset>

	<div id="frm_agregar_idioma">
	</div><!-- termina agregar idiomas -->
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
			<input type="button" id="btn_agregar_idioma" value="Agregar idioma"/>
		</td>
		</tr>
	</table>
	
	
	<table class="tab_form" id="tab_idiomas">
		<?php 
			foreach($idiomas as $idioma){
				echo '<tr>';
				echo '<td>'.$idioma['id_nombre'].'</td>';
				echo '<td>'.$idioma['niid_nivel_oral'].'</td>';
				echo '<td>'.$idioma['niid_nivel_escrito'].'</td>';
				echo '<td>'.$idioma['niid_nivel_lectura'].'</td>';
				echo "<td><input type='button' value='Eliminar' name='btn_eliminar_idioma' id='".$idioma['peas_id']."'/></td>";
				echo '</tr>';
			}
		?>
	</table>
<?php 
	}
}
?>