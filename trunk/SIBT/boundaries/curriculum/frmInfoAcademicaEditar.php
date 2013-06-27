<div id="resFrmEditar"></div>
<form id="frmEditar" method="post" enctype="multipart/form-data">
	<?php
		//$id_infoAcademica = $_GET[id_infoAca];
		
		//echo "Id info academica en formulario: ".$id_infoAca;
		echo "<input type=\"hidden\" id=\"infoAc_id\" name=\"infoAc_id\" value=\"$id_infoAca\" >";	
	 
		$registro = "";					 
		$infoAc_id = $resultados[0]['inac_id'];	
		$universidad = $resultados[0]['inac_universidad']; 				
		$escuela = $resultados[0]['inac_escuela'];
		$promedio = $resultados[0]['inac_promedio'];
		$fecha_inicio = $resultados[0]['inac_fecha_inicio'];
		$fecha_termino = $resultados[0]['inac_fecha_termino'];
		$otro_id = $resultados[0]['esot_id'];
		$esfc_id_info= $resultados[0]['esfc_id'];
		$nombre = $resultados[0]['esfc_descripcion'];
		$nivel = $resultados[0]['nies_id'];		
		
		//echo "Informacion academica id en Formulario Actualizar: ".$infoAc_id;
	?>
	<table>
		<tbody>
			<tr>
				<td>* Nivel educativo: </td>
				<td><input name="btnNivel" type="radio" value="Licenciatura" disabled="disabled" <?php echo ($nivel == 1) ? "checked=\"checked\"":""?>/>Licenciatura</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input name="btnNivel" type="radio" value="Especializacion" disabled="disabled" <?php echo ($nivel == 2) ? "checked=\"checked\"":""?>/>Especializaci&oacute;n</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input name="btnNivel" type="radio" value="Maestria" disabled="disabled" <?php echo ($nivel == 3) ? "checked=\"checked\"":""?>/>Maestr&iacute;a</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input name="btnNivel" type="radio" value="Doctorado" disabled="disabled" <?php echo ($nivel == 4) ? "checked=\"checked\"":""?>/>Doctorado</td>
			</tr>
			
			<tr>
				<td>* Nombre del t&iacute;tulo o grado:</td>			
				<?php 
  					//buscar la descripción de otro, si tiene
  					if($otro_id != 0){
						$conexion = new InterfazBD2();
						$query = "SELECT esot_descripcion FROM ingsw.informacion_academica AS a 
								JOIN ingsw.estudio_otro AS b 
								ON a.esot_id = b.esot_id AND a.inac_id=$infoAc_id";
						$resultados = $conexion->consultar($query);
						$descripcion_otro = $resultados[0]['esot_descripcion'];					
						$conexion->cerrarConexion();					
  				?>
	  			<td><input name="campoNombreTitulo" type="text" id="campoNombreTitulo" disabled="disabled" value="<?php echo $descripcion_otro; ?>"/></td>
		  	</tr>			
			<?php 
			} else { 
			?><td><?php 
						$conexion = new InterfazBD2();
						$query = "SELECT * FROM ingsw.estudio_fca WHERE nies_id=$nivel";
						$resultados = $conexion->consultar($query);						
						echo "<select name=\"campoNombreTitulo\" disabled=\"disabled\"><option>Seleccione...</option>";
						//$resultados = $this->listarEstudiosFCA();
						for ($i=0; $i <= count($resultados)-1; $i++) {							
							echo "<option value=\"";
							echo $resultados[$i]['esfc_id'];							
							if($resultados[$i]['esfc_id'] == $esfc_id_info ){
								echo "\" selected>";
							}else{
								echo "\">";
							}
							echo $resultados[$i]['esfc_descripcion'];
							echo "</option>";
						}
						echo "</select>";
						$conexion->cerrarConexion();
					?>					
					<div id="listaNombres">	</div>  				
  				</td>
  			</tr>
  			<?php } ?>  			
			<tr>
				<td>* Universidad o Instituci&oacute;n:</td>
				<td><input name="txtUniversidad" type="text" id="txtUniversidad" value="<?php echo $universidad;?>" /> </td>
			</tr>
			<tr>
				<td>* Escuela: </td>
				<td><input name="txtEscuela" type="text" id="txtEscuela" value="<?php echo $escuela;?>" /> </td>
			</tr>			
			<tr>
				<td>* Fecha de inicio (dd/mm/aaaa): </td>
				<td><input name="txtFechaInicio" type="text" id="txtFechaInicio" value="<?php echo $fecha_inicio; ?>"/></td>
			</tr>
			<tr>
				<td>Fecha de t&eacute;rmino (dd/mm/aaaa): </td>
				<td><input name="txtFechaTermino" type="text" id="txtFechaTermino" value="<?php echo $fecha_termino; ?>"/></td>
			</tr>			
			<tr>
				<td>Estado:</td>
				<td><select name="lstEstado">
    				<option value="En curso">En curso</option>
    				<option value="Truncado">Truncado</option>
    				<option value="Terminado">Terminado</option>
    				<option value="Titulado">Titulado</option>
    				<option value="Graduado">Graduado</option>
  				</select></td>
			</tr> 
			<tr>
				<td>Promedio: </td>
				<td><input name="txtPromedio" type="text" id="txtPromedio" value="<?php echo $promedio; ?>"/></td>
			</tr>
			<tr>
				<td>Cargar constancia: </td>
				<td><input type="file" name="filImagen" id="filImagen"/>
				<input type="hidden" name="MAX_FILE_SIZE" value="3485760" /></td>
			</tr>
			<tr>
				<td> 
				<td><input name="btnAccion" type="button" value="Actualizar" onclick="ajaxConId('controllers/gestionarCurriculum/CtlCurriculum.php', 'infoAcademicaActualizar', 'frmEditar', 'contenido', <?php echo $infoAc_id; ?>)"/></td>
				<td><input name="btnCancelar" type="button" id="btnCancelar" value="Cancelar" onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'infoAcademicaListar', 'vacio', 'contenido')"/></td>
			</tr>
	</tbody>
  </table>	
</form>