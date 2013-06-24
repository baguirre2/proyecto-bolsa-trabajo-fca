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
				<td><input type="text" id="nombreIdioma" value="<?=$nombreIdioma?>" name="nombreIdioma"></td>
			</tr>
			<tr>
				<td> Porcentaje de Escritura </td>
				<td>:</td>
				<td> <input type="number" id="escritura" value="<?=$porcentajeEscritura?>" name="escritura"></td>
			</tr>				
			<tr> 
				<td> Porcentaje de Oral </td>
				<td>:</td>
				<td> <input type="number" id="oral" name="oral"  value="<?=$porcentajeOral?>"></td>
			</tr>
			<tr> 
				<td> Porcentaje Lectura </td>
				<td>:</td>
				<td> <input type="number" id="lectura" name="lectura"  value="<?=$porcentajeLectura?>"></td>
			</tr>			
			<tr>
				<td> <input type="button" value="<? if ($_GET['opc'] != "EditarIdioma") { echo "Registrar Idioma"; } else { echo "Actualizar";} ?>" id="Guardar" onclick="ajax('./controllers/gestionarCurriculum/CtlCurric.php', '<? if ($_GET['opc'] != "EditarIdioma") { echo "RegistrarIdioma"; } else { echo "ActualizarIdioma"; } ?>', 'frmRegistrarIdioma', 'contenido')"></td>
				<td></td>
				<td><input type="button" value="Cancelar" id="Cancelar" onclick="ajax('./controllers/gestionarCurriculum/CtlCurric.php', 1 , 'vacio', 'contenido')"></td>
			</tr>
		</table>
	</form>
<div>