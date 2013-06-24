<div id="Respuesta">
	<?=$errMsj?>
</div>
<div id="RegistrarCurso">
	<form id="frmRegistrarCurso">
		<table>
			<tr>
				<th colspan="3"> Registrar Curso </th>
			</tr>
			<tr>
				<td>Nombre del Curso</td>
				<td>:</td>
				<td><input type="text" id="nombreCurso" value="<?=$nombreCurso?>" name="nombreCurso"></td>
			</tr>
			<tr>
				<td> Fecha de Participación </td>
				<td>:</td>
				<td> <input type="date" id="fechaParticipacion" value="<?=$fechaParticipacion?>" name="fechaParticipacion"></td>
			</tr>				
			<tr> 
				<td>Cargar Imagen</td>
				<td>:</td>
				<td> <input type="text" id="rutaImg" name="rutaImg"  value="<?=$rutaImg?>"></td>
			</tr>
			<tr>
				<td><input type="button" value="Guardar" id="Guardar" onclick="ajax('./controllers/gestionarCurriculum/CtlCurric.php', 'RegistrarCurso', 'frmRegistrarCurso', 'contenido')"></td>
				<td></td>
				<td><input type="button" value="Cancelar" id="Cancelar" onclick="ajax('./controllers/gestionarCurriculum/CtlCurric.php', 1 , 'vacio', 'contenido')"></td>
			</tr>
		</table>
	</form>
<div>