<div id="Respuesta">
	<?=$errMsj?>
</div>
<div id="RegistrarCurso">
	<form id="frmRegistrarCurso">
		<table>
			<tr>
				<th colspan="3"> <? if ($_GET['opc'] != "EditarCurso") { echo "Registrar Curso"; } else { echo "Actualizar Curso"; } ?> </th>
			</tr>
			
			<tr>
				<td>Nombre del Curso</td>
				<td>: <input type='hidden' value='<?=$idCurso?>' name='idCurso' id='idCuso'> </td>
				<td><input type="text" id="nombreCurso" value="<?=$nombreCurso?>" name="nombreCurso" class='required'></td>
			</tr>
			<tr>
				<td> Fecha de Participación </td>
				<td>:</td>
				<td> <input type="date" id="fechaParticipacion" value="<?=$fechaParticipacion?>" name="fechaParticipacion"></td>
			</tr>				
			<tr> 
				<td>Cargar Imagen</td>
				<td>:</td>
				<td> <input type="file" id="rutaImg" name="rutaImg"  value="<?=$rutaImg?>"></td>
			</tr>
			<tr>
				<td> <input type="button" value="<? if ($_GET['opc'] != "EditarCurso") { echo "Registrar Curso"; } else { echo "Actualizar";} ?>" id="Guardar" onclick="ajax('./controllers/gestionarCurriculum/CtlCurric.php', '<? if ($_GET['opc'] != "EditarCurso") { echo "RegistrarCurso"; } else { echo "ActualizarCurso"; } ?>', 'frmRegistrarCurso', 'contenido')"></td>
				<td></td>
            
            
            .-.-.-
            .-.-
            ññjkhhi
            
            hkijiluhj
            
            kkaslaksln
            asdksac m
            
            askdnsadj
            
            asdknasdkj
           ;: jeje
            
				<td><input type="button" value="Cancelar" id="Cancelar" onclick="ajax('./controllers/gestionarCurriculum/CtlCurric.php', 1 , 'vacio', 'contenido')"></td>
			</tr>
		</table>
	</form>
<div>