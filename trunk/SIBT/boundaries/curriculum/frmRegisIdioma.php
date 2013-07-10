<div id="Respuesta">
	<?
	if (isset($errMsj)) { echo $errMsj; }          
	?>
</div>
<div id="RegistrarIdioma">
	<form id="frmRegistrarIdioma">
		<table>
			<tr>
				<th colspan="4"> <? if (verify()) { echo "Registrar Idioma"; } else { echo "Actualizar Idioma"; } ?> </th>
			</tr>
			<tr>
				<td>Idioma</td>
				<td>: <input type='hidden' value='<?php if (isset($alumnoIdioma)) { echo $alumnoIdioma; }?>' name='AlumnoIdioma' id='AlumnoIdioma'>  </td>
				<td><?php if (isset($idIdioma)) { echo getIdiomas($idIdioma);  } else { echo getIdiomas(0); }?></td>
			</tr>
			<tr>
				<td> Porcentaje de Escritura </td>
				<td>:</td>
				<td> <?if (isset($porcentajeEscritura)) { echo setSelect($porcentajeEscritura, "escritura");  } else { echo setSelect(0, "escritura"); } ?> 	</td>
			</tr>				
			<tr> 
				<td> Porcentaje de Oral </td>
				<td>:</td>
				<td> <? if (isset($porcentajeOral)) { echo setSelect($porcentajeOral, "oral");  } else { echo setSelect(0, "oral"); } ?> </td>
			</tr>
			<tr> 
				<td> Porcentaje Lectura </td>
				<td>:</td>
				<td> <? if (isset($porcentajeLectura)) { echo setSelect($porcentajeLectura, "lectura");  } else { echo setSelect(0, "lectura"); } ?>  </td>
			</tr>
			<tr>
				<th colspan="3"> Información de Constancia </th>
			</tr>
			<?php if ($_GET['opc'] == "AgregarConstancia" || isset($rutaImg)) { ?>			
			<tr>
				<td> Institución </td>
				<td> : </td>
				<td> <input type="text" name="institucion" id="institucion" value="<?php if (isset($institucion)) { echo $institucion; } ?>"> </td>
			</tr>
			<tr>
				<td> Año </td>
				<td> : </td>
				<td> <input type="text" name="anio" value="<?php if (isset($anio)) { echo $anio; } ?>" id="anio"> </td>
			</tr>
			<tr>
				<td> Cargar Constancia </td>
				<td> : </td>
				<td><?php 
					if ($_GET['opc'] != "EditarRuta" && isset($rutaImg)) { 
						echo "<input type=\"text\" id=\"rutaImg\" name=\"rutaImg\"  value=\"$rutaImg\" readonly> 
					 		  <td> <input type=\"button\" value=\"Editar\" id=\"Editar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'EditarRuta' , 'frmRegistrarIdioma', 'contenido')\">";
					} else {
						echo "<input type=\"file\" id=\"rutaImg\" name=\"rutaImg\" class='required'>";
					}
				?> </td>
			</tr>
			<?php } else { ?>
			<tr>
				<td colspan="2"> <input type="button" value="Agregar Constancia" id="Agregar Constancia" onclick="ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'AgregarConstancia' , 'frmRegistrarIdioma', 'contenido')"> </td> 			
			</tr>
			<?php } ?>
			<tr>
				<td> <input type="button" value="<? if (!isset($alumnoIdioma)) { echo "Registrar Idioma"; } else { echo "Actualizar"; } ?>" id="Guardar" onclick="ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', '<? if (!isset($alumnoIdioma)) { echo "RegistrarIdioma"; } else { echo "ActualizarIdioma"; } ?>', 'frmRegistrarIdioma', 'contenido')"></td>
				<td></td>
				<td><input type="button" value="Cancelar" id="Cancelar" onclick="ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 1 , 'vacio', 'contenido')"></td>
			</tr>
		</table>
	</form>
<div>

<?php

	function verify() {
		
		if ($_GET['opc'] != "EditarIdioma" && $_GET['opc'] != "ActualizarIdioma" && $_GET['opc'] != "EditarRuta") {
			return true;
		} else { 
			return false;
		}
		
	}

	function setSelect($value, $name_id) {
		$strSelect = "<select name='$name_id' id='$name_id' class='required numeric'>";
		for ($i = 0; $i <= 100; $i = $i + 10) {
			$selected = "";
			if ($value == $i) {
				$selected = "selected";
			} 
			$strSelect .="<option value='$i' $selected > $i %" ;
		}
		$strSelect .= "</select>";
		return  $strSelect;
	}
	
	function getIdiomas($value) {
		include_once '../../entities/Idioma.php';
		$idioma1 = new Idioma();
		$arrIdiomas = $idioma1->obtenerIdiomas();
		$strSelect = "<select name='idIdioma' id='idIdioma'> <option value='0' selected class='required numeric'> ---";
		foreach ($arrIdiomas as $valor) {
			$selected = "";
			if ($value == $valor['id_id']) {
				$selected = "selected";
			}			
			$strSelect .= "<option value='$valor[id_id]' $selected> $valor[id_nombre]";
		}
		return $strSelect;
	}

?>