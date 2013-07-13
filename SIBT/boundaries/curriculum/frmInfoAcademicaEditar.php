<div id="resFrmEditar"></div>
<form enctype="multipart/form-data" action="controllers/gestionarCurriculum/CtlCurriculum.php" name="frmEditar" id="frmEditar" method="POST" >	
	<input type="hidden" name="opc" value="carInfoAcademicaImagenEditar" />

	<?php
		//$id_infoAcademica = $_GET[id_infoAca];		
		//echo "Id info academica en formulario: ".$id_infoAca;
		
		echo "<input type=\"hidden\" id=\"infoAc_id\" name=\"infoAc_id\" value=\"$id_infoAca\" >";	
	 							 
		$infoAc_id = $resultados[0]['inac_id'];	
		$universidad = $resultados[0]['inac_universidad']; 				
		$escuela = $resultados[0]['inac_escuela'];
		$promedio = $resultados[0]['inac_promedio'];
		$fecha_inicio = $resultados[0]['inac_fecha_inicio'];
		$fecha_termino = $resultados[0]['inac_fecha_termino'];
		$otro_id = $resultados[0]['esot_id'];			
		$nivel = $resultados[0]['nies_id'];		
		$esac_id = $resultados[0]['esac_id'];
		$esau_id = $resultados[0]['esau_id'];
			
		/*echo "esau_id: ".$esau_id;			
		echo "<br>Informacion academica id en Formulario Actualizar: ".$id_infoAca;*/
		
	?>
	<table>
		<tbody>
			<tr>
				<td>* Nivel educativo: </td>
				<td><input name="btnNivel" type="radio" value="1" disabled="disabled" <?php echo ($nivel == 1) ? "checked=\"checked\"":""?>/>Licenciatura</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input name="btnNivel" type="radio" value="2" disabled="disabled" <?php echo ($nivel == 2) ? "checked=\"checked\"":""?>/>Especializaci&oacute;n</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input name="btnNivel" type="radio" value="3" disabled="disabled" <?php echo ($nivel == 3) ? "checked=\"checked\"":""?>/>Maestr&iacute;a</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input name="btnNivel" type="radio" value="4" disabled="disabled" <?php echo ($nivel == 4) ? "checked=\"checked\"":""?>/>Doctorado</td>
			</tr>
			
			<tr>
				<td>* Nombre del t&iacute;tulo o grado:</td>			
				<?php 
  					//buscar la descripción de otro, si tiene
					if($otro_id != ""){			
					$nombre = $resultados[0]['esot_descripcion'];
					}else{
						$nombre = $resultados[0]['esfc_descripcion'];
					}				
  				?>  				
  				
	  			<td><input name="campoNombreTitulo" type="text" id="campoNombreTitulo" disabled="disabled" value="<?php echo $nombre; ?>"/></td>
		  	</tr>			 			
			<tr>
				<td>* Universidad o Instituci&oacute;n:</td>
				<td><input name="txtUniversidad" type="text" id="txtUniversidad" value="<?php echo $universidad;?>" /> </td>
			</tr>
			<tr>
				<td>* Escuela: </td>
				<td><input name="txtEscuela" type="text" id="txtEscuela" value="<?php echo $escuela;?>" /> </td>
			</tr>			
			<tr>
				<td>* Fecha de inicio (aaaa-mm-dd): </td>
				<td><input name="txtFechaInicio" type="text" id="txtFechaInicio" value="<?php echo $fecha_inicio; ?>"/></td>
			</tr>
			<tr>
				<td>Fecha de t&eacute;rmino (aaaa-mm-dd): </td>
				<td><input name="txtFechaTermino" type="text" id="txtFechaTermino" value="<?php echo $fecha_termino; ?>"/></td>
			</tr>			
			<tr>
				<td>Estado:</td>
				<td><select name="lstEstado">
    				<option value="1" <?php echo ($esac_id == 1) ? "selected":""?> >En curso</option>
    				<option value="2" <?php echo ($esac_id == 2) ? "selected":""?> >Truncado</option>
    				<option value="3" <?php echo ($esac_id == 3) ? "selected":""?> >Terminado</option>
    				<option value="4" <?php echo ($esac_id == 4) ? "selected":""?> >Titulado</option>
    				<option value="5" <?php echo ($esac_id == 5) ? "selected":""?> >Graduado</option>
  				</select></td>
			</tr> 
			<tr>
				<td>Promedio: </td>
				<?php 
					if(($esac_id==1) || ($esau_id==2)){	
						echo "<td><input name=\"txtPromedio\" type=\"text\" id=\"txtPromedio\" value=\"$promedio\"/></td>";
					}else{
						echo "<td><input name=\"txtPromedio\" type=\"text\" id=\"txtPromedio\" value=\"$promedio\"/ disabled></td>";
					}			
				?>			
			</tr>
			<tr>
				<td colspan="2">Cargar imagen de constancia obtenida: <input name="userfile" type="file" class="required"></td>
			</tr>
			<tr>								
				<td> <input type = "submit" value= "Editar"></td>
				<td><input name="btnCancelar" type="button" id="btnCancelar" value="Cancelar" onclick="ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'infoAcademicaListar', 'vacio', 'contenido')"/></td>
			</tr>
	</tbody>
  </table>	
</form>