<div id="Respuesta">
	<?if (isset($errMsj)) { echo $errMsj; }?>
</div>

<form id="frmRegistrarCurso" name="frmRegistrarCurso" method="post" enctype="multipart/form-data" action="index.php">
	<input type="hidden" id='opc' name='opc' value='<? if (!isset($idCurso)) { echo "RegistrarCurso"; } else { echo "ActualizarCurso"; } ?>' />
		<table>
			<tr>
				<th colspan="3"> <? if (!isset($idCurso)) { echo "Registrar Curso"; } else { echo "Actualizar Curso"; } ?> </th>
			</tr>
			
			<tr>
				<td>Nombre del Curso</td>
				<td>: <input type='hidden' value='<? if (isset($idCurso)) { echo $idCurso; } ?>' name='idCurso' id='idCuso'> </td>
				<td><input type="text" id="nombreCurso" value="<? if (isset($idCurso)) { echo $nombreCurso; }?>" name="nombreCurso" class='required'></td>
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
//				$file = null;
//				if (isset($file)) { 
//					echo "<input type=\"text\" id=\"file\" name=\"file\"  value=\"$file\" readonly> 
//					 	  <td> <input type=\"button\" value=\"Editar\" id=\"Editar\" name=\"Editar\" onclick=\"ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'EditarRuta' , 'frmRegistrarCurso', 'contenido'); DoSubmit();\">";
//				} else {
					echo "<input type=\"file\" id=\"file\" name=\"file\" class='required'>";
//				}
				?></td>
			</tr>
			<tr>
				<td> <input type="submit" id="btnSubmit" name="btnSubmit" value="<? if (!isset($idCurso)) { echo "Registrar Curso"; } else { echo "Actualizar";} ?>" id="Guardar" ></td>
				<td></td>
				<td><input type="button" value="Cancelar" id="Cancelar" onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'Cursos', 'vacio', 'contenido')"></td>
			</tr>
		</table>
	</form>