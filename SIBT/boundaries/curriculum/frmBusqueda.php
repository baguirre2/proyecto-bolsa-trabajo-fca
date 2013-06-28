<?php 
include_once '../../entities/InfoAcademica.php';
?>
<div>
	<form id="frmBusqueda">
		<table>
			<tr> 
				<th colspan="3">  Busqueda De Curriculum
			<tr> 
				<th> Nivel educativo </th>
				<th> Grado </th>
			<tr>
				<td><input name="busqueda" id="" type="radio" value="Licenciatura" onchange="ajax('boundaries/curriculum/frmBusqueda.php', 'llenarListaEstudios', 'frmBusqueda', 'contenido')" <?php if (isset($_GET['busqueda']) && $_GET['busqueda'] == "Licenciatura") { echo "checked='checked'"; }  ?>/>Licenciatura</td>
				<td> <?php if (isset($_GET['busqueda']) && $_GET['busqueda'] == "Licenciatura") { listarEstudiosFCA($_GET['idLicenciatura'], 1, "idLicenciatura"); } ?> </td>
			</tr>
			<tr>
				<td><input name="busqueda" type="radio" value="Especializacion" onchange="ajax('boundaries/curriculum/frmBusqueda.php', 'llenarListaEstudios', 'frmBusqueda', 'contenido')" <?php if (isset($_GET['busqueda']) && $_GET['busqueda'] == "Especializacion") { echo "checked='checked'"; }  ?>/>Especializaci&oacute;n</td>
				<td> <?php if (isset($_GET['busqueda']) && $_GET['busqueda'] == "Especializacion") { listarEstudiosFCA($_GET['idEspecializacion'], 2, "idEspecializacion"); } ?> </td>
			</tr>
			<tr>
				<td><input name="busqueda" type="radio" value="Maestria" onchange="ajax('boundaries/curriculum/frmBusqueda.php', 'llenarListaEstudios', 'frmBusqueda', 'contenido')" <?php if (isset($_GET['busqueda']) && $_GET['busqueda'] == "Maestria") { echo "checked='checked'"; } ?>/>Maestr&iacute;a</td>
				<td> <?php if (isset($_GET['busqueda']) && $_GET['busqueda'] == "Maestria") { listarEstudiosFCA($_GET['idMaestria'], 3, "idMaestria"); } ?> </td>
			</tr>
			<tr>
				<td><input name="busqueda" type="radio" value="Doctorado" onchange="ajax('boundaries/curriculum/frmBusqueda.php', 'llenarListaEstudios', 'frmBusqueda', 'contenido')" <?php if (isset($_GET['busqueda']) && $_GET['busqueda'] == "Doctorado") { echo "checked='checked'";} ?>/>Doctorado</td>
				<td> <?php if (isset($_GET['busqueda']) && $_GET['busqueda'] == "Doctorado") { listarEstudiosFCA($_GET['idDoctorado'], 4, "idDoctorado"); } ?> </td>
			</tr>
		<tr><td>  <input type="checkbox" id="cbOtro" name="cbOtro" value="Otro" onchange="ajax('boundaries/curriculum/frmBusqueda.php', 'listarOtrosEstudios' , 'frmBusqueda', 'contenido')"  <?php if (isset($_GET['cbOtro'])) { echo "checked='checked'"; } ?> > Otro
			<td> <?php if (isset($_GET['cbOtro'])) { listarOtrosEstudios($_GET['idOtros'], "idOtros"); } ?> </td>
			 
  		<tr>
  			<td> <input type="button" value="Ver Favoritos" id="Favoritos" onclick="ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'IrAFavoritos' , 'vacio', 'ResultadosBusqueda')">
  			<td> <input type="button" value="Buscar" id="Buscar" onclick="ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'BuscarCurriculum' , 'frmBusqueda', 'ResultadosBusqueda')">
  			     <input type="button" value="Cancelar" id="Cancelar" onclick="ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 1 , 'frmBusqueda', 'contenido')">
		</table>
	</form>
</div>
<div id="ResultadosBusqueda"></div>
<?php 

function listarEstudiosFCA($idSet = 0, $nivel, $idEstudio){
	
	$infoAcademica = new InfoAcademica();
	$res = $infoAcademica->obtenerEstudiosFCAPorNivel($nivel);		
	$strSelect = "<select name=\"idGrado\"><option>Seleccione...</option>";
	foreach ($res as $dato) {
		$strSelect .= "<option value='$dato[esfc_id]'>";
		$strSelect .= $dato[esfc_descripcion]."</option>";
	}
	echo $strSelect .= "</select>";
	
}

function listarOtrosEstudios($idSet = 0, $idEstudios){

//	$infoAcademica = new InfoAcademica();
//	$res = $infoAcademica->obtenerOtrosEstudios();		
//	
//	$strSelect = "<select name=\"$idEstudios\"><option>Seleccione...</option>";
//	foreach ($res as $dato) {
//		$strSelect .= "<option value='$dato[esot_id]'>";
//		$strSelect .= $dato[nies_descripcion]." - ".$dato[esot_descripcion]."</option>";
//	}
//	echo $strSelect .= "</select>";
	echo "Esta Opción Actualmente no está Disponible ";
	 
} 

?>