<div id="Respuesta">
	<?=$errMsj?>
</div>
<div id="RegistrarIdioma">
	<form id="frmRegistrarIdioma">
		<table>
			<tr>
				<th colspan="3"> <? if ($_GET['opc'] != "EditarIdioma") { echo "Registrar Idioma"; } else { echo "Actualizar Idioma"; } ?> </th>
			</tr>
			
			<tr>
				<td>Idioma</td>
				<td>: <input type='hidden' value='<?=$idIdioma?>' name='idIdioma' id='idIdioma'> </td>
				<td><?php echo getIdiomas($idIdioma); ?></td>
			</tr>
			<tr>
				<td> Porcentaje de Escritura </td>
				<td>:</td>
				<td> <?echo setSelect($porcentajeEscritura, "escritura");?> 	</td>
			</tr>				
			<tr> 
				<td> Porcentaje de Oral </td>
				<td>:</td>
				<td> <?echo setSelect($porcentajeOral, "escritura");?> </td>
			</tr>
			<tr> 
				<td> Porcentaje Lectura </td>
				<td>:</td>
				<td> <?echo setSelect($porcentajeLectura, "escritura");?></td>
			</tr>			
			<tr>
				<td> <input type="button" value="<? if ($_GET['opc'] != "EditarIdioma") { echo "Registrar Idioma"; } else { echo "Actualizar";} ?>" id="Guardar" onclick="ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', '<? if ($_GET['opc'] != "EditarIdioma") { echo "RegistrarIdioma"; } else { echo "ActualizarIdioma"; } ?>', 'frmRegistrarIdioma', 'contenido'); validarFrm('frmRegistrarIdioma');"></td>
				<td></td>
				<td><input type="button" value="Cancelar" id="Cancelar" onclick="ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 1 , 'vacio', 'contenido')"></td>
			</tr>
		</table>
	</form>
<div>
<?php 
	function setSelect($value, $name_id) {
		$strSelect = "<select name='$name_id' id='$name_id'>";
		for ($i = 0; $i <= 100; $i = $i + 5) {
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
		$strSelect = "<select name='idIdioma' id='idIdioma'> <option value='0' selected> ---";
		foreach ($arrIdiomas as $valor) {
			$selected = "";
			if ($value == $valor[id_idioma]) {
				$selected = "selected";
			}			
			$strSelect .= "<option value='$valor[id_idioma]' $selected> $valor[id_nombre]";
		}
		return $strSelect;
	}

?>