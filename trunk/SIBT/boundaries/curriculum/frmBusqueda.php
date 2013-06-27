	<form id="frmBusqueda">
		<table>
		<tr> <th colspan="3">  Busqueda De Curriculum
		<tr><td>
			<input type="checkbox" id="cbInformatica" value="Informática" <?php if (isset($_GET['cbInformatica'])) { echo "checked='cheked'"; } ?>> Informática
		<tr><td>	 
			<input type="checkbox" id="cbAdministracion" value="Administración" <?php if (isset($_GET['cbAdministracion'])) { echo "checked='cheked'"; } ?>>Administración
		<tr><td>			 
		 	<input type="checkbox" id="cbContaduria" value="Contaduría" <?php if (isset($_GET['cbContaduria'])) { echo "cheked"; } ?>>  Contaduría
		<tr><td>  <input type="checkbox" id="cbOtro" name="cbOtro" value="Otro" onchange="ajax('./boundaries/curriculum/frmBusqueda.php', 'habilitarOtros' , 'frmBusqueda', 'contenido')"  <?php if (isset($_GET['cbOtro'])) { echo "checked='cheked'"; } ?> > Otro 
  			<td> <input type="text" id="txtOtro"  <?php if (!isset($_GET['cbOtro'])) { echo "readonly"; }?> > </td> 
  		<tr>
  			<td> <input type="button" value="Ver Favoritos" id="Favoritos" onclick="ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'IrAFavoritos' , 'vacio', 'ResultadosBusqueda')">
  			<td> <input type="button" value="Buscar" id="Buscar" onclick="ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 'BuscarCurriculum' , 'vacio', 'ResultadosBusqueda')">
  			     <input type="button" value="Cancelar" id="Cancelar" onclick="ajax('./controllers/gestionarCurriculum/CtlCurriculum.php', 1 , 'vacio', 'contenido')">
		</table>
	</form>
<div id="ResultadosBusqueda"></div>
