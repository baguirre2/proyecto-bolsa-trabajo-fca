
<?
echo "<h1>Mi objetivo Profesional</h1>";
$objProf = new InterfazBD2();
$contador = 0;
$res = $objProf->consultar('select * from ingsw.alumno where al_id = 1');
while ($row  = $res[$contador]) {
	$alCuenta = $row[al_num_cuenta];
	$ObjetivoProf = $row[al_objetivos_profesionales];
	$contador = $contador + 1;
}
/*echo"cnta: $alCuenta";
echo"ObjProf: $ObjetivoProf";*/

if($ObjetivoProf){
	echo "
	<form id='frmEditarObj'>
		<table width='200' border='0'>
  			<tr>
    			<td colspan='2'>$ObjetivoProf</td>
				<input type='hidden' name='editObjProf' value=\"$ObjetivoProf\" />
  			</tr>
  			<tr>
    			<td><input type='button' value='Editar' onclick=\"ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'editObj', 'frmEditarObj', 'frme')\"></td>
				<td><input type='button' value='Regresar' onclick= \"ajax('controllers/gestionarCurriculum/CtlCurriculum.php', '1', 'vacio', 'contenido')\"></td>
			</tr>
		</table>
	</form>
	
		";

} else {
	echo "
	<form id='frmAgregarObj' >
	<input type='hidden' name='alObjProf' value=\"$alCuenta\" />
		<table width='200' border='0'>
  			<tr>
    			<td><input type='button' value='Agregar' onclick=\"ajax('controllers/gestionarCurriculum/CtlCurriculum.php', 'agregarObj', 'frmAgregarObj', 'frme')\"></td>
				<td><input type='button' value='Regresar' onclick=\"ajax('controllers/gestionarCurriculum/CtlCurriculum.php', '1', 'vacio', 'contenido')\"></td>
			</tr>
		</table>
	</form>
		";
}
echo "<div id='frme'></div>";
		/*$contador = 0;
				$objProf->cerrarConexion();
				while ($row  = $res[$contador]) {
					echo "$row[id_alumno] ";
					echo "$row[nombre_alu] ";
					echo "$row[apaterno] ";
					echo "$row[amaterno]";
					$contador = $contador + 1;
				}*/


?>
