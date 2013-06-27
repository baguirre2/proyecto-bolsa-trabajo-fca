<div id="Respuesta">
	<?if (isset($errMsj)) { echo $errMsj; }?>
</div>
<div id="RegistrarCurso">
	<form id="frmRegistrarCurso">
		<table>
			<tr>
				<th colspan="3"> <? if (!isset($idCurso)) { echo "Registrar Curso"; } else { echo "Actualizar Curso"; } ?> </th>
			</tr>
			
			<tr>
				<td>Nombre del Curso</td>
				<td>: <input type='hidden' value='<? if (isset($idCurso)) { echo $idCurso; } ?>' name='idCurso' id='idCuso'> </td>
				<td><input type="text" id="nombreCurso" value="<?=$nombreCurso?>" name="nombreCurso" class='required'></td>
			</tr>
			<tr>
				<td> Fecha de Participación </td>
				<td>:</td>
				<td> <input type="date" id="fechaParticipacion" value="<? if (isset($fechaParticipacion)) { echo $fechaParticipacion; } ?>" name="fechaParticipacion" class='required'></td>
			</tr>				
			<tr> 
				<td>Cargar Imagen</td>
				<td>:</td>
				<td> <?php 
				if (isset($rutaImg)) { 
					echo "<input type=\"text\" id=\"rutaImg\" name=\"rutaImg\"  value=\"=$rutaImg\" readonly> 
					 	  <td> <input type=\"button\" value=\"Editar\" id=\"Editar\" name=\"Editar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'EditarRuta' , 'frmRegistrarCurso', 'contenido')\">";
				} else {
					echo "<input type=\"file\" id=\"rutaImg\" name=\"rutaImg\"  value=\"$rutaImg\" class='required'>";
				}
				?></td>
			</tr>
			<tr>
				<td> <input type="button" value="<? if (!isset($idCurso)) { echo "Registrar Curso"; } else { echo "Actualizar";} ?>" id="Guardar" onclick="ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', '<? if (!isset($idCurso)) { echo "RegistrarCurso"; } else { echo "ActualizarCurso"; } ?>', 'frmRegistrarCurso', 'contenido')"></td>
				<td></td>
				<td><input type="button" value="Cancelar" id="Cancelar" onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'Cursos', 'vacio', 'contenido')"></td>
			</tr>
		</table>
	</form>
<div>